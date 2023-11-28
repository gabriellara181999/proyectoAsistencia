@extends('layouts.app_admin')

@section('title', 'Carreras | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Gestión de Carreras</h1>
@stop

@section('content_body')
    <div class="d-grid gap-2 d-md-block ">
        <a href="{{ route('carreras.create') }}" class="btn btn-danger rounded-pill d-block d-sm-inline-block align-self-sm-center">
            <i class="fas fa-vote-yea"></i> Nueva Carrera
        </a>
    </div>
    <br>
    <div class="col-lg-12">
        <div class="table-responsive">
            @component('common.datatable')
                @slot('table_id', 'ejemplo')
                @slot('columns')
                    <th scope="col">#</th>
                    <th>Carrera</th>
                    <th class="d-none d-md-table-cell">Facultad</th>
                    <th>Opciones</th>
                @endslot
                @slot('data')
                    @foreach ($carreras as $carrera)
                        <tr>
                            <td data-id="{{ $carrera->carreras_id }}">{{ $contador=$contador+1 }}</td>
                            <td data-name="{{ $carrera->nombreCarrera }}">{{ $carrera->nombreCarrera }}</td>
                            <td data-unit="{{ $carrera->Facultade->nombreFacultad }}" class="d-none d-md-table-cell">{{ $carrera->Facultade->nombreFacultad }}</td>
                            <td>
                                <a href="" data-toggle="modal" data-target="#modal{{ $carrera->carreras_id }}"
                                    style="color: inherit;">
                                    <button class="btn btn-success rounded  mx-1 shadow" title="Detalles">
                                        <i class="fas fa-clipboard-list"></i>
                                    </button>
                                </a>
                                <a class="btn btn-dark rounded mx-1 shadow" href="{{ route('carreras.edit', $carrera->carreras_id) }}">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('carreras.destroy', $carrera->carreras_id) }}" method="post" style="display:inline;">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger rounded mx-1 shadow" onclick="confirmarEliminacion(event, this.form)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <x-adminlte-modal id="modal{{ $carrera->carreras_id }}" title="{{ $carrera->Facultade->nombreFacultad }}" size="sm" theme="danger" icon="fas fa-clipboard-list" v-centered static-backdrop scrollable>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-center">Detalle de la Carrera</h4>
                                    <hr>
                                    <p style="margin-bottom: 0;"><strong>Nombre de la Carrera: </strong><br>{{ $carrera->nombreCarrera }}</p>
                                    <p style="margin-bottom: 0;"><strong>Facultad: </strong><br>{{ $carrera->Facultade->nombreFacultad }}</p>
                                </div>
                            </div>
                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="dark" label="Cerrar" data-dismiss="modal" />
                            </x-slot>
                        </x-adminlte-modal>
                    @endforeach
                @endslot
            @endcomponent
        </div>
    </div>
    <script>
        function confirmarEliminacion(event) {
            event.preventDefault();
            const form = event.target.closest('form');

            if (!form) {
                console.error('Error: No se pudo encontrar el formulario.');
                return;
            }
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
                    form.submit();
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