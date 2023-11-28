@extends('layouts.app_admin')

@section('title', 'Catedraticos | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Gestión de Catedráticos</h1>
@stop

@section('content_body')
    <br>
    <div class="col-lg-12">
        <div class="table-responsive">
            @component('common.datatable')
                @slot('table_id', 'ejemplo')
                @slot('columns')
                    <th scope="col">#</th>
                    <th>Facultad</th>
                    <th class="d-none d-md-table-cell">Carrera</th>
                    <th class="d-none d-md-table-cell">Catedrático</th>
                    <th>Opciones</th>
                @endslot
                @slot('data')
                    @foreach ($catedratico as $catedraticos)
                        <tr>
                            <td >{{ $contador=$contador+1 }}</td>
                            <td >{{ $catedraticos->nombreFacultad }}</td>
                            <td class="d-none d-md-table-cell">{{ $catedraticos->nombreCarrera }}</td>
                            <td class="d-none d-md-table-cell">{{ $catedraticos->name }} {{ $catedraticos->apellido }}</td>
                            <td>
                                <a class="btn btn-dark rounded mx-1 shadow" href="{{ route('gestionMateriasIndex', $catedraticos->users_id) }}">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endslot
            @endcomponent
        </div>
    </div>
@stop

@section('footer')
    <h1></h1>
@stop

@section('css')
    <style>
        table.dataTable thead tr {
            background-color: #dc3545;
            color: white;
        }

        table.dataTable thead tr th{
            border: 1px solid #000;
            border-color: #000;
        }
    </style>

@endsection