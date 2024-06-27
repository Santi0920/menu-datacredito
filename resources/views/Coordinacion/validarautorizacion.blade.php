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
            <div class="table-responsive mb-5">
                <table id="personas" class="hover table table-striped shadow-lg mt-4 table-hover table-bordered">
                    <thead style="background-color: #005E56;">
                        <tr class="text-white">
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center" style="width: 15%">CÉDULA</th>
                            <th scope="col" class="text-center" style="width: 30%">CONCEPTO</th>
                            <th scope="col" class="text-center">FECHA SOLICITUD</th>
                            <th scope="col" class="text-center" style="width: 17%">ESTADO</th>
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
                scrollY: 420,
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
                                    REMITIDO A GERENCIA</label></div>`
                                }else if(row.Estado == 2){
                                    var Estado = '<div class="btn btn-warning shadow" style="padding: 0.4rem 1.4rem; border-radius: 10%;font-weight: 600;font-size: 14px;"><label style="margin-bottom: 0px;" class="blink">EN TRAMITE</div>'
                                }else if(row.Estado == 3){
                                    var Estado = '<div class="btn btn-primary shadow" style="padding: 0.4rem 1.6rem; border-radius: 10%;font-weight: 600;font-size: 14px;"><label style="margin-bottom: 0px;">CORREGIR</div>'
                                }else{
                                    var Estado = '<div class="btn btn-secondary shadow" style="padding: 0.4rem 1.6rem; border-radius: 10%;font-weight: 600;font-size: 14px;"><label style="margin-bottom: 0px;">PENDIENTE</div>'
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
                            data: 'Detalle',
                            render: function(data, type, row) {

                                //para traer por quien LO SOLICITÓ
                                if (row.Solicitud == 1){
                                    var solicitadopor = `<th scope="row">SOLICITADO POR:</th>
                                                            <td id="aprobado_por" class="fw-bold text-primary">${row.SolicitadoPor}</td>
                                                        </tr>`
                                }else{
                                    var solicitadopor = `<th scope="row">SOLICITADO POR:</th>
                                                            <td id="aprobado_por" class="fw-bold text-dark">Pendiente...</td>
                                                        </tr>`
                                }

                                var id = row.IDAutorizacion; // Obtener el ID de la fila
                                var url = "{{ route('updatecoor.autorizacion', ':id') }}";
                                url = url.replace(':id', id);


                                //TRAE LA CUENTA SI ES 11D QUE ES AUTORIZACION POR SCORE BAJO CREDITO
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

                                if(row.Estado == 0){
                                    var RadioEstado = `
                                    <label class="label">
                                        <input value="0" type="radio" name="Estado" id="Estado" checked>
                                        <span>ANULADO</span>
                                    </label>

                                    <label class="label" >
                                        <input value="1" type="radio" name="Estado" id="Estado">
                                        <span>APROBADO</span>
                                    </label>
                                    <label class="label">
                                        <input value="2" type="radio" name="Estado" id="Estado" >
                                        <span>EN TRAMITE</span>
                                    </label>
                                    <label class="label" >
                                        <input value="3" type="radio" name="Estado" id="Estado">
                                        <span>CORREGIR</span>
                                    </label>
                                    `
                                }else if(row.Estado == 1){
                                    var RadioEstado = `
                                    <label class="label">
                                        <input value="0" type="radio" name="Estado" id="Estado" >
                                        <span>ANULADO</span>
                                    </label>

                                    <label class="label" >
                                        <input value="1" type="radio" name="Estado" id="Estado" checked>
                                        <span>APROBADO</span>
                                    </label>
                                    <label class="label">
                                        <input value="2" type="radio" name="Estado" id="Estado" >
                                        <span>EN TRAMITE</span>
                                    </label>
                                    <label class="label" >
                                        <input value="3" type="radio" name="Estado" id="Estado">
                                        <span>CORREGIR</span>
                                    </label>
                                    `
                                }else if(row.Estado == 2){
                                    var RadioEstado = `
                                    <label class="label">
                                        <input value="0" type="radio" name="Estado" id="Estado">
                                        <span>ANULADO</span>
                                    </label>

                                    <label class="label" >
                                        <input value="1" type="radio" name="Estado" id="Estado">
                                        <span>APROBADO</span>
                                    </label>
                                    <label class="label">
                                        <input value="2" type="radio" name="Estado" id="Estado" checked>
                                        <span>EN TRAMITE</span>
                                    </label>
                                    <label class="label" >
                                        <input value="3" type="radio" name="Estado" id="Estado">
                                        <span>CORREGIR</span>
                                    </label>
                                    `
                                }else if(row.Estado == 3){
                                    var RadioEstado = `
                                    <label class="label">
                                        <input value="0" type="radio" name="Estado" id="Estado" >
                                        <span>ANULADO</span>
                                    </label>

                                    <label class="label" >
                                        <input value="1" type="radio" name="Estado" id="Estado">
                                        <span>APROBADO</span>
                                    </label>
                                    <label class="label">
                                        <input value="2" type="radio" name="Estado" id="Estado" >
                                        <span>EN TRAMITE</span>
                                    </label>
                                    <label class="label" >
                                        <input value="3" type="radio" name="Estado" id="Estado" checked>
                                        <span>CORREGIR</span>
                                    </label>
                                    `
                                }

                                if (row.CodigoAutorizacion == '11A' || row.CodigoAutorizacion == '11D'){
                                    var DocumentoSoporte = `
                                    <tr>
                                        <th scope="row">SOPORTE:</th>
                                        <td id="tipo"><a href="Storage/files/soporteautorizaciones/${row.DocumentoSoporte}" target="__blank"><img src="img/pdf.png" style="height: 2.5rem"></a></td>
                                    </tr>
                                    `
                                }else{
                                    var DocumentoSoporte = ``
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
                                    </li></ul>`


                                var modal = `        {{-- MODAL --}}
                                            <div class="modal fade bd-example-modal-lg" id="exampleModal_${row.IDAutorizacion}" data-id="${row.IDAutorizacion}" tabindex="-1" role="dialog" aria-labelledby="permisoModalLabel" aria-hidden="true">
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
                                                                        <td id="estado" style="text-align: center">${row.Detalle}</td>
                                                                        </tr>
                                                                        `+DocumentoSoporte+`
                                                                        `+solicitadopor+`
                                                                        <th scope="row">CAMBIAR ESTADO:<br><br><br><br>OBSERVACIONES:</th>
                                                                        <td id="estado" style="text-align: center">
                                                                            <form enctype="multipart/form-data" id="formEditarAutorizacion${row.IDAutorizacion}" data-id="${row.IDAutorizacion}">
                                                                                @csrf
                                                                                `+RadioEstado+`
                                                                                <input class="input text-center" name="Observaciones" id="Observaciones" type="text" value="${row.Observaciones}"></input>
                                                                            </form>
                                                                        </td>
                                                                    </tbody>
                                                                </table>
                                                                <div class="text-center">
                                                                        <button id="boton${row.IDAutorizacion}" type="button" class="btn btn-primary fs-5 fw-bold" name="btnregistrar" onclick="formEditarAutorizacion(${row.IDAutorizacion}, event)"
                                                                        style="background-color: #005E56;">GUARDAR</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`;
                                return Detalle + modal;
                            },
                            orderable:false,
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
                    "zeroRecords": "<span style='font-size: 40px; text-align: left;'>No existen Autorizaciones Disponibles!</span>",
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


            function csesion() {
                var respuesta = confirm("¿Estas seguro que deseas cerrar sesión?")
                return respuesta
            }
        </script>
        <script>
                function formEditarAutorizacion(id, event) {

                    var form = $("#formEditarAutorizacion" + id);

                    // Verificar si el formulario ya ha sido enviado
                    if (form.data('submitted')) {
                        // Si el formulario ya ha sido enviado, no hacer nada
                        return;
                    }

                    // Marcar el formulario como enviado
                    form.data('submitted', true);

                    var formDataArray = form.serializeArray();

                    // Almacenar los valores en variables
                    var estado, observaciones;

                    // Recorrer el array de objetos y asignar valores a las variables según el nombre del campo
                    formDataArray.forEach(function(input) {
                        if (input.name === "Estado") {
                            estado = input.value;
                        } else if (input.name === "Observaciones") {
                            observaciones = input.value;
                            event.preventDefault();
                        }
                    });
                    console.log(estado+' ' + observaciones);

                    // Realizar la solicitud AJAX para actualizar la autorización
                    $.ajax({
                        url: "{{ route('updatecoor.autorizacion', ['id' => ':id']) }}".replace(':id', id),
                        type: "POST",
                        data: {
                            Observaciones: observaciones,
                            Estado: estado,
                            _token: $('input[name="_token"]').val()
                        },
                        success: function(response) {
                            if (response) {
                                $(`#exampleModal_${id}`).modal('hide');
                                console.log('¡Éxito!');
                                $('#personas').DataTable().ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: "¡ACTUALIZADO!",
                                    html: "<span class='fw-semibold'>Se actualizó correctamente la autorización No. <span class='badge bg-primary fw-bold'>" + id + "</span></span>",
                                    confirmButtonColor: '#005E56'
                                });
                            }
                        },
                        error: function(error) {
                            console.log('Error');
                        }
                    });
                }



                $(document).on('keypress', 'input[name="Observaciones"]', function(e) {
                // Verificar si la tecla presionada es Enter (código 13)
                if (e.which == 13) {
                    e.preventDefault(); // Evitar el comportamiento predeterminado de presionar Enter (recargar la página)
                    var id = $(this).closest('form').data('id'); // Obtener el ID de la autorización
                    formEditarAutorizacion(id, e); // Llamar a la función para manejar la actualización de la autorización
                }
            });

        </script>

    </div>

    </div>
    <style>
