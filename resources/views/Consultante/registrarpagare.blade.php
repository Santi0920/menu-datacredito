@extends('layouts.base')

@section('content')


@if (session("correcto"))
  <div>
  <script>
    Swal.fire
      ({
          icon: 'success',
          title: "Exitoso!",
          html: `{!! session('correcto') !!}`,
          confirmButtonColor: '#005E56',


      });
  </script>
  </div>
@endif

@if (session("correcto2"))
  <div>
  <script>
    Swal.fire
      ({
          icon: 'success',
          title: "{!! session('correcto2') !!}",
          confirmButtonColor: '#005E56',


      });
  </script>
  </div>
@endif

@if (session("incorrecto"))
<div>
  <script>
    Swal.fire
      ({
          icon: 'error',
          title: "¡RECHAZADO!",
          html: `{!! session('incorrecto') !!}`,
          confirmButtonColor: '#005E56',

      });
  </script>
  </div>
@endif

@if (session("incorrecto2"))
<div>
  <script>
    Swal.fire
      ({
          icon: 'error',
          title: "{!! session('incorrecto2') !!}",
          confirmButtonColor: '#005E56',

      });
  </script>
  </div>
@endif


@if (session("incorrecto3"))
<div>
  <script>
    Swal.fire
      ({
          icon: 'error',
          title: "¡ERROR!",
          html: `{!! session('incorrecto3') !!}`,
          confirmButtonColor: '#005E56',

      });
  </script>
  </div>
@endif


@if (session("correcto3"))
  <div>
  <script>
    Swal.fire
      ({
          icon: 'success',
          title: "{!! session('correcto3') !!}",
          confirmButtonColor: '#005E56',


      });
  </script>
  </div>
@endif


@error('message')
<div>
<script>
  Swal.fire
    ({
        icon: 'error',
        title: "Error al registrar!\n{{$message}}",
        text: '',
        confirmButtonColor: '#005E56'

    });
</script>
</div>
@enderror

@include('layouts/nav-consultante')

<div class="contenedor2">
  <div class="agregar2">
    <a href="datacredito.php" class="btn btn-primary" style="font-size: 35px;font-family: 'Montserrat', sans-serif; font-weight: bold;" data-bs-toggle="modal" data-bs-target="#exampleModal3">
      <span style="margin-bottom: 30px; margin-top: 20px;">V1</span>
    </a>
  </div>
</div>

