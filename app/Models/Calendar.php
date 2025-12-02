<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];

    // Un calendario pertenece a un admin
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Un calendario tiene muchos bloques
    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}
