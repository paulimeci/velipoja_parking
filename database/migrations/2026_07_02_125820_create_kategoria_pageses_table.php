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
        Schema::create('adm_kategoria_pageses', function (Blueprint $table) {
            $table->id();
            $table->enum('njesia_matjes', ['ore', 'dite'])->default('ore');
            $table->string('kategoria');
            $table->boolean('is_default')->default(false);
            $table->unsignedInteger('ore_per_njesi')->default(24);
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'KategoriaPagesesSeeder' // Emri i saktë i klasës së Seeder-it tënd
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adm_kategoria_pageses');
    }
};
