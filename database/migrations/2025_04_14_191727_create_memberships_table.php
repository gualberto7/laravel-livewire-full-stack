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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price');
            $table->integer('duration'); // in days
            $table->integer('max_entries')->nullable();
            $table->string('description')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('is_promo')->default(false);
            $table->date('promo_start_date')->nullable();
            $table->date('promo_end_date')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->foreignId('gym_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
