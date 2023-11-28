<?php

namespace App\Http\Controllers\catedratico;
use App\Models\asistencia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class consultasController extends Controller
{
    //
    public function catedraticoAsistenciaId($id){
        $asistencia=asistencia::select('asistencias.fechaAsistencia','asistencias.inscritoMateria', 'asistencias.estudianteAsistencia','qrs.ruta','materias.nombreMateria','estados.nombreEstado','users.name','users.apellido','asistencias.id as asistencias_id')->join('qrs','qrs.id','=','asistencias.Qr_id')->join('materias','materias.id','=','asistencias.materia_id')->join('estados','estados.id','=','asistencias.estado_id')->join('users','users.id','=','asistencias.user_id')->where('asistencias.id',$id)->get();
        return response()->json($asistencia);
    }

    public function catedraticoEstadisticaAsistencia($id){
        $asistencia=asistencia::select('asistencias.inscritoMateria', 'asistencias.estudianteAsistencia')->where('id',$id)->get();
        return response()->json($asistencia);
    }
}
