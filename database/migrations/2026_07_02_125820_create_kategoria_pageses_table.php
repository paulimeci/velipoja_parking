<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Krijojmë tabelën dhe fushat bazë
        Schema::create('adm_kategoria_pageses', function (Blueprint $table) {
            $table->id();
            $table->enum('njesia_matjes', ['ore', 'dite'])->default('ore');
            $table->string('kategoria');
            $table->boolean('is_default')->default(false);
            $table->unsignedInteger('ore_per_njesi')->default(24);

            // Definojmë kolonat si fillim pa aplikuar constraint-in direkt në krijim
            $table->unsignedBigInteger('id_kategoria_gjysme_dite')->nullable();
            $table->unsignedBigInteger('id_kategoria_gjysme_nate')->nullable();

            $table->timestamps();
        });

        // 2. Lidhim Foreign Keys tani që tabela u krijua zyrtarisht
        Schema::table('adm_kategoria_pageses', function (Blueprint $table) {
            $table->foreign('id_kategoria_gjysme_dite')
                ->references('id')->on('adm_kategoria_pageses')
                ->nullOnDelete();

            $table->foreign('id_kategoria_gjysme_nate')
                ->references('id')->on('adm_kategoria_pageses')
                ->nullOnDelete();
        });

        // 3. Ekzekutojmë Seeder-in për të populluar të dhënat fillestare
        Artisan::call('db:seed', [
            '--class' => 'KategoriaPagesesSeeder'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Gjatë drop, MySQL do të ankohet nëse ka foreign keys aktivë,
        // prandaj heqim dorë nga kontrolli i tyre përpara se ta fshijmë tabelën.
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('adm_kategoria_pageses');
        Schema::enableForeignKeyConstraints();
    }
};
