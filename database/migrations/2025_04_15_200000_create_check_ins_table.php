<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('client_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('gym_id')->constrained()->cascadeOnDelete();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();

            // Índices para mejorar el rendimiento de las búsquedas
            $table->index(['client_id', 'created_at']);
            $table->index(['gym_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
}; 