@extends('layouts.app_admin')

@section('title', 'Reportes | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Reporte de Catedráticos</h1>
@stop

@section('content_body')
    <div class="d-grid gap-2 d-md-block ">
        <a onclick="createBackup()" class="btn btn-danger rounded-pill d-block d-sm-inline-block align-self-sm-center">
            <i class="fas fa-download"></i> Crear Back-Up
        </a>
    </div>
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
                                <a class="btn btn-dark rounded mx-1 shadow" href="{{ route('reporteMateria', $catedraticos->users_id) }}">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endslot
            @endcomponent
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function createBackup() {
        axios.get("{{ route('backupCreate') }}")
            .then(response => {
                if (response.status == 200) {
                Swal.fire({
                    title: "Exito!",
                    text: "Se ha creado con exito el back-up!",
                    icon: "success"
                    });
                }
            })
            .catch(error => {
                console.error('Error al crear la copia de seguridad:', error);
            });
        }
    </script>
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

@stop
