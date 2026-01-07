<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        
        // Handle Slug
        if (empty($data['slug'])) {
            $slug = \Illuminate\Support\Str::slug($data['nama']);
            $count = \App\Models\Product::where('slug', 'LIKE', "{$slug}%")->count();
            $data['slug'] = $count > 0 ? "{$slug}-" . ($count + 1) : $slug;
        }

        // Handle Image
        if ($request->hasFile('images')) {
            $image = $request->file('images')[0]; // Taking first image as main image
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $filename);
            $data['gambar'] = 'images/products/' . $filename;
        }

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Handle Slug
        // Handle Slug
        if ($data['nama'] !== $product->nama) {
            $slug = \Illuminate\Support\Str::slug($data['nama']);
            $originalSlug = $slug;
            $count = 1;
            while (\App\Models\Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = "{$originalSlug}-{$count}";
                $count++;
            }
            $data['slug'] = $slug;
        } else {
            unset($data['slug']);
        }

        // Handle Image
        if ($request->hasFile('images')) {
            // Delete old image if needed (optional)
            $image = $request->file('images')[0];
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $filename);
            $data['gambar'] = 'images/products/' . $filename;
        } else {
             unset($data['gambar']); // Keep old image
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted');
    }
}
