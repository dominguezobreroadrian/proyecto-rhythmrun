<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorActividad;
use App\Http\Controllers\ControladorAutenticacion;
use App\Http\Controllers\ControladorClasificacion;
use App\Http\Controllers\ControladorResultados;
use App\Http\Controllers\ControladorRetos;
use App\Http\Controllers\ControladorSeguimientos;

Route::post('/register', [ControladorAutenticacion::class, 'register'])->middleware('throttle:5,1');
Route::post('/login', [ControladorAutenticacion::class, 'login'])->middleware('throttle:5,1');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ControladorAutenticacion::class, 'logout']);

    // Challenges
    Route::get('/challenges', [ControladorRetos::class, 'index']);
    Route::post('/challenges', [ControladorRetos::class, 'store']);
    Route::get('/challenges/{reto}', [ControladorRetos::class, 'show']);
    Route::delete('/challenges/{reto}', [ControladorRetos::class, 'destroy']);

    // Results
    Route::get('/challenges/{reto}/results', [ControladorResultados::class, 'index']);
    Route::post('/challenges/{reto}/results', [ControladorResultados::class, 'store']);

    // Follow
    Route::post('/users/{usuario}/follow', [ControladorSeguimientos::class, 'follow']);
    Route::delete('/users/{usuario}/unfollow', [ControladorSeguimientos::class, 'unfollow']);
    Route::get('/users/{usuario}/followers', [ControladorSeguimientos::class, 'followers']);
    Route::get('/users/{usuario}/following', [ControladorSeguimientos::class, 'following']);

    // Ranking
    Route::get('/ranking', [ControladorClasificacion::class, 'global']);
    Route::get('/ranking/challenge/{reto}', [ControladorClasificacion::class, 'challenge']);

    // Feed
    Route::get('/feed', [ControladorActividad::class, 'index']);
});