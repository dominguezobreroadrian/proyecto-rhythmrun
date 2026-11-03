<?php

namespace App\Http\Controllers;

use App\Models\Seguimiento;
use App\Models\Reto;
use Illuminate\Http\Request;

class ControladorActividad extends Controller
{
    public function index(Request $request)
    {
        // Obtener IDs de usuarios que sigue el usuario autenticado
        $idsSeguidos = Seguimiento::where('follower_id', $request->user()->id)
                                  ->pluck('following_id');

        $actividad = Reto::whereIn('user_id', $idsSeguidos)
                         ->with('user:id,name')
                         ->withCount('results')
                         ->latest()
                         ->get();

        return response()->json($actividad);
    }
}
