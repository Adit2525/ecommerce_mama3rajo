<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'kategori_id',
        'nama',
        'slug',
        'deskripsi',
        'harga',
        'harga_coret',
        'stok',
        'gambar',
        'is_active',
    ];

    protected $casts = [
        'harga' => 'integer',
        'harga_coret' => 'integer',
        'stok' => 'integer',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'produk_id');
    }
}
