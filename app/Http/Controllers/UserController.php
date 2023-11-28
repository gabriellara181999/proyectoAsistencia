<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\carrera;
use App\Models\Facultade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:usuario-ver|usuario-crear|usuario-editar|usuario-eliminar|usuario-facultad', ['only' => ['index', 'show']]);
        $this->middleware('permission:usuario-crear', ['only' => ['create', 'store' ]]);
        $this->middleware('permission:usuario-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:usuario-eliminar', ['only' => ['destroy']]);
        $this->middleware('permission:usuario-facultad', ['only' => ['carrerasFacultad']]);
    }
    
    public function index()
    {
        //
        $usuario = [1];
        $user= User::select('users.id','users.name','users.apellido','users.fechaNacimiento','users.email','users.sexo','users.numeroCatedratico','users.telefono','users.carrera_id', 'carreras.nombreCarrera','users.role_name', 'facultades.nombreFacultad')->join('carreras', 'carreras.id','=', 'users.carrera_id')->join('facultades', 'facultades.id', '=', 'carreras.facultad_id')->whereNotIn('users.id', $usuario)->get();
        $contadorNum = 0;
        return view('admins.usuarios.index')->with('user',$user)->with('contador', $contadorNum);
    }

    public function create()
    {
        //
        $roles = Role::all();
        $facultades = [4];
        $facultad=Facultade::select('id', 'nombreFacultad')->whereNotIn('facultades.id', $facultades)->get();
        return view('admins.usuarios.addUsuarios')->with('facultad', $facultad)->with('roles', $roles);
    }

    public function store(Request $request)
    {
        //
        $rules = [
            'name' => 'required|string|max:255|regex:/^[A-Z][a-z]*( [A-Z][a-z]*)*$/',
            'apellido' => 'required|string|max:255|regex:/^[A-Z][a-z]*( [A-Z][a-z]*)*$/',
            'fechaNacimiento' => 'required|date|before_or_equal:-18 years',
            'email' => 'required|string|email|max:255|unique:users',
            'sexo' => 'required|not_in:0',
            'numeroCatedratico' => 'required|string|regex:/^[A-Z]{2}\d{0,9}$/|min:11|max:11|unique:users',
            'password' => 'required|min:8|max:15',
            'telefono' => 'required',
            'facultad_id' => 'required|not_in:0',
            'carrera_id' => 'required|not_in:0',
            'roles' => 'required|not_in:0',
        ];
        $attributes = [
            'name' => ['required'=>'Ingrese un nombre','regex' => 'Los nombres deben tener la primera letra de cada palabra en mayúscula.'],
            'apellido' => ['required'=>'Ingrese un apellido','regex' => 'Los apellidos deben tener la primera letra de cada palabra en mayúscula.'],
            'fechaNacimiento' => 'Ingrese una fecha válida o mayor a 18 años',
            'email' => ['required'=>'Ingrese un correo', 'unique'=>'El correo electronico ya esta en uso'],
            'sexo' => 'Seleccione su sexo',
            'numeroCatedratico'=>['required' => 'Ingrese su número de catedrático.','regex' => 'El campo código debe tener dos letras mayúsculas seguidas de números.', 'min' => 'El campo código no puede tener menos de :min caracteres.','max' => 'El campo código no puede tener más de :max caracteres.','unique'=>'El número de catedrático ya esta en uso'],
            'password' => ['min'=>'La contraseña debe tener al menos :min caracteres','max'=>'La contraseña debe tener maximo :max caracteres','required'=>'Ingrese la contraseña'],
            'telefono' => 'Ingrese un número teléfonico',
            'facultad_id' => 'Seleccione una facultad',
            'carrera_id' => 'Seleccione una carrera',
            'roles' => 'Seleccione un rol'
        ];
    
        $validator = Validator::make($request->all(), $rules, $attributes);
    
        if ($validator->fails()) {
            toastr()->error('Debe de completar los campos requeridos', 'Error');
            return redirect()->route('usuarios.create')->withErrors($validator)->withInput();
        }

        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $input = $request->all();
        if ($input['sexo'] === 'Femenino') {
            $input['sexo'] = 'F';
        } elseif ($input['sexo'] === 'Masculino') {
            $input['sexo'] = 'M';
        }
        $input['password'] = Hash::make($input['password']);
        $user = user::create($input);
        $user->assignRole($request->input('roles'));
        $role = $user->roles->first();
        $user->role_name = $role->name;
        $user->save();
        toastr()->success('Exito al guardar', 'Exito!');
        return redirect()->route('usuarios.index');
    }

    public function edit($id)
    {
        //
        $facultades = [4];
        $facultad=Facultade::select('id', 'nombreFacultad')->whereNotIn('facultades.id', $facultades)->get();
        $user=user::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('admins.usuarios.editUsuario')->with('user', $user)->with('facultad', $facultad)->with('userRole', $userRole)->with('roles', $roles);
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
            'numeroCatedratico' => 'required|string|regex:/^[A-Z]{2}\d{0,9}$/|min:11|max:11',
            'password' => 'required|min:8|max:15',
            'telefono' => 'required',
            'facultad_id' => 'required|not_in:0',
            'carrera_id' => 'required|not_in:0',
            'roles' => 'required|not_in:0',
        ];
        $attributes = [
            'name' => ['required'=>'Ingrese un nombre','regex' => 'Los nombres deben tener la primera letra de cada palabra en mayúscula.'],
            'apellido' => ['required'=>'Ingrese un apellido','regex' => 'Los apellidos deben tener la primera letra de cada palabra en mayúscula.'],
            'fechaNacimiento' => 'Ingrese una fecha válida o mayor a 18 años',
            'email' => ['required'=>'Ingrese un correo'],
            'sexo' => 'Seleccione su sexo',
            'numeroCatedratico'=>['required' => 'Ingrese su número de catedrático.','regex' => 'El campo código debe tener dos letras mayúsculas seguidas de números.', 'min' => 'El campo código no puede tener menos de :min caracteres.','max' => 'El campo código no puede tener más de :max caracteres.'],
            'password' => ['min'=>'La contraseña debe tener al menos :min caracteres','max'=>'La contraseña debe tener maximo :max caracteres','required'=>'Ingrese la contraseña'],
            'telefono' => 'Ingrese un número teléfonico',
            'facultad_id' => 'Seleccione una facultad',
            'carrera_id' => 'Seleccione una carrera',
            'roles' => 'Seleccione un rol'
        ];
        toastr()->warning('Debe de completar los campos requeridos','Alerta');
        $validator = Validator::make($request->all(), $rules, $attributes);
    
        if ($validator->fails()) {
            toastr()->error('Debe de completar los campos requeridos', 'Error');
            return redirect()->route('usuarios.edit',['usuario' => $id])->withErrors($validator)->withInput();
        }

        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $input = $request->all();
        if ($input['sexo'] === 'Femenino') {
            $input['sexo'] = 'F';
        } elseif ($input['sexo'] === 'Masculino') {
            $input['sexo'] = 'M';
        }
        $input['password'] = Hash::make($input['password']);
        $user= user::find($id);
        $user->update($input);
        $roles = $request->input('roles');
        $user->syncRoles($roles);
        $role = $user->roles->first();
        $user->role_name = $role->name;
        $user->save();
        toastr()->success('Exito al modificar', 'Exito!');
        return redirect()->route('usuarios.index');
    }

    public function destroy($id)
    {
        //
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $user = user::find($id);
        $user->delete();
        toastr()->success('Exito al eliminar', 'Exito!');
        return redirect()->route('usuarios.index');
    }

    public function carrerasFacultad($id){
        $carrera=carrera::where('facultad_id', $id)->select('id', 'nombreCarrera')->get();
        return response()->json($carrera);
    }
}
