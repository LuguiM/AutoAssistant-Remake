<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Roles;


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::create([
            'rol' => 'Admin',
        ]);

        Roles::create([
            'rol' => 'conductor',
        ]);

        Roles::create([
            'rol' => 'futuro_conductor',
        ]);

        Roles::create([
            'rol' => 'mecanico_independiente',
        ]);

        Roles::create([
            'rol' => 'taller_mecanico',
        ]);
    }
}
