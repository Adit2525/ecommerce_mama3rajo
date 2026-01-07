<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'pesanan_detail';

    protected $fillable = [
        'pesanan_id',
        'produk_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'warna',
        'ukuran',
    ];

    protected $casts = [
        'harga_satuan' => 'integer',
        'subtotal' => 'integer',
        'jumlah' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'pesanan_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }

    // Alias for product() - Indonesian naming
    public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }

    // Accessor for product_id (alias to produk_id)
    public function getProductIdAttribute()
    {
        return $this->produk_id;
    }

    // Accessor for nama_produk (get from related product)
    public function getNamaProdukAttribute()
    {
        return $this->product?->nama ?? 'Product';
    }

    // Accessor for harga (alias to harga_satuan)
    public function getHargaAttribute()
    {
        return $this->harga_satuan;
    }
}

