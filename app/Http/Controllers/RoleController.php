<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:rol-ver|rol-crear|rol-editar|rol-eliminar', ['only' => ['index', 'show']]);
        $this->middleware('permission:rol-crear', ['only' => ['create', 'store', 'rolPermisos' ]]);
        $this->middleware('permission:rol-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:rol-eliminar', ['only' => ['destroy']]);
    }
    public function index()
    {
        //
        $role = Role::all();
        $contador=0;
        return view('admins.roles.index')->with('roles', $role)->with('contador', $contador);
    }
    public function create()
    {
        //
        $permission = Permission::get();
        return view('admins.roles.addRole')->with('Permission', $permission);
    }
    public function store(Request $request)
    {
        //
        $rules = [
            'name' => 'required|string|max:100'
        ];
        $attributes = [
            'name' => 'Ingrese un nombre de rol',
        ];
    
        $validator = Validator::make($request->all(), $rules, $attributes);
    
        if ($validator->fails()) {
            toastr()->error('Debe de completar los campos requeridos', 'Error');
            return redirect()->route('roles.create')->withErrors($validator)->withInput();
        }
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
        toastr()->success('Exito al guardar', 'Exito!');
        return redirect()->route('roles.index');  
    }
    public function edit($id)
    {
        //
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();
        return view('admins.roles.editRole')->with('role', $role)->with('Permission', $permission)->with('rolePermissions', $rolePermissions);
    }
    public function update(Request $request, $id)
    {
        //
        $rules = [
            'name' => 'required|string|max:100'
        ];
        $attributes = [
            'name' => 'Ingrese un nombre de rol',
        ];
        $validator = Validator::make($request->all(), $rules, $attributes);
    
        if ($validator->fails()) {
            toastr()->error('Debe de completar los campos requeridos', 'Error');
            return redirect()->route('roles.edit',['role' => $id])->withErrors($validator)->withInput();
        }
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permission'));
        toastr()->success('Exito al modificar', 'Exito!');
        return redirect()->route('roles.index'); 
    }
    public function destroy($id)
    {
        //
        $this->middleware('auth');
        $this->middleware('guest')->only('store');
        $role = Role::find($id);
        $role->delete();
        toastr()->success('Exito al eliminar', 'Exito!');
        return redirect()->route('roles.index');
    }

    public function rolPermisos($id){
        $role = Role::find($id);
        $permissions = $role->permissions->pluck('name')->toArray();
        return response()->json(['permissions' => $permissions]);
    }
}
