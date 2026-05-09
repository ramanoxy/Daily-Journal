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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            // Kita siapkan user_id untuk antisipasi fitur multi-user ke depannya
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->unsignedTinyInteger('focus_level')->comment('Skala 1-10');
            $table->unsignedTinyInteger('energy_level')->comment('Skala 1-10');
            $table->json('tags')->nullable()->comment('Tag hasil ekstraksi AI');
            $table->date('entry_date');
            $table->timestamps();

            $table->index(['user_id', 'entry_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
