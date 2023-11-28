<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\alumno;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use \Firebase\JWT\JWT;
use App\Models\alumnoMaterias;

class UsuarioApiController extends Controller
{
    //
    public function login(Request $request){
        $numeroEstudiante = $request->input('numeroEstudiante');
        $password = $request->input('password');
    
        // Buscar el usuario por número de estudiante
        $alumno = alumno::where('numeroEstudiante', $numeroEstudiante)->first();
    
        // Verificar si se encontró un usuario y la contraseña es válida
        if ($alumno && Hash::check($password, $alumno->password)) {
            // Las credenciales son correctas, puedes hacer lo que necesites aquí
            // Por ejemplo, iniciar sesión del usuario
            /* Auth::login($alumno); */
            $token = $alumno->createToken('token-name')->plainTextToken;
            // Resto de la lógica...
            $datos = [
                'id' => $alumno->id,
                'name' => $alumno->name,
                'apellido' => $alumno->apellido,
            ];
            Auth::user();
            Auth::attempt($datos);
            // Resto de la lógica...
    
            return response()->json(['message' => 'Login exitoso', 'alumno' => $datos,'token' => $token,], 200);
        } else {
            // Credenciales incorrectas
            return response()->json(['message' => 'Credenciales invalidas'], 401);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token) {
            // Eliminar el token
            if ($request->user()) {
                $request->user()->currentAccessToken()->delete();
                return response()->json(['message' => 'Logout exitoso'], 200);
            } else {
                return response()->json(['message' => 'Usuario no autenticado'], 401);
            }
        } else {
            return response()->json(['message' => 'Token no proporcionado'], 401);
        }
    }

    public function listadoMaterias(Request $request){
        $token = $request->header('Authorization');
        if ($token) {
            if ($request->user()) {
                $idAlumno=$request->user()->id;
                $alumnoMateria=alumnoMaterias::where('alumno_id',$idAlumno)->select('materias.diaHorario_idv2','materias.nombreMateria','users.name','users.apellido','ciclos.nombreCiclo','dh1.nombreDia AS nombreDia1','dh2.nombreDia AS nombreDia2','h1.turno AS turno1','h2.turno AS turno2','h1.horaApertura AS horaApertura1','h2.horaApertura AS horaApertura2','h1.horaFinalizacion AS horaFinalizacion1','h2.horaFinalizacion AS horaFinalizacion2')->join('materias','materias.id','=','alumnoMaterias.materia_id')->join('users','users.id','=','materias.user_id')->join('ciclos', 'ciclos.id', '=', 'materias.ciclo_id')->leftJoin('dia_horarios AS dh1', 'dh1.id', '=', 'materias.diaHorario_id')->leftJoin('horarios AS h1', 'h1.id', '=', 'dh1.horario_id')->leftJoin('dia_horarios AS dh2', 'dh2.id', '=', 'materias.diaHorario_idv2')->leftJoin('horarios AS h2', 'h2.id', '=', 'dh2.horario_id')->get();
                $totalMaterias = $alumnoMateria->count();
                return response()->json(['materias' => $alumnoMateria,'total_materias' => $totalMaterias ],201);
            } else {
                return response()->json(['message' => 'Usuario no autenticado'], 401);
            }
        } else {
            return response()->json(['message' => 'Token no proporcionado'], 401);
        }
    }

    public function recibirDatosQr(Request $request){
        $materia_id=decrypt($request->input('materia_id'));
        $user_id=decrypt($request->input('user_id'));
        dd($user_id);

    }
}
