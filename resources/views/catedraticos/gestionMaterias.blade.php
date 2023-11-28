<!doctype html>
<html lang="es-SV">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Materias | Asistencia UMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
                            <div class="row">
                                @php
                                    $sortedMateriasUsuario = $materiasUsuario->sort(function ($a, $b) {
                                        preg_match('/\d+/', $a->nombreCiclo, $matchesA);
                                        preg_match('/\d+/', $b->nombreCiclo, $matchesB);
                                        $numeroA = isset($matchesA[0]) ? (int) $matchesA[0] : 0;
                                        $numeroB = isset($matchesB[0]) ? (int) $matchesB[0] : 0;
                                        return $numeroA - $numeroB;
                                    });
                                @endphp
                                @foreach ($sortedMateriasUsuario as $materiaUsuario)
                                    <div class="col-md-4 col-sm-6 mb-3">
                                        @if (
                                            ($diaSemanaActual == $materiaUsuario->nombreDia1 &&
                                                $materiaUsuario->horaApertura1 <= $horaActual &&
                                                $horaActual <= $materiaUsuario->horaFinalizacion1) ||
                                                ($diaSemanaActual == $materiaUsuario->nombreDia2 &&
                                                    $materiaUsuario->horaApertura2 <= $horaActual &&
                                                    $horaActual <= $materiaUsuario->horaFinalizacion2))
                                            <a href="{{ route('catedraticoAsistenciaMateriaAlumno', ['user_id' => encrypt($materiaUsuario->user_id), 'materia_id' => encrypt($materiaUsuario->materias_id)]) }}" style="text-decoration: none">
                                                <div class="card card-hover">
                                                @else
                                                    <div class="card" style="cursor: not-allowed;">
                                        @endif
                                        <div class="card-header text-center bg-danger">
                                            <h6>
                                                <strong class="text-white">{{ $materiaUsuario->nombreMateria }}</strong>
                                            </h6>
                                        </div>
                                        <div class="card-body text-dark">
                                            <p class="card-text mb-2"><strong>Facultad:
                                                </strong>{{ $materiaUsuario->nombreFacultad }}</p>
                                            <p class="card-text mb-2"><strong>Carrera: </strong>{{ $materiaUsuario->nombreCarrera }}
                                            </p>
                                            <p class="card-text mb-2"><strong>Ciclo: </strong>{{ $materiaUsuario->nombreCiclo }}</p>
                                            <p style="margin-bottom: 0;"><strong>Horario: </strong>{{ $materiaUsuario->nombreDia1 }}
                                                | {{ $materiaUsuario->turno1 }}
                                                ({{ $materiaUsuario->horaApertura1 }}-{{ $materiaUsuario->horaFinalizacion1 }})
                                                @if (!empty($materiaUsuario->diaHorario_idv2))
                                                    -- {{ $materiaUsuario->nombreDia2 }} | {{ $materiaUsuario->turno2 }}
                                                    ({{ $materiaUsuario->horaApertura2 }}-{{ $materiaUsuario->horaFinalizacion2 }})
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
<style>
    .card-hover {
        transition: transform 0.3s ease;
    }

    .card-hover:hover {
        transform: scale(1.05);
    }
</style>
</html>