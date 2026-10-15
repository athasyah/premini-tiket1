<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Event;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['event'])->latest()->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        return view('admin.category.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:1000',
            'event_id' => 'required|exists:events,id',
        ]);

        Category::create($request->all());
        return redirect()->route('admin.category.index')->with('success', 'category added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $events = Event::all();
        return view('admin.category.edit',compact('category','events'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {    $request->validate([
        'name' => 'required|string',
        'price' => 'required|integer|min:1000',
        'event_id' => 'required|exists:events,id',
    ]);

    $category->update($request->all());
    return redirect()->route('admin.category.index')->with('success', 'category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.category.index')->with('success', 'category deleted successfully');
    }

//     public function getCategoriesByEvent($event_id)
// {
//     $categories = Category::where('event_id', $event_id)->get();
//     return response()->json($categories);
// }

}
