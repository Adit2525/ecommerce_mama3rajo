<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource with filtering and sorting.
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', 1);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('kategori_id', $request->category);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'price_low':
                $query->orderBy('harga', 'asc');
                break;
            case 'price_high':
                $query->orderBy('harga', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('nama', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('nama', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();
        
        return view('shop.index', compact('products', 'categories'));
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $searchQuery = $request->get('q', '');
        
        $products = Product::where('is_active', 1)
            ->where(function($query) use ($searchQuery) {
                $query->where('nama', 'like', "%{$searchQuery}%")
                      ->orWhere('deskripsi', 'like', "%{$searchQuery}%")
                      ->orWhere('slug', 'like', "%{$searchQuery}%");
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('is_active', true)->get();

        return view('shop.search', compact('products', 'searchQuery', 'categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Get related products from same category
        $relatedProducts = Product::where('is_active', 1)
            ->where('id', '!=', $product->id)
            ->where('kategori_id', $product->kategori_id)
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }
}
