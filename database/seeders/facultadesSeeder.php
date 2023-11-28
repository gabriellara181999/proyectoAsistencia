<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class facultadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $facultades = [
            'Facultad de Ciencias Económicas',
            'Facultad de Ciencias y Humanidades',
            'Facultad de Jurisprudencia y Ciencias Sociales',
            'Administrador'
        ];

        foreach ($facultades as $facultad) {
            $created_at = Carbon::now()->format('Y-m-d H:i:s');
            $updated_at = Carbon::now()->format('Y-m-d H:i:s');
            DB::table('facultades')->insert([
                'nombreFacultad' => $facultad,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
        }

    }
}
