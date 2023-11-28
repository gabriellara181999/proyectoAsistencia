<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class diahorariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $dias = [
            ['nombreDia' => 'Lunes', 'horario_id' => 1],
            ['nombreDia' => 'Lunes', 'horario_id' => 2],
            ['nombreDia' => 'Lunes', 'horario_id' => 3],
            ['nombreDia' => 'Lunes', 'horario_id' => 4],
            ['nombreDia' => 'Lunes', 'horario_id' => 5],
            ['nombreDia' => 'Martes', 'horario_id' => 1],
            ['nombreDia' => 'Martes', 'horario_id' => 2],
            ['nombreDia' => 'Martes', 'horario_id' => 3],
            ['nombreDia' => 'Martes', 'horario_id' => 4],
            ['nombreDia' => 'Martes', 'horario_id' => 5],
            ['nombreDia' => 'Miércoles', 'horario_id' => 1],
            ['nombreDia' => 'Miércoles', 'horario_id' => 2],
            ['nombreDia' => 'Miércoles', 'horario_id' => 3],
            ['nombreDia' => 'Miércoles', 'horario_id' => 4],
            ['nombreDia' => 'Miércoles', 'horario_id' => 5],
            ['nombreDia' => 'Jueves', 'horario_id' => 1],
            ['nombreDia' => 'Jueves', 'horario_id' => 2],
            ['nombreDia' => 'Jueves', 'horario_id' => 3],
            ['nombreDia' => 'Jueves', 'horario_id' => 4],
            ['nombreDia' => 'Jueves', 'horario_id' => 5],
            ['nombreDia' => 'Viernes', 'horario_id' => 1],
            ['nombreDia' => 'Viernes', 'horario_id' => 2],
            ['nombreDia' => 'Viernes', 'horario_id' => 3],
            ['nombreDia' => 'Sábado', 'horario_id' => 1],
            ['nombreDia' => 'Sábado', 'horario_id' => 2]
        ];

        foreach ($dias as $dia) {
            $now = Carbon::now()->format('Y-m-d H:i:s');
            DB::table('dia_horarios')->insert([
                'nombreDia' => $dia['nombreDia'],
                'horario_id' => $dia['horario_id'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
