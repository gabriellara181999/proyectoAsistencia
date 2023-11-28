<table id="{{ $table_id }}" class="hover table-bordered" style="width:100%">
    <thead>
        <tr>
            {{ $columns }}
        </tr>
    </thead>
    <tbody>
        {{ $data }}
    </tbody>
</table>

@section('css')
    <style>
        table.dataTable thead tr {
            background-color: #dc3545ff;
            color: #fff;
        }
        table.dataTable thead tr th{
            border: 1px solid;
            /* border-color: white; */
            border-color: rgb(223, 110, 122);
        }
    </style>
@stop

@section('js')
    <script>
        new DataTable('#{{ $table_id }}', {
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
            responsive: {
                breakpoints: [{
                        name: 'bigdesktop',
                        width: Infinity
                    },
                    {
                        name: 'meddesktop',
                        width: 1480
                    },
                    {
                        name: 'smalldesktop',
                        width: 1280
                    },
                    {
                        name: 'medium',
                        width: 1188
                    },
                    {
                        name: 'tabletl',
                        width: 1024
                    },
                    {
                        name: 'btwtabllandp',
                        width: 848
                    },
                    {
                        name: 'tabletp',
                        width: 768
                    },
                    {
                        name: 'mobilel',
                        width: 480
                    },
                    {
                        name: 'mobilep',
                        width: 320
                    }
                ]
            }
        });
    </script>
@stop
