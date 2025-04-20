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
        Schema::create('gym_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('gym_id')->constrained()->onDelete('cascade');
            $table->string('report_type'); // 'monthly', 'yearly'
            $table->integer('year');
            $table->integer('month')->nullable(); // Solo para reportes mensuales
            $table->decimal('total_income', 10, 2);
            $table->integer('active_subscriptions');
            $table->integer('new_subscriptions');
            $table->integer('expired_subscriptions');
            $table->json('membership_breakdown')->nullable(); // Desglose por tipo de membresía
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index(['gym_id', 'report_type', 'year']);
            $table->index(['gym_id', 'report_type', 'year', 'month']);
            $table->unique(['gym_id', 'report_type', 'year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_reports');
    }
}; 