<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            KategoriaPagesesSeeder::class,
            MonedhaSeeder::class,
        ]);

        $admin = User::factory()->create([
            'name' => 'Paulin Meci',
            'email' => 'paulin.meci@gmail.com',
            'password' => Hash::make('0697749217'),
        ]);

        $admin->assignRole('admin');

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
