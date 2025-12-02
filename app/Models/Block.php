<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'calendar_id',
        'start_time',
        'end_time',
        'is_available',
    ];

    // Un bloque pertenece a un calendario
    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
