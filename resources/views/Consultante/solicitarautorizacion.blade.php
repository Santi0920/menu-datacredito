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
        <form action="{{ route('solicitar.autorizacion') }}" class="col m-3" method="POST" enctype= "multipart/form-data"
            id="pagare">
            @csrf
            <h2 class="p-2 text-secondary text-center"><b>Solicitar Autorización</b></h2>

            <div class="mb-3 w-100" title="Este campo es obligatorio" id="id">
                <label for="input1" class="form-label col-form-label-lg fw-semibold">TIPO DE AUTORIZACIÓN <span
                        class="text-danger" style="font-size:20px;">*</span></label>
                <select class="form-select form-select-lg " name="tautorizacion" required>
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
                <input type="text" name="cedula" class="form-control form-control-lg" id="input1" autocomplete="off" autofocus
                    required>

            </div>


            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input2" class="form-label col-form-label-lg fw-semibold">DETALLES DE LA AUTORIZACIÓN <span
                        class="text-danger" style="font-size:20px;">*</span></label>
                <textarea type="number" name="detalle" class="form-control form-control-lg" autocomplete="off" required></textarea>

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
                <table id="personas" class="hover table table-striped shadow-lg mt-4 table-hover table-bordered">
                    <thead style="background-color: #005E56;">
                        <tr class="text-white">
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center" style="width: 15%">CÉDULA</th>
                            <th scope="col" class="text-center" style="width: 35%">CONCEPTO</th>
                            <th scope="col" class="text-center">FECHA SOLICITUD</th>
                            <th scope="col" class="text-center" style="width: 13%">ESTADO</th>
                            <th scope="col" class="text-center" style="width: 13%">DETALLE</th>
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
                "ajax": "{{ route('data.solicitudes') }}",
                "order": [
                    [0, 'desc']
                ],
                "ordering": false,
                "columns": [{
                        data: 'IDAutorizacion',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': '500',
                                'font-size': '20px',
                                'text-align': 'center'
                            });
                        }
                    },
                    {
                        data: 'Cedula',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': '500',
                                'font-size': '20px',
                                'text-align': 'center'
                            });
                        }
                    },

                    {
                        data: 'CodigoAutorizacion',
                        render: function(data, type, row) {
                            var Codigo = `<span>${row.CodigoAutorizacion} - ${row.Concepto}</span>`

                            return Codigo
                        },
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': '500',
                                'font-size': '20px',
                                'text-align': 'center'
                            });
                        }
                    },

                    {
                        data: 'Fecha',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': '500',
                                'font-size': '20px',
                                'text-align': 'center'
                            });
                        }
                    },
                    {
                        data: 'Fecha',
                        render: function(data, type, row) {
                                // Supongo que deseas mostrar el ID, no un botón de Aprobado, por lo que he cambiado el nombre de la variable a 'IDLabel'
                                if(row.Estado == 0){
                                    var Estado = '<div class="btn btn-danger shadow" style="padding: 0.4rem 1.7rem; border-radius: 10%;font-weight: 600;font-size: 14px;">ANULADO</div>';
                                }else if(row.Estado == 1){
                                    var Estado = `<div class="btn btn-success shadow" style="padding: 0.4rem 1.4rem; border-radius: 10%;font-weight: 600;font-size: 14px;"><label style="margin-bottom: 0px;">

                                    APROBADO</label></div>`
                                }else if(row.Estado == 2){
                                    var Estado = '<div class="btn btn-info shadow" style="padding: 0.4rem 1.4rem; border-radius: 10%;font-weight: 600;font-size: 14px;"><label style="margin-bottom: 0px;">EN TRAMITE</div>'
                                }else if(row.Estado == 3){
                                    var Estado = '<div class="btn btn-primary shadow" style="padding: 0.4rem 1.4rem; border-radius: 10%;font-weight: 600;font-size: 14px;"><label style="margin-bottom: 0px;">CORREGIR</div>'
                                }

                                return Estado;
                        },
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': '500',
                                'font-size': '20px',
                                'text-align': 'center'
                            });
                        }
                    },
                    {
                            data: 'Fecha',
                            render: function(data, type, row) {

                                //para traer por quien fue calidado
                                if (row.Validacion == 1){
                                    var validadopor = `<th scope="row">VALIDADO POR:</th>
                                                            <td id="aprobado_por" class="fw-bold text-primary">${row.ValidadoPor}</td>
                                                        </tr>`
                                }else{
                                    var validadopor = `<th scope="row">VALIDADO POR:</th>
                                                            <td id="aprobado_por" class="fw-bold text-dark">Pendiente...</td>
                                                        </tr>`
                                }


                                if (row.CodigoAutorizacion == '11D'){
                                    var cuenta = `<th scope="row">CUENTA:</th>
                                                            <td id="aprobado_por" class="text-dark">${row.CuentaAsociada}</td>
                                                        </tr>`
                                }else{
                                    var cuenta = ``
                                }

                                //para traer el score en badge
                                if(row.Score == 'S/E'){
                                    //SIN EXPERIENCIA
                                    var score = `<div class="btn btn-warning" title="sin experiencia" style="padding: 0.3rem 1.3rem; border-radius: 10%;font-weight: 600;font-size: 15px;"><label style="margin-bottom: 0px;">${row.Score}</label></div>`
                                }else if (row.Score >= 650) {
                                    //NORMAL
                                    var score = `<div class="btn btn-success" style="padding: 0.3rem 1.3rem; border-radius: 10%;font-weight: 600;font-size: 17px;"><label style="margin-bottom: 0px;">${row.Score}</label></div>`
                                }else {
                                    //BAJO
                                    var score = `<div class="btn btn-danger" style="padding: 0.3rem 1.3rem; border-radius: 10%;font-weight: 600;font-size: 15px;"><label style="margin-bottom: 0px;">${row.Score}</label></div>`
                                }


                                var Detalle = '<td style="font-weight: 700;">' +
                                    `<a class="btn btn-secondary fw-bold" href="#" onclick="" style="padding: 0.4rem 1.4rem; border-radius: 10%; background-color: #2866a5;font-size: 14px;" data-bs-toggle="modal" data-bs-target="#exampleModal_${row.IDAutorizacion}">` +
                                            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">' +
                                            '<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>' +
                                            '<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>' +
                                            '</svg> VER' +
                                            '</a>' +
                                            '</td>';

                                var modal = `        {{-- MODAL --}}
                                            <div class="modal fade bd-example-modal-lg" id="exampleModal_${row.IDAutorizacion}" tabindex="-1" role="dialog" aria-labelledby="permisoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" style="max-width: 700px;">
                                                    <div class="modal-content" style="padding: 2% 5% 5% 5%">
                                                        <div class="modal-header text-center">
                                                            <h6 class="modal-title" id="exampleModalLongTitle" style="color: #005E56;font-weight: 700;font-size: 22px">DETALLE DE LA AUTORIZACIÓN</h6>
                                                            <button type="button" class="btn-close fs-5" data-bs-dismiss="modal" aria-label="Close" style="outline: none; border: none; font-size:18px">
                                                            </button>
                                                        </div>

                                                        <div class="d-flex position-relative" style="max-height: 1000px; overflow-y: auto;">
                                                            <div style="margin-top: 4%;width: 100%;">
                                                                <table class="table table-bordered" style="color: #111 !important; font-size: 17px;">
                                                                    <tbody>
                                                            <tr>
                                                            <th scope="row" style="width: 50%;">CONSECUTIVO:</th>
                                                            <td id="consecutivo">${row.IDAutorizacion}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">AGENCIA:</th>
                                                                <td id="tipo">${row.NomAgencia}</td>
                                                            </tr>
                                                            <tr>
                                                            <th scope="row">CODIGO:</th>
                                                            <td id="tipo">${row.CodigoAutorizacion}</td>
                                                            </tr>
                                                            <tr>
                                                            <th scope="row">CONCEPTO:</th>
                                                            <td id="motivo">${row.Concepto}</td>
                                                            </tr>
                                                            <tr>
                                                            <th scope="row">FECHA DE LA SOLICITUD:</th>
                                                            <td id="fe_ho_in">${row.Fecha}</td>
                                                            </tr>
                                                            <tr>
                                                            <th scope="row">CÉDULA</th>
                                                            <td id="fe_ho_fi">${row.Cedula}</td>
                                                            </tr>
                                                            <tr>
                                                            <th scope="row">NOMBRE:</th>
                                                            <td id="fe_ho_so">${row.Nombre} ${row.Apellidos}</</td>
                                                            </tr>
                                                            `+cuenta+`
                                                            <tr>
                                                            <th scope="row">SCORE:</th>
                                                            <td id="observacion">`+score+`</td>
                                                            </tr>
                                                            <tr>
                                                            <th scope="row">DETALLE:</th>
                                                            <td id="estado" style="text-align: justify">${row.Detalle}</</td>
                                                            </tr>
                                                            <tr>
                                                            `+validadopor+`

                                                        </tbody>
                                                        </table>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            </div>`;
                                return Detalle + modal;
                            },
                            createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'text-align': 'center'
                            });
                        }
                    }
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
            .badge {
            display: inline-block;
            padding: 5px 10px;
            font-size: 20px;
            font-weight: 500;
            color: white;
            background-color: #28a745; /* Verde de Bootstrap para éxito */
            border-radius: 10px; /* Ajusta según lo que prefieras */
            transition: background-color 0.3s ease;
            }

            .badge:hover {
            background-color: #218838; /* Cambia el tono de verde al pasar el mouse */
            cursor: pointer; /* Cambia el cursor al pasar el mouse */
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
