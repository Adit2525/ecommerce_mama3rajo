<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Store in public/images/promotions
            $file->move(public_path('images/promotions'), $filename);
            $data['gambar'] = 'images/promotions/' . $filename;
        }

        // Add default for is_active if not present (unchecked checkbox)
        $data['is_active'] = $request->has('is_active');

        Promotion::create($data);

        return redirect()->route('admin.promotions.index')->with('success', 'Promosi berhasil dibuat');
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if needed, but for now just overwrite logic
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/promotions'), $filename);
            $data['gambar'] = 'images/promotions/' . $filename;
        }

        $data['is_active'] = $request->has('is_active');

        $promotion->update($data);

        return redirect()->route('admin.promotions.index')->with('success', 'Promosi berhasil diperbarui');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('admin.promotions.index')->with('success', 'Promosi berhasil dihapus');
    }
}
