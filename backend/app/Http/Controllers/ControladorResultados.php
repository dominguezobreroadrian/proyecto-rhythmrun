<?php

namespace App\Http\Controllers;

use App\Models\Resultado;
use App\Models\Reto;
use Illuminate\Http\Request;

class ControladorResultados extends Controller
{
    // Enviar resultado a un reto
    public function store(Request $request, Reto $reto)
    {
        $request->validate([
            'time_minutes'  => 'required|numeric|min:0.1',
            'distance_km'   => 'required|numeric|min:0.1',
            'notes'         => 'nullable|string',
        ]);

        // Evitar que el mismo usuario envíe dos resultados al mismo reto
        $existe = Resultado::where('user_id', $request->user()->id)
                            ->where('challenge_id', $reto->id)
                            ->exists();

        if ($existe) {
            return response()->json([
                'message' => 'Ya has enviado un resultado para este reto'
            ], 409);
        }

        $resultado = Resultado::create([
            'user_id'       => $request->user()->id,
            'challenge_id'  => $reto->id,
            'time_minutes'  => $request->time_minutes,
            'distance_km'   => $request->distance_km,
            'notes'         => $request->notes,
        ]);

        return response()->json($resultado, 201);
    }

    // Ver todos los resultados de un reto
    public function index(Reto $reto)
    {
        $resultados = $reto->results()->with('user:id,name')->latest()->get();
        return response()->json($resultados);
    }
}
