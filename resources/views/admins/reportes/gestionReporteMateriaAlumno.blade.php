@extends('layouts.app_admin')

@section('title', 'Alumnos / Reportes / Catedratico / Materias | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Reporte de Materia por Alumno </h1>
@stop

@section('content_body')
    <br>
    <div class="col-lg-12">
        <div class="table-responsive">
            <table id="example" class="table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th>Nombre</th>
                        <th class="d-none d-md-table-cell">Fecha</th>
                        <th class="d-none d-md-table-cell">N° Estudiante</th>
                        <th class="d-none d-md-table-cell">Ciclo</th>
                        <th class="d-none d-md-table-cell">Asistencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estado as $estados)
                        <tr>
                            <td >{{ $contador=$contador+1 }}</td>
                            <td>{{ $estados->name }} {{ $estados->apellido }}</td>
                            <td class="d-none d-md-table-cell">{{ $estados->fechaAsistencia}}</td>
                            <td class="d-none d-md-table-cell">{{ $estados->numeroEstudiante }}</td>
                            <td class="d-none d-md-table-cell">{{ $estados->nombreCiclo }}</td>
                            <td class="d-none d-md-table-cell">{{ $estados->nombreEstadoAlumno }}</td>
                    @endforeach
                
                </tbody>
            </table>
        </div>
    </div>
@stop


@section('css')
    <link href='https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
    <link href='https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'>

    <style>
            table.dataTable thead tr {
                background-color: #dc3545;
                color: white;
            }

            .table-inline {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px; /* Ajusta el margen inferior según sea necesario */
            margin-top: 15px;

        }

        .table-row {
            display: table-row;
        }

        .table-cell {
            display: table-cell;
            padding: 5px;
            width: 25%;
        }

        .address-container {
            text-align: center;
            margin-bottom: 10px; /* Ajusta el margen inferior según sea necesario */
            margin-top: 15px;
        }

        .address {
            display: inline-block;
            text-align: center;
            padding: 5px;

        }
        div.dt-buttons > .dt-button,
        div.dt-buttons > div.dt-button-split .dt-button {
            position: relative;
            display: inline-block;
            box-sizing: border-box;
            margin-left: 0.167em;
            margin-right: 0.167em;
            margin-bottom: 0.333em;
            padding: 0.5em 1em;
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-radius: 4px; /* Aumentado el radio de borde para un aspecto más moderno */
            cursor: pointer;
            font-size: 1em; /* Aumentado el tamaño de fuente */
            line-height: 1.6em;
            color: #fff; /* Cambiado el color del texto a blanco */
            white-space: nowrap;
            overflow: hidden;
            background-color: #3498db; /* Cambiado el color de fondo a un tono de azul */
            background: linear-gradient(to bottom, #111 0%, #111 100%);
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            text-decoration: none;
            outline: none;
            text-overflow: ellipsis;
            transition: background-color 0.3s; /* Añadida una transición suave para el cambio de color de fondo */
        }
        div#example_length{
            margin-left: 12px !important;
        }
        div.dt-buttons > .dt-button:hover,
        div.dt-buttons > div.dt-button-split .dt-button:hover {
            background-color: #dc3545 !important; /* Cambiado el color de fondo al pasar el ratón por encima */
        }

    </style>
@stop

@section('js')
    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <!-- Datatable JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function(){
            var materia = {!! json_encode($materia) !!};
            var fecha = {!! json_encode($fecha) !!};
            var empDataTable  = $('#example').DataTable({
                order: [],
                dom: 'Blfrtip',
                language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 de 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':not(.acciones)' 
                        },
                        title: function () {
                            // Obtener la fecha actual

                            // Retornar el título con el formato deseado
                            return 'Reporte de la Materia\n\n' + materia[0].nombreMateria+'\n\n por Alumnos';
                        },
                        text: 'Exportar PDF',
                        customize: function (win) {
                            var header = $('<div style="display: flow; justify-content:center ; align-items: center; margin-bottom:20px"></div>');
                            header.append(`
                            <p style="display:flex;justify-content:end; font-size: 1rem;">Fecha del reporte: ` + fecha+`</p>
                                <div style="display: flex; align-items: center;">
                                    <img src="{{asset('img/uma.png')}}" style="max-width: 120px; margin-top: 10px; margin-left:0px;">
                                    <h1 style="margin-left: 60px; font-size:3.5rem;">Universidad Modular Abierta</h1>
                                </div>
                            `);
                            // Agregar el encabezado al documento antes del contenido existente
                            $(win.document.body).prepend(header);
                            var style = `
                                <style>
                                    @media print {
                                        th {
                                            background: red;
                                            color: #111;
                                        }
                                        .acciones {
                                        display: none; 
                                    }
                                        h1 {
                                            font-size: 20px;
                                            font-weight:bold;
                                            text-align: center;
                                        }
                                    }
                                </style>
                            `;
                            $(win.document.head).append(style);

                            var footer = '<div style="position: absolute; bottom: 0; text-align: center; width: 100%;"><span>Todos los Derechos Reservados</span></div>';
                            $(win.document.body).append(footer);

                            // Customize the title font size for printing
                            /* $(win.document.head).append('<style> @media print {table tr th { background-color: #dc3545;color:#fff;} h1 { font-size: 30px; text-align:center; } } </style>'); */
                        },
                    } 
                ]
            });
        });
    </script>
@stop