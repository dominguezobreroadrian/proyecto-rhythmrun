<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('challenges', function (Blueprint $table): void {
            $table->string('playlist_id')->nullable()->change();
            $table->string('playlist_name')->nullable()->change();
        });
    }

    public function down(): void
    {
        $hayValoresNulos = DB::table('challenges')
            ->whereNull('playlist_id')
            ->orWhereNull('playlist_name')
            ->exists();

        if ($hayValoresNulos) {
            throw new \RuntimeException('No se puede revertir: hay retos sin música asociada.');
        }

        Schema::table('challenges', function (Blueprint $table): void {
            $table->string('playlist_id')->nullable(false)->change();
            $table->string('playlist_name')->nullable(false)->change();
        });
    }
};
