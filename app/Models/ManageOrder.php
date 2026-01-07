<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageOrder extends Model
{
    use HasFactory;

    public $table = 'manage_orders';
    public $timestamps = true;
    const UPDATED_AT = null;

    protected $fillable = [
        'order_id',
        'admin_id',
        'previous_status',
        'new_status',
        'note',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
