<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiAplicacionTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_pagina_raiz_informa_que_es_la_api(): void
    {
        $this->getJson('/')
            ->assertOk()
            ->assertJsonPath('message', 'RhythmRun API');
    }

    public function test_los_retos_requieren_autenticacion(): void
    {
        $this->getJson('/api/challenges')->assertUnauthorized();
    }

    public function test_se_puede_crear_un_reto_sin_musica(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/challenges', [
            'title' => 'Carrera de prueba',
            'description' => 'Cinco kilómetros a ritmo cómodo.',
            'distance_km' => 5,
        ])
            ->assertCreated()
            ->assertJsonPath('title', 'Carrera de prueba')
            ->assertJsonPath('playlist_id', null)
            ->assertJsonPath('playlist_name', null);

        $this->assertDatabaseHas('challenges', [
            'title' => 'Carrera de prueba',
            'playlist_id' => null,
            'playlist_name' => null,
        ]);
    }
}
