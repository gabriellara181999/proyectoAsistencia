<?php

namespace App\Http\Controllers;

use App\Models\alumno;
use App\Models\Facultade;
use App\Models\carrera;
use App\Models\materia;
use App\Models\alumnoMaterias;
use App\Models\materiaInscrita;
use App\Models\ciclo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:alumno-ver|alumno-crear|alumno-editar|alumno-eliminar', ['only' => ['index', 'show']]);
        $this->middleware('permission:alumno-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:alumno-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:alumno-eliminar', ['only' => ['destroy']]);
        $this->middleware('permission:alumno-carrera', ['only' => ['carrerasFacultad']]);
        $this->middleware('permission:alumno-materia', ['only' => ['materiasAlumno', 'materiasindexAlumno']]);
    }
    public function index()
    {
        //
        $estudiante= alumno::select('alumnos.name', 'alumnos.apellido','alumnos.fechaNacimiento', 'alumnos.sexo','alumnos.numeroEstudiante', 'alumnos.email', 'alumnos.password', 'alumnos.telefono','materia_inscritas.cantidadMateria', 'ciclos.nombreCiclo', 'facultades.nombreFacultad','carreras.nombreCarrera', 'alumnos.id as alumno_id')->join('materia_inscritas', 'materia_inscritas.id', '=', 'alumnos.materiaInscrita_id')->join('ciclos', 'ciclos.id', '=', 'alumnos.ciclo_id')->join('carreras', 'carreras.id','=','alumnos.carrera_id')->join('facultades', 'facultades.id','=','carreras.facultad_id')->get();
        $contador=0;
        return view('admins.alumnos.index')->with('estudiante', $estudiante)->with('contador', $contador);
    }

    public function create()
    {
        //
        $ciclo=ciclo::select('id', 'nombreCiclo')->get();
        $facultades = [4];
        $facultad=Facultade::select('id', 'nombreFacultad')->whereNotIn('facultades.id', $facultades)->get();
        $materiaInscrita=materiaInscrita::select('id', 'cantidadMateria')->get();
        return view('admins.alumnos.addEstudiantes')->with('ciclo', $ciclo)->with('facultad', $facultad)->with('materiaInscrita', $materiaInscrita);
    }

    public function store(Request $request)
    {
        //
        $rules = [
            'name' => 'required|string|max:255|regex:/^[A-Z][a-z]*( [A-Z][a-z]*)*$/',
            'apellido' => 'required|string|max:255|regex:/^[A-Z][a-z]*( [A-Z][a-z]*)*$/',
            'fechaNacimiento' => 'required|date|before_or_equal:-18 years',
            'email' => 'required|string|email|max:255|unique:alumnos,email',
            'sexo' => 'required|not_in:0',
            'numeroEstudiante' => 'required|string|regex:/^[A-Z]{2}\d{0,9}$/|min:11|max:11|unique:alumnos,numeroEstudiante',
            'password' => 'required|min:8|max:15',
            'telefono' => 'required',
            'facultad_id' => 'required|not_in:0',
            'carrera_id' => 'required|not_in:0',
            'ciclo_id' => 'required|not_in:0',
        ];
        $attributes = [
            'name' => ['required'=>'Ingrese un nombre','regex' => 'Los nombres deben tener la primera letra de cada palabra en mayúscula.'],
            'apellido' => ['required'=>'Ingrese un apellido','regex' => 'Los apellidos deben tener la primera letra de cada palabra en mayúscula.'],
            'fechaNacimiento' => 'Ingrese una fecha válida o mayor a 18 años',
            'email' => ['required'=>'Ingrese un correo', 'unique'=>'El correo electronico ya esta en uso'],
            'sexo' => 'Seleccione su sexo',
            'numeroEstudiante'=>['required' => 'Ingrese su número de catedrático.','regex' => 'El campo código debe tener dos letras mayúsculas seguidas de números.', 'min' => 'El campo código no puede tener menos de :min caracteres.','max' => 'El campo código no puede tener más de :max caracteres.','unique'=>'El número de estudiante ya esta en uso'],
            'password' => ['min'=>'La contraseña debe tener al menos :min caracteres','max'=>'La contraseña debe tener maximo :max caracteres','required'=>'Ingrese la contraseña'],
            'telefono' => 'Ingrese un número teléfonico',
            'facultad_id' => 'Seleccione una facultad',
            'carrera_id' => 'Seleccione una carrera',
            'ciclo_id' => 'Seleccione un ciclo'
        ];
    
        $validator = Validator::make($request->all(), $rules, $attributes);
    
        if ($validator->fails()) {
            toastr()->error('Debe de completar los campos requeridos', 'Error');
            return redirect()->route('estudiantes.create')->withErrors($validator)->withInput();
        }
        $materiasSeleccionadas = $request->input('materiasSeleccionadas');
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $data1=[
            'name' => $request->input('name'),
            'apellido' => $request->input('apellido'),
            'fechaNacimiento' => $request->input('fechaNacimiento'),
            'sexo' => ($request->input('sexo') === 'Femenino') ? 'F' : 'M',
            'numeroEstudiante' => $request->input('numeroEstudiante'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'telefono' => $request->input('telefono'),
            'ciclo_id' => $request->input('ciclo_id'),
            'carrera_id' => $request->input('carrera_id'),
            'materiaInscrita_id' => count($materiasSeleccionadas)
        ];
        $alumno=alumno::create($data1);
        $alumno->save();
        $numeroAlumno=$request->input('numeroEstudiante');
        $alumnoSeleccionado=alumno::where('numeroEstudiante', $numeroAlumno)->select('id')->get();
        $datosAsociativos = [];
        foreach ($materiasSeleccionadas as $materia) {
            foreach ($alumnoSeleccionado as $alumnoSeleccionados) {
                $datosAsociativos[] = [
                    'alumno_id' => $alumnoSeleccionados->id,
                    'materia_id' => $materia,
                ];
            }
        }
        $materiasAlumno=alumnoMaterias::insert($datosAsociativos);
        if($materiasAlumno){
            toastr()->success('Exito al guardar', 'Exito!');
            return redirect()->route('estudiantes.index');
        }
    }

    public function edit($id)
    {
        //
        $ciclo=ciclo::select('id', 'nombreCiclo')->get();
        $facultades = [4];
        $facultad=Facultade::select('id', 'nombreFacultad')->whereNotIn('facultades.id', $facultades)->get();
        $materiaInscrita=materiaInscrita::select('id', 'cantidadMateria')->get();
        $alumno=alumno::select('id', 'name', 'apellido', 'fechaNacimiento', 'numeroEstudiante','email', 'telefono')->findOrFail($id);
        return view('admins.alumnos.editEstudiantes')->with('alumno', $alumno)->with('ciclo', $ciclo)->with('facultad', $facultad)->with('materiaInscrita', $materiaInscrita);
    }

    public function update(Request $request, $id)
    {
        //
        $rules = [
            'name' => 'required|string|max:255|regex:/^[A-Z][a-z]*( [A-Z][a-z]*)*$/',
            'apellido' => 'required|string|max:255|regex:/^[A-Z][a-z]*( [A-Z][a-z]*)*$/',
            'fechaNacimiento' => 'required|date|before_or_equal:-18 years',
            'email' => 'required|string|email|max:255',
            'sexo' => 'required|not_in:0',
            'numeroEstudiante' => 'required|string|regex:/^[A-Z]{2}\d{0,9}$/|min:11|max:11',
            'password' => 'required|min:8|max:15',
            'telefono' => 'required',
            'facultad_id' => 'required|not_in:0',
            'carrera_id' => 'required|not_in:0',
            'ciclo_id' => 'required|not_in:0',
        ];
        $attributes = [
            'name' => ['required'=>'Ingrese un nombre','regex' => 'Los nombres deben tener la primera letra de cada palabra en mayúscula.'],
            'apellido' => ['required'=>'Ingrese un apellido','regex' => 'Los apellidos deben tener la primera letra de cada palabra en mayúscula.'],
            'fechaNacimiento' => 'Ingrese una fecha válida o mayor a 18 años',
            'email' => ['required'=>'Ingrese un correo', 'unique'=>'El correo electronico ya esta en uso'],
            'sexo' => 'Seleccione su sexo',
            'numeroEstudiante'=>['required' => 'Ingrese su número de catedrático.','regex' => 'El campo código debe tener dos letras mayúsculas seguidas de números.', 'min' => 'El campo código no puede tener menos de :min caracteres.','max' => 'El campo código no puede tener más de :max caracteres.','unique'=>'El número de estudiante ya esta en uso'],
            'password' => ['min'=>'La contraseña debe tener al menos :min caracteres','max'=>'La contraseña debe tener maximo :max caracteres','required'=>'Ingrese la contraseña'],
            'telefono' => 'Ingrese un número teléfonico',
            'facultad_id' => 'Seleccione una facultad',
            'carrera_id' => 'Seleccione una carrera',
            'ciclo_id' => 'Seleccione un ciclo'
        ];
    
        $validator = Validator::make($request->all(), $rules, $attributes);
        if ($validator->fails()) {
            toastr()->error('Debe de completar los campos requeridos', 'Error');
            return redirect()->route('estudiantes.edit',['estudiante' => $id])->withErrors($validator)->withInput();
        }
        $materiasSeleccionadas = $request->input('materiasSeleccionadas');
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $data1=[
            'name' => $request->input('name'),
            'apellido' => $request->input('apellido'),
            'fechaNacimiento' => $request->input('fechaNacimiento'),
            'sexo' => ($request->input('sexo') === 'Femenino') ? 'F' : 'M',
            'numeroEstudiante' => $request->input('numeroEstudiante'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'telefono' => $request->input('telefono'),
            'ciclo_id' => $request->input('ciclo_id'),
            'carrera_id' => $request->input('carrera_id'),
            'materiaInscrita_id' => count($materiasSeleccionadas)
        ];
        $alumno=alumno::find($id);
        $alumno->update($data1);
        $alumno->save();
        $alumnoMateria=alumnoMaterias::where('alumno_id', $id);
        $alumnoMateria->delete();
        $numeroAlumno=$request->input('numeroEstudiante');
        $alumnoSeleccionado=alumno::where('numeroEstudiante', $numeroAlumno)->select('id')->get();
        $datosAsociativos = [];
        foreach ($materiasSeleccionadas as $materia) {
            foreach ($alumnoSeleccionado as $alumnoSeleccionados) {
                $datosAsociativos[] = [
                    'alumno_id' => $alumnoSeleccionados->id,
                    'materia_id' => $materia,
                ];
            }
        }
        $materiasAlumno=alumnoMaterias::insert($datosAsociativos);
        if($materiasAlumno){
            toastr()->success('Exito al modificar', 'Exito!');
            return redirect()->route('estudiantes.index');
        }

    }

    public function destroy($id)
    {
        //
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $alumno = alumno::find($id);
        $alumno->delete();
        $alumnoMateria=alumnoMaterias::where('alumno_id', $id);
        $alumnoMateria->delete();
        toastr()->success('Exito al eliminar', 'Exito!');
        return redirect()->route('estudiantes.index');
    }

    public function carrerasFacultad($id){
        $carrera=carrera::where('facultad_id', $id)->select('id', 'nombreCarrera')->get();
        return response()->json($carrera);
    }

    public function materiasAlumno($id){
        $materia = materia::where('materias.carrera_id', $id)->select('materias.nombreMateria','ciclos.nombreCiclo','users.name','users.apellido','carreras.nombreCarrera','dh1.nombreDia AS nombreDia1','dh2.nombreDia AS nombreDia2','h1.turno AS turno1','h2.turno AS turno2','h1.horaApertura AS horaApertura1','h2.horaApertura AS horaApertura2','h1.horaFinalizacion AS horaFinalizacion1','h2.horaFinalizacion AS horaFinalizacion2','materias.id as materias_id')->join('ciclos', 'ciclos.id', '=', 'materias.ciclo_id')->join('users', 'users.id', '=', 'materias.user_id')->join('carreras', 'carreras.id', '=', 'materias.carrera_id')->leftJoin('dia_horarios AS dh1', 'dh1.id', '=', 'materias.diaHorario_id')->leftJoin('horarios AS h1', 'h1.id', '=', 'dh1.horario_id')->leftJoin('dia_horarios AS dh2', 'dh2.id', '=', 'materias.diaHorario_idv2')->leftJoin('horarios AS h2', 'h2.id', '=', 'dh2.horario_id')->get();
        return response()->json($materia);
    }

    public function materiasindexAlumno($id){
        $alumnoMateria=alumnoMaterias::where('alumno_id',$id)->select('materias.diaHorario_idv2','materias.nombreMateria','users.name','users.apellido','ciclos.nombreCiclo','dh1.nombreDia AS nombreDia1','dh2.nombreDia AS nombreDia2','h1.turno AS turno1','h2.turno AS turno2','h1.horaApertura AS horaApertura1','h2.horaApertura AS horaApertura2','h1.horaFinalizacion AS horaFinalizacion1','h2.horaFinalizacion AS horaFinalizacion2')->join('materias','materias.id','=','alumnoMaterias.materia_id')->join('users','users.id','=','materias.user_id')->join('ciclos', 'ciclos.id', '=', 'materias.ciclo_id')->leftJoin('dia_horarios AS dh1', 'dh1.id', '=', 'materias.diaHorario_id')->leftJoin('horarios AS h1', 'h1.id', '=', 'dh1.horario_id')->leftJoin('dia_horarios AS dh2', 'dh2.id', '=', 'materias.diaHorario_idv2')->leftJoin('horarios AS h2', 'h2.id', '=', 'dh2.horario_id')->get();
        return response()->json($alumnoMateria);
    }
}
