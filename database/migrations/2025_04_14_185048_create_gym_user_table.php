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
        Schema::create('gym_user', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('gym_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->string('role'); // 'admin', 'instructor', etc.
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Un usuario solo puede tener un rol específico en un gimnasio
            $table->unique(['gym_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_user');
    }
};
