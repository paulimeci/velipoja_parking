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
        Schema::create('adm_transaksioni_operacionit', function (Blueprint $table) {
            $table->id();
            $table->integer('id_operacionit');
            $table->integer('id_prenotimit');
            $table->integer('id_fashes_orare');
            $table->enum('status_pagesa', ['paguar', 'jo_paguar'])->default('jo_paguar');
            $table->integer('monedha');
            $table->decimal('vlera', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adm_transaksioni_operacionit');
    }
};
