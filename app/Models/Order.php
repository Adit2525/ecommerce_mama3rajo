<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'kode_pesanan',
        'nama_penerima',
        'no_telp',
        'alamat',
        'kota',
        'kode_pos',
        'jarak',
        'ongkir',
        'ekspedisi',
        'metode_pembayaran',
        'bank',
        'no_rekening',
        'status_pembayaran',
        'total_harga',
        'status',
        'catatan',
        'bukti_pembayaran',
        'tanggal_pembayaran',
        'bank_tujuan',
        'catatan_pembayaran',
        'snap_token',
        'midtrans_order_id',
        'midtrans_transaction_id',
    ];

    protected $casts = [
        'total_harga' => 'integer',
        'ongkir' => 'integer',
        'jarak' => 'decimal:2',
        'tanggal_pembayaran' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'pesanan_id');
    }

    // Alias for items() to support different naming conventions
    public function orderItems()
    {
        return $this->items();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for telepon (alias to no_telp)
    public function getTeleponAttribute()
    {
        return $this->no_telp;
    }
}
