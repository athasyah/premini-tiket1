<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        $order = Order::where('user_id', Auth::id())->where('status', 'pending')->latest()->first();

        if (!$order) {
            return redirect()->route('checkout')->with('error', 'Tidak ada pesanan yang bisa dibayar.');
        }

        return view('user.payment', compact('order'));
    }

    public function pay(Request $request)
    {
    
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string',
        ]);

        $order = Order::findOrFail($request->order_id);





        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $request->payment_method,
            'amount_paid' => $order->total_price,
            'status' => 'paid',
        ]);

        $order->update(['status' => 'paid']);

        return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil!');
    }
}
