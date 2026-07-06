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
        // NEW: fshijmë çdo kategori ekzistuese përpara se t'i rikrijojmë,
        // kështu seeder-i mund të rirrjeshet pa krijuar dublikatë
        KategoriaPageses::query()->delete();

        KategoriaPageses::create([
            'kategoria'     => 'dite_nate',
            'njesia_matjes' => 'dite',
            'is_default'    => true,   // NEW: kjo është kategoria default
            'ore_per_njesi' => 24,     // NEW: 1 njësi = 24 orë (ditë + natë të plota)
        ]);

        KategoriaPageses::create([
            'kategoria'     => 'dite',
            'njesia_matjes' => 'dite',
            'is_default'    => false,
            'ore_per_njesi' => 12,     // NEW: 1 njësi = 12 orë (vetëm pjesa e ditës)
        ]);

        KategoriaPageses::create([
            'kategoria'     => 'nate',
            'njesia_matjes' => 'dite',
            'is_default'    => false,
            'ore_per_njesi' => 12,     // NEW: 1 njësi = 12 orë (vetëm pjesa e natës)
        ]);

        KategoriaPageses::create([
            'kategoria'     => 'ore',
            'njesia_matjes' => 'ore',  // NEW: e vetmja kategori me njësi ORË
            'is_default'    => false,
            'ore_per_njesi' => 24,     // s'përdoret për 'ore' (llogaritet me fasha nga/ne), mbetet default
        ]);

        KategoriaPageses::create([
            'kategoria'     => 'fikse',
            'njesia_matjes' => 'dite',
            'is_default'    => false,
            'ore_per_njesi' => 24,     // s'përdoret realisht për çmim fiks, vlerë neutrale
        ]);
    }
}
