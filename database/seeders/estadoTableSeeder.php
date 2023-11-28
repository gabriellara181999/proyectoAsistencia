<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class estadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $estados = [
            'Activo',
            'Inactivo',
        ];

        foreach ($estados as $estado) {
            $created_at = Carbon::now()->format('Y-m-d H:i:s');
            $updated_at = Carbon::now()->format('Y-m-d H:i:s');
            DB::table('estados')->insert([
                'nombreEstado' => $estado,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);
        }
    }
}
