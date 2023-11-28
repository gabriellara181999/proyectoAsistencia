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

        .modal-header .btn-close{
            display: none;
        }
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
                    <div class="d-grid gap-2 d-md-block ">
                        {{--  --}}
                            @if ($qrCreadoEnSemana)
                                <div class="alert alert-warning border border-warning d-flex d-lg-inline-flex align-self-sm-center justify-content-center" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </svg>
                                    <div>
                                        No puedes crear un nuevo QR esta semana
                                    </div>
                                </div>   
                            @else
                                <form method="POST" action="{{ route('catedraticoCrearAsistencia') }}" enctype="multipart/form-data">
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
                            <table id="example" class="table table-striped-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th>Fecha / Hora</th>
                                        <th class="d-none d-md-table-cell">Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($materiaAsistencia as $materiaAsistencias)
                                        <tr>
                                            <td>{{ $contador=$contador+1 }}</td>
                                            <td>{{ ucfirst(Carbon\Carbon::parse($materiaAsistencias->fechaAsistencia)->isoFormat('dddd D-MMM-YYYY')) }} | {{ \Carbon\Carbon::parse($materiaAsistencias->fechaAsistencia)->format('h:i A') }}</td>
                                            <td class="d-none d-md-table-cell"><span class="{{ $materiaAsistencias->nombreEstado == 'Activo' ? 'badge rounded-pill text-bg-success' : 'badge rounded-pill text-bg-danger' }}">{{ $materiaAsistencias->nombreEstado}}</span></td>
                                            <td>
                                                <a href="#" class="asistenciaId" id="asistenciaId" data-bs-toggle="modal" data-bs-target="#modal{{ $materiaAsistencias->id }}" style="color: inherit;">
                                                    <button class="btn btn-dark rounded mx-1 shadow" title="Detalles">
                                                        <span class="material-symbols-outlined">
                                                            qr_code_scanner
                                                            </span>
                                                    </button>
                                                </a>
                                                <a class="btn btn-success rounded mx-1 shadow" href="{{ route('catedraticoEstadoAlumnoIndex', ['id' => encrypt($materiaAsistencias->id)] ) }}">
                                                <span class="material-symbols-outlined">
                                                    list_alt_add
                                                </span>
                                            </a>
                                            </td>
                                        </tr>
                                        {{-- modal --}}
                                        <div class="modal fade modal-lg" id="modal{{ $materiaAsistencias->id }}"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Asistencias</h1>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 class="text-center" style="position: sticky;">Asistencias</h3>
                                                            <div id="modalContent{{ $materiaAsistencias->id }}"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-dark cerrar" data-id="{{ $materiaAsistencias->id }}" data-bs-dismiss="modal">Cerrar</button>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        var myPieChart;
        var intervaloActualizarGrafico = null;
        if (intervaloActualizarGrafico) {
            clearInterval(intervaloActualizarGrafico);
        }
        function obtenerNuevosDatos(asistencia_id) {
            return new Promise(function (resolve, reject) {
                axios.get('{{ route("catedraticoEstadisticaAsistencia",["id"=>"/"]) }}' + '/' + asistencia_id)
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
                var dataTarget = this.getAttribute('data-bs-target');
                var partes = dataTarget.split("#modal");
                if (partes.length > 1) {
                    var loQueVieneDespuésDeModal = partes[1];
                    var asistencia_id = parseInt(loQueVieneDespuésDeModal);
                }
                obtenerNuevosDatos(asistencia_id);
                axios.get('{{ route("catedraticoAsistenciaIdController",["id"=>"/"]) }}' + '/' + asistencia_id)
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
                    var imagenPredeterminada = "{{ asset('img/') }}/umaCodigo.svg"; // Ruta de la imagen predeterminada

                    qrImage.onerror = function() {
                        // Se ejecutará si la imagen no se puede cargar
                        qrImage.src = imagenPredeterminada; // Cambia la imagen a la predeterminada
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
                    cardBodyLeft.appendChild(fechaText);
                    cardBodyLeft.appendChild(horaText);
                    cardBodyLeft.appendChild(fechaText);
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
                            data: [0, 0], // Datos de ejemplo (reemplaza con tus propios datos)
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
</body>
</html>