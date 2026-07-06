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
        Schema::create('adm_ndryshimi_operatorit', function (Blueprint $table) {
            $table->id();
            $table->integer('id_transaksionit');
            $table->integer('operatori_pare');
            $table->integer('operatori_dyte');
            $table->double('pagesa_e_re')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adm_ndryshimi_operatorit');
    }
};
