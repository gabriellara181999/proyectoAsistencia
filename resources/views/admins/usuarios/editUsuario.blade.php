@extends('layouts.app_admin')

@section('title', 'Modificar / Usuarios | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Creación de Usuarios</h1>
@stop

@section('content_body')
    <div class="col-lg-9 mb-3 mx-auto">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('usuarios.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <x-adminlte-input type="text" class="form-control" id="name" name="name" autocomplete="name" aria-describedby="emailHelp" label="Nombres" fgroup-class="col-me-3" value="{{ $user->name }}"/>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <x-adminlte-input type="text" class="form-control" id="apellido" name="apellido" aria-describedby="emailHelp" label="Apellidos" fgroup-class="col-me-3" value="{{ $user->apellido}}" />
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <x-adminlte-input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" aria-describedby="emailHelp" label="Fecha de Nacimiento" fgroup-class="col-me-3" value="{{ $user->fechaNacimiento }}" />
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="mb-3">
                                <x-adminlte-input type="email" class="form-control" id="email" name="email"
                                    aria-describedby="emailHelp" label="Correo electrónico" fgroup-class="col-me-3" value="{{ $user->email }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <label for="sexo" class="form-label">Sexo</label>
                                <x-adminlte-select class="form-control" id="sexo" name="sexo" aria-label="Default select example">
                                    <option selected disabled>Seleccione el sexo</option>
                                    <option value="Femenino" {{ old('sexo') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="Masculino" {{ old('sexo') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                </x-adminlte-select>
                        </div> 
                        <div class="col-md-6 col-lg-6">
                            <div class="mb-3">
                                <x-adminlte-input type="text" class="form-control" id="numeroCatedratico" name="numeroCatedratico"
                                    aria-describedby="emailHelp" label="N° de Catedrático" placeholder="AA111111111" fgroup-class="col-me-3" value="{{ $user->numeroCatedratico}}" />
                            </div>
                        </div>                                            
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <div class="mb-3">
                                <x-adminlte-input id="password" name="password" type="password" label="Contraseña" fgroup-class="col-me-3" value="{{ old('password') }}">
                                    <x-slot name="appendSlot">
                                        <x-adminlte-button theme=" btn btn-outline-secondary" id="showPasswordBtn" icon="fas fa-eye"/>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="mb-3">
                                <x-adminlte-input type="text" class="form-control" id="telefono" name="telefono" placeholder="____-____" pattern="\d{4}-\d{4}" aria-describedby="emailHelp" label="Teléfono" fgroup-class="col-me-3" value="{{$user->telefono }}"/>
                            </div>
                        </div> 
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <label for="facultad_id" class="form-label">Facultad</label>
                            <x-adminlte-select class="form-control " id="facultad_id" name="facultad_id" aria-label="Default select example">
                                <option selected disabled>Seleccione la Facultad</option>
                                @foreach ($facultad as $facultades)
                                    <option value="{{ $facultades->id }}">{{ $facultades->nombreFacultad }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label for="carrera_id" class="form-label">Carrera</label>
                            <x-adminlte-select class="form-control " id="carrera_id" name="carrera_id" aria-label="Default select example">
                            </x-adminlte-select>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col">
                            <div class="form-group">
                                <label for="roles" class="form-label">Rol</label>
                                <x-adminlte-select class="form-control " id="roles" name="roles" aria-label="Default select example">
                                    <option selected disabled>Seleccione un Rol</option>
                                    @foreach($roles as $role => $roleName)
                                        <option value="{{ $role }}" @if(in_array($role, $userRole)) selected @endif>{{ $roleName }}</option>
                                    @endforeach
                                </x-adminlte-select>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-dark mt-3">
                                <i class="fas fa-chevron-left"></i> Regresar
                            </a>
                        </div>
                        <div style="margin-left: 10px">
                            <button type="submit" class="btn btn-danger mt-3" id="agregar">Modificar Usuario</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <h1></h1>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $("#showPasswordBtn").on("click", function() {
                var passwordField = $("#password");
                var passwordFieldType = passwordField.attr("type");

                if (passwordFieldType === "password") {
                    passwordField.attr("type", "text");
                } else {
                    passwordField.attr("type", "password");
                }
            });
        });

        $(document).ready(function() {
            $(document).ready(function() {
                var telefono = $("#telefono");

                telefono.on("input", function() {
                    var inputValue = telefono.val();
                    var numericValue = inputValue.replace(/\D/g, ""); // Obtener solo los números
                    var formattedValue = numericValue.slice(0, 4) + "-" + numericValue.slice(4,8); // Aplicar la máscara
                    telefono.val(formattedValue);
                });

                telefono.on("focusout", function() {
                    if (duiInput.val().length < 9) {
                        duiInput.val("");
                    }
                });
            });
        });
        $(document).ready(function() {
            var numeroCatedratico = $("#numeroCatedratico");

            numeroCatedratico.on("input", function() {
                var inputValue = numeroCatedratico.val();
                var sanitizedValue = inputValue.replace(/[^A-Z\d]/g, "").slice(0, 11);
                var firstTwoChars = sanitizedValue.slice(0, 2);
                var nextNineChars = sanitizedValue.slice(2);
                letras = firstTwoChars.replace(/[^A-Z]/g, '')
                numero=nextNineChars.replace(/[^0-9]/g, '')
                var formattedValue = letras + numero;

                numeroCatedratico.val(formattedValue);
            });

            numeroCatedratico.on("focusout", function() {
                if (numeroCatedratico.val().length !== 11) {
                    numeroCatedratico.val("");
                }
            });
        });
        document.getElementById('facultad_id').addEventListener('change', function() {
            var facultad_id = this.value;
            axios.get('/admin/materias/obtenerMaterias/' + facultad_id)
                .then(function(response) {
                    var carreras = response.data;
                    var carreraSelect = document.getElementById('carrera_id');
                    carreraSelect.innerHTML = '<option selected disabled>Seleccione la Carrera</option>';
                    carreras.forEach(function(carrera) {
                        carreraSelect.innerHTML += '<option value="' + carrera.id + '">' + carrera.nombreCarrera + '</option>';
                    });
                })
                .catch(function(error) {
                    console.error('Error al obtener la carrera:', error);
                });
        });
    </script>
@stop    