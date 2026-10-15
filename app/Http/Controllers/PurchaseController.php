<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;

class PurchaseController extends Controller
{
    public function show($eventId)
    {
        $tickets = Ticket::with('category')->get();
        $event = Event::with('tickets.category')->findOrFail($eventId);

        
        return view('purchase', compact('event', 'tickets'));
    }

   
}

