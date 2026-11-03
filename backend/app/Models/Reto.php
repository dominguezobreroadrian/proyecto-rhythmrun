<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reto extends Model
{
    protected $table = 'challenges';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'playlist_id',
        'playlist_name',
        'distance_km',
    ];

    // Un reto pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un reto tiene muchos resultados
    public function results()
    {
        return $this->hasMany(Resultado::class, 'challenge_id');
    }
}
