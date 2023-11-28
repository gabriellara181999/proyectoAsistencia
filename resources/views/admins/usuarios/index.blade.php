@extends('layouts.app_admin')

@section('title', 'Usuarios | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Gestión de Usuarios</h1>
@stop

@section('content_body')
    <div class="d-grid gap-2 d-md-block ">
        <a href="{{ route('usuarios.create') }}" class="btn btn-danger rounded-pill d-block d-sm-inline-block align-self-sm-center">
            <i class="fas fa-user-plus"></i> Nuevo Usuario
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
                    <th class="d-none d-md-table-cell">Apellido</th>
                    <th class="d-none d-md-table-cell">Fecha de Nacimiento</th>
                    <th class="d-none d-md-table-cell">Correo Electrónico</th>
                    <th class="d-none d-md-table-cell">Sexo</th>
                    <th class="d-none d-md-table-cell">N° Catedrático</th>
                    <th class="d-none d-md-table-cell">Teléfono</th>
                    <th>Opciones</th>
                @endslot
                @slot('data')
                    @foreach ($user as $users)
                        <tr>
                            <td data-id="{{ $users->id }}">{{ $contador=$contador+1}}</td>
                            <td data-name="{{ $users->name }}">{{ $users->name }}</td>
                            <td data-unit="{{ $users->apellido }}" class="d-none d-md-table-cell">{{ $users->apellido }}</td>
                            <td data-id="{{ date('d-m-Y', strtotime($users->fechaNacimiento)) }}" class="d-none d-md-table-cell">{{ date('d-m-Y', strtotime($users->fechaNacimiento)) }}</td>
                            <td data-id="{{ $users->email }}" class="d-none d-md-table-cell">{{ $users->email }}</td>
                            <td data-id="{{ $users->sexo }}" class="d-none d-md-table-cell">{{ $users->sexo === 'F' ? 'Femenino' : 'Masculino' }}</td>
                            <td data-id="{{ $users->numeroCatedratico }}" class="d-none d-md-table-cell">{{ $users->numeroCatedratico }}</td>
                            <td data-id="{{ $users->telefono }}" class="d-none d-md-table-cell">{{ $users->telefono }}</td>
                            <td>
                                <a href="" data-toggle="modal" data-target="#modal{{ $users->id }}"
                                    style="color: inherit;">
                                    <button class="btn btn-success rounded  mx-1 shadow" title="Detalles">
                                        <i class="fas fa-clipboard-list"></i>
                                    </button>
                                </a>
                                <a class="btn btn-dark rounded mx-1 shadow" href="{{ route('usuarios.edit', $users->id) }}">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('usuarios.destroy', $users->id) }}" method="post" style="display:inline;">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger rounded mx-1 shadow"  onclick="confirmarEliminacion(event, this.form)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <x-adminlte-modal id="modal{{ $users->id }}" title="{{ $users->name }}" size="sm" theme="danger" icon="fas fa-clipboard-list" v-centered static-backdrop scrollable>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-center">Detalle del Usuario</h4>
                                    <hr>
                                    <p style="margin-bottom: 0;"><strong>Nombres: </strong>{{ $users->name }}</p>
                                    <p style="margin-bottom: 0;"><strong>Apellidos: </strong>{{ $users->apellido }}</p>
                                    <p style="margin-bottom: 0;"><strong>Fecha de Nacimiento: </strong>{{ date('d-m-Y', strtotime($users->fechaNacimiento)) }}</p>
                                    <p style="margin-bottom: 0;"><strong>Correo: </strong>{{ $users->email }}</p>
                                    <p style="margin-bottom: 0;"><strong>Sexo: </strong>{{ $users->sexo === 'F' ? 'Femenino' : 'Masculino' }}</p>
                                    <p style="margin-bottom: 0;"><strong>N° Catedrático: </strong>{{ $users->numeroCatedratico }}</p>
                                    <p style="margin-bottom: 0;"><strong>Teléfono: </strong>{{ $users->telefono }}</p>
                                    <p style="margin-bottom: 0;"><strong>Facultad: </strong>{{ $users->nombreFacultad }}</p>
                                    <p style="margin-bottom: 0;"><strong>Carrera: </strong>{{ $users->nombreCarrera }}</p>
                                    <p style="margin-bottom: 0;"><strong>Rol: </strong>{{ $users->role_name }}</p>
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
@stop
