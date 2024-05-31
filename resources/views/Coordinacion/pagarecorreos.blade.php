@extends('layouts.base')

@section('content')


@if (session("correcto"))
  <div>
  <script>
    Swal.fire
      ({
          icon: 'success',
          title: "{{session('correcto')}}",
          text: '',
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
          title: "{{session('correcto')}}",
          text: '',
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
          title: "{{session('incorrecto')}}",
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

@include('layouts/nav-coordinacion')
<style>
  .formato-ayuda {
    color: gray;
    font-style:inherit;
  }
  </style>

    </form>
    <br>
    {{-- FECHA --}}
    <div class="col-11" style="margin-left:3.5%">
      <div class="">
        <form action="" method="post">
        <div class="" style="margin-top: 0px; margin-right: -14px;">

      </b></h2>
    </div>
    <h2 class="p-1 mb-3 text-secondary text-start"><b>Registros Pagare - <span class="text-end" id="fechaActual"></b></span></h2>
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
      <div style="overflow: auto;" class="">
        <table id="personas" class="hover table table-responsive table-striped shadow-lg mt-2 table-bordered table-hover">
          <thead class="" style="background-color: #005E56;">
            <tr class="text-white">
            <th scope="col">#</th>
          <th scope="col">SCORE</th>
          <th scope="col">ESTADO</th>
          <th scope="col">APROBADO</th>
          <th scope="col">RAZON</th>
          <th scope="col">ACCIONES</th>
          <th scope="col">AUTORIZACIÓN</th>
          <th scope="col">1 CUOTA</th>
          <th scope="col">FECHA ESCANEO</th>
          <th scope="col">FECHA REPORTE</th>
          <th scope="col">GARANTIA</th>
          <th scope="col">AGENCIA</th>
          <th scope="col">INTERES PROPORCIONAL</th>
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

<style>
  .disabled-link {
    pointer-events: none;
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
<script>


 var table = $('#personas').DataTable({
  "ajax": "{{ route('datatable.coordipagarecorreos') }}",
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
    {
    data: null,
      render: function(data, type, row) {

        if(row.ExisteDatacredito == 2){
              var AprobadoButton = '<span class="text-danger blink" style="font-weight: bold; font-size: 25px">SCORE NULO</span><br><span class="text-dark opacity-50" style="font-weight: bold; font-size: 15px">Espere a area de cumplimiento a que sea consultado.</span>';
        }else if(row.ExisteDatacredito == 3){
              var AprobadoButton = '<span class="text-danger blink" style="font-weight: bold; font-size: 25px">EL DATACRÉDITO ESTA VENCIDO</span></span></a>';
        }else if(row.ExisteDatacredito == 1){
              var AprobadoButton = '<span class="text-danger blink" style="font-weight: bold; font-size: 25px">NO EXISTE EN DATACRÉDITO</span><br><a href="director"><span class="text-primary-emphasis" style="font-weight: bold; font-size: 15px">Registra en datacrédito.</span></a>';
        }else if(row.Aprobado == 1){
            var AprobadoButton = '<span class="text-success" style="font-weight: bold; font-size: 30px">SI</span>';
        }else if(row.Aprobado == 0){
            var AprobadoButton = '<span class="text-danger" style="font-weight: bold; font-size: 30px">NO</span>';
        }else{
            var AprobadoButton = '<span class="text-danger" style="font-weight: bold; font-size: 30px">ANULADO</span>';
        }
    return AprobadoButton;

      }
    },
    {
        data: 'Razon',
        createdCell: function (td, cellData, rowData, row, col) {
            $(td).css({
                'font-weight': 'bold',
                'font-size': '20px'
            });
        }
    },
    {    data: null,
      render: function(data, type, row) {
        var id = row.ID;
        var url = "{{ route('crud.update2', ':id') }}";
        url = url.replace(':id', id);


        var aprobar =  '<div class="text-center mt-2 "><a onclick="return estado()" href="{{ route('crudcoor.aprobarcred', ':id') }}" type="submit" class="fw-bold btn btn-small btn-outline-success fs-5" name="eliminar" value="ok">APROBAR</a></div>'.replace(':id', row.ID);

        var rechazar = '<div class="text-center mt-2 "><a onclick="return estado()" href="{{ route('crudcoor.rechazarcred', ':id') }}" type="submit" class="fw-bold btn btn-small btn-outline-danger fs-5" name="eliminar" value="ok">RECHAZAR</a></div>'.replace(':id', row.ID);

        if(row.CorreoEnviado == 0){
          if(row.Aprobado == 1){
            var AprobadoButton = '<div class="text-center"><a onclick="return eliminar2()" href="{{ route('crud.pagarecorreo', ':id') }}" type="submit" class="btn btn-small btn-outline-primary fs-4" name="eliminar" value="ok"><i class="fa-solid fa-envelope"></i></a></div>'.replace(':id', row.ID);
            return AprobadoButton + rechazar;
          }else if(row.Aprobado == 0){
            var RechazadoButton = '<div class="text-center"><a onclick="return eliminar2()" href="{{ route('crud.pagarecorreorecha', ':id') }}" type="submit" class="btn btn-small btn-outline-danger fs-4" name="eliminar" value="ok"><i class="fa-solid fa-envelope"></i></a></div>'.replace(':id', row.ID);
            return RechazadoButton + aprobar;
          }else{
            var RechazadoButton = '<div class="text-center"><a onclick="" type="submit" class="btn btn-small btn-danger fs-4 disabled-link" name="eliminar" value="ok"><i class="fa-solid fa-envelope"></i></a></div>'.replace(':id', row.ID);
            return RechazadoButton;
          }
        }else if(row.CorreoEnviado == 1)  {
          if(row.Aprobado == 1){
            var AprobadoButton = '<div class="text-center"><a onclick="return false;" title="CORREO YA FUE ENVIADO!" class="btn btn-small btn-outline-primary fs-4 disabled-link" name="eliminar" value="ok" disabled><i class="fa-solid fa-envelope"></i></a></div>'.replace(':id', row.ID);
            return AprobadoButton ;
          }else if(row.Aprobado == 0){
            var RechazadoButton = '<div class="text-center"><a onclick="" type="submit" class="btn btn-small btn-danger fs-4 disabled-link" name="eliminar" value="ok"><i class="fa-solid fa-envelope"></i></a></div>'.replace(':id', row.ID);
            return RechazadoButton+ rechazar;
          }else{
            var RechazadoButton = '<div class="text-center"><a onclick="" type="submit" class="btn btn-small btn-danger fs-4 disabled-link" name="eliminar" value="ok"><i class="fa-solid fa-envelope"></i></a></div>'.replace(':id', row.ID);
            return RechazadoButton;
          }
        }
    }
},
{    data: null,
      render: function(data, type, row) {
        var id = row.ID;
        var url = "{{ route('crudger.adjuntarautorizacion', ':id') }}";
        var today = new Date().toISOString().split('T')[0];
        url = url.replace(':id', id);

        var html = '';
      if(row.AutorizacionGerente == 0){

        var editButton = `<div class="text-center fw-bold fs-2">N/A</div>`
      }else if(row.AutorizacionGerente==1){
      var editButton = `<div class="text-center"><a title="Modificar" href="" id="modalLink_${id}" type="submit" class="btn btn-small btn-warning edit-button edit fw-bold fs-1" data-bs-toggle="modal" data-bs-target="#modalEditar_${id}" data-id="${id}" style="margin-right: "><i class="fa-regular fa-file-pdf"></i></a></div>
                  <div class="modal fade" id="modalEditar_${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">


                        <div class="">
                        <button type="button" class="btn-close p-3" aria-label="Close" data-bs-dismiss="modal"></button>
                        <h1 class="modal-title text-center" id="modificar"  style="margin-top: -40px">ADJUNTAR AUTORIZACIÓN</h1>
                        </div>
                        <hr>
                        <div class="modal-body">
                          <form action="`+url+`" class="text-center" method="POST" enctype="multipart/form-data" id="formulario">
                            @csrf

                            <div class="mb-5 mt-3 ms-2 me-2">
                              <label for="" id="" class="form-label text-start fs-5" style="margin-left: 0%;">Por favor, adjuntar documento de <strong>Autorización</strong> de <strong>${row.NombreCompleto}</strong> con cuenta <strong>${row.CuentaCoop}</strong> firmado por <strong>Gerencia</strong>.</label>
                              <input type="file" class="form-control" name="DocuAutorizacion" id="asd" accept="application/pdf" required>
                              <p class="formato-ayuda2">Debe contener el formato: <strong>Autorizacion-(Cédula).pdf</strong></strong></p>
                            </div>


                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary fs-4" data-bs-dismiss="modal">Cerrar</button>
                              <button type="submit" href=""  name="editar" class="btn btn-primary fs-4" style="background-color: #005E56;">Guardar</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>`;
                }else{
                  var editButton =`<a href="Storage/files/autorizacionpagare/${row.DocuAutorizacion}" download style="display: flex; justify-content: center;"><img src="img/pdf.png" style="height: 4.0rem; width: 3.0rem"></a>`
                }
  return editButton;

}
  },
{
      data: null,
      render: function(data, type, row) {
        var Fecha1Cuota = '<strong style="font-size:25px">'+row.Fecha1Cuota+'</strong>';
        return Fecha1Cuota;
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
        var FechaAccion = '<strong style="font-size:25px">'+row.FechaReporte+'</strong>';
        return FechaAccion;
      }
    },
    {
      data: null,
      render: function(data, type, row) {
        var Garantia = '<span style="font-size:25px">'+row.Garantia+'</span>';
        return Garantia;
      }
    },


    {data: 'NoAgencia'},
    {
      data: null,
      render: function(data, type, row) {
        var Interes = '<span style="font-size:25px">'+row.InteresProporcional+'</span>';
        return Interes;
      }
    },
    {data: 'CuentaCoop'},
    {data: 'Cedula_Persona'},
    {data: 'NombreCompleto'},
    {data: 'ID_Pagare'},
    {
      data: null,
      render: function(data, type, row) {
        var NoLC = '<strong>'+row.NoLC+'</strong>';
        var Linea_Credito = row.Linea_Credito;


        return NoLC+'-'+Linea_Credito;
      }
    },
    { "data": "Capital",
      "render": $.fn.dataTable.render.number(',', '.', 0) // Formatea como número con 2 decimales
    },

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
    {data: 'GeneradorPagare'}
  ],



  "lengthMenu": [[7], [7]],
  "language": {
    "lengthMenu": "Mostrar _MENU_ registros por página",
    "zeroRecords": "No existe!",
    "info": "Mostrando la página _PAGE_ de _PAGES_",
    "infoEmpty": "No hay registros disponibles",
    "infoFiltered": "(Filtrado de _MAX_ registros totales)",
    "search": "Buscar:",
    "paginate": {
      "next": "Siguiente",
      "previous": "Anterior"
    }
  },
        responsive: "true",
        dom: 'Bfrtilp',
        buttons:[
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel"></i> ',
				titleAttr: 'Exportar a Excel',
				className: 'btn btn-success btn-lg'
			},
			{
				extend:    'print',
				text:      '<i class="fa fa-print"></i> ',
				titleAttr: 'Imprimir',
				className: 'btn btn-info btn-lg'
			},
      ]
});



function showUnauthorizedMessage() {
  Swal.fire({
    icon: 'error',
    title: '¡Permiso no autorizado!',
    text: 'No tienes permiso para realizar esta acción.',
    confirmButtonColor: '#005E56'
  });

  return false;
}
function fecha(){
            var respuesta=confirm("Recuerda cambiar la FECHA ya que el datacrédito esta vencido!")
            return respuesta
          }

          function eliminar(){
            var respuesta=confirm("¿Estas seguro que deseas eliminar este registro?")
            return respuesta
          }

          function csesion(){
            var respuesta=confirm("¿Estas seguro que deseas cerrar sesión?")
            return respuesta
          }


          function estado(){
            var respuesta=confirm("¿Estas seguro de cambiar el estado al crédito?")
            return respuesta
          }

        </script>


    </div>

    </div>

</div>



    @endsection


