<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\diaHorario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleTableSeeder::class,
            PermissionTableSeeder::class,
            RoleHasPermissionTableSeeder::class,
            ciclosSeeder::class,
            facultadesSeeder::class,
            horariosTableSeeder::class,
            diahorariosTableSeeder::class,
            materiaInscritaTableSeeder::class,
            estadoTableSeeder::class,
            estadoAlumnoAsistenciasSeeder::class,
            CarreraAdminSeeder::class,
            AdminUserSeeder::class
        ]);
    }
}
