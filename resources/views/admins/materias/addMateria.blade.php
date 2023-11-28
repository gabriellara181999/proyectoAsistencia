@extends('layouts.app_admin')

@section('title', 'Crear / Materias | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Creación de Materias</h1>
@stop

@section('content_body')
    <div class="col-lg-9 mb-3 mx-auto">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('materias.index') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <x-adminlte-input type="text" class="form-control" id="nombreMateria" name="nombreMateria" autocomplete="name" aria-describedby="emailHelp" label="Nombre" fgroup-class="col-me-3" value="{{ old('nombreMateria') }}"/>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <x-adminlte-input type="text" class="form-control" id="numero" name="numero" aria-describedby="emailHelp" label="Número" fgroup-class="col-me-3" value="{{ old('numero') }}" />
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <x-adminlte-input type="text" class="form-control" id="requisito" name="requisito" aria-describedby="emailHelp" label="Requisito" fgroup-class="col-me-3" value="{{ old('requisito') }}" />
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="mb-3">
                                <x-adminlte-input type="text" class="form-control" id="unidadValorativa" name="unidadValorativa"
                                    aria-describedby="emailHelp" label="Unidad Valorativa" fgroup-class="col-me-3" value="{{ old('unidadValorativa') }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <label for="ciclo_id" class="form-label">Ciclo</label>
                            <x-adminlte-select class="form-control " id="ciclo_id" name="ciclo_id" aria-label="Default select example">
                                <option selected disabled>Seleccione el Ciclo</option>
                                @foreach ($ciclo as $ciclos)
                                    <option value="{{ $ciclos->id }}" >{{ $ciclos->nombreCiclo }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label for="facultad_id" class="form-label">Facultad</label>
                            <x-adminlte-select class="form-control " id="facultad_id" name="facultad_id" aria-label="Default select example">
                                <option selected disabled>Seleccione la Facultad</option>
                                @foreach ($facultad as $facultades)
                                    <option value="{{ $facultades->id }}" >{{ $facultades->nombreFacultad }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <label for="carrera_id" class="form-label">Carrera</label>
                            <x-adminlte-select class="form-control " id="carrera_id" name="carrera_id" aria-label="Default select example">
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label for="user_id" class="form-label">Catedrático</label>
                            <x-adminlte-select class="form-control " id="user_id" name="user_id" aria-label="Default select example">
                            </x-adminlte-select>
                        </div>
                    </div>
                    <hr>
                    <div class="row mx-auto">
                        <div class="col-md-12 text-center mb-3">
                            <h4>Horario</h4>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <label for="" class="form-label">Seleccione una jornada</label>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="jornadaUnica" name="jornada" value="unica">
                                <label class="form-check-label" for="jornadaUnica">
                                    Jornada Unica
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="jornadaDividida" name="jornada" value="dividida">
                                <label class="form-check-label" for="jornadaDividida">
                                    Jornada Dividida
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto"  id="jornadaUnicaFields" style="display: none;">
                        <div class="col-md-6 col-lg-6">
                            <label for="dia_id" class="form-label">Dia</label>
                            <x-adminlte-select class="form-control " id="dia_id" name="dia_id" aria-label="Default select example">
                                <option selected disabled>Seleccione el dia</option>
                                @foreach ($diaHorario as $diaHorarios)
                                    <option value="{{ $diaHorarios->nombreDia }}">{{ $diaHorarios->nombreDia }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label for="diaHorario_id" class="form-label">Turno</label>
                            <x-adminlte-select class="form-control " id="diaHorario_id" name="diaHorario_id" aria-label="Default select example">
                            </x-adminlte-select>
                        </div>
                    </div>
                    <div class="row mx-auto"  id="jornadaDivididaFields1" style="display: none;">
                        <div class="col-md-6 col-lg-6">
                            <label for="dia_id1" class="form-label">Dia #1</label>
                            <x-adminlte-select class="form-control " id="dia_id1" name="dia_id1" aria-label="Default select example">
                                <option selected disabled>Seleccione el dia</option>
                                @foreach ($diaHorario1 as $diaHorarios)
                                    <option value="{{ $diaHorarios->nombreDia }}">{{ $diaHorarios->nombreDia }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label for="diaHorario_id1" class="form-label">Turno</label>
                            <x-adminlte-select class="form-control " id="diaHorario_idv1" name="diaHorario_idv1" aria-label="Default select example">
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label for="dia_id2" class="form-label">Dia #2</label>
                            <x-adminlte-select class="form-control " id="dia_id2" name="dia_id2" aria-label="Default select example">
                                <option selected disabled>Seleccione el dia</option>
                                @foreach ($diaHorario2 as $diaHorarios)
                                    <option value="{{ $diaHorarios->nombreDia }}">{{ $diaHorarios->nombreDia }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label for="diaHorario_id2" class="form-label">Turno</label>
                            <x-adminlte-select class="form-control " id="diaHorario_idv2" name="diaHorario_idv2" aria-label="Default select example">
                            </x-adminlte-select>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div>
                            <a href="{{ route('materias.index') }}" class="btn btn-dark mt-3">
                                <i class="fas fa-chevron-left"></i> Regresar
                            </a>
                        </div>
                        <div style="margin-left: 10px">
                            <button type="submit" class="btn btn-danger mt-3" id="agregar">Agregar Materia</button>
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
            $('input[type="radio"]').change(function() {
                if ($('#jornadaUnica').is(':checked')) {
                    $('#jornadaUnicaFields').show(300);
                    $('#jornadaDivididaFields1').hide(300);
                } else if ($('#jornadaDividida').is(':checked')) {
                    $('#jornadaUnicaFields').hide(300);
                    $('#jornadaDivididaFields1').show(300);
                } else {
                    $('#jornadaUnicaFields').hide(300);
                    $('#jornadaDivididaFields1').hide(300);
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
        document.getElementById('carrera_id').addEventListener('change', function() {
            var carrera_id = this.value;
            axios.get('/admin/materias/obtenerCatedraticos/' + carrera_id)
                .then(function(response) {
                    var users = response.data;
                    var userSelect = document.getElementById('user_id');
                    userSelect.innerHTML = '<option selected disabled>Seleccione el catedratico</option>';
                    users.forEach(function(user) {
                        userSelect.innerHTML += '<option value="' + user.id + '">' + user.name +' '+user.apellido+ '</option>';
                    });
                })
                .catch(function(error) {
                    console.error('Error al obtener la carrera:', error);
                });
        });
        document.getElementById('dia_id').addEventListener('change', function() {
            var diaHorario_id = this.value;
            axios.get('/admin/materias/obtenerTurno/' + diaHorario_id)
            .then(function(response) {
                var diaTurno = response.data;
                var turnoSelect = document.getElementById('diaHorario_id');
                turnoSelect.innerHTML = '<option selected disabled>Seleccione el turno</option>';
                diaTurno.forEach(function(diaTurnos) {
                    turnoSelect.innerHTML += '<option value="' + diaTurnos.diaHorarios_id + '">' + diaTurnos.turno +' ('+diaTurnos.horaApertura+'-'+diaTurnos.horaFinalizacion+')'+ '</option>';
                    var maxItemsToShow = 3;
                });
            })
            .catch(function(error) {
                console.error('Error al obtener la carrera:', error);
            });
        });
        document.getElementById('dia_id1').addEventListener('change', function() {
            var diaHorario_id = this.value;
            axios.get('/admin/materias/obtenerTurnoNocturno/' + diaHorario_id)
            .then(function(response) {
                var diaTurno = response.data;
                var turnoSelect = document.getElementById('diaHorario_idv1');
                turnoSelect.innerHTML = '<option selected disabled>Seleccione el turno</option>';
                diaTurno.forEach(function(diaTurnos) {
                    turnoSelect.innerHTML += '<option value="' + diaTurnos.diaHorarios_id + '">' + diaTurnos.turno +' ('+diaTurnos.horaApertura+'-'+diaTurnos.horaFinalizacion+')'+ '</option>';
                    var maxItemsToShow = 3;
                });
            })
            .catch(function(error) {
                console.error('Error al obtener la carrera:', error);
            });
        });
        document.getElementById('dia_id2').addEventListener('change', function() {
            var diaHorario_id = this.value;
            axios.get('/admin/materias/obtenerTurnoNocturno2/' + diaHorario_id)
            .then(function(response) {
                var diaTurno = response.data;
                var turnoSelect = document.getElementById('diaHorario_idv2');
                turnoSelect.innerHTML = '<option selected disabled>Seleccione el turno</option>';
                diaTurno.forEach(function(diaTurnos) {
                    turnoSelect.innerHTML += '<option value="' + diaTurnos.diaHorarios_id + '">' + diaTurnos.turno +' ('+diaTurnos.horaApertura+'-'+diaTurnos.horaFinalizacion+')'+ '</option>';
                    var maxItemsToShow = 3;
                });
            })
            .catch(function(error) {
                console.error('Error al obtener la carrera:', error);
            });
        });
    </script>
@stop    