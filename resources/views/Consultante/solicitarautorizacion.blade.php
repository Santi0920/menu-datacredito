@extends('layouts.base')

@section('content')
    @if (session('correcto'))
        <div>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: "{{ session('correcto') }}",
                    text: '',
                    confirmButtonColor: '#005E56',

                });
            </script>
        </div>
    @endif

    @if (session('incorrecto'))
        <div>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: "{{ session('incorrecto') }}",
                    text: '',
                    confirmButtonColor: '#005E56',
                    timer: 10000

                });
            </script>
        </div>
    @endif

    @error('message')
        <div>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: "Error al registrar!\n{{ $message }}",
                    text: '',
                    confirmButtonColor: '#005E56'

                });
            </script>
        </div>
    @enderror

    @include('layouts/nav-consultante')

    <div class="container-fluid row p-4">
        <form action="{{ route('cruddir.createpagare') }}" class="col m-3" method="POST" enctype= "multipart/form-data"
            id="pagare">
            @csrf
            <h2 class="p-2 text-secondary text-center"><b>Solicitar Autorización</b></h2>

            <div class="mb-3 w-100" title="Este campo es obligatorio" id="id">
                <label for="input1" class="form-label col-form-label-lg fw-semibold">TIPO DE AUTORIZACIÓN <span
                        class="text-danger" style="font-size:20px;">*</span></label>
                <select class="form-select form-select-lg " id="tipo-autorizacion" aria-label=".form-select-lg example">
                    <option selected disabled>Selecciona una opción</option>
                    <option disabled class="fw-bold">---TALENTO HUMANO---</option>
                    @foreach ($user as $autorizacion)
                        @if ($autorizacion->No == 10)
                            <option class="fw-semibold" value="{{ $autorizacion->No . $autorizacion->Letra }}">
                                {{ $autorizacion->No . $autorizacion->Letra }} -
                                {{ $autorizacion->Concepto }}
                            </option>
                        @endif
                    @endforeach
                    <option disabled class="fw-bold">---COORDINACION---</option>
                    @foreach ($user as $autorizacion)
                        @if ($autorizacion->No == 11)
                            <option class="fw-semibold" value="{{ $autorizacion->No . $autorizacion->Letra }}">
                                {{ $autorizacion->No . $autorizacion->Letra }} -
                                {{ $autorizacion->Concepto }}
                            </option>
                        @endif
                    @endforeach
                    <option disabled class="fw-bold">---SISTEMAS---</option>
                    @foreach ($user as $autorizacion)
                        @if ($autorizacion->No == 19)
                            <option class="fw-semibold" value="{{ $autorizacion->No . $autorizacion->Letra }}">
                                {{ $autorizacion->No . $autorizacion->Letra }} -
                                {{ $autorizacion->Concepto }}
                            </option>
                        @endif
                    @endforeach
                    <option disabled class="fw-bold">---JURIDICO ZONA CENTRO---</option>
                    @foreach ($user as $autorizacion)
                        @if ($autorizacion->No == 2150)
                            <option class="fw-semibold" value="{{ $autorizacion->No . $autorizacion->Letra }}">
                                {{ $autorizacion->No . $autorizacion->Letra }} -
                                {{ $autorizacion->Concepto }}
                            </option>
                        @endif
                    @endforeach
                    <option disabled class="fw-bold">---JURIDICO ZONA NORTE---</option>
                    @foreach ($user as $autorizacion)
                        @if ($autorizacion->No == 2250)
                            <option class="fw-semibold" value="{{ $autorizacion->No . $autorizacion->Letra }}">
                                {{ $autorizacion->No . $autorizacion->Letra }} -
                                {{ $autorizacion->Concepto }}
                            </option>
                        @endif
                    @endforeach
                    <option disabled class="fw-bold">---JURIDICO ZONA SUR---</option>
                    @foreach ($user as $autorizacion)
                        @if ($autorizacion->No == 2350)
                            <option class="fw-semibold" value="{{ $autorizacion->No . $autorizacion->Letra }}">
                                {{ $autorizacion->No . $autorizacion->Letra }} -
                                {{ $autorizacion->Concepto }}
                            </option>
                        @endif
                    @endforeach
                    <option disabled class="fw-bold">---TESORERIA---</option>
                    @foreach ($user as $autorizacion)
                        @if ($autorizacion->No == 1500)
                            <option class="fw-semibold" value="{{ $autorizacion->No . $autorizacion->Letra }}">
                                {{ $autorizacion->No . $autorizacion->Letra }} -
                                {{ $autorizacion->Concepto }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>


            <div class="mb-3 w-100" title="Este campo es obligatorio" id="id">
                <label for="input1" class="form-label col-form-label-lg fw-semibold">CÉDULA <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="text" class="form-control form-control-lg" id="input1" autocomplete="off" autofocus
                    required>

            </div>


            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input2" class="form-label col-form-label-lg fw-semibold">DETALLES DE LA AUTORIZACIÓN <span
                        class="text-danger" style="font-size:20px;">*</span></label>
                <textarea type="number" class="form-control form-control-lg" name="NoAgencia" autocomplete="off" required></textarea>

            </div>



            <div class="text-center">
                <!-- onclick="return confirmar()" -->
                <button id="agregar" type="submit" class="btn btn-primary fs-4 fw-bold" name="btnregistrar"
                    style="background-color: #005E56;">SOLICITAR</button>
                <!-- <button onclick="limpiarCampos()" id="botonRegistrar" class="btn btn-primary" name="btnregistrar" style="background-color: #005E56;">Limpiar</button> -->
            </div>

        </form>


        {{-- FECHA --}}
        <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9 col-xxl-9">
            <div class="">
                <form action="" method="post">
                    <div class="" style="margin-top: 8px; margin-right: -14px;">

                        <h2 class="p-3 mb-0 text-secondary text-end"><b><span id="fechaActual"></span></b></h2>
                    </div>
                    <script>
                        function obtenerFechaActual() {
                            const fecha = new Date();
                            const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                            const mes = meses[fecha.getMonth()];
                            const dia = fecha.getDate();
                            const anio = fecha.getFullYear();
                            let horas = fecha.getHours();
                            let amPm = 'AM';

                            // AM/PM
                            if (horas > 12) {
                                horas -= 12;
                                amPm = 'PM';
                            } else if (horas === 0) {
                                horas = 12;
                            }

                            const minutos = fecha.getMinutes();
                            const segundos = fecha.getSeconds();


                            return `${mes} ${dia}, ${anio} - ${horas}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')} ${amPm}`;
                        }


                        function actualizarFechaActual() {
                            const elementoFecha = document.getElementById('fechaActual');
                            elementoFecha.textContent = `${obtenerFechaActual()}`;
                        }


                        setInterval(actualizarFechaActual, 1000);
                    </script>


                </form>
            </div>
            <div class="table-responsive">
                <table id="personas" class="hover table table-striped shadow-lg mt-4 table-bordered table-hover">
                    <thead style="background-color: #005E56;">
                        <tr class="text-white">
                            <th scope="col">#</th>
                            <th scope="col">CEDULA</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                    </tbody>
                </table>
            </div>
        </div>
        <script src="ResourcesAll/dtables/jquery-3.5.1.js"></script>
        <script src="ResourcesAll/dtables/jquerydataTables.js"></script>
        <script src="ResourcesAll/dtables/dataTablesbootstrap5.js"></script>
        <script src="ResourcesAll/dtables/dtable1.min.js"></script>
        <script src="ResourcesAll/dtables/botonesdt.min.js"></script>
        <script src="ResourcesAll/dtables/estilobotondt.min.js"></script>
        <script src="ResourcesAll/dtables/botonimprimir.min.js"></script>
        <script src="ResourcesAll/dtables/imprimir2.min.js"></script>
        <script>
            var table = $('#personas').DataTable({
                "ajax": "{{ route('datatable.consultarpagaredir') }}",
                "order": [
                    [0, 'desc']
                ],
                "columns": [{
                        data: 'ID',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '30px'
                            });
                        }
                    },
                    {
                        data: 'Score',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '30px'
                            });
                        }
                    },
                ],


                "lengthMenu": [
                    [5],
                    [5]
                ],
                "drawCallback": function(settings) {
                    var api = this.api();
                    var noRecordsMessage = api.table().container().querySelector('.dataTables_empty');
                    if (noRecordsMessage) {
                        noRecordsMessage.style.textAlign = 'left';
                        noRecordsMessage.style.fontSize = '40px';
                        noRecordsMessage.style.fontWeight = 'bold';
                    }
                },
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "<span style='font-size: 40px; text-align: left;'>No existen datos!</span>",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                    "search": "<span style='font-size: 20px; font-weight: bold'>Buscar:</span>",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },


                "initComplete": function(settings, json) {
                    var buttonsHtml = '<div class="custom-buttons">' +
                        '<button id="btnT" class="custom-btn" title="LISTAR TODOS LOS REGISTROS">TODO</button>' +
                        '<button id="btnR" class="custom-btn" title="RECHAZADOS">R</button>' +
                        '<button id="btnA" class="custom-btn" title="APROBADOS">A</button>' +
                        //   '<button id="btnFA" class="custom-btn" title="FALTA POR APROBAR">FA</button>' +
                        '</div>';
                    $(buttonsHtml).prependTo('.dataTables_filter');
                    $('#btnT').on('click', function() {
                        var newAjaxSource =
                            '{{ route('datatable.consultarpagaredir') }}'; // Adjust the route as needed

                        $('#personas').DataTable().ajax.url(newAjaxSource).load();
                    });

                    $('#btnR').on('click', function() {
                        var newAjaxSource =
                            '{{ route('datatabledir.rechazados') }}'; // Adjust the route as needed

                        $('#personas').DataTable().ajax.url(newAjaxSource).load();
                    });

                    $('#btnA').on('click', function() {
                        var newAjaxSource =
                            '{{ route('datatabledir.aprobados') }}'; // Adjust the route as needed

                        $('#personas').DataTable().ajax.url(newAjaxSource).load();
                    });

                    // $('#btnFA').on('click', function() {
                    //     var newAjaxSource = '{{ route('datatable.pendientes') }}'; // Adjust the route as needed

                    //     $('#personas').DataTable().ajax.url(newAjaxSource).load();
                    // });

                },
                //   responsive: "true",
                //   dom: 'Bfrtilp',
                //   buttons:[
                // {
                // 	extend:    'excelHtml5',
                // 	text:      '<i class="fas fa-file-excel"></i> ',
                // 	titleAttr: 'Exportar a Excel',
                // 	className: 'btn btn-success btn-lg'
                // },
                // {
                // 	extend:    'print',
                // 	text:      '<i class="fa fa-print"></i> ',
                // 	titleAttr: 'Imprimir',
                // 	className: 'btn btn-info btn-lg'
                // }
                // ]
            });





            function activar() {
                var respuesta = confirm("¿Estas seguro que deseas activar este usuario?")
                return respuesta
            }

            function desactivar() {
                var respuesta = confirm("¿Estas seguro que deseas desactivar este usuario?")
                return respuesta
            }

            function eliminar() {
                var respuesta = confirm("¿Estas seguro que deseas eliminar este registro?")
                return respuesta
            }

            function eliminar2() {
                var respuesta = confirm("¿Estas seguro que deseas eliminar definitivamente este registro?")
                return respuesta
            }

            function csesion() {
                var respuesta = confirm("¿Estas seguro que deseas cerrar sesión?")
                return respuesta
            }
        </script>


    </div>

    </div>
    <style>
        .custom-buttons {
            display: inline-block;
            margin-right: 10px;
        }

        .custom-btn {
            background-color: #005E56;
            /* Color Verde */
            font-weight: bold;
            font-size: 20px;
            color: white;
            padding: 5px 10px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .custom-btn:hover {
            background-color: #45a049;
        }
    </style>
    </div>
@endsection
