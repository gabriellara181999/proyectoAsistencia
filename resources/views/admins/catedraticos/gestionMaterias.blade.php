@extends('layouts.app_admin')

@section('title', 'Catedraticos / Materias | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Materias</h1>
@stop

@section('content_body')
    <br>
    <div class="col-lg-12">
        <div class="row">
            @php
                $sortedMateriasUsuario = $materiasUsuario->sort(function($a, $b) {
                    preg_match('/\d+/', $a->nombreCiclo, $matchesA);
                    preg_match('/\d+/', $b->nombreCiclo, $matchesB);
                    $numeroA = isset($matchesA[0]) ? (int)$matchesA[0] : 0;
                    $numeroB = isset($matchesB[0]) ? (int)$matchesB[0] : 0;
                    return $numeroA - $numeroB;
                });
            @endphp
            @foreach ($sortedMateriasUsuario as $materiaUsuario)
                <div class="col-md-4 col-sm-6 mb-3">
                     @if ( $diaSemanaActual == $materiaUsuario->nombreDia1 && $materiaUsuario->horaApertura1 <= $horaActual && $horaActual <= $materiaUsuario->horaFinalizacion1 || $diaSemanaActual == $materiaUsuario->nombreDia2 && $materiaUsuario->horaApertura2 <= $horaActual && $horaActual <= $materiaUsuario->horaFinalizacion2) <a href="{{ route('asistenciaMateriaAlumno',['user_id'=>$materiaUsuario->user_id, 'materia_id'=>$materiaUsuario->materias_id]) }}"><div class="card card-hover">@else <div class="card" style="cursor: not-allowed;">@endif
                            <div class="card-header text-center bg-danger">
                                <h6>
                                    <strong>{{ $materiaUsuario->nombreMateria }}</strong>
                                </h6>
                            </div>
                            <div class="card-body text-dark">
                                <p class="card-text mb-2"><strong>Facultad: </strong>{{ $materiaUsuario->nombreFacultad }}</p>
                                <p class="card-text mb-2"><strong>Carrera: </strong>{{ $materiaUsuario->nombreCarrera }}</p>
                                <p class="card-text mb-2"><strong>Ciclo: </strong>{{ $materiaUsuario->nombreCiclo }}</p>
                                <p style="margin-bottom: 0;"><strong>Horario: </strong>{{ $materiaUsuario->nombreDia1 }} | {{ $materiaUsuario->turno1 }} ({{ $materiaUsuario->horaApertura1 }}-{{ $materiaUsuario->horaFinalizacion1 }})@if (!empty($materiaUsuario->diaHorario_idv2)) -- {{ $materiaUsuario->nombreDia2}} | {{ $materiaUsuario->turno2 }} ({{ $materiaUsuario->horaApertura2 }}-{{ $materiaUsuario->horaFinalizacion2 }}) @endif </p>
                            </div>
                        </div>
                    </a>
                </div>
                
            @endforeach
         </div>
    </div>
@stop

@section('footer')
    <h1></h1>
@stop

@section('css')
    <style>
        .card-hover {
            transition: transform 0.3s ease;
        }

        .card-hover:hover {
            transform: scale(1.05);
        }

    </style>

@endsection
