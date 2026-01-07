<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama',
        'slug',
        'gambar',
        'is_active',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'kategori_id');
    }

    // Accessor for name (alias to nama)
    public function getNameAttribute()
    {
        return $this->nama;
    }
}

