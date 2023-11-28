<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ciclosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $ciclos = [
            'Ciclo 1',
            'Ciclo 2',
            'Ciclo 3',
            'Ciclo 4',
            'Ciclo 5',
            'Ciclo 6',
            'Ciclo 7',
            'Ciclo 8',
            'Ciclo 9',
            'Ciclo 10',
        ];

        foreach ($ciclos as $ciclo) {
            $created_at = Carbon::now()->format('Y-m-d H:i:s');
            $updated_at = Carbon::now()->format('Y-m-d H:i:s');
            DB::table('ciclos')->insert([
                'nombreCiclo' => $ciclo,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
        }
    }
}
