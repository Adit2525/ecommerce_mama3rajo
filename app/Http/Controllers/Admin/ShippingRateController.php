<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingRate;
use Illuminate\Http\Request;

class ShippingRateController extends Controller
{
    public function index()
    {
        $rates = ShippingRate::latest()->paginate(10);
        return view('admin.shipping_rates.index', compact('rates'));
    }

    public function create()
    {
        return view('admin.shipping_rates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'courier_name' => 'required|string|max:255',
            'destination' => 'nullable|string|max:255',
            'min_distance' => 'nullable|integer|min:0',
            'max_distance' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'estimate' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        ShippingRate::create($request->all());

        return redirect()->route('admin.shipping-rates.index')->with('success', 'Biaya ekspedisi berhasil ditambahkan.');
    }

    public function edit(ShippingRate $shippingRate)
    {
        return view('admin.shipping_rates.edit', compact('shippingRate'));
    }

    public function update(Request $request, ShippingRate $shippingRate)
    {
        $request->validate([
            'courier_name' => 'required|string|max:255',
            'destination' => 'nullable|string|max:255',
            'min_distance' => 'nullable|integer|min:0',
            'max_distance' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'estimate' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $shippingRate->update($request->all());

        return redirect()->route('admin.shipping-rates.index')->with('success', 'Biaya ekspedisi berhasil diperbarui.');
    }

    public function destroy(ShippingRate $shippingRate)
    {
        $shippingRate->delete();
        return redirect()->route('admin.shipping-rates.index')->with('success', 'Biaya ekspedisi berhasil dihapus.');
    }
}
