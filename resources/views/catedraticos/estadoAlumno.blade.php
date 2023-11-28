<!DOCTYPE html>
<html lang="es-SV">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Materias | Asistencia UMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .dataTables_info{
            color: white;
        }

        div.dataTables_wrapper div.dataTables_length label{
            color: white;
        }
        div.dataTables_wrapper div.dataTables_filter label{
            color: white;
        }
        .page-item.active .page-link{background: #dc3545; border-radius: #dc3545;}
    </style>
</head>
<body style="height: 100%; background-color:#B46060;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('catedarticoGestionMateriasIndex',['id' => encrypt(Auth::user()->id)]) }}">
                <img src="{{ asset('img/logo1.svg') }}" alt="Bootstrap" width="30" height="28">
                Asistencia <strong>UMA</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }} {{ Auth::user()->apellido }}
                        </button>
                        <ul class="dropdown-menu">
                            @can('boton-administrador')<li><a class="dropdown-item" href="{{ route('AdminIndex') }}">Administrador</a></li>
                            <li><hr class="dropdown-divider"></li>
                            @endcan
                          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                    viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path
                                        d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z" />
                                </svg> {{ __(' Cerrar sesión') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
    <main class="mt-5 d-flex align-items-center justify-content-center" style="height: 100%;">
        <div class="container">
            <div class="d-flex flex-column align-items-center">
                <h2 class="mt-4 text-white">Bienvenidos</h2>
                <div class="bg-dark rounded p-4 mx-auto w-100">
                    <br>
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th>Nombre de Alumno</th>
                                        <th class="d-none d-md-table-cell">Fecha</th>
                                        <th class="d-none d-md-table-cell">Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estado as $estados)
                                        <tr>
                                            <td >{{ $contador=$contador+1 }}</td>
                                            <td >{{ $estados->name }} {{ $estados->apellido }}</td>
                                            <td class="d-none d-md-table-cell">{{ $estados->fechaAsistencia }}</td>
                                            <td class="d-none d-md-table-cell"><span class="{{ ($estados->nombreEstadoAlumno === 'Puntual') ? 'badge badge-pill bg-success' : (($estados->nombreEstadoAlumno === 'Impuntual') ? 'badge badge-pill bg-warning' : (($estados->nombreEstadoAlumno === 'Ausente') ? 'badge badge-pill bg-danger' : (($estados->nombreEstadoAlumno === 'Permiso') ? 'badge badge-pill bg-info' : 'badge badge-pill bg-secondary'))) }}">{{ $estados->nombreEstadoAlumno}}</span></td>
                                            <td>
                                                <a href="#" class="asistenciaId" id="asistenciaId" data-bs-toggle="modal" data-bs-target="#modal{{ $estados->alumno_id }}"
                                                    style="color: inherit;">
                                                    <button class="btn btn-dark rounded mx-1 shadow" title="Detalles">
                                                        <span class="material-symbols-outlined">
                                                            markdown_paste
                                                        </span>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        {{-- modal --}}
                                        <div class="modal fade" id="modal{{ $estados->alumno_id }}"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Asistencia del Alumno</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12 col-lg-12">
                                                                <select class="form-select" id="estadoAlumno" name="estadoAlumno" aria-label="Default select example" required>
                                                                    <option selected disabled>Seleccione un Estado</option>
                                                                    @foreach ($estadoAlumno as $estadoAlumnos)
                                                                        <option value="{{ $estadoAlumnos->id }}">{{ $estadoAlumnos->nombreEstadoAlumno }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <br><br>
                                                            <div class="col-md-12 col-lg-12">
                                                                <button type="submit" class="btn btn-danger col-md-12 col-lg-12" id="agregar" data-alumno_id="{{ $estados->alumno_id }}" data-asistencia_id="{{ $estados->asistencia_id }}">Modificar Estado</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        	
        /* new DataTable('#example') */
        $('#example').DataTable({
            responsive:true,
            "language": {
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "zeroRecords": "Sin resultados encontrados",
            "info": "Mostrando _PAGE_ de _PAGES_ Entradas",
            "infoEmpty": "No existen datos",
            "infoFiltered": "(Filtrado de _MAX_  total entradas)",
            "search":"Buscar: ",
            "paginate":{
                "next":"Siguiente",
                "previous":"Anteior"
            }
        }
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.querySelector("#agregar").addEventListener("click", function () {
            var alumnoId = this.getAttribute("data-alumno_id");
            var asistenciaId = this.getAttribute("data-asistencia_id");
            var estadoAlumnoValue = document.querySelector("#estadoAlumno").value;
            axios.put("{{ route('catedraticoCambiasEstado',['asistencia_id'=>':asistenciaId', 'alumno_id'=>':alumnoId'])}}".replace(":asistenciaId", asistenciaId).replace(":alumnoId", alumnoId),{
                estadoAlumno_id:estadoAlumnoValue
            })
            .then(response => {
                    if (response.status == 200) {
                        var asistenciaCifrada = response.data.asistenciaCifrada;
                        window.location="{{ route('catedraticoEstadoAlumnoIndex', ['id'=>':asistenciaId']) }}".replace(":asistenciaId", asistenciaCifrada)
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        })
    </script>
</body>
</html>