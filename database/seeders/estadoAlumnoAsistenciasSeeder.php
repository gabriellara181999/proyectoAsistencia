<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class estadoAlumnoAsistenciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $estadoAlumno = [
            'Puntual',
            'Impuntual',
            'Ausente',
            'Permiso'
        ];

        foreach ($estadoAlumno as $estadoAlumnos) {
            $created_at = Carbon::now()->format('Y-m-d H:i:s');
            $updated_at = Carbon::now()->format('Y-m-d H:i:s');
            DB::table('estadoAlumnoAsistencias')->insert([
                'nombreEstadoAlumno' => $estadoAlumnos,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
        }
    }
}
