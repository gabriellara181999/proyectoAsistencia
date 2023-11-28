<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:administrador-ver', ['only' => ['index']]);
        $this->middleware('permission:administrador-contar', ['only' => ['countAndShow',]]);
    }

    public function index()
    {

        $models = [
            [
                'model' => 'User',
                'nameText' => 'Usuarios',
                'color' => 'primary',
                'icon' => 'fa-users',
                'route' => 'usuarios.index',
            ],
            [
                'model' => 'carrera',
                'nameText' => 'Carreras',
                'color' => 'dark',
                'icon' => 'fa-user-tie',
                'route' => 'carreras.index',
            ],
            [
                'model' => 'Role',
                'nameText' => 'Roles',
                'color' => 'info',
                'icon' => 'fa-lock',
                'route' => 'roles.index',
            ],
            [
                'model' => 'materia',
                'nameText' => 'Materias',
                'color' => 'warning',
                'icon' => 'fa-book',
                'route' => 'materias.index',
            ],
            [
                'model' => 'alumno',
                'nameText' => 'Estudiantes',
                'color' => 'success',
                'icon' => 'fa-graduation-cap',
                'route' => 'estudiantes.index',
            ],
            [
                'model' => 'diaHorario',
                'nameText' => 'Horarios',
                'color' => 'danger',
                'icon' => 'fa-calendar-alt',
                'route' => 'estudiantes.index',
            ]
        ];
        return $this->countAndShow($models);
    }
    public function countAndShow($models){
        $data = [];

        foreach ($models as $modelInfo) {
            $modelName = $modelInfo['model'];
            $viewName = $modelInfo['route'];
            $nameText = $modelInfo['nameText'];
            $color = $modelInfo['color'];
            $icon = $modelInfo['icon'];

            $model = app("App\\Models\\$modelName");
            $count = $model::count();

            $data[] = [
                'modelName' => $modelName,
                'total' => $count,
                'nameText' => $nameText,
                'viewName' => $viewName,
                'color' => $color,
                'icon' => $icon,
            ];
        }
        return view('admins.index')->with('data', $data);
    }
}
