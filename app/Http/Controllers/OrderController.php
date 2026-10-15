<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Ticket;
use App\Models\Event;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'selected_tickets' => 'required|json',
            'payment_method' => 'required|string',
            'payment_details' => 'required|json',
        ]);

        
        $selectedTickets = json_decode($request->selected_tickets, true);
        
        $globalFees = \App\Models\Fee::all();

        
        $totalAmount = 0;
        $tiketMemilikiFee = false; 

        foreach ($selectedTickets as $ticket) {
            $ticketModel = Ticket::where('event_id', $request->event_id)
                ->with(['category', 'fees']) 
                ->find($ticket['id']);

            if ($ticketModel) {
                $ticketPrice = $ticketModel->category->price ?? 0;
                $ticketFees = 0;

                foreach ($ticketModel->fees as $fee) {
                    if ($fee->type === 'fixed') {
                        $ticketFees += $fee->amount;
                    } elseif ($fee->type === 'percent') {
                        $ticketFees += ($ticketPrice * $fee->percentage / 100);
                    }
                }

                // Tandai bahwa ada tiket yang memiliki fee
                if (!$ticketModel->fees->isEmpty()) {
                    $tiketMemilikiFee = true;
                }

                $subtotal = ($ticketPrice + $ticketFees) * $ticket['quantity'];
                $totalAmount += $subtotal;
            }
        }

        if ($tiketMemilikiFee) {
            foreach ($globalFees as $fee) {
                if ($fee->type === 'fixed') {
                    $totalAmount += $fee->amount;
                } elseif ($fee->type === 'percent') {
                    $totalAmount += ($totalAmount * $fee->percentage / 100);
                }
            }
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'event_id' => $request->event_id,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);


        foreach ($selectedTickets as $ticket) {
            $ticketModel = Ticket::find($ticket['id']);
            if ($ticketModel) {
                $ticketPrice = $ticketModel->category->price ?? 0;
                $ticketFees = 0;

                foreach ($ticketModel->fees as $fee) {
                    if ($fee->type === 'fixed') {
                        $ticketFees += $fee->amount;
                    } elseif ($fee->type === 'percent') {
                        $ticketFees += ($ticketPrice * $fee->percentage / 100);
                    }
                }

                $subtotal = ($ticketPrice + $ticketFees) * $ticket['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'ticket_id' => $ticket['id'],
                    'quantity' => $ticket['quantity'],
                    'price' => $ticketPrice,
                    'fee' => $ticketFees,
                    'subtotal' => $subtotal,
                ]);

                $ticketModel->stock -= $ticket['quantity'];
                $ticketModel->save();
            }
        }

        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $request->payment_method,
            'amount_paid' => $totalAmount,
            'status' => 'pending',
        ]);

        return redirect()->route('order.success')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function success()
    {
        return view('user.success'); // Sesuaikan dengan nama view Anda
    }
}
