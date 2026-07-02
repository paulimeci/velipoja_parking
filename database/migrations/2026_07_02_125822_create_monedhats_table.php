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
        Schema::create('adm_monedhat', function (Blueprint $table) {
            $table->id();
            $table->string('kodi', 3); // ALL, EUR, USD
            $table->string('emri', 20); // Leku Shqiptar, Euro, Dollar Amerikan
            $table->boolean('is_default')->default(false); // E përdorim për të vendosur LEK-un si monedhë kryesore
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'MonedhaSeeder' // Emri i saktë i klasës së Seeder-it tënd
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adm_monedhat');
    }
};
