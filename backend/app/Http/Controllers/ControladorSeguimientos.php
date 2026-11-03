<?php

namespace App\Http\Controllers;

use App\Models\Seguimiento;
use App\Models\User;
use Illuminate\Http\Request;

class ControladorSeguimientos extends Controller
{
    // Seguir a un usuario
    public function follow(Request $request, User $usuario)
    {
        if ($request->user()->id === $usuario->id) {
            return response()->json(['message' => 'No puedes seguirte a ti mismo'], 400);
        }

        $existe = Seguimiento::where('follower_id', $request->user()->id)
                             ->where('following_id', $usuario->id)
                             ->exists();

        if ($existe) {
            return response()->json(['message' => 'Ya sigues a este usuario'], 409);
        }

        Seguimiento::create([
            'follower_id'  => $request->user()->id,
            'following_id' => $usuario->id,
        ]);

        return response()->json(['message' => 'Ahora sigues a ' . $usuario->name], 201);
    }

    // Dejar de seguir a un usuario
    public function unfollow(Request $request, User $usuario)
    {
        Seguimiento::where('follower_id', $request->user()->id)
                   ->where('following_id', $usuario->id)
                   ->delete();

        return response()->json(['message' => 'Has dejado de seguir a ' . $usuario->name]);
    }

    // Ver seguidores de un usuario
    public function followers(User $usuario)
    {
        $seguidores = Seguimiento::where('following_id', $usuario->id)
                                 ->with('follower:id,name')
                                 ->get()
                                 ->pluck('follower');

        return response()->json($seguidores);
    }

    // Ver a quién sigue un usuario
    public function following(User $usuario)
    {
        $seguidos = Seguimiento::where('follower_id', $usuario->id)
                               ->with('following:id,name')
                               ->get()
                               ->pluck('following');

        return response()->json($seguidos);
    }
}
