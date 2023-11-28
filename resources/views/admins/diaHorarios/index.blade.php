@extends('layouts.app_admin')

@section('title', 'Horarios | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Gestión de Horarios</h1>
@stop

@section('content_body')
    <br>
    <div class="col-lg-12">
        <div class="table-responsive">
            @component('common.datatable')
                @slot('table_id', 'ejemplo')
                @slot('columns')
                    <th scope="col">#</th>
                    <th>Dia</th>
                    <th class="d-none d-md-table-cell">Turno</th>
                    <th class="d-none d-md-table-cell">Hora de Apertura</th>
                    <th class="d-none d-md-table-cell">Hora de Finalización</th>
                    <th>Opciones</th>
                @endslot
                @slot('data')
                {{-- {{ dd($materia) }} --}}
                    @foreach ($diaHorario as $diaHorarios)
                        <tr>
                            <td data-id="{{ $diaHorarios->dia_horario_id }}">{{ $contador=$contador+1 }}</td>
                            <td data-name="{{ $diaHorarios->nombreDia }}">{{ $diaHorarios->nombreDia }}</td>
                            <td data-name="{{ $diaHorarios->turno }}"  class="d-none d-md-table-cell">{{ $diaHorarios->turno }}</td>
                            <td data-name="{{ $diaHorarios->horaApertura }}"  class="d-none d-md-table-cell">{{ $diaHorarios->horaApertura }}</td>
                            <td data-name="{{ $diaHorarios->horaFinalizacion }}"  class="d-none d-md-table-cell">{{ $diaHorarios->horaFinalizacion }}</td>
                            <td>
                                <a href="" data-toggle="modal" data-target="#modal{{ $diaHorarios->dia_horario_id }}"
                                    style="color: inherit;">
                                    <button class="btn btn-success rounded  mx-1 shadow" title="Detalles">
                                        <i class="fas fa-clipboard-list"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <x-adminlte-modal id="modal{{ $diaHorarios->dia_horario_id }}" title="{{ $diaHorarios->nombreDia}}" size="sm" theme="danger" icon="fas fa-clipboard-list" v-centered static-backdrop scrollable>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-center">Detalle del Horario</h4>
                                    <hr>
                                    <p style="margin-bottom: 0;"><strong>Dia: </strong>{{ $diaHorarios->nombreDia }}</p>
                                    <p style="margin-bottom: 0;"><strong>Turno: </strong>{{ $diaHorarios->turno }}</p>
                                    <p style="margin-bottom: 0;"><strong>Hora de Apertura: </strong>{{ $diaHorarios->horaApertura }}</p>
                                    <p style="margin-bottom: 0;"><strong>Hora de Finalización: </strong>{{ $diaHorarios->horaFinalizacion }}</p>
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