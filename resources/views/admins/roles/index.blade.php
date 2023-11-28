@extends('layouts.app_admin')

@section('title', 'Roles | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Gestión de Roles</h1>
@stop

@section('content_body')
<style>
    .modal-header .close {
        display: none;
    }
</style>
    <div class="col-sm-12">
        <a href="{{ route('roles.create') }}"
            class="btn btn-danger rounded-pill d-block d-sm-inline-block align-self-sm-center">
            <i class="fas fa-key"></i> Agregar Rol
        </a>
    </div>
    <br>
    <br>
    <div class="box">
        <div class="box-body">
            @component('common.datatable')
                @slot('table_id', 'ejemplo')
                @slot('columns')
                    <th scope="col">#</th>
                    <th>Nombre de Rol</th>
                    <th class="d-none d-md-table-cell">N° de Permisos</th>
                    <th>Opciones</th>
                @endslot
                @slot('data')
                    @foreach ($roles as $rol)
                        <tr>
                            <td data-id="{{ $rol->id }}">{{ $contador=$contador+1 }}</td>
                            <td data-name="{{ $rol->name }}">{{ $rol->name }}</td>
                            <td class="d-none d-md-table-cell">{{ $rol->permissions->count() }}</td>
                            <td>
                                <a href="#" class="rolId" id="rolId"  data-toggle="modal" data-target="#modal{{ $rol->id }}"
                                    style="color: inherit;">
                                    <button class="btn btn-success rounded  mx-1 shadow" title="Detalles">
                                        <i class="fas fa-clipboard-list"></i>
                                    </button>
                                </a>
                                <a class="btn btn-dark rounded mx-1 shadow" href="{{ route('roles.edit', $rol->id) }}">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('roles.destroy', $rol->id) }}" method="post" style="display:inline;">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger rounded mx-1 shadow" onclick="confirmarEliminacion(event, this.form)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <x-adminlte-modal id="modal{{ $rol->id }}" title="{{ $rol->name }}" size="lg" theme="danger" icon="fas fa-user-lock" v-centered static-backdrop scrollable>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-center">Permisos del Rol</h4>
                                    <hr>
                                    <div id="modalContent{{ $rol->id }}"></div>
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
    <br>
    <br>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.min.js"></script>
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
                    event.target.form.submit();
                }
            });
        }


        var rolId = document.querySelectorAll('.rolId');
        rolId.forEach(function (button) {
            button.addEventListener('click', function () {
                var dataTarget = this.getAttribute('data-target');
                var partes = dataTarget.split("#modal");
                if (partes.length > 1) {
                    var loQueVieneDespuésDeModal = partes[1];
                    var rol_id = parseInt(loQueVieneDespuésDeModal);
                }
                axios.get('{{ route("rolPermisos",["id"=>"/"]) }}' + '/' + rol_id)
                .then(function (response) {
                    var modalContent = document.getElementById('modalContent' + rol_id);
                    modalContent.innerHTML = '';
                    if (typeof response.data === 'string') {
                        try {
                            datos = JSON.parse(response.data);
                        } catch (error) {
                            console.error('Error al analizar la cadena JSON:', error);
                        }
                    } else if (typeof response.data === 'object') {
                        datos = response.data;
                    } else {
                        console.error('Tipo de datos desconocido en response.data:', typeof response.data);
                    }
                    if (datos.permissions!=0) {
                        var currentCategory = '';
                        var currentRow;
                        var categoryIcons = {
                            'usuario': 'fa-user',
                            'rol': 'fa-lock',
                            'carrera': 'fa-university',
                            'materia': 'fa-book-open',
                            'alumno': 'fa-user-graduate',
                            'horario': 'fa-calendar-alt',
                            'catedratico': 'fa-chalkboard-teacher',
                            'asistencia': 'fa-check-square',
                            'administrador': 'fa-user-cog',
                            'boton':'fa-toggle-on'
                        };
                        var categories = {};

                        datos.permissions.forEach(function (permission) {
                        var category = permission.split('-')[0];
                        var permissionName = permission;

                        if (!categories[category]) {
                            categories[category] = [];
                        }
                            categories[category].push(permissionName);
                        });

                        var currentRow;
                        var columnsPerRow = 2;
                        var colCount = 0;

                        for (var category in categories) {
                            var icon = categoryIcons[category] || 'fa-question';
                            var permissionsList = categories[category].map(function (permission) {
                                return `<li>${permission}</li>`;
                            }).join('');

                            if (colCount % columnsPerRow === 0) {
                                currentRow = document.createElement('div');
                                currentRow.className = 'row';
                            }

                            var col = document.createElement('div');
                            col.className = 'col-md-6'; // Dos columnas por fila
                            var callout = document.createElement('div');
                            callout.className = 'callout callout-danger alert-dismissible fade show';
                            callout.innerHTML = `
                                <h5><i class="fas ${icon} text-danger"></i> ${category.charAt(0).toUpperCase() + category.slice(1)}</h5>
                                <ul>${permissionsList}</ul>
                            `;
                            col.appendChild(callout);
                            currentRow.appendChild(col);
                            modalContent.appendChild(currentRow);

                            colCount++;
                        }
                    } else {
                        var noInfoMessage = document.createElement('p');
                        noInfoMessage.innerText = 'No hay información disponible';
                        noInfoMessage.style.textAlign = 'center';
                        modalContent.appendChild(noInfoMessage);
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
            })
        })
    </script>
@stop

