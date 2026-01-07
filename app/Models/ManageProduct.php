<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageProduct extends Model
{
    use HasFactory;

    public $table = 'manage_products';

    protected $fillable = [
        'admin_id',
        'product_id',
        'action',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public $timestamps = true;
    const UPDATED_AT = null;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
