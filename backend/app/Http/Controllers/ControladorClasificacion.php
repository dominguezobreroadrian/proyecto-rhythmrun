<?php

namespace App\Http\Controllers;

use App\Models\Resultado;
use App\Models\Reto;

class ControladorClasificacion extends Controller
{
    // Ranking global: usuarios con más retos completados
    public function global()
    {
        $clasificacion = Resultado::selectRaw('user_id, COUNT(*) as retos_completados, AVG(time_minutes) as media_minutos')
                                    ->with('user:id,name')
                                    ->groupBy('user_id')
                                    ->orderByDesc('retos_completados')
                                    ->get();

        return response()->json($clasificacion);
    }

    // Ranking de un reto concreto: ordenado por tiempo
    public function challenge(Reto $reto)
    {
        $clasificacion = Resultado::where('challenge_id', $reto->id)
                                    ->with('user:id,name')
                                    ->orderBy('time_minutes')
                                    ->get();

        return response()->json($clasificacion);
    }
}
