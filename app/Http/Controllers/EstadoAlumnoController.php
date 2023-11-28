<?php

namespace App\Http\Controllers;
use App\Models\alumnoasistencia;
use App\Models\asistencia;
use App\Models\estadoAlumnoAsistencia;
use Illuminate\Http\Request;

class EstadoAlumnoController extends Controller
{
    //
    public function __construct(){
        $this->middleware('permission:asistencia-alumno', ['only' => ['index', 'cambiasEstado']]);
    }
    public function index($idAsistencia){
        $estado=alumnoasistencia::where('asistencia_id', $idAsistencia)->select( 'alumnoasistencias.fechaAsistencia','alumnoasistencias.alumno_id','alumnoasistencias.asistencia_id', 'alumnos.name', 'alumnos.apellido','estadoAlumnoAsistencias.id', 'estadoAlumnoAsistencias.nombreEstadoAlumno','alumnoasistencias.id as alumnoasistencia_id')->join('alumnos','alumnos.id','=','alumnoasistencias.alumno_id')->join('estadoAlumnoAsistencias', 'estadoAlumnoAsistencias.id','=','alumnoasistencias.estadoAlumno_id')->get();
        $estadoAlumno=estadoAlumnoAsistencia::select('id', 'nombreEstadoAlumno')->get();
        $contador=0;
        return view("admins.estadoAlumno.index")->with("estado",$estado)->with("contador",$contador)->with("estadoAlumno",$estadoAlumno);
    }

    public function cambiasEstado(Request $request,$alumno_id, $asistencia_id){
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $input = $request->input('estadoAlumno');
        $estado=alumnoasistencia::where("asistencia_id", $asistencia_id)->where('alumno_id', $alumno_id)->update(['estadoAlumno_id' => $input]);
        if($input===4){
            $asistencia=asistencia::find($asistencia_id);
            $datos=$asistencia->estudianteAsistencia+1;
            $asistencia->update(['estudianteAsistencia'=>$datos]);
        }
        toastr()->success('Exito al modificar Alumno', 'Exito!');
        return redirect()->route('estadoAlumnoIndex',$asistencia_id);
    }
}
