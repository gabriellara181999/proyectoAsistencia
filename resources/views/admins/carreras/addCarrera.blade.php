@extends('layouts.app_admin')

@section('title', 'Crear / Carreras | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Creación de Carreras</h1>
@stop

@section('content_body')
    <div class="col-lg-9 mb-3 mx-auto">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('carreras.index') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <x-adminlte-input type="text" class="form-control" id="nombreCarrera" name="nombreCarrera" autocomplete="nombreCarrera" aria-describedby="emailHelp" label="Nombre" fgroup-class="col-me-3" value="{{ old('nombreCarrera') }}"/>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label for="facultad_id" class="form-label">Facultades</label>
                            <x-adminlte-select class="form-control " id="facultad_id" name="facultad_id" aria-label="Default select example" required>
                                <option selected disabled>Seleccione la Facultad</option>
                                @foreach ($facultad as $facultades)
                                    <option value="{{ $facultades->id }}" {{ old('unit_id') == $facultades->id ? 'selected' : '' }}>{{ $facultades->nombreFacultad }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div>
                            <a href="{{ route('carreras.index') }}" class="btn btn-dark mt-3">
                                <i class="fas fa-chevron-left"></i> Regresar
                            </a>
                        </div>
                        <div style="margin-left: 10px">
                            <button type="submit" class="btn btn-danger mt-3" id="agregar">Crear Carrera</button>
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

@section('css')

@endsection