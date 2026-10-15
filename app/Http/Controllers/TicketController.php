<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Event;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $tickets = Ticket::with(['event', 'category'])->latest()->paginate(10);
        return view('admin.ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events =  Event::all();
        $categories = Category::all();
        return view('admin.ticket.create', compact('events', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'category_id' => 'required|exists:categories,id',
            "stock" => 'required|numeric',
        ]);

        Ticket::create($request->all());
        return  redirect()->route('admin.ticket.index')->with('success', 'Ticket added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    { 
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $events =  Event::all();
        $categories = Category::all();
        return view('admin.ticket.edit', compact('events', 'categories', 'ticket'));
    }

    /**     
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'category_id' => 'required|exists:categories,id',
            "stock" => 'required|numeric',
        ]);

        $ticket->update($request->all());
        return redirect()->route('admin.ticket.index')->with('success', 'Ticket updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.ticket.index')->with('success', 'Ticket deleted successfully');
    }

//     public function getCategories($event_id)
// {
//     $categories = Category::where('event_id', $event_id)->get();
//     return response()->json($categories);
// }

public function showPurchasePage($eventId)
{
    $event = Event::findOrFail($eventId);
    $tickets = Ticket::where('event_id', $eventId)->get(); // Ambil tiket berdasarkan event

    if (!$event) {
        abort(404, "Event tidak ditemukan");
    }

    // $minPrice = $tickets->min(fn($ticket) => $ticket->category->price ?? INF);

    $categories = Category::where('event_id', $eventId)->get(); // Ambil kategori tiket untuk event ini

    return view('purchase', compact('event', 'categories', 'tickets',));
}
}
