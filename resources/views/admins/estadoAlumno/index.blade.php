@extends('layouts.app_admin')

@section('title', 'Alumno | Asistencia | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Gestión de Asistencia por Alumno</h1>
@stop

@section('content_body')
    <style>
        .modal-footer{
            display: none;
        }
    </style>
    <br>
    <div class="col-lg-12">
        <div class="table-responsive">
            @component('common.datatable')
                @slot('table_id', 'ejemplo')
                @slot('columns')
                    <th scope="col">#</th>
                    <th>Nombre de Alumno</th>
                    <th class="d-none d-md-table-cell">Fecha</th>
                    <th class="d-none d-md-table-cell">Estado</th>
                    <th>Opciones</th>
                @endslot
                @slot('data')
                    @foreach ($estado as $estados)
                        <tr>
                            <td >{{ $contador=$contador+1 }}</td>
                            <td>{{ $estados->name }} {{ $estados->apellido }}</td>
                            <td class="d-none d-md-table-cell">{{ $estados->fechaAsistencia }}</td>
                            <td class="d-none d-md-table-cell"><span class="{{ ($estados->nombreEstadoAlumno === 'Puntual') ? 'badge badge-pill badge-success' : (($estados->nombreEstadoAlumno === 'Impuntual') ? 'badge badge-pill badge-warning' : (($estados->nombreEstadoAlumno === 'Ausente') ? 'badge badge-pill badge-danger' : (($estados->nombreEstadoAlumno === 'Permiso') ? 'badge badge-pill badge-info' : 'badge badge-pill badge-secondary'))) }}">{{ $estados->nombreEstadoAlumno}}</span></td>
                            <td>
                                <a href="#" class="asistenciaId" id="asistenciaId" data-toggle="modal" data-target="#modal{{ $estados->alumno_id }}"
                                    style="color: inherit;">
                                    <button class="btn btn-dark rounded  mx-1 shadow" title="Detalles">
                                        <i class="fas fa-clipboard-check"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                         <!-- Modal -->
                         <x-adminlte-modal id="modal{{ $estados->alumno_id }}" title="Estado" size="sm" theme="danger" icon="fas fa-clipboard-check" v-centered static-backdrop scrollable>
                            <form action="{{ route('cambiasEstadoAlumno',['alumno_id'=>$estados->alumno_id, 'asistencia_id'=>$estados->asistencia_id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf 
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="text-center">Asistencia del Alumno</h4>
                                        <br>
                                        <div class="col-md-12 col-lg-12">
                                            <x-adminlte-select class="form-control " id="estadoAlumno" name="estadoAlumno" aria-label="Default select example" required>
                                                <option selected disabled>Seleccione un Estado</option>
                                                @foreach ($estadoAlumno as $estadoAlumnos)
                                                    <option value="{{ $estadoAlumnos->id }}">{{ $estadoAlumnos->nombreEstadoAlumno }}</option>
                                                @endforeach
                                            </x-adminlte-select>
                                        </div>
                                    </div>
                                    
                                        <div class="col-md-12 col-lg-12">
                                            <button type="submit" class="btn btn-danger col-md-12 col-lg-12" id="agregar">Modificar Estado</button>
                                        </div>
                                </div>
                            </form>
                        </x-adminlte-modal>
                    @endforeach
                @endslot
            @endcomponent
        </div>
    </div>
    <script>
        function confirmarEliminacion(event) {
            event.preventDefault();
    
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#343a40',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.form.submit();
                }
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

@endsection