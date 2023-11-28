<?php

namespace Database\Seeders;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::create([
            'name' => 'Admin',
            'apellido' => 'Admin',
            'fechaNacimiento'=>'2023-10-23',
            'email' => 'admin@uma.edu.sv',
            'sexo'=>'M',
            'numeroCatedratico'=>'AA111111111',
            'password' => Hash::make('adminuma123'),
            'telefono'=>'1111-1111',
            'carrera_id'=>'1',
            'role_name' => 'Administrador',
        ]);


        $user->assignRole('Administrador');
    }
}
