<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    protected $table = 'results';

    protected $fillable = [
        'user_id',
        'challenge_id',
        'time_minutes',
        'distance_km',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Reto::class, 'challenge_id');
    }
}
