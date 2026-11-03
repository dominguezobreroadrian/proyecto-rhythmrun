<?php

namespace App\Http\Controllers;

use App\Models\Reto;
use Illuminate\Http\Request;

class ControladorRetos extends Controller
{
    // Listar todos los retos
    public function index()
    {
        $retos = Reto::with('user:id,name')->latest()->get();
        return response()->json($retos);
    }

    // Crear un reto
    public function store(Request $request)
    {
        $datos = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'playlist_id'   => 'nullable|string|max:255',
            'playlist_name' => 'nullable|string|max:255',
            'distance_km'   => 'required|numeric|min:0.1',
        ]);

        $reto = $request->user()->challenges()->create($datos);

        return response()->json($reto, 201);
    }

    // Ver un reto concreto
    public function show(Reto $reto)
    {
        $reto->load('user:id,name', 'results.user:id,name');
        return response()->json($reto);
    }

    // Eliminar un reto (solo el creador)
    public function destroy(Reto $reto, Request $request)
    {
        if ($reto->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $reto->delete();
        return response()->json(['message' => 'Reto eliminado']);
    }
}
