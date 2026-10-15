<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class UserController extends Controller
{
    public function dashboard()
    {

        $user = auth()->user();

        // Total Tiket yang Dibeli dari tabel orders
        $total_tickets = Order::where('user_id', $user->id)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->count();

        // Tiket yang Akan Datang
        $upcoming_tickets = Order::where('user_id', $user->id)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('events', 'orders.event_id', '=', 'events.id')
            ->where('events.start_date', '>', Carbon::now())
            ->count();

        // Tiket yang Sudah Digunakan (jika ada status di order_items)
        $used_tickets = Order::where('user_id', $user->id)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'used')
            ->count();

        // Total Pengeluaran
        $total_spent = Order::where('user_id', $user->id)
            ->where('status', 'success')
            ->sum('total_amount');

        // Tiket Terbaru (5 order terbaru)
        $recent_tickets = Order::where('user_id', $user->id)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('tickets', 'order_items.ticket_id', '=', 'tickets.id')
            ->join('events', 'orders.event_id', '=', 'events.id')
            ->join('categories', 'tickets.category_id', '=', 'categories.id')
            ->select('events.name as event_name', 'categories.name as category_name', 'order_items.price', 'orders.total_amount', 'orders.status', 'order_items.id')
            ->orderBy('orders.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('user.dashboard', compact(
            'total_tickets',
            'upcoming_tickets',
            'used_tickets',
            'total_spent',
            'recent_tickets'
        ));
    }

    public function ticketDetail($id)
    {
        $orderItem = OrderItem::findOrFail($id); // Cari order item
        $ticket = Ticket::findOrFail($orderItem->ticket_id); // Cari tiket berdasarkan ticket_id


        if (!$ticket) {
            return "Tiket dengan ID $id tidak ditemukan"; // Debugging
        }

        return view('user.detail', compact('ticket'));
    }
    
}
