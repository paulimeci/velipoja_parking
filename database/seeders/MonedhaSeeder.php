<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- Shtuar për të përdorur DB query builder

class MonedhaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fshin çdo gjë në tabelë përpara se të bëjë insert (për të shmangur dublikimet)
        DB::table('adm_monedhat')->truncate();

        DB::table('adm_monedhat')->insert([
            [
                'kodi' => 'ALL',
                'emri' => 'Leku Shqiptar',
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
    }
}
