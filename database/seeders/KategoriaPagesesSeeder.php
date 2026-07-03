<?php

namespace Database\Seeders;

use App\Models\Admin\KategoriaPageses;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriaPagesesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriaPageses::create(['kategoria' => '24h']);
        KategoriaPageses::create(['kategoria' => 'dite_nate']);
        KategoriaPageses::create(['kategoria' => 'ore']);
        KategoriaPageses::create(['kategoria' => 'fikse']);
    }
}
