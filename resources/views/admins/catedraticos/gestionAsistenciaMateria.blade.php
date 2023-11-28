@extends('layouts.app_admin')

@section('title', 'Asistencia / Catedraticos / Materias | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Asistencia de Materia</h1>
@stop

@section('content_body')
<style>
    .modal-header .close {
        display: none;
    }
</style>
    <div class="d-grid gap-2 d-md-block ">
            {{-- {{ dd($qrCreadoEnSemana) }} --}}
            @if ($qrCreadoEnSemana)
                <div class="alert alert-warning border border-warning d-flex d-lg-inline-flex align-self-sm-center justify-content-center" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                        <span style="margin-left: 6px">   No puedes crear un nuevo QR esta semana</span>
                </div>   
            @else
                <form method="POST" action="{{ route('crearAsistencia') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                    <input type="hidden" name="materia_id" value="{{ $materia_id }}">
                    <button type="submit" class="btn btn-danger rounded-pill d-block d-sm-inline-block align-self-sm-center">
                        <i class="fas fa-qrcode"></i> Nuevo QR
                    </button>
                </form>
            @endif
    </div>
    <br>
    <div class="col-lg-12">
        <div class="table-responsive">
            @component('common.datatable')
                @slot('table_id', 'ejemplo')
                @slot('columns')
                    <th scope="col">#</th>
                    <th>Fecha / Hora</th>
                    <th class="d-none d-md-table-cell">Estado</th>
                    <th>Opciones</th>
                @endslot
                @slot('data')
                    @foreach ($materiaAsistencia as $materiaAsistencias)
                        <tr>
                            <td >{{ $contador=$contador+1 }}</td>
                            <td>{{ ucfirst(Carbon\Carbon::parse($materiaAsistencias->fechaAsistencia)->isoFormat('dddd D-MMM-YYYY')) }} | {{ \Carbon\Carbon::parse($materiaAsistencias->fechaAsistencia)->format('h:i A') }}</td>
                            <td class="d-none d-md-table-cell"><span class="{{ $materiaAsistencias->nombreEstado == 'Activo' ? 'badge badge-pill badge-success' : 'badge badge-pill badge-danger' }}">{{ $materiaAsistencias->nombreEstado}}</span></td>
                            <td>
                                <a href="#" class="asistenciaId" id="asistenciaId" data-toggle="modal" data-target="#modal{{ $materiaAsistencias->id }}"
                                    style="color: inherit;">
                                    <button class="btn btn-dark rounded  mx-1 shadow" title="Detalles">
                                        <i class="fas fa-chart-pie"></i>
                                    </button>
                                </a>

                                <a class="btn btn-success rounded mx-1 shadow" href="{{ route('estadoAlumnoIndex', $materiaAsistencias->id) }}">
                                    <i class="fas fa-user-clock"></i>
                                </a>
                            </td>
                        </tr>
                        {{-- modal --}}
                        <x-adminlte-modal id="modal{{ $materiaAsistencias->id }}" title="Asistencias" size="lg" theme="danger" icon="fas fa-clipboard-list" v-centered static-backdrop scrollable>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="text-center" style="position: sticky;">Asistencias</h3>
                                    <div id="modalContent{{ $materiaAsistencias->id }}"></div>
                                </div>
                            </div>
                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="dark" label="Cerrar" class="cerrar" data-id="{{ $materiaAsistencias->id }}" data-dismiss="modal" />
                            </x-slot>
                        </x-adminlte-modal>
                    @endforeach
                @endslot
            @endcomponent
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        var myPieChart;
        var intervaloActualizarGrafico = null;
        if (intervaloActualizarGrafico) {
            clearInterval(intervaloActualizarGrafico);
        }
        function obtenerNuevosDatos(asistencia_id) {
            return new Promise(function (resolve, reject) {
                axios.get('{{ route("estadisticaAsistencia",["id"=>"/"]) }}' + '/' + asistencia_id)
                .then(function (response) {
                    if (typeof response.data === 'string') {
                        try {
                            datos = JSON.parse(response.data);
                            resolve(datos)
                        } catch (error) {
                            console.error('Error al analizar la cadena JSON:', error);
                            reject(error); 
                        }
                    } else if (typeof response.data === 'object') {
                        datos = response.data;
                        resolve(datos);
                    } else {
                        console.error('Tipo de datos desconocido en response.data:', typeof response.data);
                        reject('Tipo de datos desconocido en response.data');
                    }
                })
                .catch(function (error) {
                    console.error('Error al obtener datos:', error);
                    reject(error); 
                });
            });
        }

        var asistenciaId = document.querySelectorAll('.asistenciaId');
        asistenciaId.forEach(function (button) {
            button.addEventListener('click', function () {
                var dataTarget = this.getAttribute('data-target');
                var partes = dataTarget.split("#modal");
                if (partes.length > 1) {
                    var loQueVieneDespuésDeModal = partes[1];
                    var asistencia_id = parseInt(loQueVieneDespuésDeModal);
                }
                obtenerNuevosDatos(asistencia_id);
                axios.get('{{ route("asistenciaId",["id"=>"/"]) }}' + '/' + asistencia_id)
                .then(async function (response) {
                    var modalContent = document.getElementById('modalContent' + asistencia_id);
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
                    var cardContainer = document.createElement('div');
                    cardContainer.classList.add('row', 'g-4');
                    var cardLeft = document.createElement('div');
                    cardLeft.classList.add('col-md-6', 'border', 'rounded-lg', 'border-2', 'shadow', 'my-3');
                    var imageContainer = document.createElement('div');
                    imageContainer.classList.add('text-center', 'p-3', 'bg-light', 'rounded');

                    // Crear la imagen del QR
                    var qrImage = document.createElement('img');
                    qrImage.classList.add('img-fluid');
                    var rutaImagen = "{{ asset('storage/qrs/') }}/" + datos[0].ruta;
                    var imagenPredeterminada = "{{ asset('img/') }}/umaCodigo.svg";
                    qrImage.onerror = function() {
                        qrImage.src = imagenPredeterminada;
                    };

                    qrImage.src = rutaImagen;
                    qrImage.alt = "Imagen QR";
                    imageContainer.appendChild(qrImage);

                    // Crear el cuerpo del card
                    var hr = document.createElement('hr');
                    hr.classList.add('mb-0');
                    var cardBodyLeft = document.createElement('div');
                    cardBodyLeft.classList.add('card-body');
                    var cardBodyLeft = document.createElement('div');
                    cardBodyLeft.classList.add('card-body', 'text-center', 'pt-4');
                    var fechaText = document.createElement('p');
                    fechaText.classList.add('card-text', 'mb-0');
                    var fechaHora = datos[0].fechaAsistencia.split(' ');
                    fechaText.innerHTML = '<strong>Fecha:</strong> ' + fechaHora[0];
                    var horaText = document.createElement('p');
                    horaText.classList.add('card-text', 'mb-0');
                    var hora = fechaHora[1].split(':');
                    var hora12 = (parseInt(hora[0]) % 12) || 12;
                    var amPm = parseInt(hora[0]) >= 12 ? 'PM' : 'AM';
                    horaText.innerHTML = '<strong>Hora:</strong> ' + hora12 + ':' + hora[1] + ' ' + amPm;
                    var nombreText = document.createElement('p');
                    nombreText.classList.add('card-text', 'mb-0');
                    nombreText.innerHTML = '<strong>Creado por: </strong> ' + datos[0].name + ' ' + datos[0].apellido;
                    cardBodyLeft.appendChild(fechaText);
                    cardBodyLeft.appendChild(horaText);
                    cardBodyLeft.appendChild(fechaText);
                    cardBodyLeft.appendChild(nombreText);
                    cardLeft.appendChild(imageContainer);
                    cardLeft.appendChild(hr);
                    cardLeft.appendChild(cardBodyLeft);

                    // Crear el segundo card (derecha)
                    var cardRight = document.createElement('div');
                    cardRight.classList.add('col-md-6', 'border', 'rounded-lg', 'border-2', 'shadow', 'my-3');
                    var cardBodyRight = document.createElement('div');
                    cardBodyRight.classList.add('card-body');
                    // Crear un lienzo para la gráfica
                    var chartCanvas = document.createElement('canvas');
                    cardBodyRight.appendChild(chartCanvas);
                    var ctx = chartCanvas.getContext('2d');
                    var datosAsistencia = {
                        labels: ['Asistentes', 'Ausentes'],
                        datasets: [{
                            data: [0, 0], 
                            backgroundColor: ['#4bc0c0', '#ff6384']
                        }],
                    };
                    myPieChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: datosAsistencia,
                    });

                    cardRight.appendChild(cardBodyRight);
                    cardContainer.appendChild(cardLeft);
                    cardContainer.appendChild(cardRight);
                    modalContent.appendChild(cardContainer);
                    var dataset = myPieChart.data.datasets[0];
                    var valores = dataset.data;
                    try {
                        // Verifica si ya hay un intervalo en ejecución y detenlo
                        if (intervaloActualizarGrafico) {
                            clearInterval(intervaloActualizarGrafico);
                        }
                        
                        // Inicia el nuevo intervalo
                        intervaloActualizarGrafico = setInterval(async function () {
                            const nuevosDatos = await obtenerNuevosDatos(asistencia_id);
                            var calculoA = nuevosDatos[0].inscritoMateria - nuevosDatos[0].estudianteAsistencia;
                            datosAsistencia.datasets[0].data = [nuevosDatos[0].estudianteAsistencia, calculoA];
                            myPieChart.update();
                        }, 1000);
                    } catch (error) {
                        console.error('Error al obtener nuevos datos:', error);
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
            });
        });

        var datas = document.querySelectorAll('.cerrar');
        datas.forEach(function(elements) {
            elements.addEventListener('click', function() {
                var asistencia_id = this.getAttribute('data-id'); 
                var modalContent = document.getElementById('modalContent' + asistencia_id);
                modalContent.innerHTML = '';
                if (myPieChart) {
                    myPieChart.destroy();
                    myPieChart = null;
                }
                if (intervaloActualizarGrafico) {
                    clearInterval(intervaloActualizarGrafico);
                }
            })
        })
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