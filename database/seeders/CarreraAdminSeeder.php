<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CarreraAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $carreras = [
            'Administrador'
        ];

        foreach ($carreras as $carrera) {
            $created_at = Carbon::now()->format('Y-m-d H:i:s');
            $updated_at = Carbon::now()->format('Y-m-d H:i:s');
            DB::table('carreras')->insert([
                'nombreCarrera' => $carrera,
                'facultad_id' => '4',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
        }
    }
}
