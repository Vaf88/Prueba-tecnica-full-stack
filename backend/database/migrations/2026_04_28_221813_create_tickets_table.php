<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 120);
            $table->text('descripcion');
            $table->enum('prioridad', ['baja', 'media', 'alta']);
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Índices para filtros
            $table->index('prioridad');
            $table->index(['created_at']);
            $table->index(['titulo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
