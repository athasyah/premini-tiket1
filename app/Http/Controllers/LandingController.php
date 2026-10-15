<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil 5 event terbaru berdasarkan tanggal dibuat
        // $latestEvents = Event::latest()->take(10)->get();

        $latestEvents = Event::with(['tickets.category'])
        ->where('start_date', '>=', now())
        ->whereNotNull('image')
        ->latest()
        ->take(10)
        ->get();

        $events = Event::with(['tickets.category']) 
            ->where('start_date', '>=', now())
            ->whereNotNull('image')
            ->get();

        $popularEvents = Event::with(['tickets.category'])
            ->where('start_date', '>=', now())
            ->whereNotNull('image')
            ->withSum('orderItems', 'quantity') 
            ->orderByDesc('order_items_sum_quantity')
            ->take(10)
            ->get();


        foreach ($events as $event) {
            $event->minPrice = $event->tickets->isNotEmpty()? $event->tickets->min(fn($ticket) => $ticket->category->price ?? INF): INF;
        }
 

        foreach ($latestEvents as $event) {
            $event->minPrice = $event->tickets->isNotEmpty()
                ? $event->tickets->min(fn($ticket) => $ticket->category->price ?? INF)
                : INF;
        }

        return view('landing', compact('events', 'latestEvents', 'popularEvents'));
    }



    public function tickets(Request $request)
    {
        $query = Event::where('start_date', '>=', now())
            ->whereNotNull('image')
            ->whereHas('category.ticket')
            ->withCount([
                'orderItems as total_sold' => function ($q) {
                    $q->select(DB::raw("SUM(quantity)"));
                }
            ]); // Hitung jumlah pembelian untuk sorting populer
    
        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
    
        // Sorting berdasarkan pilihan user
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc'); // Terbaru
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc'); // Terlama
                    break;
                case 'popular':
                    $query->orderBy('total_sold', 'desc'); // Terpopuler berdasarkan jumlah pembelian
                    break;
            }
        } else {
            $query->orderBy('start_date', 'desc'); // Default: Terbaru
        }
    
        $events = $query->paginate(6);
    
        $tickets = Ticket::with('category')
            ->whereHas('event', function ($query) {
                $query->whereDate('start_date', '>=', now()->toDateString());
            })
            ->get();
    
        $minPrice = $tickets->min(fn($ticket) => $ticket->category->price ?? INF);
    
        return view('tickets', compact('tickets', 'events', 'minPrice'));
    }
    

}
