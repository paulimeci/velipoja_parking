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
        Schema::create('adm_operacionet', function (Blueprint $table) {
            $table->id();
            $table->string('targa', 20);
            $table->dateTime('nisja');
            $table->dateTime('ikja')->nullable();
            $table->enum('status', ['prezent', 'larguar'])->default('prezent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adm_operacionet');
    }
};