<div class="container-fluid row p-4">
    <form action="{{ route('cruddir.createpagare')}}" class="col m-3" method="POST" enctype= "multipart/form-data" id="pagare">
    @csrf
    <h2 class="p-2 text-secondary text-center"><b>Ingresar Pagaré</b></h2>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input3" class="form-label fw-semibold">CUENTA ASOCIADO <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="number" class="form-control " name="CuentaCoop" id="input3" autocomplete="off" required>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input4" class="form-label fw-semibold">CÉDULA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="number" class="form-control " name="Cedula_Persona" id="input4" autocomplete="off" required>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input5" class="form-label fw-semibold">NOMBRE COMPLETO <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="NombreCompleto" id="input5" autocomplete="off" required>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input6" class="form-label fw-semibold">ID PAGARE <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="ID_Pagare" id="input6" autocomplete="off" required>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input7" class="form-label fw-semibold">LÍNEA CRÉDITO <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Linea_Credito" id="input7" autocomplete="off" required>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input8" class="form-label fw-semibold">CAPITAL <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Capital" id="input8" autocomplete="off" required>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input9" class="form-label fw-semibold">NÚMERO DE CUOTAS <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="NoCuotas" id="input9" autocomplete="off" required>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input10" class="form-label fw-semibold">VALOR CUOTA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="ValorCuota" id="input10" autocomplete="off" required>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input11" class="form-label fw-semibold">TASA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Tasa" id="input11" autocomplete="off" required>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input12" class="form-label fw-semibold">FECHA CRÉDITO <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="FechaCredito" id="input12" autocomplete="off" required>
        <p class="formato-ayuda">Ejemplo: <strong>1240130</strong>. 124 - es el año, 01 - es el mes y 30 - es el
            día.</p>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input13" class="form-label fw-semibold">NOMINA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Nomina" id="input13" autocomplete="off" required>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input14" class="form-label fw-semibold">DIRECCIÓN <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Direccion" id="input14" autocomplete="off" required>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input15" class="form-label fw-semibold">TELÉFONO FIJO <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="number" class="form-control " name="TelFijo" id="input15" autocomplete="off" required>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input16" class="form-label fw-semibold">FECHA 1ra CUOTA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Fecha1Cuota" id="input16" autocomplete="off" required>
        <p class="formato-ayuda">Ejemplo: <strong>1240130</strong>. 124 - es el año, 01 - es el mes y 30 - es el
            día.</p>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input17" class="form-label fw-semibold">Fecha ULTIMA CUOTA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="FechaUltimaCuota" id="input17" autocomplete="off" required>
        <p class="formato-ayuda">Ejemplo: <strong>1240130</strong>. 124 - es el año, 01 - es el mes y 30 - es el
            día.</p>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input18" class="form-label fw-semibold">CELULAR <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="number" class="form-control " name="Celular" id="input18" autocomplete="off" required>

      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
          <label for="input19" class="form-label fw-semibold">CORREO <span class="text-danger" style="font-size:20px;">*</span></label>
          <input type="text" class="form-control" name="Correo" id="input19" autocomplete="off" required oninput="formatEmail(this)">
      </div>

      <script>
          function formatEmail(input) {
              // Convertir a minúsculas y reemplazar espacios con arrobas
              input.value = input.value.toLowerCase().replace(/\s/g, '@');
          }
      </script>


      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input20" class="form-label fw-semibold">GENERADOR PAGARE <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="GeneradorPagare" id="input20" autocomplete="off" required>
      </div>


      <div class="text-center">
          <!-- onclick="return confirmar()" -->
          <button onclick="confirmVote(event)" id="agregar" type="submit" class="btn btn-primary fs-4 fw-bold" name="btnregistrar" style="background-color: #005E56;">Registrar</button>
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
          <!-- <th style="width: 77px">FUNCIONES</th> -->
          <th scope="col">SCORE</th>
          <th scope="col">REPORTE</th>
          <th scope="col">ESTADO</th>
          <th scope="col">AUTORIZACIÓN</th>
          <th scope="col">GARANTIA</th>
          <th scope="col">INTERES PROPORCIONAL</th>
          <th scope="col">FECHA ESCANEO</th>
          <th scope="col">1 CUOTA</th>
          <th scope="col">AGENCIA</th>
          <th class="" scope="col">CUENTA</th>
          <th class="" scope="col">CÉDULA</th>
          <th class="" scope="col">NOMBRE</th>
          <th class="" scope="col">ID PAGARE</th>
          <th class="" scope="col">LINEA CRÉDITO</th>
          <th scope="col">CAPITAL</th>
          <th scope="col">NO CUOTAS</th>
          <th scope="col">VALOR CUOTA</th>
          <th scope="col">TASA</th>
          <th scope="col">FECHA CRÉDITO</th>
          <th scope="col">NOMINA</th>
          <th scope="col">DIRECCIÓN</th>
          <th scope="col">FIJO</th>
          <th scope="col">ULTIMA CUOTA</th>
          <th scope="col">CELULAR</th>
          <th scope="col">CORREO</th>
          <th scope="col">GENERADOR PAGARE</th>

        </tr>
      </thead>
      <tbody class="table-group-divider">

      </tbody>
    </table>
    <div id="customTooltip" style="font-weight:bold; display: none; position: absolute; background-color: white; color: #333; border: 1px solid #ddd; border-radius: 8px; padding: 5px; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 300px; text-align: center;">
    <p>NO NECESITA CONSULTA DE DATACRÉDITO
    PORQUE EL CAPITAL ES MENOR A $3'000.000</p>
