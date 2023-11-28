@extends('layouts.app_admin')

@section('title', 'Estudiantes | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Gestión de Estudiantes</h1>
@stop
@section('content_body')
<style>
    .modal-header .close {
        display: none;
    }
</style>
    <div class="d-grid gap-2 d-md-block ">
        <a href="{{ route('estudiantes.create') }}" class="btn btn-danger rounded-pill d-block d-sm-inline-block align-self-sm-center">
            <i class="fas fa-graduation-cap"></i> Crear Estudiante
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
                    <th class="d-none d-md-table-cell">Sexo</th>
                    <th class="d-none d-md-table-cell">N° Estudiante</th>
                    <th class="d-none d-md-table-cell">Carrera</th>
                    <th class="d-none d-md-table-cell">N° Materia</th>
                    <th>Opciones</th>
                @endslot
                @slot('data')
                    @foreach ($estudiante as $estudiantes)
                        <tr>
                            <td data-id="{{ $estudiantes->alumno_id }}">{{ $contador=$contador+1}}</td>
                            <td data-name="{{ $estudiantes->name }}">{{ $estudiantes->name }}</td>
                            <td data-unit="{{ $estudiantes->apellido }}" class="d-none d-md-table-cell">{{ $estudiantes->apellido }}</td>
                            <td data-id="{{ $estudiantes->sexo }}" class="d-none d-md-table-cell">{{ $estudiantes->sexo === 'F' ? 'Femenino' : 'Masculino' }}</td>
                            <td data-id="{{ $estudiantes->numeroEstudiante }}" class="d-none d-md-table-cell">{{ $estudiantes->numeroEstudiante }}</td>
                            <td data-id="{{ $estudiantes->nombreCarrera }}" class="d-none d-md-table-cell">{{ $estudiantes->nombreCarrera }}</td>
                            <td data-id="{{ $estudiantes->cantidadMatereia }}" class="d-none d-md-table-cell">{{ $estudiantes->cantidadMateria }}</td>
                            <td>
                                <a href="" data-toggle="modal" data-target="#modal{{ $estudiantes->alumno_id }}"
                                    style="color: inherit;">
                                    <button class="btn btn-success rounded  mx-1 shadow" title="Detalles">
                                        <i class="fas fa-clipboard-list"></i>
                                    </button>
                                </a>
                                <a class="btn btn-dark rounded mx-1 shadow" href="{{ route('estudiantes.edit', ['estudiante' => $estudiantes->alumno_id]) }}">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('estudiantes.destroy', $estudiantes->alumno_id) }}" method="post" style="display:inline;">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger rounded mx-1 shadow" onclick="confirmarEliminacion(event, this.form)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <x-adminlte-modal id="modal{{ $estudiantes->alumno_id }}" title="{{ $estudiantes->name }}" size="lg" theme="danger" icon="fas fa-clipboard-list" v-centered static-backdrop scrollable>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-center">Detalle del Estudiante</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Nombres: </strong>{{ $estudiantes->name }}</p>
                                            <p><strong>Apellidos: </strong>{{ $estudiantes->apellido }}</p>
                                            <p><strong>Fecha de Nacimiento: </strong>{{ date('d-m-Y', strtotime($estudiantes->fechaNacimiento)) }}</p>
                                            <p><strong>Correo: </strong>{{ $estudiantes->email }}</p>
                                            <p><strong>Sexo: </strong>{{ $estudiantes->sexo === 'F' ? 'Femenino' : 'Masculino' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>N° Catedrático: </strong>{{ $estudiantes->numeroEstudiante }}</p>
                                            <p><strong>Teléfono: </strong>{{ $estudiantes->telefono }}</p>
                                            <p><strong>Facultad: </strong>{{ $estudiantes->nombreFacultad }}</p>
                                            <p><strong>Ciclo: </strong>{{ $estudiantes->nombreCiclo }}</p>
                                            <p><strong>Carrera: </strong>{{ $estudiantes->nombreCarrera }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="materiasInscritas" data-id="{{ $estudiantes->alumno_id }}" data-modal-loaded="false"><strong>N° Materias Inscritas: </strong>{{ $estudiantes->cantidadMateria }}</p>
                                        </div>
                                    </div>                                    
                                    <div id="materias{{ $estudiantes->alumno_id }}"></div>
                                </div>
                            </div>
                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="dark" label="Cerrar" data-dismiss="modal" class="cerrar" />
                            </x-slot>
                        </x-adminlte-modal>
                    @endforeach
                @endslot
            @endcomponent
        </div>
    </div>
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
                    form.submit();
                }
            });
        }
        function fadeIn(element, duration) {
            element.style.opacity = 0;
            var startTime = null;
            function animate(currentTime) {
                if (!startTime) {
                    startTime = currentTime;
                }
                var elapsedTime = currentTime - startTime;
                var progress = Math.min(elapsedTime / duration, 1);
                element.style.opacity = progress;
                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            }

            requestAnimationFrame(animate);
        }
        var materiasInscritasElements = document.querySelectorAll('.materiasInscritas');
        materiasInscritasElements.forEach(function(element) {
            element.addEventListener('click', function() {
                var alumno_id = element.getAttribute('data-id');
                var modalLoaded = element.getAttribute('data-modal-loaded');
                var materias = document.getElementById('materias' + alumno_id);
                materias.innerHTML = '';
                materias.style.display = 'none';

                if (modalLoaded === 'false') {
                    console.log(alumno_id);
                    axios.get('/admin/estudiantes/materiasIndexAlumno/' + alumno_id)
                        .then(function(response) {
                            datos = response.data;
                            console.log(datos);
                            var hr = document.createElement('hr')
                            materias.appendChild(hr)
                            var tituloMateria=document.createElement('h5')
                            tituloMateria.className='text-center'
                            tituloMateria.textContent='Materias'
                            materias.appendChild(tituloMateria)
                            //carrusel
                            var carruselDiv = document.createElement('div');
                            carruselDiv.className = 'carousel slide';
                            carruselDiv.setAttribute('data-ride', 'carousel');
                            carruselDiv.id = 'materiasCarousel'; 
                            var indicadorOl = document.createElement('ol');
                            indicadorOl.className = 'carousel-indicators';
                            var carruselInnerDiv = document.createElement('div');
                            carruselInnerDiv.className = 'carousel-inner';
                            var activeIndex = 0;
                            datos.forEach(function(dato, index) {
                                var diapositivaDiv = document.createElement('div');
                                diapositivaDiv.className = 'carousel-item' + (index === activeIndex ? ' active' : '');
                                var contenidoDiapositiva = document.createElement('div');
                                contenidoDiapositiva.className = 'd-flex flex-column align-items-center ';
                                var numeracion = document.createElement('span');
                                numeracion.className = 'carousel-numero';
                                numeracion.textContent = (index + 1) + '/' + datos.length;
                                contenidoDiapositiva.appendChild(numeracion);
                                var contenidoDato = document.createElement('div');
                                contenidoDato.className = 'card-container';
                                contenidoDato.style.width='70%'

                                var card = document.createElement('div');
                                card.className = 'card border-dark mb-3';

                                var cardBody = document.createElement('div');
                                cardBody.className = 'card-body';

                                var cardText = document.createElement('p');
                                cardText.className = 'card-text';
                                cardText.innerHTML = '<h6 class="card-title"><strong>Nombre:</strong> ' + dato.nombreMateria + '</h6>' + '<p class="card-text"><strong>Ciclo:</strong> ' + dato.nombreCiclo + '<br>' +'<strong>Catedratico:</strong> ' + dato.name+' '+dato.apellido + '<br>' + '<strong>Horario: </strong>' + dato.nombreDia1 + ' | ' + dato.turno1 + ' (' + dato.horaApertura1 + '-' + dato.horaFinalizacion1 + ')' + (dato.diaHorario_idv2 ? ' -- ' + dato.nombreDia2 + ' | ' + dato.turno2 + ' (' + dato.horaApertura2 + '-' + dato.horaFinalizacion2 + ')' : '') + '</p>';
                                cardBody.appendChild(cardText);
                                card.appendChild(cardBody);
                                contenidoDato.appendChild(card);

                                contenidoDiapositiva.appendChild(contenidoDato);
                                diapositivaDiv.appendChild(contenidoDiapositiva);
                                var indicadorLi = document.createElement('li');
                                indicadorLi.setAttribute('data-target', '#materiasCarousel');
                                indicadorLi.setAttribute('data-slide-to', index);
                                indicadorLi.className = index === activeIndex ? 'active' : '';
                                indicadorOl.appendChild(indicadorLi);
                                carruselInnerDiv.appendChild(diapositivaDiv);
                            });
                            carruselDiv.appendChild(indicadorOl);
                            carruselDiv.appendChild(carruselInnerDiv);
                            materias.appendChild(carruselDiv);

                            var prevButton = document.createElement('a');
                            prevButton.className = 'carousel-control-prev';
                            prevButton.href = '#materiasCarousel';
                            prevButton.role = 'button';
                            prevButton.setAttribute('data-slide', 'prev');
                            prevButton.innerHTML = '<span class="carousel-control-prev-icon black-control " aria-hidden="true"></span><span class="sr-only">Previous</span>';
                            var nextButton = document.createElement('a');
                            nextButton.className = 'carousel-control-next';
                            nextButton.href = '#materiasCarousel';
                            nextButton.role = 'button';
                            nextButton.setAttribute('data-slide', 'next');
                            nextButton.innerHTML = '<span class="carousel-control-next-icon black-control" aria-hidden="true"></span><span class="sr-only">Next</span>';
                            var style = document.createElement('style');
                            style.innerHTML = `
                                .black-control {
                                    background-color:#dc3545;
                                    border-radius: 10%;
                                }
                            `;
                            document.head.appendChild(style);
                            carruselDiv.appendChild(prevButton);
                            carruselDiv.appendChild(nextButton);
                            $(carruselDiv).carousel();
                            materias.style.display = 'block';
                            fadeIn(materias, 1000);
                        })
                        .catch(function(error) {
                            console.error('Error al obtener la materia:', error);
                        });

                    element.setAttribute('data-modal-loaded', 'true');
                }
            });
        });

        // Función para aplicar animación de aparición
        function fadeIn(element, duration) {
            element.style.opacity = 0;

            var startTime = null;

            function animate(currentTime) {
                if (!startTime) {
                    startTime = currentTime;
                }

                var elapsedTime = currentTime - startTime;
                var progress = Math.min(elapsedTime / duration, 1);
                element.style.opacity = progress;

                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            }

            requestAnimationFrame(animate);
        }

        var datas = document.querySelectorAll('.cerrar');
        datas.forEach(function(elements) {
            elements.addEventListener('click', function() {
                var modalContent = elements.closest('.modal-content');
                var materiasInscritas = modalContent.querySelector('.materiasInscritas');
                materiasInscritas.setAttribute('data-modal-loaded', 'false');
                var dataId=materiasInscritas.getAttribute('data-id')
                var materias = document.getElementById('materias' + dataId);
                materias.innerHTML=''
                materias.style.display='none'
            });
        });

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