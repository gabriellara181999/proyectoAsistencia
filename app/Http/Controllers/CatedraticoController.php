<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class CatedraticoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:catedratico-ver', ['only' => ['index', 'show']]);
    }
    public function index()
    {
        //
        $usuario = [1];
        $catedratico=User::select('users.name','users.apellido', 'carreras.nombreCarrera','facultades.nombreFacultad','users.id as users_id')->join('carreras','carreras.id','=','users.carrera_id')->join('facultades','facultades.id','=','carreras.facultad_id')->whereNotIn('users.id', $usuario)->get();
        $contador=0;
        return view('admins.catedraticos.index')->with('catedratico',$catedratico)->with('contador', $contador);
    }
}
