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
        Schema::create('insights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('week_start');
            $table->date('week_end');
            $table->decimal('avg_focus', 4, 2);
            $table->decimal('avg_energy', 4, 2);
            $table->unsignedTinyInteger('sentiment_score')->comment('Skala 1-100');
            $table->json('suggestions')->comment('Array string saran dari AI');
            $table->json('raw_ai_response')->comment('Full JSON response dari Gemini');
            $table->timestamps();

            // Mencegah duplikasi insight untuk minggu yang sama pada user yang sama
            $table->unique(['user_id', 'week_start']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insights');
    }
};
