<?php

namespace App\Http\Controllers;
use App\Models\alumnoasistencia;
use App\Models\estadoAlumnoAsistencia;
use App\Models\materia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReporteController extends Controller
{
    //

    public function index()
    {
        //
        $usuario = [1];
        $catedratico=User::select('users.name','users.apellido', 'carreras.nombreCarrera','facultades.nombreFacultad','users.id as users_id')->join('carreras','carreras.id','=','users.carrera_id')->join('facultades','facultades.id','=','carreras.facultad_id')->whereNotIn('users.id', $usuario)->get();
        $contador=0;
        return view('admins.reportes.index')->with('catedratico',$catedratico)->with('contador', $contador);
    }

    public function materiaCatedratico($id)
    {
        $materiasUsuario=materia::where('user_id', $id)->select('materias.nombreMateria','materias.user_id','materias.diaHorario_idv2','ciclos.nombreCiclo','carreras.nombreCarrera','dh1.nombreDia AS nombreDia1','dh2.nombreDia AS nombreDia2','h1.turno AS turno1','h2.turno AS turno2','h1.horaApertura AS horaApertura1','h2.horaApertura AS horaApertura2','h1.horaFinalizacion AS horaFinalizacion1','h2.horaFinalizacion AS horaFinalizacion2','materias.id as materias_id', 'facultades.nombreFacultad','materias.id as materias_id')->join('ciclos', 'ciclos.id', '=', 'materias.ciclo_id')->join('users', 'users.id', '=', 'materias.user_id')->join('carreras', 'carreras.id', '=', 'materias.carrera_id')->join('facultades', 'facultades.id', '=', 'carreras.facultad_id')->leftJoin('dia_horarios AS dh1', 'dh1.id', '=', 'materias.diaHorario_id')->leftJoin('horarios AS h1', 'h1.id', '=', 'dh1.horario_id')->leftJoin('dia_horarios AS dh2', 'dh2.id', '=', 'materias.diaHorario_idv2')->leftJoin('horarios AS h2', 'h2.id', '=', 'dh2.horario_id')->get();
        return view('admins.reportes.gestionMaterias')->with('materiasUsuario', $materiasUsuario);
    }

    public function reporteMateriaCatedratico($user_id,$materia_id){
        $fechaActual = Carbon::now();
        $fechaFormateada = $fechaActual->format('d-m-Y h:i:s A');
        $materiaAsistencia = materia::join('asistencias', 'materias.id', '=', 'asistencias.materia_id')->select('materias.nombreMateria','asistencias.id', 'asistencias.fechaAsistencia', 'asistencias.inscritoMateria','asistencias.estudianteAsistencia')->where('materias.user_id', $user_id)->where('materias.id', $materia_id)->get();
        $contador=0;
        return view('admins.reportes.gestionReporteMateria')->with('materiaAsistencia', $materiaAsistencia)->with('contador', $contador)->with('fecha', $fechaFormateada);
    }
    public function reporteMateriaCatedraticoAlumno($idAsistencia){
        $fechaActual = Carbon::now();
        $fechaFormateada = $fechaActual->format('d-m-Y h:i:s A');
        $estado=alumnoasistencia::where('asistencia_id', $idAsistencia)->select( 'alumnoasistencias.fechaAsistencia','alumnoasistencias.alumno_id','alumnoasistencias.asistencia_id', 'alumnos.name', 'alumnos.apellido','alumnos.numeroEstudiante','ciclos.nombreCiclo','estadoAlumnoAsistencias.id', 'estadoAlumnoAsistencias.nombreEstadoAlumno','alumnoasistencias.id as alumnoasistencia_id')->join('alumnos','alumnos.id','=','alumnoasistencias.alumno_id')->join('estadoAlumnoAsistencias', 'estadoAlumnoAsistencias.id','=','alumnoasistencias.estadoAlumno_id')->join('ciclos', 'ciclos.id','=','alumnos.ciclo_id')->get();
        $materia=alumnoasistencia::where('asistencia_id', $idAsistencia)->join('asistencias','asistencias.id','=','alumnoasistencias.asistencia_id')->join('materias','materias.id','=','asistencias.materia_id')->select('materias.nombreMateria')->get();
        $contador=0;
        return view("admins.reportes.gestionReporteMateriaAlumno")->with("estado",$estado)->with("contador",$contador)->with('materia',$materia)->with('fecha', $fechaFormateada);;
    }
}
