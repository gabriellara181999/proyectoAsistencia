<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions=[
            //usuario
            'usuario',
            'usuario-ver',
            'usuario-crear',
            'usuario-editar',
            'usuario-eliminar',
            'usuario-facultad',
            //roles
            'rol',
            'rol-ver',
            'rol-crear',
            'rol-editar',
            'rol-eliminar',
            //carrera
            'carrera',
            'carrera-ver',
            'carrera-crear',
            'carrera-editar',
            'carrera-eliminar',
            //materias
            'materia',
            'materia-ver',
            'materia-crear',
            'materia-editar',
            'materia-eliminar',
            'materia-carrera',
            'materia-usuario',
            'materia-horario',
            //alumno
            'alumno',
            'alumno-ver',
            'alumno-crear',
            'alumno-editar',
            'alumno-eliminar',
            'alumno-carrera',
            'alumno-materia',
            //horarios
            'horario',
            'horario-ver',
            //catedartico
            'catedratico',
            'catedratico-ver',
            //catedratico-asistencia
            'asistencia',
            'asistencia-ver',
            'asistencia-materia',
            'asistencia-crear',
            'asistencia-alumno',
            //administrador
            'administrador',
            'administrador-ver',
            'administrador-contar',
            //botones
            'boton-administrador',
            'boton-usuario',
            'boton-estudiante',
            'boton-carrera',
            'boton-materia',
            'boton-rol',
            'boton-horario',
            'boton-catedratico'
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
