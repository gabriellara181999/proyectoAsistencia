<?php

namespace App\Http\Controllers;

use App\Models\diaHorario;
use Illuminate\Http\Request;

class DiaHorarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:horario-ver', ['only' => ['index', 'show']]);
    }
    public function index()
    {
        //
        $diaHorario=diaHorario::select('dia_horarios.*', 'horarios.turno', 'horarios.horaApertura', 'horarios.horaFinalizacion')->join('horarios', 'horarios.id', '=', 'dia_horarios.horario_id')->get();
        $contador=0;
        return view('admins.diaHorarios.index')->with('diaHorario', $diaHorario)->with('contador', $contador);
    }
}
