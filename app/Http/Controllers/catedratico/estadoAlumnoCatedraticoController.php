<?php

namespace App\Http\Controllers\catedratico;
use App\Models\alumnoasistencia;
use App\Models\asistencia;
use App\Models\estadoAlumnoAsistencia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class estadoAlumnoCatedraticoController extends Controller
{
    //
    public function index($idAsistencia){
        $idAsistencia=decrypt($idAsistencia);
        $estado=alumnoasistencia::where('asistencia_id', $idAsistencia)->select( 'alumnoasistencias.fechaAsistencia','alumnoasistencias.alumno_id','alumnoasistencias.asistencia_id', 'alumnos.name', 'alumnos.apellido','estadoAlumnoAsistencias.id', 'estadoAlumnoAsistencias.nombreEstadoAlumno','alumnoasistencias.id as alumnoasistencia_id')->join('alumnos','alumnos.id','=','alumnoasistencias.alumno_id')->join('estadoAlumnoAsistencias', 'estadoAlumnoAsistencias.id','=','alumnoasistencias.estadoAlumno_id')->get();
        $estadoAlumno=estadoAlumnoAsistencia::select('id', 'nombreEstadoAlumno')->get();
        $contador=0;
        return view("catedraticos.estadoAlumno")->with("estado",$estado)->with("contador",$contador)->with("estadoAlumno",$estadoAlumno);
    }

    public function cambiasEstado(Request $request, $asistencia_id, $alumno_id){
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $input = $request->get('estadoAlumno_id');
        if($input===4){
            $asistencia=asistencia::find($asistencia_id);
            $datos=$asistencia->estudianteAsistencia+1;
            $asistencia->update(['estudianteAsistencia'=>$datos]);
        }
        $estado=alumnoasistencia::where("asistencia_id", $asistencia_id)->where('alumno_id', $alumno_id)->update(['estadoAlumno_id' => $input]);
        $asistenciaCifrada = encrypt($asistencia_id);
        if ($estado) {
            return response()->json(['success' => 200,'asistenciaCifrada' => $asistenciaCifrada]);
        } else {
            return response()->json(['err' => 'Campo incorrecto']);
        }
    }
}
