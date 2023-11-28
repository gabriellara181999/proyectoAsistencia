@extends('layouts.app_admin')

@section('title', 'Editar / Estudiantes | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Modificación de Estudiantes</h1>
@stop

@section('content_body')
<style>
    .materiasInscritas_button {
        display: none;
        opacity: 0;
        transition: opacity 1.5s ease;
    }
    .fade-in {
        opacity: 1;
    }
</style>
    <div class="col-lg-9 mb-3 mx-auto">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('estudiantes.update', $alumno->id)  }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <x-adminlte-input type="text" class="form-control" id="name" name="name" autocomplete="name" aria-describedby="emailHelp" label="Nombres" fgroup-class="col-me-3" value="{{ $alumno->name }}"/>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <x-adminlte-input type="text" class="form-control" id="apellido" name="apellido" aria-describedby="emailHelp" label="Apellidos" fgroup-class="col-me-3" value="{{ $alumno->apellido }}" />
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <x-adminlte-input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" aria-describedby="emailHelp" label="Fecha de Nacimiento" fgroup-class="col-me-3" value="{{ $alumno->fechaNacimiento }}" />
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label for="sexo" class="form-label">Sexo</label>
                                <x-adminlte-select class="form-control" id="sexo" name="sexo" aria-label="Default select example">
                                    <option selected disabled>Seleccione el sexo</option>
                                    <option value="Femenino" {{ old('sexo') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="Masculino" {{ old('sexo') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                </x-adminlte-select>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <div class="mb-3">
                                <x-adminlte-input type="text" class="form-control" id="numeroEstudiante" name="numeroEstudiante"
                                    aria-describedby="emailHelp" label="N° de Estudiante" placeholder="AA111111111" fgroup-class="col-me-3" value="{{ $alumno->numeroEstudiante }}" autocomplete="alumnonumber"/>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="mb-3">
                                <x-adminlte-input type="email" class="form-control" id="email" name="email"
                                    aria-describedby="emailHelp" label="Correo electrónico" fgroup-class="col-me-3" value="{{ $alumno->email }}" autocomplete="username"/>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <div class="mb-3">
                                <x-adminlte-input id="password" name="password" type="password" label="Contraseña" fgroup-class="col-me-3" value="{{ old('password') }}" autocomplete="current-password">
                                    <x-slot name="appendSlot">
                                        <x-adminlte-button theme=" btn btn-outline-secondary" id="showPasswordBtn" icon="fas fa-eye"/>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="mb-3">
                                <x-adminlte-input type="text" class="form-control" id="telefono" name="telefono" placeholder="____-____" pattern="\d{4}-\d{4}" aria-describedby="emailHelp" label="Teléfono" fgroup-class="col-me-3" value="{{ $alumno->telefono }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <label for="facultad_id" class="form-label">Facultad</label>
                            <x-adminlte-select class="form-control " id="facultad_id" name="facultad_id" aria-label="Default select example">
                                <option selected disabled>Seleccione la Facultad</option>
                                @foreach ($facultad as $facultades)
                                    <option value="{{ $facultades->id }}">{{ $facultades->nombreFacultad }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label for="carrera_id" class="form-label">Carrera</label>
                            <x-adminlte-select class="form-control " id="carrera_id" name="carrera_id" aria-label="Default select example">
                            </x-adminlte-select>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-6 col-lg-6">
                            <label for="ciclo_id" class="form-label">Ciclo</label>
                            <x-adminlte-select class="form-control " id="ciclo_id" name="ciclo_id" aria-label="Default select example">
                                <option selected disabled>Seleccione el Ciclo</option>
                                @foreach ($ciclo as $ciclos)
                                    <option value="{{ $ciclos->id }}" >{{ $ciclos->nombreCiclo }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label for="materiasInscritas_id" class="form-label">N° de Materias Inscritas</label>
                            <br>
                            @foreach ($materiaInscrita as $materiaInscritas)
                            <a href="#" class="materiasInscritas_button" id="materiasInscritas_button" data-toggle="modal" data-target="#modal{{ $materiaInscritas->id }}" data-materia-id="{{ $materiaInscritas->id }}" style="color: inherit;">
                                <button class="btn btn-outline-dark rounded mx-1 shadow " title="Materias">
                                    {{ $materiaInscritas->cantidadMateria }}
                                </button>
                            </a>
                            <x-adminlte-modal id="modal{{ $materiaInscritas->id }}" title="Materias" size="lg" theme="danger" icon="fas fa-clipboard-list" v-centered static-backdrop>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="text-center" style="position: sticky;">Materias</h3>
                                        <hr>
                                        <div id="modalContent{{ $materiaInscritas->id }}"></div>
                                    </div>
                                </div>
                                <x-slot name="footerSlot">
                                    <x-adminlte-button theme="dark" label="Cerrar" data-dismiss="modal" />
                                    <x-adminlte-button id="botonAgregar{{ $materiaInscritas->id }}" class="mr-auto" theme="danger" label="Agregar Materia"/>
                                    <div id="materiasSeleccionadas{{ $materiaInscritas->id }}"></div>
                                </x-slot>
                            </x-adminlte-modal>
                            @endforeach
                        </div>
                    </div>
                    <hr id="oculto2">
                    <div class="row mx-auto" id="oculto">
                        <div class="col-md-6 col-lg-12">
                            <h5 style="text-align: center;">Materias Seleccionadas</h5>
                            <div id="nombreMateriasMostrar"></div>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div>
                            <a href="{{ route('estudiantes.index') }}" class="btn btn-dark mt-3">
                                <i class="fas fa-chevron-left"></i> Regresar
                            </a>
                        </div>
                        <div style="margin-left: 10px">
                            <button type="submit" class="btn btn-danger mt-3" id="agregar">Modificar Estudiante</button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <style>
        .seleccionada {
            border: 2px solid red;
        }
    </style>
@stop

@section('footer')
    <h1></h1>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $("#showPasswordBtn").on("click", function() {
                var passwordField = $("#password");
                var passwordFieldType = passwordField.attr("type");

                if (passwordFieldType === "password") {
                    passwordField.attr("type", "text");
                } else {
                    passwordField.attr("type", "password");
                }
            });
        });

        $(document).ready(function() {
            $(document).ready(function() {
                var telefono = $("#telefono");

                telefono.on("input", function() {
                    var inputValue = telefono.val();
                    var numericValue = inputValue.replace(/\D/g, "");
                    var formattedValue = numericValue.slice(0, 4) + "-" + numericValue.slice(4,8);
                    telefono.val(formattedValue);
                });

                telefono.on("focusout", function() {
                    if (telefono.val().length < 9) {
                        telefono.val("");
                    }
                });
            });
        });
        $(document).ready(function() {
            var numeroEstudiante = $("#numeroEstudiante");

            numeroEstudiante.on("input", function() {
                var inputValue = numeroEstudiante.val();
                var sanitizedValue = inputValue.replace(/[^A-Z\d]/g, "").slice(0, 11);
                var firstTwoChars = sanitizedValue.slice(0, 2);
                var nextNineChars = sanitizedValue.slice(2);
                letras = firstTwoChars.replace(/[^A-Z]/g, '')
                numero=nextNineChars.replace(/[^0-9]/g, '')
                var formattedValue = letras + numero;

                numeroEstudiante.val(formattedValue);
            });

            numeroEstudiante.on("focusout", function() {
                if (numeroEstudiante.val().length !== 11) {
                    numeroEstudiante.val("");
                }
            });
        });
        document.getElementById('facultad_id').addEventListener('change', function() {
            var facultad_id = this.value;
            axios.get('/admin/estudiantes/obtenerCarreras/' + facultad_id)
            .then(function(response) {
                var carreras = response.data;
                var carreraSelect = document.getElementById('carrera_id');
                carreraSelect.innerHTML = '<option selected disabled>Seleccione la Carrera</option>';
                carreras.forEach(function(carrera) {
                    carreraSelect.innerHTML += '<option value="' + carrera.id + '">' + carrera.nombreCarrera + '</option>';
                });
            })
            .catch(function(error) {
                console.error('Error al obtener la carrera:', error);
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            var carreraSelect = document.getElementById('carrera_id');
            var cicloSelect = document.getElementById('ciclo_id');
            var materiasInscritasButtons = document.querySelectorAll('.materiasInscritas_button');
            carreraSelect.addEventListener('change', function () {
                cicloSelect.addEventListener('change', function(){
                    var carreraSeleccionada = carreraSelect.value;
                    if (carreraSeleccionada !== '') {
                        materiasInscritasButtons.forEach(function (button) {
                            button.style.display = 'inline-block';
                            setTimeout(function () {
                                button.classList.add('fade-in');
                            }, 50);
                        });
                    } else {
                        materiasInscritasButtons.forEach(function (button) {
                            button.style.display = 'none';
                            button.classList.remove('fade-in');
                        });
                    }
                })
            });
        });
        var elementosMostrar = document.getElementById('oculto');
        var elementosMostrarHr = document.getElementById('oculto2');
        elementosMostrar.style.display='none';
        elementosMostrarHr.style.display='none'
        var materiasInscritasButtons = document.querySelectorAll('.materiasInscritas_button');
        var nombreMateriasMostrar = document.getElementById('nombreMateriasMostrar')
        materiasInscritasButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                nombreMateriasMostrar.innerHTML=''
                var nombreMateriasSeleccionadas = [];
                var idMateriasSeleccionadas=[]
                var totalMaterias = 0;
                var materiasSeleccionadas = 0;
                var materiaInscrita_id = this.getAttribute('data-target').charAt(this.getAttribute('data-target').length - 1);
                console.log(materiaInscrita_id);
                var carrera_id = document.getElementById('carrera_id').value;
                axios.get('/admin/estudiantes/materiasAlumno/' + carrera_id)
                .then(function (response) {
                    if (typeof response.data === 'string') {
                        try {
                            materias = JSON.parse(response.data);
                        } catch (error) {
                            console.error('Error al analizar la cadena JSON:', error);
                        }
                    } else if (typeof response.data === 'object') {
                        materias = response.data;
                    } else {
                        console.error('Tipo de datos desconocido en response.data:', typeof response.data);
                    }
                    var modalContent = document.getElementById('modalContent' + materiaInscrita_id);
                    var nombreMateria = document.getElementById('materiasSeleccionadas' + materiaInscrita_id);
                    modalContent.innerHTML = '';
                    var tarjetasPorFila = 6;
                    var materiasPorCiclo = {};
                    console.log(materias);
                    materias.sort(function (a, b) {
                        return parseInt(a.nombreCiclo.match(/\d+/)) - parseInt(b.nombreCiclo.match(/\d+/));
                    });
                    var ciclosSet = new Set();
                    materias.forEach(function (materia) {
                        ciclosSet.add(materia.nombreCiclo);
                    });
                    var ciclosOrdenados = Array.from(ciclosSet);
                    ciclosOrdenados.sort((a, b) => parseInt(a) - parseInt(b));
                    var row = document.createElement('div');
                    row.className = 'row';
                    row.style.position = 'sticky';
                    var contadorMaterias = document.createElement('p');
                    contadorMaterias.textContent = '0 materias seleccionadas';
                    contadorMaterias.style.position = 'sticky';
                    row.appendChild(contadorMaterias);
                    var nuevoDiv = document.createElement('div');
                    nuevoDiv.className = 'd-flex col-md-12';
                    nuevoDiv.style.maxWidth = '1300px'
                    nuevoDiv.style.maxHeight = '450px';
                    nuevoDiv.style.overflowX = 'auto';
                    nuevoDiv.style.overflowY = 'auto';
                    row.appendChild(nuevoDiv);
                    var columnContainer = document.createElement('div');
                    columnContainer.className = 'd-flex col-md-12';
                    columnContainer.style.maxWidth = '1300px'
                    ciclosOrdenados.forEach(function (ciclo) {
                        var column = document.createElement('div');
                        column.className = 'col-md-3';
                        var title = document.createElement('h4');
                        title.textContent = ciclo;
                        title.style.textAlign = 'center';
                        column.appendChild(title);
                        var materiasDelCiclo = materias.filter(function (materia) {
                            return materia.nombreCiclo === ciclo;
                        });

                        var filas = [];
                        for (var i = 0; i < materiasDelCiclo.length; i += tarjetasPorFila) {
                            filas.push(materiasDelCiclo.slice(i, i + tarjetasPorFila));
                        }
                        filas.forEach(function (filaMaterias, index) {
                            var fila = document.createElement('div');
                            fila.className = 'row';
                            filaMaterias.forEach(function (materia) {
                                var card = document.createElement('div');
                                card.className = 'col-md-12';
                                card.innerHTML = '<div class="card"><div class="card-body">' +
                                    '<h6 class="card-title"><strong>Nombre:</strong> ' + materia.nombreMateria + '</h6>' +
                                    '<p class="card-text"><strong>Ciclo:</strong> ' + materia.nombreCiclo + '<br>' + '<strong>Horario: </strong>' + materia.nombreDia1 + ' | ' + materia.turno1 + ' (' + materia.horaApertura1 + '-' + materia.horaFinalizacion1 + ')' + (materia.diaHorario_idv2 ? ' -- ' + materia.nombreDia2 + ' | ' + materia.turno2 + ' (' + materia.horaApertura2 + '-' + materia.horaFinalizacion2 + ')' : '') + '</p>' +
                                    '</div></div>';
                                var cardDiv = card.querySelector('.card');
                                var materiasInscritas = new Set();
                                if (materiasInscritas.has(materia.id)) {
                                    cardDiv.style.backgroundColor = 'red';
                                }
                                //cada materia por ciclo
                                cardDiv.addEventListener('click', function () {
                                    if (cardDiv.classList.contains('seleccionada')) {
                                        cardDiv.classList.remove('seleccionada');
                                        var index = nombreMateriasSeleccionadas.indexOf(materia.nombreMateria);
                                        if (index !== -1) {
                                            nombreMateriasSeleccionadas.splice(index, 1);
                                        }
                                        var index2 = idMateriasSeleccionadas.indexOf(materia.materias_id);
                                        if (index2 !== -1) {
                                            idMateriasSeleccionadas.splice(index2, 1);
                                        }
                                        materiasSeleccionadas--;
                                    } else {
                                        var maxMateriasSeleccionar = parseInt(materiaInscrita_id);
                                        totalMaterias = maxMateriasSeleccionar
                                        if (materiasSeleccionadas >= maxMateriasSeleccionar) {
                                            Swal.fire('Has alcanzado el límite de materias para seleccionar');
                                        } else {
                                            cardDiv.classList.add('seleccionada');
                                            nombreMateriasSeleccionadas.push(materia.nombreMateria);
                                            idMateriasSeleccionadas.push(materia.materias_id);
                                            materiasSeleccionadas++;
                                        }
                                    }
                                    contadorMaterias.textContent = materiasSeleccionadas+' / '+totalMaterias + ' materias seleccionadas';
                                    console.log(nombreMateriasSeleccionadas);
                                    console.log(idMateriasSeleccionadas);
                                    nombreMateria.textContent = nombreMateriasSeleccionadas.slice(0, 3).join(', ');
                                    if (nombreMateriasSeleccionadas.length > 3) {
                                        nombreMateria.textContent += ', ...';
                                    } 
                                });
                                fila.appendChild(card);
                            });

                            column.appendChild(fila);
                        });
                        columnContainer.appendChild(column);
                    });
                    nuevoDiv.appendChild(columnContainer);
                    row.appendChild(nuevoDiv)
                    modalContent.appendChild(row);

                    var botonAgregarMateria=document.getElementById('botonAgregar'+materiaInscrita_id)
                    document.getElementById('botonAgregar'+materiaInscrita_id).addEventListener('click', function () {
                        console.log(nombreMateriasSeleccionadas);
                        console.log(idMateriasSeleccionadas);
                        console.log('holaa');
                        
                        if(materiasSeleccionadas === totalMaterias){
                            elementosMostrarHr.style.display='block';
                            elementosMostrar.style.display='block';
                            var rowContainer = document.createElement('div');
                            rowContainer.className = 'row';

                            for (var i = 0; i < nombreMateriasSeleccionadas.length; i++) {
                                var materiaSeleccionada = nombreMateriasSeleccionadas[i];
                                var idMateriaSeleccionada = idMateriasSeleccionadas[i];
                                var inputIdMateria = document.createElement('input');
                                inputIdMateria.type = 'hidden';
                                inputIdMateria.name = 'materiasSeleccionadas[]'
                                inputIdMateria.id = 'idMateriaSeleccionada'+(i+1);
                                inputIdMateria.value = idMateriaSeleccionada;
                                var col = document.createElement('div');
                                col.className = 'col-md-6'; 
                                var parrafo = document.createElement('p');
                                parrafo.textContent = (i + 1) + '. ' + materiaSeleccionada;
                                parrafo.setAttribute('value', idMateriaSeleccionada);

                                col.appendChild(parrafo);
                                col.appendChild(inputIdMateria)
                                rowContainer.appendChild(col);
                            }
                            nombreMateriasMostrar.appendChild(rowContainer);

                            botonAgregarMateria.setAttribute('data-dismiss', 'modal');
                        }else{
                            elementosMostrarHr.style.display='none';
                            elementosMostrar.style.display='none';
                            Swal.fire('Debes seleccionar todas las materias antes de agregar.')
                        }
                    })
                })
                .catch(function (error) {
                    console.error('Error al obtener la materia:', error);
                });
            });
        });
    </script>
@stop