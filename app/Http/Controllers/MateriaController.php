<?php

namespace App\Http\Controllers;
use App\Models\ciclo;
use App\Models\Facultade;
use App\Models\User;
use App\Models\carrera;
use App\Models\diaHorario;
use Illuminate\Http\Request;
use App\Models\materia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class MateriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:materia-ver|materia-crear|materia-editar|materia-eliminar', ['only' => ['index', 'show']]);
        $this->middleware('permission:materia-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:materia-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:materia-eliminar', ['only' => ['destroy']]);
        $this->middleware('permission:materia-carrera', ['only' => ['carrerasFacultad']]);
        $this->middleware('permission:materia-usuario', ['only' => ['carrerasUser']]);
        $this->middleware('permission:materia-horario', ['only' => ['diaHorarioTurno', 'diaHorarioTurnoNocturno', 'diaHorarioTurnoNocturno2']]);
    }

    public function index()
    {
        //
        $materia = materia::select('materias.*','ciclos.nombreCiclo','users.name','users.apellido','carreras.nombreCarrera','dh1.nombreDia AS nombreDia1','dh2.nombreDia AS nombreDia2','h1.turno AS turno1','h2.turno AS turno2','h1.horaApertura AS horaApertura1','h2.horaApertura AS horaApertura2','h1.horaFinalizacion AS horaFinalizacion1','h2.horaFinalizacion AS horaFinalizacion2','materias.id as materias_id', 'facultades.nombreFacultad')->join('ciclos', 'ciclos.id', '=', 'materias.ciclo_id')->join('users', 'users.id', '=', 'materias.user_id')->join('carreras', 'carreras.id', '=', 'materias.carrera_id')->join('facultades', 'facultades.id', '=', 'carreras.facultad_id')->leftJoin('dia_horarios AS dh1', 'dh1.id', '=', 'materias.diaHorario_id')->leftJoin('horarios AS h1', 'h1.id', '=', 'dh1.horario_id')->leftJoin('dia_horarios AS dh2', 'dh2.id', '=', 'materias.diaHorario_idv2')->leftJoin('horarios AS h2', 'h2.id', '=', 'dh2.horario_id')->get();
        $contador=0;
        return view('admins.materias.index')->with('materia', $materia)->with('contador', $contador);
    }

    public function create()
    {
        //
        $diaHorario = diaHorario::all()->unique('nombreDia')->sortBy(function ($item) {switch ($item->nombreDia) {case 'lunes': return 1;case 'martes': return 2; case 'miércoles': return 3; case 'jueves': return 4; case 'viernes': return 5;case 'sábado': return 6; default:return 7;}});
        $diaHorario1 = diaHorario::whereIn('nombreDia', ['Lunes', 'Martes'])->get()->unique('nombreDia')->sortBy(function ($item) {switch ($item->nombreDia) { case 'Lunes': return 1; case 'Martes': return 2; default: return 3;}});
        $diaHorario2 = diaHorario::whereIn('nombreDia', ['Miércoles', 'Jueves'])->get()->unique('nombreDia')->sortBy(function ($item) {switch ($item->nombreDia) { case 'Miercoles': return 1; case 'Jueves': return 2; default: return 3;}});
        $ciclo=ciclo::select('id', 'nombreCiclo')->get();
        $facultades = [4];
        $facultad=Facultade::select('id', 'nombreFacultad')->whereNotIn('facultades.id', $facultades)->get();
        return view('admins.materias.addMateria')->with('ciclo', $ciclo)->with('facultad', $facultad)->with('diaHorario', $diaHorario)->with('diaHorario1', $diaHorario1)->with('diaHorario2', $diaHorario2);
    }

    public function store(Request $request)
    {
        //
        $rules = [
            'nombreMateria' => 'required|string|max:150',
            'numero' => 'required|numeric|digits_between:1,2',
            'requisito' => 'required|string|max:150',
            'unidadValorativa' => 'required|numeric|digits:1|between:1,9',
            'ciclo_id' => 'required|not_in:0',
            'user_id' => 'required|not_in:0',
            'facultad_id' => 'required|not_in:0',
            'carrera_id' => 'required|not_in:0',
            'dia_id' => Rule::requiredIf(function () use ($request) {
                return $request->input('jornada') === 'unica';
            }),
            'diaHorario_id' => Rule::requiredIf(function () use ($request) {
                return $request->input('jornada') === 'unica';
            }),
            'dia_id1' => Rule::requiredIf(function () use ($request) {
                return $request->input('jornada') === 'dividida';
            }),
            'diaHorario_idv1' => Rule::requiredIf(function () use ($request) {
                return $request->input('jornada') === 'dividida';
            }),
            'dia_id2' => Rule::requiredIf(function () use ($request) {
                return $request->input('jornada') === 'dividida';
            }),
            'diaHorario_idv2' => Rule::requiredIf(function () use ($request) {
                return $request->input('jornada') === 'dividida';
            }),
        ];
        $attributes = [
            'nombreMateria' => 'Ingrese un nombre de la carrera',
            'numero' => ['required' => 'Ingrese el numero', 'numeric' => 'Ingrese solo números', 'digits_between' => 'Solo acepta dos números'],
            'requisito' => 'Ingrese los requisitos de la materia',
            'unidadValorativa' => ['required' => 'Ingrese la unidad valorativa', 'numeric' => 'La unidad valorativa debe ser numérico.', 'digits' => 'La unidad valorativa solo debe contener un solo dígito.', 'between' => 'La unidad valorativa solo debe estar entre 1 y 9.'],
            'ciclo_id' => 'Seleccione un ciclo',
            'user_id' => 'Seleccione un catedrático',
            'facultad_id' => 'Seleccione una facultad',
            'carrera_id' => 'Seleccione una carrera',
            'dia_id' => 'Seleccione un dia',
            'diaHorario_id' => 'Seleccione un turno',
            'dia_id1' => 'Seleccione un dia',
            'diaHorario_idv1' => 'Seleccione un turno',
            'dia_id2' => 'Seleccione un dia',
            'diaHorario_idv2' => 'Seleccione un turno'
        ];
    
        $validator = Validator::make($request->all(), $rules, $attributes);
    
        if ($validator->fails()) {
            toastr()->error('Debe de completar los campos requeridos', 'Error');
            return redirect()->route('materias.create')->withErrors($validator)->withInput();
        }
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $jornada = $request->input('jornada');
        if($jornada ==='unica'){
            $datos=[
                'nombreMateria' => $request->input('nombreMateria'),
                'numero' => $request->input('numero'),
                'requisito' => $request->input('requisito'),
                'unidadValorativa' => $request->input('unidadValorativa'),
                'ciclo_id' => $request->input('ciclo_id'),
                'user_id' => $request->input('user_id'),
                'carrera_id' => $request->input('carrera_id'),
                'diaHorario_id' => $request->input('diaHorario_id'),
            ];
        }else if( $jornada === 'dividida'){
            $datos=[
                'nombreMateria' => $request->input('nombreMateria'),
                'numero' => $request->input('numero'),
                'requisito' => $request->input('requisito'),
                'unidadValorativa' => $request->input('unidadValorativa'),
                'ciclo_id' => $request->input('ciclo_id'),
                'user_id' => $request->input('user_id'),
                'carrera_id' => $request->input('carrera_id'),
                'diaHorario_id' => $request->input('diaHorario_idv1'),
                'diaHorario_idv2' => $request->input('diaHorario_idv2'),
            ];
        }
        //envioDatos
        $materia=materia::create($datos);
        $materia->save();
        toastr()->success('Exito al guardar', 'Exito!');
        return redirect()->route('materias.index');
    }

    public function edit($materias_id)
    {
        //
        $materia=materia::findOrFail($materias_id);
        $diaHorario = diaHorario::all()->unique('nombreDia')->sortBy(function ($item) {switch ($item->nombreDia) {case 'lunes': return 1;case 'martes': return 2; case 'miércoles': return 3; case 'jueves': return 4; case 'viernes': return 5;case 'sábado': return 6; default:return 7;}});
        $diaHorario1 = diaHorario::whereIn('nombreDia', ['Lunes', 'Martes'])->get()->unique('nombreDia')->sortBy(function ($item) {switch ($item->nombreDia) { case 'Lunes': return 1; case 'Martes': return 2; default: return 3;}});
        $diaHorario2 = diaHorario::whereIn('nombreDia', ['Miércoles', 'Jueves'])->get()->unique('nombreDia')->sortBy(function ($item) {switch ($item->nombreDia) { case 'Miercoles': return 1; case 'Jueves': return 2; default: return 3;}});
        $ciclo=ciclo::select('id', 'nombreCiclo')->get();
        $facultades = [4];
        $facultad=Facultade::select('id', 'nombreFacultad')->whereNotIn('facultades.id', $facultades)->get();
        return view('admins.materias.editMateria')->with('materias',$materia)->with('ciclo', $ciclo)->with('facultad', $facultad)->with('diaHorario',$diaHorario)->with('diaHorario1',$diaHorario1)->with('diaHorario2',$diaHorario2);
    }

    public function update(Request $request, $id)
    {
        //
        $rules = [
            'nombreMateria' => 'required|string|max:150',
            'numero' => 'required|numeric|digits_between:1,2',
            'requisito' => 'required|string|max:150',
            'unidadValorativa' => 'required|numeric|digits:1|between:1,9',
            'ciclo_id' => 'required|not_in:0',
            'user_id' => 'required|not_in:0',
            'facultad_id' => 'required|not_in:0',
            'carrera_id' => 'required|not_in:0',
            'dia_id' => Rule::requiredIf(function () use ($request) {
                return $request->input('jornada') === 'unica';
            }),
            'diaHorario_id' => Rule::requiredIf(function () use ($request) {
                return $request->input('jornada') === 'unica';
            }),
            'dia_id1' => Rule::requiredIf(function () use ($request) {
                return $request->input('jornada') === 'dividida';
            }),
            'diaHorario_id1' => Rule::requiredIf(function () use ($request) {
                return $request->input('jornada') === 'dividida';
            }),
            'dia_id2' => Rule::requiredIf(function () use ($request) {
                return $request->input('jornada') === 'dividida';
            }),
            'diaHorario_idv2' => Rule::requiredIf(function () use ($request) {
                return $request->input('jornada') === 'dividida';
            }),
        ];
        $attributes = [
            'nombreMateria' => 'Ingrese un nombre de la carrera',
            'numero' => ['required' => 'Ingrese el numero', 'numeric' => 'Ingrese solo números', 'digits_between' => 'Solo acepta dos números'],
            'requisito' => 'Ingrese los requisitos de la materia',
            'unidadValorativa' => ['required' => 'Ingrese la unidad valorativa', 'numeric' => 'La unidad valorativa debe ser numérico.', 'digits' => 'La unidad valorativa solo debe contener un solo dígito.', 'between' => 'La unidad valorativa solo debe estar entre 1 y 9.'],
            'ciclo_id' => 'Seleccione un ciclo',
            'user_id' => 'Seleccione un catedrático',
            'facultad_id' => 'Seleccione una facultad',
            'carrera_id' => 'Seleccione una carrera',
            'dia_id' => 'Seleccione un dia',
            'diaHorario_id' => 'Seleccione un turno',
            'dia_id1' => 'Seleccione un dia',
            'diaHorario_id1' => 'Seleccione un turno',
            'dia_id2' => 'Seleccione un dia',
            'diaHorario_idv2' => 'Seleccione un turno'
        ];
    
        $validator = Validator::make($request->all(), $rules, $attributes);
    
        if ($validator->fails()) {
            toastr()->error('Debe de completar los campos requeridos', 'Error');
            return redirect()->route('materias.edit',['materia'=>$id])->withErrors($validator)->withInput();
        }
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $jornada = $request->input('jornada');
        if($jornada ==='unica'){
            $datos=[
                'nombreMateria' => $request->input('nombreMateria'),
                'numero' => $request->input('numero'),
                'requisito' => $request->input('requisito'),
                'unidadValorativa' => $request->input('unidadValorativa'),
                'ciclo_id' => $request->input('ciclo_id'),
                'user_id' => $request->input('user_id'),
                'carrera_id' => $request->input('carrera_id'),
                'diaHorario_id' => $request->input('diaHorario_id'),
                'diaHorario_idv2' => null,
            ];
        }else if( $jornada === 'dividida'){
            $datos=[
                'nombreMateria' => $request->input('nombreMateria'),
                'numero' => $request->input('numero'),
                'requisito' => $request->input('requisito'),
                'unidadValorativa' => $request->input('unidadValorativa'),
                'ciclo_id' => $request->input('ciclo_id'),
                'user_id' => $request->input('user_id'),
                'carrera_id' => $request->input('carrera_id'),
                'diaHorario_id' => $request->input('diaHorario_id1'),
                'diaHorario_idv2' => $request->input('diaHorario_idv2'),
            ];
        }
        $materia= materia::find($id);
        $materia->update($datos);
        $materia->save();
        toastr()->success('Exito al modificar', 'Exito!');
        return redirect()->route('materias.index');
    }

    public function destroy($materias_id)
    {
        //
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $materia = materia::find($materias_id);
        $materia->delete();toastr()->success('Exito al eliminar', 'Exito!');
        return redirect()->route('materias.index');
    }

    public function carrerasFacultad($id){
        $carrera=carrera::where('facultad_id', $id)->select('id', 'nombreCarrera')->get();
        return response()->json($carrera);
    }

    public function carrerasUser($id){
        $user=User::where('carrera_id', $id)->select('id', 'name', 'apellido')->get();
        return response()->json($user);
    }

    public function diaHorarioTurno($nombre){
        $horariosExcluidos = [4, 5];
        $diaHorario=diaHorario::where('nombreDia', $nombre)->select('dia_horarios.id','horarios.turno', 'horarios.horaApertura', 'horarios.horaFinalizacion', 'dia_horarios.id as diaHorarios_id')->join('horarios', 'horarios.id', '=', 'dia_horarios.horario_id')->whereNotIn('horarios.id', $horariosExcluidos)->get();
        return response()->json($diaHorario);
    }
    public function diaHorarioTurnoNocturno($nombre){
        $horariosExcluidos = [1,2,3];
        $diaHorario=diaHorario::where('nombreDia', $nombre)->select('dia_horarios.id','horarios.turno', 'horarios.horaApertura', 'horarios.horaFinalizacion', 'dia_horarios.id as diaHorarios_id')->join('horarios', 'horarios.id', '=', 'dia_horarios.horario_id')->whereNotIn('horarios.id', $horariosExcluidos)->get();
        return response()->json($diaHorario);
    }
    public function diaHorarioTurnoNocturno2($nombre){
        $horariosExcluidos = [1,2,3];
        $diaHorario=diaHorario::where('nombreDia', $nombre)->select('dia_horarios.id','horarios.turno', 'horarios.horaApertura', 'horarios.horaFinalizacion', 'dia_horarios.id as diaHorarios_id')->join('horarios', 'horarios.id', '=', 'dia_horarios.horario_id')->whereNotIn('horarios.id', $horariosExcluidos)->get();
        return response()->json($diaHorario);
    }
}
