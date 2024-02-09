<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estados;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estados::create([
            'estado' => 'Activo',
            'color' => 'primary',
            'icon' => 'mdi-cogs',
        ]);

        Estados::create([
            'estado' => 'En espera',
            'color' => 'grey',
            'icon' => 'mdi-clock-outline',
        ]);

        Estados::create([
            'estado' => 'Completado',
            'color' => 'green',
            'icon' => 'mdi-checkbox-marked-circle-outline',
        ]);

        Estados::create([
            'estado' => 'Cancelado',
            'color' => 'red',
            'icon' => 'mdi-delete-outline',
        ]);

        Estados::create([
            'estado' => 'Rechazado',
            'color' => 'orange-darken-4',
            'icon' => 'mdi-close-circle-outline',
        ]);
    }
}
