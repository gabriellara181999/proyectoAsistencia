<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        unset($data['_token']);
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'dui' => ['required', 'max:10', 'unique:users'],
            'employee_number' => ['required', 'unique:users'],
            'unit_id' => ['required']
        ];

        $messages = [
            'email.unique' => 'La dirección de correo electrónico ya está registrada.',
            'dui.unique' => 'El número de DUI ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ];

        $attributes = [
            'name' => 'nombre', 
            'last_name' => 'apellido',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'employee_number' => 'número de empleado',
            'unit_id' => 'unidad',
            // Agregar más alias de atributos aquí si es necesario
        ];

        return Validator::make($data, $rules, $messages, $attributes);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'dui' => $data['dui'],
            'employee_number' => $data['employee_number'],
            'unit_id'=> $data['unit_id']
        ]);
    }
}
