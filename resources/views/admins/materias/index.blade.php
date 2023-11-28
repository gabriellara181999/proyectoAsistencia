@extends('layouts.app_admin')

@section('title', 'Materias | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Gestión de Materias</h1>
@stop

@section('content_body')
    <div class="d-grid gap-2 d-md-block ">
        <a href="{{ route('materias.create') }}" class="btn btn-danger rounded-pill d-block d-sm-inline-block align-self-sm-center">
            <i class="fas fa-folder-plus"></i> Crear Materias
        </a>
    </div>
    <br>
    <div class="col-lg-12">
        <div class="table-responsive">
            @component('common.datatable')
                @slot('table_id', 'ejemplo')
                @slot('columns')
                    <th scope="col">#</th>
                    <th>Nombre</th>
                    <th class="d-none d-md-table-cell">Número</th>
                    <th class="d-none d-md-table-cell">Requisitos</th>
                    <th class="d-none d-md-table-cell">UV</th>
                    <th class="d-none d-md-table-cell">Ciclo</th>
                    <th class="d-none d-md-table-cell">Catedrático</th>
                    <th class="d-none d-md-table-cell">Carrera</th>
                    <th class="d-none d-md-table-cell">Horario</th>
                    <th>Opciones</th>
                @endslot
                @slot('data')
                {{-- {{ dd($materia) }} --}}
                    @foreach ($materia as $materias)
                        <tr>
                            <td data-id="{{ $materias->materias_id }}">{{ $contador=$contador+1 }}</td>
                            <td data-name="{{ $materias->nombreMateria }}">{{ $materias->nombreMateria }}</td>
                            <td data-name="{{ $materias->numero }}"  class="d-none d-md-table-cell">{{ $materias->numero }}</td>
                            <td data-name="{{ $materias->requisito }}"  class="d-none d-md-table-cell">{{ $materias->requisito }}</td>
                            <td data-name="{{ $materias->unidadValorativa }}"  class="d-none d-md-table-cell">{{ $materias->unidadValorativa }}</td>
                            <td data-unit="{{ $materias->nombreCiclo }}" class="d-none d-md-table-cell">{{ $materias->nombreCiclo }}</td>
                            <td data-unit="{{ $materias->name }}{{ $materias->apellido }}" class="d-none d-md-table-cell">{{ $materias->name }} {{ $materias->apellido }}</td>
                            <td data-unit="{{ $materias->nombreCarrera }}" class="d-none d-md-table-cell">{{ $materias->nombreCarrera }}</td>
                            <td data-unit="{{ $materias->nombreDia1 }}" class="d-none d-md-table-cell">{{ $materias->nombreDia1 }}
                                @if (!empty($materias->diaHorario_idv2))
                                    - {{ $materias->nombreDia2}} 
                                @endif
                            </td>
                            <td>
                                <a href="" data-toggle="modal" data-target="#modal{{ $materias->materias_id }}" style="color: inherit;">
                                    <button class="btn btn-success rounded  mx-1 shadow" title="Detalles">
                                        <i class="fas fa-clipboard-list"></i>
                                    </button>
                                </a>
                                <a class="btn btn-dark rounded mx-1 shadow" href="{{ route('materias.edit', $materias->materias_id) }}">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('materias.destroy', $materias->materias_id) }}" method="post" style="display:inline;">
                                    @method('DELETE')
                                    @csrf
                                    <button type="button" class="btn btn-danger rounded mx-1 shadow" onclick="confirmarEliminacion(event, this.form)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <x-adminlte-modal id="modal{{ $materias->materias_id }}" title="{{ $materias->nombreMateria}}" size="sm" theme="danger" icon="fas fa-clipboard-list" v-centered static-backdrop scrollable>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-center">Detalle de la Materia</h4>
                                    <hr>
                                    <p style="margin-bottom: 0;"><strong>Nombre de la Materia: </strong>{{ $materias->nombreMateria }}</p>
                                    <p style="margin-bottom: 0;"><strong>Número: </strong>{{ $materias->numero }}</p>
                                    <p style="margin-bottom: 0;"><strong>Requisito: </strong>{{ $materias->requisito }}</p>
                                    <p style="margin-bottom: 0;"><strong>Unidad Valorativa: </strong>{{ $materias->unidadValorativa }}</p>
                                    <p style="margin-bottom: 0;"><strong>Facultad: </strong>{{ $materias->nombreFacultad }}</p>
                                    <p style="margin-bottom: 0;"><strong>Carrera: </strong>{{ $materias->nombreCarrera }}</p>
                                    <p style="margin-bottom: 0;"><strong>Ciclo: </strong>{{ $materias->nombreCiclo }}</p>
                                    <p style="margin-bottom: 0;"><strong>Catedrático: </strong>{{ $materias->name }} {{ $materias->apellido }}</p>
                                    <hr>
                                    <p style="margin-bottom: 0;"><strong>Horario: </strong>{{ $materias->nombreDia1 }} | {{ $materias->turno1 }} ({{ $materias->horaApertura1 }}-{{ $materias->horaFinalizacion1 }})@if (!empty($materias->diaHorario_idv2)) -- {{ $materias->nombreDia2}} | {{ $materias->turno2 }} ({{ $materias->horaApertura2 }}-{{ $materias->horaFinalizacion2 }}) @endif </p>
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