<?php

namespace App\Http\Controllers;

use App\Models\carrera;
use App\Models\Facultade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarreraController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:carrera-ver|carrera-crear|carrera-editar|carrera-eliminar', ['only' => ['index', 'show']]);
        $this->middleware('permission:carrera-ver', ['only' => ['create', 'store' ]]);
        $this->middleware('permission:carrera-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:carrera-eliminar', ['only' => ['destroy']]);
    }
    public function index()
    {
        //
        $carreras = [1];
        $carrera= carrera::select('carreras.*', 'facultades.*', 'carreras.id as carreras_id')->join('facultades', 'facultades.id', '=', 'carreras.facultad_id')->whereNotIn('carreras.id', $carreras)->get();   
        $contadorNum = 0;
        return view('admins.carreras.index')->with('carreras', $carrera)->with('contador',$contadorNum);
    }

    public function create()
    {
        //
        $facultades = [4];
        $facultad=Facultade::whereNotIn('facultades.id', $facultades)->get();
        return view('admins.carreras.addCarrera')->with('facultad', $facultad);
    }

    public function store(Request $request)
    {
        //
        $rules = [
            'nombreCarrera' => 'required|string|max:255',
            'facultad_id' => 'required|not_in:0'
        ];
        $attributes = [
            'nombreCarrera' => 'Ingrese un nombre de la carrera',
            'facultad_id' => 'Seleccione una facultad'
        ];
        $validator = Validator::make($request->all(), $rules, $attributes);
        if ($validator->fails()) {
            toastr()->error('Debe de completar los campos requeridos', 'Error');
            return redirect()->route('carreras.create')->withErrors($validator)->withInput();
        }
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $input = $request->all();
        $carrera = carrera::create($input);
        $carrera->save();
        toastr()->success('Exito al guardar', 'Exito!');
        return redirect()->route('carreras.index');
    }
    public function edit($carrera_id)
    {
        //
        $carreras=carrera::findOrFail($carrera_id);
        $facultad = [4];
        $facultades=Facultade::whereNotIn('facultades.id', $facultad)->get();
        return view('admins.carreras.editCarrera')->with('carreras', $carreras)->with('facultad', $facultades);
    }

    public function update(Request $request, $id)
    {
        //
        $rules = [
            'nombreCarrera' => 'required|string|max:255',
            'facultad_id' => 'required|not_in:0'
        ];
        $attributes = [
            'nombreCarrera' => 'Ingrese un nombre de la carrera',
            'facultad_id' => 'Seleccione una facultad'
        ];
        $validator = Validator::make($request->all(), $rules, $attributes);
        if ($validator->fails()) {
            toastr()->error('Debe de completar los campos requeridos', 'Error');
            return redirect()->route('carreras.edit',['carrera' => $id])->withErrors($validator)->withInput();
        }
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $input = $request->all();
        $carrera= carrera::find($id);
        $carrera->update($input);
        $carrera->save();
        toastr()->success('Exito al modificar', 'Exito!');
        return redirect()->route('carreras.index');
    }

    public function destroy($id)
    {
        //
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $carrera = carrera::find($id);
        $carrera->delete();
        toastr()->success('Exito al eliminar', 'Exito!');
        return redirect()->route('carreras.index');
    }
}
