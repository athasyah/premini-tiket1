<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('landing');
    // }
    // public function landingPage()
    // {
    //     $events = Event::where('start_date', '>', now())->get();  // Tiket yang belum lewat tanggal mulai
    //     return view('landing', compact('events'));
    // }

    public function userDashboard()
    {
        $user = auth()->user();
        return view('user.dashboard', compact('user'));
    }

    public function adminDashboard()
    {
        $tickets = Ticket::all();  // Semua tiket
        return view('admin.dashboard', compact('tickets'));
    }
}
