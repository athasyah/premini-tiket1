<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Event;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\OrderItem;

class AdminController extends Controller
{
    public function index()
    {
        $totalRevenueThisMonth = OrderItem::whereMonth('created_at', now()->month)->sum('price');
        $totalTicketsThisMonth = OrderItem::whereMonth('created_at', now()->month)->count();
        $activeEvents = Event::where('start_date', '>=', now())->count();
        $failedPayments = Payment::where('status', 'failed')->count();


        $bulanNama = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Hitung Pendapatan per Bulan
        $monthlyRevenue = OrderItem::selectRaw('MONTH(created_at) as month, SUM(price) as total_revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) use ($bulanNama) {
                $item->month_name = $bulanNama[$item->month] ?? 'Unknown';
                return $item;
            });

        // Hitung Jumlah Tiket Terjual per Bulan
        $ticketSales = OrderItem::selectRaw('MONTH(created_at) as month, COUNT(*) as total_tickets')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) use ($bulanNama) {
                $item->month_name = $bulanNama[$item->month] ?? 'Unknown';
                return $item;
            });

        $orders = Order::with(['user', 'event', 'orderItems.ticket'])
            ->orderBy('created_at', 'desc')
            ->get();


        return view('admin.dashboard', compact('monthlyRevenue', 'ticketSales', 'orders','totalRevenueThisMonth', 'totalTicketsThisMonth','activeEvents','failedPayments'));
    }

    public function transaction(){
        $orders = Order::with(['user', 'event', 'orderItems.ticket'])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.transaction', compact('orders'));
    }
}