.label {
  cursor: pointer;
  font-weight: 500;
  position: relative;
  overflow: hidden;
  margin-bottom: 0em;
  font-size: 15px
}

.label input {
  position: absolute;
  left: -9999px;
}
.label input:checked + span {
  background-color: #005E56;
  color: white;
}
.label input:checked + span:before {
  box-shadow: inset 0 0 0 0.4375em #003833;
}
.label span {
  display: flex;
  align-items: center;
  padding: 0.375em 0.75em 0.375em 0.375em;
  border-radius: 99em;
  transition: 0.25s ease;
  color: #005E56;
}
.label span:hover {
  background-color: #d6d6e5;
}
.label span:before {
  display: flex;
  flex-shrink: 0;
  content: "";
  background-color: #fff;
  width: 1.5em;
  height: 1.5em;
  border-radius: 50%;
  margin-right: 0.375em;
  transition: 0.25s ease;
  box-shadow: inset 0 0 0 0.125em #003833;
}

.input {
  width: 100%;
  height: 52px;
  padding: 12px;
  border-radius: 12px;
  border: 1.5px solid lightgrey;
  outline: none;
  transition: all 0.3s cubic-bezier(0.19, 1, 0.22, 1);
  box-shadow: 0px 0px 20px -18px;
}

.input:hover {
  border: 2px solid lightgrey;
  box-shadow: 0px 0px 20px -17px;
}

.input:active {
  transform: scale(0.95);
}

.input:focus {
  border: 2px solid grey;
}


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
