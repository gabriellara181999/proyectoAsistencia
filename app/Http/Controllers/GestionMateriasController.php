<?php

namespace App\Http\Controllers;
use App\Models\estado;
use App\Models\materia;
use App\Models\asistencia;
use App\Models\QR;
use App\Models\alumnoMaterias;
use App\Models\alumnoasistencia;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Facades\Image;

class GestionMateriasController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:asistencia-ver|asistencia-materia|asistencia-crear|asistencia-alumno', ['only' => ['index']]);
        $this->middleware('permission:asistencia-materia', ['only' => ['asistenciaMateriaAlumno']]);
        $this->middleware('permission:asistencia-crear', ['only' => ['crearAsistencia']]);
        $this->middleware('permission:asistencia-alumno', ['only' => ['asistenciaId', 'estadisticaAsistencia']]);
    }

    public function index($id)
    {
        Carbon::setLocale('es');
        //hora actual
        $horaActual = Carbon::now()->format('h:i A');
        $fechaActual = Carbon::now();
        $diaActual = ucfirst($fechaActual->isoFormat('dddd'));
        $materiasUsuario=materia::where('user_id', $id)->select('materias.nombreMateria','materias.user_id','materias.diaHorario_idv2','ciclos.nombreCiclo','carreras.nombreCarrera','dh1.nombreDia AS nombreDia1','dh2.nombreDia AS nombreDia2','h1.turno AS turno1','h2.turno AS turno2','h1.horaApertura AS horaApertura1','h2.horaApertura AS horaApertura2','h1.horaFinalizacion AS horaFinalizacion1','h2.horaFinalizacion AS horaFinalizacion2','materias.id as materias_id', 'facultades.nombreFacultad','materias.id as materias_id')->join('ciclos', 'ciclos.id', '=', 'materias.ciclo_id')->join('users', 'users.id', '=', 'materias.user_id')->join('carreras', 'carreras.id', '=', 'materias.carrera_id')->join('facultades', 'facultades.id', '=', 'carreras.facultad_id')->leftJoin('dia_horarios AS dh1', 'dh1.id', '=', 'materias.diaHorario_id')->leftJoin('horarios AS h1', 'h1.id', '=', 'dh1.horario_id')->leftJoin('dia_horarios AS dh2', 'dh2.id', '=', 'materias.diaHorario_idv2')->leftJoin('horarios AS h2', 'h2.id', '=', 'dh2.horario_id')->get();
        return view('admins.catedraticos.gestionMaterias')->with('materiasUsuario', $materiasUsuario)->with('horaActual', $horaActual)->with('diaSemanaActual', $diaActual);
    }

    public function asistenciaMateriaAlumno($user_id,$materia_id){
        $fechaActual = Carbon::now();
        $fechaActual2 = Carbon::now();
         $inicioSemana = $fechaActual->startOfWeek();
        $finSemana = $fechaActual2->endOfWeek();
        $semanaMateria = materia::where('materias.user_id', $user_id)->where('materias.id', $materia_id)->select('dh1.nombreDia as nombreDia1', 'dh2.nombreDia as nombreDia2','h1.turno AS turno1','h2.turno AS turno2','h1.horaApertura AS horaApertura1','h2.horaApertura AS horaApertura2','h1.horaFinalizacion AS horaFinalizacion1','h2.horaFinalizacion AS horaFinalizacion2', 'materias.id as materias_id')->join('dia_horarios as dh1', 'dh1.id', '=', 'materias.diaHorario_id')->leftJoin('horarios AS h1', 'h1.id', '=', 'dh1.horario_id')->leftJoin('dia_horarios as dh2', 'dh2.id', '=', 'materias.diaHorario_idv2')->leftJoin('horarios AS h2', 'h2.id', '=', 'dh2.horario_id')->get();
        $diaActual = ucfirst(Carbon::now()->isoFormat('dddd'));
        $tieneDosDias = false;
        foreach ($semanaMateria as $materia) {
            if (($diaActual === $materia->nombreDia1 && !$materia->nombreDia2) || ($diaActual === $materia->nombreDia1 || $diaActual === $materia->nombreDia2)) {
                $tieneDosDias = true;
            }
        }
        $qrCreadoEnSemanaNueva=true;
        if ($tieneDosDias) {
            $diaActual = ucfirst(Carbon::now()->isoFormat('dddd'));
            $diasDeMateria = [
                $semanaMateria->first()->nombreDia1,
                $semanaMateria->first()->nombreDia2,
            ];
            $qrCreadoEnSemana = QR::join('asistencias', 'qrs.id', '=', 'asistencias.Qr_id')->where('asistencias.materia_id', $materia_id)->where('qrs.created_at', '>=', $inicioSemana)->where('qrs.created_at', '<=', $finSemana)->select('qrs.created_at')->count() > 0;

            if (in_array($diaActual, $diasDeMateria)) {
                if ($qrCreadoEnSemana) {
                    // Verificar si ya existe un código QR para el día actual
                    $codigoQREnDiaActual = QR::join('asistencias', 'qrs.id', '=', 'asistencias.Qr_id')
                        ->where('asistencias.materia_id', $materia_id)
                        ->whereDate('qrs.created_at', '=', Carbon::now()->toDateString())
                        ->count() > 0;

                    if (!$codigoQREnDiaActual) {
                        // Permitir la creación del código QR
                        // Aquí puedes agregar la lógica para crear el código QR.
                        // Luego, muestra un mensaje de éxito.
                       $qrCreadoEnSemanaNueva=false;
                    } else {
                        // Mensaje de error si ya se creó un código QR para el día actual
                        $qrCreadoEnSemanaNueva=true;
                    }
                } else {
                    // Permitir la creación del código QR si no se ha creado uno en la semana
                    // Aquí puedes agregar la lógica para crear el código QR.
                    // Luego, muestra un mensaje de éxito.
                    $qrCreadoEnSemanaNueva=false;
                }
            } else {
                // Mensaje de error si el día actual no coincide con el horario de la materia
                $qrCreadoEnSemanaNueva=true;
            }
        } else {
            $diaActual = ucfirst(Carbon::now()->isoFormat('dddd'));
            $diasDeMateria = [
                $semanaMateria->first()->nombreDia1,
                $semanaMateria->first()->nombreDia2,
            ];
            if (in_array($diaActual, $diasDeMateria)) {
                // Verificar si ya existe un código QR para el día actual
                $codigoQREnDiaActual = QR::join('asistencias', 'qrs.id', '=', 'asistencias.Qr_id')->where('asistencias.materia_id', $materia_id)->whereDate('qrs.created_at', '=', Carbon::now()->toDateString())->count() > 0;
                if (!$codigoQREnDiaActual) {
                    // Permitir la creación del código QR
                    // Aquí puedes agregar la lógica para crear el código QR.
                    // Luego, muestra un mensaje de éxito.
                    $qrCreadoEnSemanaNueva=false;
                } else {
                    // Mensaje de error si ya se creó un código QR para el día actual
                    $qrCreadoEnSemanaNueva=true;
                }
            } else {
                // Mensaje de error si el día actual no coincide con el horario de la materia
                $qrCreadoEnSemanaNueva=true;
            }
        }
        $materiaAsistencia = materia::join('asistencias', 'materias.id', '=', 'asistencias.materia_id')->select('asistencias.id', 'asistencias.fechaAsistencia','asistencias.materia_id','estados.nombreEstado')->join('estados','estados.id','=','asistencias.estado_id')->where('materias.user_id', $user_id)->where('materias.id', $materia_id)->get();
        $contador=0;
        return view('admins.catedraticos.gestionAsistenciaMateria')->with('materiaAsistencia',$materiaAsistencia)->with('materia_id', $materia_id)->with('user_id', $user_id)->with('contador', $contador)->with('qrCreadoEnSemana',$qrCreadoEnSemanaNueva);
    }

    public function crearAsistencia(Request $request){
        $user_id = $request->input('user_id');
        $materia_id= $request->input('materia_id');
        //alumnosinscritos conteo
        $alumnosMaterias=alumnoMaterias::where('materia_id', $materia_id)->count();
        //creando QR
        $nombreArchivo = uniqid('codigo_qr_') . '.svg';
        $materiaCifrada = encrypt($materia_id);
        $userCifrada = encrypt($user_id);
        $contenidoQR = route('recibirDatosQr', ['user_id' => $materiaCifrada, 'materia_id' => $userCifrada]);
        $codigoQRSVG = QrCode::errorCorrection('H')->size(200)->format('svg')->generate($contenidoQR);
        //guardamos el archivo
        $rutaAlmacenamiento = storage_path('app/public/qrs/' . $nombreArchivo);
        file_put_contents($rutaAlmacenamiento, $codigoQRSVG);

        //guardamos el nombre del Qr en la base de datos
        $qr=['ruta'=>$nombreArchivo];
        $qrNombre=QR::create($qr);
        $qrNombre->save();
        $estadoId = estado::where('id', 1)->first();
        $estado = $estadoId->id;
        $estudianteAlumno=0;
        $seleccionarQR = $qrNombre->id;
        $fechaActual = Carbon::now();
        $fechaYHora = $fechaActual->toDateTimeString();
        $datosAsistencia=[
            'fechaAsistencia'=>$fechaYHora,
            'inscritoMateria'=>$alumnosMaterias,
            'estudianteAsistencia'=>$estudianteAlumno,
            'materia_id'=>$materia_id,
            'user_id'=>$user_id,
            'Qr_id'=>$seleccionarQR,
            'estado_id'=>$estado
        ];
        $asistencia=asistencia::create($datosAsistencia);
        $asistencia->save();
        $idDeAsistencia = $asistencia->id;
        $asistenciaAlumno = AlumnoMaterias::join('materias', 'alumnoMaterias.materia_id', '=', 'materias.id')->where('materias.id', $materia_id)->select('alumnoMaterias.alumno_id')->get();
        foreach ($asistenciaAlumno as $registro) {
            $alumno_id = $registro->alumno_id;
            $fechaActual = Carbon::now()->format('Y-m-d H:i:s');
            $datosAsistenciaAlumno=[
                'fechaAsistencia'=>$fechaActual,
                'alumno_id' => $alumno_id,
                'estadoAlumno_id'=> 3,
                'asistencia_id'=>$idDeAsistencia
            ];
            $alumnoAsistencia=alumnoasistencia::create($datosAsistenciaAlumno);
            $alumnoAsistencia->save();
        }
        toastr()->success('Exito al crear QR', 'Exito!');
        return redirect()->route('asistenciaMateriaAlumno',['user_id'=>$user_id, 'materia_id'=>$materia_id]);
    }
    public function asistenciaId($id){
        $asistencia=asistencia::select('asistencias.fechaAsistencia','asistencias.inscritoMateria', 'asistencias.estudianteAsistencia','qrs.ruta','materias.nombreMateria','estados.nombreEstado','users.name','users.apellido','asistencias.id as asistencias_id')->join('qrs','qrs.id','=','asistencias.Qr_id')->join('materias','materias.id','=','asistencias.materia_id')->join('estados','estados.id','=','asistencias.estado_id')->join('users','users.id','=','asistencias.user_id')->where('asistencias.id',$id)->get();
        return response()->json($asistencia);
    }

    public function estadisticaAsistencia($id){
        $asistencia=asistencia::select('asistencias.inscritoMateria', 'asistencias.estudianteAsistencia')->where('id',$id)->get();
        return response()->json($asistencia);
    }
}
