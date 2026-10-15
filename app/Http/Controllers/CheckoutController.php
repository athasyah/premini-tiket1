<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Event;

class CheckoutController extends Controller
{
//     public function show($eventId)
//     {
//         $selectedTickets = Session::get('selected_tickets', []);
//         $event = Event::findOrFail($eventId);

//         if (empty($selectedTickets)) {
//             return redirect()->route('buy.ticket', $eventId)->with('error', 'Anda belum memilih tiket.');
//         }

//         $total_price = array_sum(array_column($selectedTickets, 'subtotal'));

//         return view('user.checkout', compact('selectedTickets', 'total_price', 'event'));
//     }

//     public function store(Request $request)
//     {
//         if (!auth()->check()) {
//             return redirect()->route('login')->with('error', 'Anda harus login untuk membeli tiket.');
//         }

//         // Ambil data tiket dari session, bukan dari request
//         $selectedTickets = Session::get('selected_tickets', []);

//         if (empty($selectedTickets)) {
//             return back()->with('error', 'Tiket belum dipilih.');
//         }

//         $request->validate([
//             'event_id' => 'required|exists:events,id',
//         ]);

//         $user = Auth::user();

//         DB::beginTransaction();
//         try {
//             $order = Order::create([
//                 'user_id' => $user->id,
//                 'event_id' => $request->event_id,
//                 'total_amount' => array_sum(array_column($selectedTickets, 'subtotal')),
//                 'status' => 'pending',
//             ]);

//             foreach ($selectedTickets as $ticket) {
//                 $ticketData = Ticket::find($ticket['id']);
//                 if (!$ticketData || $ticketData->stock < $ticket['quantity']) {
//                     DB::rollBack();
//                     return back()->with('error', "Stok tiket {$ticket['name']} tidak mencukupi.");
//                 }

//                 OrderItem::create([
//                     'order_id' => $order->id,
//                     'ticket_id' => $ticket['id'],
//                     'quantity' => $ticket['quantity'],
//                     'price' => $ticketData->category->price,
//                     'subtotal' => $ticketData->category->price * $ticket['quantity'],
//                 ]);

//                 $ticketData->decrement('stock', $ticket['quantity']);
//             }

//             DB::commit();

//             // Hapus session setelah checkout berhasil
//             Session::forget('selected_tickets');

//             return redirect()->route('user.checkout.success', $order->id)->with('success', 'Tiket berhasil dibeli!');
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
//         }
//     }


//     public function success($orderId)
//     {
//         $order = Order::with('orderItems.ticket')->findOrFail($orderId);
//         return view('user.checkout_success', compact('order'));
//     }

//     public function storeSelectedTickets(Request $request, $eventId)
//     {
//         $selectedTickets = json_decode($request->selected_tickets, true);

//         if (!$selectedTickets) {
//             return back()->with('error', 'Data tiket tidak valid!');
//         }

//         Session::put('selected_tickets', $selectedTickets);
//         Session::save(); // Paksa Laravel menyimpan session

//         return redirect()->route('checkout', $eventId);
//     }

//     public function processPayment(Request $request, $eventId)
// {
//     $request->validate([
//         'ticket_id' => 'required|array',
//         'ticket_id.*' => 'exists:tickets,id',
//         'quantity' => 'required|array',
//         'quantity.*' => 'integer|min:1',
//         'payment_method' => 'required|string',
//         'bank_account' => 'required_if:payment_method,bank_transfer',
//         'ewallet_number' => 'required_if:payment_method,ewallet',
//         'card_number' => 'required_if:payment_method,credit_card',
//         'card_name' => 'required_if:payment_method,credit_card',
//         'expiry_date' => 'required_if:payment_method,credit_card',
//         'cvv' => 'required_if:payment_method,credit_card',
//     ]);

//     $user = auth()->user();
//     $event = Event::findOrFail($eventId);

//     // Hitung total harga tiket
//     $totalAmount = 0;
//     $orderItems = [];

//     foreach ($request->ticket_id as $index => $ticketId) {
//         $ticket = Ticket::findOrFail($ticketId);
//         $quantity = $request->quantity[$index];
//         $subtotal = $ticket->price * $quantity;

//         $totalAmount += $subtotal;

//         $orderItems[] = [
//             'ticket_id' => $ticketId,
//             'quantity' => $quantity,
//             'price' => $ticket->price,
//             'subtotal' => $subtotal,
//         ];
//     }

//     // Simpan order
//     $order = Order::create([
//         'user_id' => $user->id,
//         'event_id' => $event->id,
//         'total_amount' => $totalAmount,
//         'status' => 'pending',
//     ]);

//     // Simpan order items
//     foreach ($orderItems as $item) {
//         $item['order_id'] = $order->id;
//         OrderItem::create($item);
//     }

//     // Simpan pembayaran
//     Payment::create([
//         'order_id' => $order->id,
//         'payment_method' => $request->payment_method,
//         'amount_paid' => $totalAmount,
//         'status' => 'pending',
//     ]);

//     return redirect()->route('user.checkout.success', $order->id)
//         ->with('success', 'Pesanan berhasil dibuat, silakan lanjutkan pembayaran!');
// }

}
