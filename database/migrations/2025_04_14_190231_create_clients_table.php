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
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->index();
            $table->string('ci')->index();
            $table->string('phone')->index();
            $table->string('email')->nullable()->index();
            $table->string('avatar')->nullable();
            $table->foreignUuid('gym_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Índices compuestos para garantizar unicidad dentro del mismo gimnasio
            $table->unique(['ci', 'gym_id']);
            $table->unique(['email', 'gym_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
