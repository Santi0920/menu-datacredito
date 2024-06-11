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
          timer: 3000

      });
  </script>
  </div>
@endif

@if (session("alert"))
  <div>
  <script>
    Swal.fire
      ({
          icon: 'warning',
          title: "{{session('alert')}}",
          text: '',
          confirmButtonColor: '#005E56'

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

@include('layouts/nav-areacumplimiento')


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
    <h2 class="p-2 mb-0 text-secondary text-start"><b>Crédito Asociados - <span class="text-end" id="fechaActual"></b></span></h2>
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
      <div style="overflow: auto;" class="mb-4 p-3 table-responsive">
        <table id="personas" class="hover table table-striped shadow-lg mt-2 table-bordered table-hover col-md-4">
          <thead class="" style="background-color: #005E56;">
            <tr class="text-white">
              <th class="" scope="col">#</th>
              <th class="" scope="col">TIPO ASOCIADO</th>
              <th class="" scope="col">CÉDULA</th>
              <th class="" scope="col">NOMBRE</th>
              <th class="" scope="col">APELLIDOS</th>
              <th class="" scope="col">SCORE</th>
              <th class="" scope="col">REPORTE</th>
              <th class="" scope="col">CUENTA</th>
              <th class="text-center" scope="col">AGENCIA</th>
              <th class="" scope="col">FECHAGNR</th>
              <th class="" scope="col">ESTADO</th>
              <th class="" scope="col">SIN</th>
              <th class="" scope="col">PN</th>
              <th class="" scope="col">AUTORIZACION Y/O ANALISIS</th>
              <th class="" scope="col">ID AUTORIZACION Y/O ANALISIS</th>
              <th class="" scope="col" title="Recibo de Caja">RC</th>
              <th class="" scope="col">CONSECUTIVO RC</th>
              <th class="" scope="col">OBSER RC</th>
              <th class="" scope="col">LINEA</th>
              <th class="" scope="col">MONTO</th>
              <th class="" scope="col">TOTAL DEUDA</th>
              <th class="" scope="col">FECHA CORREO</th>
              <th class="w-25" scope="col">OBSERVACIONES</th>



              <th class="" style="width: 77px"></th>
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
  "ajax": "{{ route('datatable.coordinadorcredito') }}",
  "processing": true,
  "order": [
                [0, 'desc']
            ],
  "columns": [
    {data: 'ID'},
    { data: 'TipoAsociado', render: function(data, type, row) {
          if (data === 'Asociacion') {
            return '<strong>' + data + '</strong>';
          } else {
            return data;
          }
        }
      },
    {data: 'Cedula'},
    {
      data: 'Nombre',
      render: function(data, type, row) {
        if (type === 'display') {
          var formattedName = data.charAt(0).toUpperCase() + data.slice(1).toLowerCase();
          return formattedName;
        }
        return data;
      }
    },
    {data: 'Apellidos'},
    {data: 'Score'},
    {data: 'Reporte'},
    {data: 'CuentaAsociada'},
    {
      data: 'Agencia',
      render: function (data, type, row) {
        var agencia = data.charAt(0).toUpperCase() + data.slice(1).toLowerCase();
        return agencia;
      }
    },
    {
  data: 'FechaInsercion',
  render: function(data, type, row) {
    var html = '';
    var fecha_insercion = new Date(data);

    var fecha_actual = new Date();
    var diferencia = Math.floor((fecha_actual - fecha_insercion) / (1000 * 60 * 60 * 24)); // Calcular la diferencia en días
if(row.FechaInsercion == null){
  html += data + '<span class="text-success-emphasis fw-bold blink" style="font-size: 20px;"><br>PENDIENTE</span>';
} else if (parseInt(row.Consulta) === 1 && diferencia > 180) {
  html += data + '<span class="fw-bold blink" style="font-size: 20px;"><br><span style="background-color: yellow;">RENOVAR</span></span>';
} else if (diferencia > 180) {
  html += data + '<span class="text-danger fw-bold blink" style="font-size: 20px;"><br>VENCIDO</span>';
} else {
  html += data + '<span class="fw-bold" style="color: #1565c0;"><br>Al día</span>';
}

    return html;
  }
},
    {data: 'Estado'},
    {
  data: 'NombreS',
  render: function(data, type, row) {
    if (type === 'display') {
      if (data === 'null.html' || data === null) {
        return '';
      } else {
        return '<a href="Storage/files/sintesis/' + data + '" download><img src="img/pdf.png" style="height: 2.5rem"></a><span class="d-none fw-bold blink" style="font-size: 20px;"><br>1</span>';
      }
    }
    return data;
  }
},
{
  data: 'NombrePN',
  render: function(data, type, row) {
    if (type === 'display') {
      if (data === 'null.html' || data === null) {
        return '';
      } else {
        return '<a href="Storage/files/pn/' + data + '" download><img src="img/pdf.png" style="height: 2.5rem"></a><span class="d-none fw-bold blink" style="font-size: 20px;"><br>1</span>';
      }
    }
    return data;
  }
},

{data: 'NombreA',
      "render": function(data, type, row) {
        if (type === 'display') {
          if (data === null) {
            return '';
          }else{
          return '<a href="Storage/files/autorizacion/' + data + '" download><img src="img/pdf.png" style="height: 2.5rem"></a>';
          }
        }
        return data;
      }
    },
    {data: 'ConsecutivoA'},
    {
  data: 'NombreAnalisis',
  render: function(data, type, row) {
    if (type === 'display') {
      if (data === 'null.html' || data === null) {
        return '';
      } else {
        return '<a href="Storage/files/rccreditos/' + data + '" download><img src="img/pdf.png" style="height: 2.5rem"></a>';
      }
    }
    return data;
  }
},
   {data: 'ConsecutivoRC'},
   {data: 'ObRC'},
   {data: 'Linea'},
    {data: 'Monto'
},
    {data: 'DeudaEsp'},
    {data: 'FechaCorreo'},
    {data: 'Observaciones'},
    {    data: null,
      render: function(data, type, row) {
  var id = row.ID;
  var url = "{{ route('crud.updatecreditoo', ['id' => ':id']) }}";
  url = url.replace(':id', id);
  var today = new Date().toISOString().split('T')[0];
  var modalLinkId = `modalLink_${id}`;

  var deleteButton = '<a onclick="showUnauthorizedMessage()" href="#" type="submit" class="btn btn-small btn-danger" name="eliminar" value="ok" disabled><i class="fa-solid fa-trash"></i></a>'.replace(':id', row.ID);
  var editButton = `<a href="" id="modalLink_${id}" type="submit" class="btn btn-small btn-warning edit-button edit" data-bs-toggle="modal" data-bs-target="#modalEditar_${id}" data-id="${id}" style="margin-right: "><i class="fa-regular fa-pen-to-square"></i></a>
<div class="modal fade" id="modalEditar_${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!-- Contenido del modal -->
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <button type="button" data-bs-dismiss="modal" class="btn-close p-3" aria-label="Close"></button>
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <h1 class="modal-title text-center" id="modificar">MODIFICAR</h1>
          </div>
          <hr>
          <div class="modal-body">
            <form action="` + url + `" class="text-center" method="POST" enctype="multipart/form-data" id="formulario" onsubmit="return validateForm2()">
              @csrf
              <!-- Resto del contenido del modal -->
              <div class="mb-3">
                <label for="cedula2" id="izquierda7" class="form-label fw-bold" value="">CÉDULA</label>
                <input type="text" class="form-control" name="cedula2" id="cedula2" readonly value="${row.Cedula}" style="background-color: #EBEBEB; cursor: not-allowed;">
                <input type="hidden" name="cedula3" value="${row.Cedula}">
              </div>

              <div class="mb-3">
                <label for="nombre3" id="izquierda3" class="form-label fw-bold">NOMBRE</label>
                <input type="text" class="form-control" id="nombre3" name="nombre3" value="${row.Nombre}" maxlength="30" readonly style="background-color: #EBEBEB; cursor: not-allowed;">
                <div id="nombreError3" style="color: red;" class="fw-bold"></div>
              </div>

              <div class="mb-3">
                <label for="exampleInputEmail1" id="izquierda6" class="form-label fw-bold">APELLIDOS</label>
                <input type="text" class="form-control" id="apellidos3" name="apellidos3" value="${row.Apellidos}" maxlength="60" oninput="this.value = this.value.toUpperCase()" readonly style="background-color: #EBEBEB; cursor: not-allowed;">
                <div id="apellidosError3" style="color: red;" class="fw-bold"></div>
              </div>

              <div class="mb-3">
                  <label for="label" id="izquierda" class="form-label fw-bold" style="background-color: #bedffb;">SCORE</label>
                  <input type="text" class="form-control" id="score3" name="score3" value="${row.Score}" maxlength="20" oninput="this.value = this.value.toUpperCase()">
                  <div id="scoreError3" style="color: red;" class="fw-bold"></div>
                  <p class="formato-ayuda">Si cuenta con score 0, ingresar <strong>S/E(Sin experiencia)</strong>.</p>
              </div>

              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda4" class="form-label fw-bold" style="background-color: #bedffb;">REPORTE DATACRÉDITO</label>
                  <input type="text" class="form-control" id="reporte3" name="reporte3" maxlength="15" value="${row.Reporte}" oninput="this.value = this.value.toUpperCase()">
                  <div id="reporteError3" style="color: red;" class="fw-bold"></div>
                  <p class="formato-ayuda">Ingresar <strong>N</strong> = Normal, Si cuenta con Mora <strong>1 = 30, 2 = 60, <br>3 = 90, 4 = 120, 5 = 150, 6 = 180</strong>, <strong>D</strong> = Dudoso Recaudo, <br><strong>C</strong> = Cartera Castigada</p>
              </div>


              <!--Label4-->
              <div class="mb-3 ">
                <label for="label" id="izquierda2" class="form-label fw-bold">CUENTA ASOCIADA</label>
                <input type="text" class="form-control" name="cuenta3" id="cuenta3" readonly value="${row.CuentaAsociada}" style="background-color: #EBEBEB; cursor: not-allowed;">
                <input type="hidden" name="cuenta" value="${row.CuentaAsociada}">
              </div>

              <!--Label5-->
              <div class="mb-3">
                <label for="click" id="izquierda7" class="form-label fw-bold">AGENCIA</label>
                <input list="agencia" type="text" class="form-control" id="agencia3" name="agencia3" value="${row.Agencia}" maxlength="20" readonly style="background-color: #EBEBEB; cursor: not-allowed;" autocomplete="off">
                <div id="agenciaError3" style="color: red;" class="fw-bold"></div>
              </div>

              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda" class="form-label fw-bold" style="background-color: #bedffb;">FECHA</label>
                  <input type="date" class="form-control" name="fecha3" id="fecha3" min="2022-08-01" max="`+today+`" value="${row.FechaInsercion}">
                </div>

              <div class="mb-3">
                <label for="exampleInputEmail1" id="izquierda9" class="form-label fw-bold">ESTADO</label>
                <select class="form-control" name="estado3" id="estado3" disabled style="background-color: #EBEBEB; cursor: not-allowed;">
                  <option value=""></option>
                  <option value="N" ${row.Estado === 'N' ? 'selected' : ''}>Normal</option>
                  <option value="B" ${row.Estado === 'B' ? 'selected' : ''}>Bloqueado</option>
                  <option value="S" ${row.Estado === 'S' ? 'selected' : ''}>Suspendido</option>
                  <option value="J" ${row.Estado === 'J' ? 'selected' : ''}>Judicial</option>
                  <option value="I" ${row.Estado === 'I' ? 'selected' : ''}>Insolvente</option>
                  <option value="R" ${row.Estado === 'R' ? 'selected' : ''}>Renovar</option>
                </select>
                <input type="hidden" name="estado3" value="${row.Estado}">
              </div>

              <div class="mb-3">
                <label for="exampleInputEmail1" id="izquierda5" class="form-label fw-bold" style="background-color: #bedffb;">ADJUNTAR ARCHIVO SINTESIS</label>
                <input type="file" class="form-control" name="archivo22" id="archivo22" accept="application/pdf" value="">
                <p class="formato-ayuda">Formato: <strong>Sintesis-(Cédula).pdf</strong></p>
              </div>

                <div class="mb-3">
                    <label for="label" id="izquierda8" class="form-label fw-bold" style="background-color: #bedffb;">ADJUNTAR ARCHIVO PN</label>
                  <input type="file" class="form-control" name="archivo11" id="archivo11" accept="application/pdf" value="">
                  <p class="formato-ayuda">Formato: <strong>PN-(Cédula).pdf</strong></p>
                  </div>

                  <div class="mb-3">
                <label for="cedula2" id="" style="margin-left: -80%" class="form-label fw-bold" value="">INSPEKTOR</label>
                <input type="text" class="form-control" name="Inspektor2" id="Inspektor2" value="${row.Inspektor}" readonly style="background-color: #EBEBEB; cursor: not-allowed;">
                <input type="hidden" name="cedula3"  value="">
              </div>

                  <div class="mb-3">
                  <label for="exampleInputEmail1" id="" class="form-label fw-bold" style="background-color: #bedffb; margin-left: -70%">OBSERVACIONES</label>
                  <input type="text" class="form-control" id="reporte3" name="Observaciones" value="${row.Observaciones}">
                  <div id="reporteError3" style="color: red;" class="fw-bold"></div>
              </div>


              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button onclick="return confirmacion()" type="submit" href="" name="editar" class="btn btn-primary" style="background-color: #005E56;">Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>`;
  return editButton + ' ' + deleteButton;
}
}],


  "lengthMenu": [[6], [6]],
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
			}
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



          function eliminar(){
            var respuesta=confirm("¿Estas seguro que deseas eliminar este registro?")
            return respuesta
          }

          function csesion(){
            var respuesta=confirm("¿Estas seguro que deseas cerrar sesión?")
            return respuesta
          }

          function toggleFields() {
    var consecutivoInput = document.getElementById('consecutivoa');
    var archivoInput = document.getElementById('archivo22');
    var montoInput = document.getElementById('monto');

    if (consecutivoInput.value === 'N/A') {
      archivoInput.disabled = true;
      montoInput.disabled = true;
    } else {
      archivoInput.disabled = false;
      montoInput.disabled = false;
    }
  }

        </script>



    </div>

    </div>

</div>



    @endsection

