<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promosi';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'tanggal_mulai',
        'tanggal_berakhir',
        'is_active',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
        'is_active' => 'boolean',
    ];
}