</div>

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
  "order": [[0, 'desc']],
  "columns": [
    {
        data: 'ID',
        createdCell: function (td, cellData, rowData, row, col) {
            $(td).css({
                'font-weight': 'bold',
                'font-size': '30px'
            });
        }
    },
    {
    data: 'Score',
    createdCell: function (td, cellData, rowData, row, col) {
        $(td).css({
            'font-weight': 'bold',
            'font-size': '30px'
        });

        // Añadir eventos mouseenter y mouseleave
        $(td).hover(function(e) {
            // Mostrar mensaje si el contenido es 'N/A'
            if (cellData === 'N/A') {
                $('#customTooltip').css({
                    display: 'block',
                    left: (e.pageX + 10) + 'px',
                    top: (e.pageY + 10) + 'px'
                });
            }
        }, function() {
            // Ocultar el mensaje cuando el cursor deja la celda
            $('#customTooltip').hide();
        });
    }
},
    {
        data: 'Estado',
        createdCell: function (td, cellData, rowData, row, col) {
            $(td).css({
                'font-weight': 'bold',
                'font-size': '30px'
            });
        }
    },
    {    data: null,
      render: function(data, type, row) {

        if(row.Aprobado == 1){
            var AprobadoButton = '<span class="text-success" style="font-weight: bold; font-size: 30px">A</span>';
        }else if(row.Aprobado == 0){
            var AprobadoButton = '<span class="text-danger" style="font-weight: bold; font-size: 30px">R</span>';
        }else{
            var AprobadoButton = '<span class="text-secondary-emphasis" style="font-weight: bold; font-size: 30px">PENDIENTE</span>';
        }


  return AprobadoButton;

}
  },
  {    data: null,
      render: function(data, type, row) {
        var id = row.ID;
        var url = "{{ route('cruddir.adjuntarautorizacion', ':id') }}";
        var today = new Date().toISOString().split('T')[0];
        url = url.replace(':id', id);

        var html = '';
      if(row.AutorizacionGerente == 0){

        var editButton = `<div class="text-center fw-bold fs-2">N/A</div>`
      }else if(row.AutorizacionGerente==1){
        var editButton = `<div class="text-center fw-bold fs-2">Notificar a Coordinación</div>`
      // var editButton = `<div class="text-center"><a title="Modificar" href="" id="modalLink_${id}" type="submit" class="btn btn-small btn-warning edit-button edit fw-bold fs-1" data-bs-toggle="modal" data-bs-target="#modalEditar_${id}" data-id="${id}" style="margin-right: "><i class="fa-regular fa-file-pdf"></i></a></div>
      //             <div class="modal fade" id="modalEditar_${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      //               <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      //                 <div class="modal-content">


      //                   <div class="">
      //                   <button type="button" class="btn-close p-3" aria-label="Close" data-bs-dismiss="modal"></button>
      //                   <h1 class="modal-title text-center" id="modificar"  style="margin-top: -40px">ADJUNTAR AUTORIZACIÓN</h1>
      //                   </div>
      //                   <hr>
      //                   <div class="modal-body">
      //                     <form action="`+url+`" class="text-center" method="POST" enctype="multipart/form-data" id="formulario">
      //                       @csrf

      //                       <div class="mb-5 mt-3 ms-2 me-2">
      //                         <label for="" id="" class="form-label text-start fs-5" style="margin-left: 0%;">Por favor, adjuntar documento de <strong>Autorización</strong> de <strong>${row.NombreCompleto}</strong> con cuenta <strong>${row.CuentaCoop}</strong> firmado por <strong>Gerencia</strong>.</label>
      //                         <input type="file" class="form-control" name="DocuAutorizacion" id="asd" accept="application/pdf" required>
      //                         <p class="formato-ayuda2">Debe contener el formato: <strong>Autorizacion-(Cédula).pdf</strong></strong></p>
      //                       </div>


      //                       <div class="modal-footer">
      //                         <button type="button" class="btn btn-secondary fs-4" data-bs-dismiss="modal">Cerrar</button>
      //                         <button type="submit" href=""  name="editar" class="btn btn-primary fs-4" style="background-color: #005E56;">Guardar</button>
      //                       </div>
      //                     </form>
      //                   </div>
      //                 </div>
      //               </div>
      //             </div>`;
                }else{
                  var editButton =`<a href="Storage/files/autorizacionpagare/${row.DocuAutorizacion}" target="__blank" style="display: flex; justify-content: center;"><img src="img/pdf.png" style="height: 4.0rem; width: 3.0rem"></a>`
                }
  return editButton;

}
  },
  {
      data: null,
      render: function(data, type, row) {
        var Garantia = '<span style="font-size:25px">'+row.Garantia+'</span>';
        return Garantia;
      }
    },
    {
      data: null,
      render: function(data, type, row) {
        var Interes = '<span style="font-size:25px">'+row.InteresProporcional+'</span>';
        return Interes;
      }
    },
    {
      data: null,
      render: function(data, type, row) {
        var FechaAccion = '<strong style="font-size:25px">'+row.FechaAccion+'</strong>';
        return FechaAccion;
      }
    },
    {
      data: null,
      render: function(data, type, row) {
        var Fecha1Cuota = '<strong style="font-size:25px">'+row.Fecha1Cuota+'</strong>';
        return Fecha1Cuota;
      }
    },
    {data: 'NoAgencia'},
    {data: 'CuentaCoop'},
    {data: 'Cedula_Persona'},
    {data: 'NombreCompleto'},
    {data: 'ID_Pagare'},
    {
      data: null,
      render: function(data, type, row) {
        var NoLC = '<strong>'+row.NoLC+'</strong>';
        var Linea_Credito = row.Linea_Credito;


        return Linea_Credito;
      }
    },
    {data: 'Capital'},
    {data: 'NoCuotas'},
    {data: 'ValorCuota'},
    {data: 'Tasa'},
    {data: 'FechaCredito'},
    {data: 'Nomina'},
    {data: 'Direccion'},
    {data: 'TelFijo'},
    {data: 'FechaUltimaCuota'},
    {data: 'Celular'},
    {data: 'Correo'},
    {data: 'GeneradorPagare'},

  ],


  "lengthMenu": [[10,15], [10,15]],
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
            var newAjaxSource = '{{ route("datatable.consultarpagaredir") }}'; // Adjust the route as needed

            $('#personas').DataTable().ajax.url(newAjaxSource).load();
        });

        $('#btnR').on('click', function() {
            var newAjaxSource = '{{ route("datatabledir.rechazados") }}'; // Adjust the route as needed

            $('#personas').DataTable().ajax.url(newAjaxSource).load();
        });

        $('#btnA').on('click', function() {
            var newAjaxSource = '{{ route("datatabledir.aprobados") }}'; // Adjust the route as needed

            $('#personas').DataTable().ajax.url(newAjaxSource).load();
        });

        // $('#btnFA').on('click', function() {
        //     var newAjaxSource = '{{ route("datatable.pendientes") }}'; // Adjust the route as needed

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





          function activar(){
            var respuesta=confirm("¿Estas seguro que deseas activar este usuario?")
            return respuesta
          }

          function desactivar(){
            var respuesta=confirm("¿Estas seguro que deseas desactivar este usuario?")
            return respuesta
          }

          function eliminar(){
            var respuesta=confirm("¿Estas seguro que deseas eliminar este registro?")
            return respuesta
          }

          function eliminar2(){
            var respuesta=confirm("¿Estas seguro que deseas eliminar definitivamente este registro?")
            return respuesta
          }

          function csesion(){
            var respuesta=confirm("¿Estas seguro que deseas cerrar sesión?")
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
        background-color: #005E56; /* Color Verde */
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
