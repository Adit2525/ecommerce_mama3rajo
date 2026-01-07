<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'kategori_id' => 'required|exists:kategori,id',
            'nama' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:produk,slug,' . ($this->route('product')->id ?? 'NULL'),
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'harga_coret' => 'nullable|numeric|min:0',
            'stok' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
