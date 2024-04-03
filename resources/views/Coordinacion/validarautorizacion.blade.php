@extends('layouts.base')

@section('content')
    @if (session('correcto'))
        <div>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: "¡Correcto!",
                    html: "{!! session('correcto') !!}",
                    confirmButtonColor: '#005E56'
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

    @include('layouts/nav-coordinacion')

        {{-- FECHA --}}
        <div class="col-11" style="margin-left:3.5%">
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
                "ajax": "{{ route('datacoor.solicitudes') }}",
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
                            var Codigo = `<span class='badge bg-secondary fw-bold'>${row.CodigoAutorizacion}</span> - ${row.Concepto}</span>`

                            return Codigo
                        },
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': '500',
                                'font-size': '20px',
                                'text-align': 'justify'
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
                        data: 'Estado',
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


                                var Detalle = `<button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                        <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                    </svg>
                                    </button>

                                    <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal_${row.IDAutorizacion}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" color="black" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                        </svg> Ver detallado
                                        </a>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" onclick="">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" color="blue"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg> Editar
                                        </button>
                                    </li></ul>`

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
                                                            <td id="estado" style="text-align: center">${row.Detalle}</</td>
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


                // "initComplete": function(settings, json) {
                //     var buttonsHtml = '<div class="custom-buttons">' +
                //         '<button id="btnT" class="custom-btn" title="LISTAR TODOS LOS REGISTROS">TODO</button>' +
                //         '<button id="btnR" class="custom-btn" title="RECHAZADOS">R</button>' +
                //         '<button id="btnA" class="custom-btn" title="APROBADOS">A</button>' +
                //         //   '<button id="btnFA" class="custom-btn" title="FALTA POR APROBAR">FA</button>' +
                //         '</div>';
                //     $(buttonsHtml).prependTo('.dataTables_filter');
                //     $('#btnT').on('click', function() {
                //         var newAjaxSource =
                //             '{{ route('datatable.consultarpagaredir') }}'; // Adjust the route as needed

                //         $('#personas').DataTable().ajax.url(newAjaxSource).load();
                //     });

                //     $('#btnR').on('click', function() {
                //         var newAjaxSource =
                //             '{{ route('datatabledir.rechazados') }}'; // Adjust the route as needed

                //         $('#personas').DataTable().ajax.url(newAjaxSource).load();
                //     });

                //     $('#btnA').on('click', function() {
                //         var newAjaxSource =
                //             '{{ route('datatabledir.aprobados') }}'; // Adjust the route as needed

                //         $('#personas').DataTable().ajax.url(newAjaxSource).load();
                //     });

                    // $('#btnFA').on('click', function() {
                    //     var newAjaxSource = '{{ route('datatable.pendientes') }}'; // Adjust the route as needed

                    //     $('#personas').DataTable().ajax.url(newAjaxSource).load();
                    // });

                //},
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
