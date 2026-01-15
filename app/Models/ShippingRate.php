<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'courier_name',
        'destination',
        'min_distance',
        'max_distance',
        'price',
        'estimate',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
