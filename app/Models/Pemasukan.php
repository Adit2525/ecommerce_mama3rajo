<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';
    public $timestamps = true;
    const UPDATED_AT = null;

    protected $fillable = [
        'source',
        'reference_id',
        'amount',
        'recorded_by',
        'note',
        'meta',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'meta' => 'array',
    ];

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
