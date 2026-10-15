<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TicketFee;
use App\Models\Ticket;
use App\Models\Fee;
use Illuminate\Http\Request;

class TicketFeeController extends Controller
{
    public function index()
    {
        $ticketFees = TicketFee::with(['ticket', 'fee'])->get();
        return view('admin.ticket_fee.index', compact('ticketFees'));
    }

    public function create()
    {
        $tickets = Ticket::all();
        $fees = Fee::all();
        return view('admin.ticket_fee.create', compact('tickets', 'fees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'fee_id' => 'required|exists:fees,id',
        ]);

        $exists = TicketFee::where('ticket_id', $request->ticket_id)
            ->where('fee_id', $request->fee_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['error' => 'This ticket already has this fee assigned.']);
        }


        TicketFee::create($request->all());

        return redirect()->route('admin.ticket_fee.index')->with('success', 'Ticket Fee added successfully.');
    }

    public function edit(TicketFee $ticketFee)
    {
        $tickets = Ticket::all();
        $fees = Fee::all();
        return view('admin.ticket_fee.edit', compact('ticketFee', 'tickets', 'fees'));
    }

    public function update(Request $request, TicketFee $ticketFee)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'fee_id' => 'required|exists:fees,id',
        ]);

        $exists = TicketFee::where('ticket_id', $request->ticket_id)
            ->where('fee_id', $request->fee_id)
            ->where('id', '!=', $ticketFee->id) // Abaikan data saat ini
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['error' => 'This ticket already has this fee assigned.']);
        }


        $ticketFee->update($request->all());

        return redirect()->route('admin.ticket_fee.index')->with('success', 'Ticket Fee updated successfully.');
    }

    public function destroy(TicketFee $ticketFee)
    {
        $ticketFee->delete();

        return redirect()->route('admin.ticket_fee.index')->with('success', 'Ticket Fee deleted successfully.');
    }
}
