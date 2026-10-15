<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    // Menampilkan daftar fee
    public function index()
    {
        $fees = Fee::all();
        return view('admin.fee.index', compact('fees'));
    }

    // Menampilkan form tambah fee
    public function create()
    {
        return view('admin.fee.create');
    }

    // Menyimpan fee baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fixed,percent',
            'amount' => 'nullable|numeric|min:0|required_if:type,fixed',
            'percentage' => 'nullable|numeric|min:0|max:100|required_if:type,percent',
        ]);

        Fee::create($request->all());
        return redirect()->route('admin.fee.index')->with('success', 'Fee created successfully.');
    }

    // Menampilkan form edit fee
    public function edit(Fee $fee)
    {
        return view('admin.fee.edit', compact('fee'));
    }

    // Memperbarui fee di database
    public function update(Request $request, Fee $fee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fixed,percent',
            'amount' => 'nullable|numeric|min:0|required_if:type,fixed',
            'percentage' => 'nullable|numeric|min:0|max:100|required_if:type,percent',
        ]);

        $fee->update($request->all());
        return redirect()->route('admin.fee.index')->with('success', 'Fee updated successfully.');
    }

    // Menghapus fee dari database
    public function destroy(Fee $fee)
    {
        $fee->delete();
        return redirect()->route('admin.fee.index')->with('success', 'Fee deleted successfully.');
    }
}
