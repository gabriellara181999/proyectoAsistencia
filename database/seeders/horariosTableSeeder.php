<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class horariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $horario = [
            [
                'turno' => 'Matutino',
                'horaApertura' => '08:00 AM',
                'horaFinalizacion' => '11:40 AM',
            ],
            [
                'turno' => 'Vespertino',
                'horaApertura' => '01:00 PM',
                'horaFinalizacion' => '04:40 PM',
            ],
            [
                'turno' => 'Nocturno',
                'horaApertura' => '05:00 PM',
                'horaFinalizacion' => '08:30 PM',
            ],
            [
                'turno' => 'Nocturno',
                'horaApertura' => '05:00 PM',
                'horaFinalizacion' => '06:40 PM',
            ],
            [
                'turno' => 'Nocturno',
                'horaApertura' => '06:50 PM',
                'horaFinalizacion' => '08:30 PM',
            ],
        ];
        
        foreach ($horario as $data) {
            $now = Carbon::now()->format('Y-m-d H:i:s');
            
            // Crear instancias de Carbon para la apertura y finalización
            $horaFormatoApertura = Carbon::createFromFormat('h:i A', $data['horaApertura']);
            $horaFormatoFinalizacion = Carbon::createFromFormat('h:i A', $data['horaFinalizacion']);
            
            // Insertar en la base de datos
            DB::table('horarios')->insert([
                'turno' => $data['turno'],
                'horaApertura' => $horaFormatoApertura->format('h:i A'), // Hora de apertura en formato 12 horas
                'horaFinalizacion' => $horaFormatoFinalizacion->format('h:i A'), // Hora de finalización en formato 12 horas
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }        
    }
}
