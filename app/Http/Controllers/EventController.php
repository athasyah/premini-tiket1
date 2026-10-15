<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today|before_or_equal:end_date',
            'location' => 'required|string',
            'end_date' => 'date|after_or_equal:start_date',
            'seat_map' => 'image|mimes:jpeg,png,jpg',
        ]);

        // Simpan gambar ke storage
        $imagePath = $request->file('image')->store('images', 'public');
        $seatPath = $request->file(key: 'seat_map')->store('images', 'public');

        $eventData = $request->except('image','seat_map');
        $eventData['image'] = $imagePath;
        $eventData['seat_map'] = $seatPath; // Tambahkan path gambar

        // Simpan ke database
        Event::create($eventData);

        return redirect()->route('admin.event.index')->with('success', 'event added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        // $event = Event::findOrFail($id);
        // $tickets = Ticket::where('event_id', $id)->get();
        // return view('purchase', compact('event', 'tickets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg|max:10000',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string',
            'seat_map' => 'image|mimes:jpeg,png,jpg'
            
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($event->image) {
                Storage::delete('public/' . $event->image);
            }

            // Simpan gambar baru dan path-nya
            $data['image'] = $request->file('image')->store('events', 'public');
        } else {
            // Jika tidak ada gambar baru, gunakan gambar lama
            $data['image'] = $request->old_image;
        }

        $event->update($data);
        return redirect()->route('admin.event.index')->with('success', 'event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        $event->delete();
        return redirect()->route('admin.event.index')->with('success', 'event deleted successfully');
    }

//     public function landingPage()
// {
//     // Ambil event dengan jumlah order terbanyak, dibatasi 5 tiket
//     $events = Event::withCount('orders')
//                 ->orderByDesc('orders_count')
//                 ->take(5)
//                 ->get();

//     return view('landing', compact('events'));
// }
}
