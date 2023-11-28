<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class materiaInscritaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cantidadMateria = [
            '1',
            '2',
            '3',
            '4',
            '5',
            '6'
        ];

        foreach ($cantidadMateria as $cantidadMaterias) {
            $created_at = Carbon::now()->format('Y-m-d H:i:s');
            $updated_at = Carbon::now()->format('Y-m-d H:i:s');
            DB::table('materia_inscritas')->insert([
                'cantidadMateria' => $cantidadMaterias,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
        }
    }
}
