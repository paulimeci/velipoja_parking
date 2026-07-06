<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // <-- Shtuar për të menaxhuar foreign keys

class MonedhaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Çaktivizojmë përkohësisht verifikimin e Foreign Keys që të lejohet truncate
        Schema::disableForeignKeyConstraints();

        // Fshin çdo gjë në tabelë përpara se të bëjë insert (për të shmangur dublikimet)
        DB::table('adm_monedhat')->truncate();

        DB::table('adm_monedhat')->insert([
            [
                'kodi' => 'ALL',
                'emri' => 'Lek',
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kodi' => 'EUR',
                'emri' => 'Euro',
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kodi' => 'USD',
                'emri' => 'Dollar Amerikan',
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 2. Aktivizojmë përsëri kontrollin e Foreign Keys në fund
        Schema::enableForeignKeyConstraints();
    }
}
