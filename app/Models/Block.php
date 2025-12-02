<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Block extends Model
{
    use HasFactory;

    protected $table = 'blocks';

    protected $fillable = [
        'calendar_id',
        'start_time',
        'end_time',
        'is_active',
        'is_booked',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_booked' => 'boolean',
    ];

    /**
     * Relación: un bloque pertenece a un día del calendario.
     */
    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }

    // Si luego ligas con citas:
    /*
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    */
}
