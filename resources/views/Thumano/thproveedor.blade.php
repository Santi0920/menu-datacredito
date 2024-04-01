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
@include('layouts/nav-thumano')

    </form>
    <br>
    {{-- FECHA --}}
    <div class="col-11" style="margin-left:3.5%">
      <div class="">
        <form action="" method="post">
        <div class="" style="margin-top: 0px; margin-right: -14px;">

      </b></h2>
    </div>
    <h2 class="p-2 mb-0 text-secondary text-start"><b>Proveedores y Terceros - <span class="text-end" id="fechaActual"></b></span></h2>
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
      <div style="overflow: auto;" class="mb-4 p-3">
        <table id="personas" class="hover table table-responsive table-striped shadow-lg mt-2 table-bordered table-hover col-md-4">
          <thead class="" style="background-color: #005E56;">
            <tr class="text-white">
              <th class="" scope="col">#</th>
              <th class="" scope="col">TIPO</th>
              <th class="" scope="col">NIT</th>
              <th class="" scope="col">RAZÓN SOCIAL</th>
              <th class="" scope="col">CÉDULA</th>
              <th class="" scope="col">NOMBRE</th>
              <th class="" scope="col">APELLIDOS</th>
              <th class="" scope="col">SCORE</th>
              <th class="" scope="col">REPORTE</th>
              <th class="" scope="col">AGENCIA</th>
              <th class="" scope="col">FECHAGNR</th>
              <th class="" scope="col" title="Recibo de Caja">RC</th>
              <th class="" scope="col">SIN</th>
              <th class="" scope="col">PN</th>
              <th scope="col">A</th>
          <th scope="col">ID</th>
          <th scope="col">FECHA CORREO</th>
          <th scope="col">INSPEKTOR</th>
          <th scope="col">OBSERVACIONES</th>
              <th class="" style="width: 77px"></th>
            </tr> 
          </thead> 
          <tbody class="table-group-divider">
           
            
          </tbody>


          <style>
            .formato-ayuda2 {
              color: gray;
              font-style:normal;
            }
            </style>
        </table>

        
        
    

        <script>
              //VALIDACION REGISTRO
      function validateForm2() {
    

        var agenciaInput = document.getElementById('agencia3');
      var agenciaError = document.getElementById('agenciaError3');

      var agencia = agenciaInput.value.trim();
      var opcionesAgencia = document.getElementById('agencia').options;
      var valorValido = false;

      for (var i = 0; i < opcionesAgencia.length; i++) {
        if (agencia.toLowerCase() === opcionesAgencia[i].value.toLowerCase()) {
          valorValido = true;
          break;
        }
      }

      if (!valorValido) {
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'En el campo Agencia seleccionar una opción de la lista!',
          confirmButtonColor: '#005E56'
        });
        agenciaError.innerHTML = 'Seleccione una opción de la lista';
        return false;
      }
        return true;
}



            $('button[name="btnregistrar2"]').on('click', function() {
        if ($('#name').val() === '') {
            $('#name').css('background-color', 'mistyrose');
            $('#name').attr('placeholder', 'Obligatorio');
        }
        if ($('#email').val() === '') {
            $('#email').css('background-color', 'mistyrose');
            $('#email').attr('placeholder', 'Obligatorio');
        }
        if ($('#password').val() === '') {
            $('#password').css('background-color', 'mistyrose');
            $('#password').attr('placeholder', 'Obligatorio');
        }
        if ($('#password_confirmation').val() === '') {
            $('#password_confirmation').css('background-color', 'mistyrose');
            $('#password_confirmation').attr('placeholder', 'Obligatorio');
        }
    
    });
    
    </script>

          </div>
        </div>
        <script src="ResourcesAll/dtables/jquery-3.5.1.js"></script>
        <script src="ResourcesAll/dtables/jquerydataTables.js"></script>
        <script src="ResourcesAll/dtables/dataTablesbootstrap5.js"></script>
        <script>
 

 var table = $('#personas').DataTable({
  "ajax": "{{ route('datatable.tproveedor') }}",
  "columns": [
    {
      data: 'ID'
    },
    {data: 'TipoProveedor'},
    {data: 'NIT'},
    {data: 'RazonSocial'},
    {data: 'Cedula'},
    {data: 'Nombre'},
    {data: 'Apellidos'},
    {data: 'Score'},
    {data: 'Reporte'},
    {data: 'Agencia'},
    {  data: 'FechaInsercion',
  render: function(data, type, row) {
    var html = '';
    var fecha_insercion = new Date(data);

    var fecha_actual = new Date();
    var diferencia = Math.floor((fecha_actual - fecha_insercion) / (1000 * 60 * 60 * 24));

    if (parseInt(row.Consulta) === 1 && diferencia > 180) {
  html += data + '<span class=" fw-bold blink" style="font-size: 20px;"><br><span style="background-color: yellow;">RENOVAR</span></span>';
} else if (diferencia > 180) {
  html += data + '<span class="text-danger fw-bold blink" style="font-size: 20px;"><br>VENCIDO</span>';
} else {
  html += data + '<span class="fw-bold" style="color: #1565c0;"><br>Al día</span>';
}

    return html;
  }
},
{
  data: 'NombreRC',
  render: function(data, type, row) {
    if (type === 'display') {
      if (data === null) {
        return '';
      } else {
        return '<a href="Storage/files/rc/' + data + '" download><img src="img/pdf.png" title="'+data+'" style="height: 2.5rem"></a>';
      }
    }
    return data;
  }
},
{
  data: 'NombreS',
  render: function(data, type, row) {
    if (type === 'display') {
      if (data === null) {
        return '';
      } else {
        return '<a href="Storage/files/sintesis/' + data + '" download><img src="img/pdf.png" title="'+data+'" style="height: 2.5rem"></a>';
      }
    }
    return data;
  }
},
    {data: 'NombrePN',
      "render": function(data, type, row) {
        if (type === 'display') {
          if (data === null) {
            return '';
          }else{
          return '<a href="Storage/files/pn/' + data + '" download><img src="img/pdf.png" title="'+data+'" style="height: 2.5rem"></a>';
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
    {data: 'FechaCorreo'},
    {data: 'Inspektor'},
    {data: 'Observaciones'},
    {    data: null,
      render: function(data, type, row) {
        var id = row.ID; // Obtener el ID de la fila
        var url = "{{ route('crudt.update3', ':id') }}";
        var today = new Date().toISOString().split('T')[0];
        url = url.replace(':id', id);

var html = '';
var fecha_insercion = new Date(data.FechaInsercion); // Assuming "FechaInsercion" is a property in the "data" object
var fecha_actual = new Date();
var diferencia = Math.floor((fecha_actual - fecha_insercion) / (1000 * 60 * 60 * 24));

if (diferencia > 180) {
  html += `<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type="submit" href="" name="editar" class="btn btn-primary" onclick="return fecha()" style="background-color: #005E56;">Guardar</button>
  </div>`;
} else {
  html += `<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type="submit" href="" name="editar" class="btn btn-primary" onclick="" style="background-color: #005E56;">Guardar</button>
  </div>`;
}
      var deleteButton = '<a onclick="showUnauthorizedMessage()" href="#" type="submit" class="btn btn-small btn-danger" name="eliminar" value="ok" disabled><i class="fa-solid fa-trash"></i></a>'.replace(':id', row.ID);
      if(data.TipoProveedor== 'PN'){
        var editButton = `<a href="" id="modalLink_${id}" type="submit" class="btn btn-small btn-warning edit-button edit" data-bs-toggle="modal" data-bs-target="#modalEditar_${id}" data-id="${id}" style="margin-right: "><i class="fa-regular fa-pen-to-square"></i></a>
<div class="modal fade" id="modalEditar_${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!-- Contenido del modal -->
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <button type="button" data-bs-dismiss="modal" class="btn-close p-3" aria-label="Close"></button>
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <h1 class="modal-title text-center" id="modificar">MODIFICAR PN</h1>
          </div>
          <hr>
          <div class="modal-body">
            <form action="` + url + `" class="text-center" method="POST" enctype="multipart/form-data" id="formulario" onsubmit="return validateForm2()">
              @csrf
              <!-- Resto del contenido del modal -->
              <div class="mb-3" style="display:none">
                <label for="cedula2" id="izquierda7" class="form-label fw-bold" value="">CÉDULA</label>
                <input type="text" class="form-control" name="tipo" id="tipo" readonly value="${row.TipoProveedor}" style="background-color: #EBEBEB; cursor: not-allowed;">
                <input type="hidden" name="cedula3" value="">
              </div>
              <div class="mb-3">
                <label for="cedula2" id="izquierda7" class="form-label fw-bold" value="">CÉDULA</label>
                <input type="text" class="form-control" name="cedula2" id="cedula2" readonly value="${row.Cedula}" style="background-color: #EBEBEB; cursor: not-allowed;">
                <input type="hidden" name="cedula3" value="">
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
                <input type="text" class="form-control" id="score3" name="score3" value="${row.Score}" maxlength="3" pattern="^(0*[1-9]|[1-9][0-9]{0,2}|950|S\/E)$" title="Debe ingresar solo números 1-950 o 'S/E'" oninput="this.value = this.value.toUpperCase()">
                <div id="scoreError3" style="color: red;" class="fw-bold"></div>
                <p class="formato-ayuda">Si cuenta con score 0, ingresar <strong>S/E (Sin experiencia)</strong>.</p>
              </div>

                <!-- Campo REPORTE DATACRÉDITO -->
                <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda4" class="form-label fw-bold" style="background-color: #bedffb;">REPORTE DATACRÉDITO</label>
                  <input type="text" class="form-control" id="reporte3" name="reporte3" maxlength="15" value="${row.Reporte}" pattern="[A-Za-z0-9]+" title="Debe ingresar solo letras o números!" oninput="this.value = this.value.toUpperCase()">
                  <div id="reporteError3" style="color: red;" class="fw-bold"></div>
                  <p class="formato-ayuda">Ingresar N = Normal, D = Dudoso Recaudo, C = Cartera Castigada ó 1 - 6 (Si cuenta con Mora).</p>
                </div>

              

              <!--Label5-->
              <div class="mb-3">
                <label for="click" id="izquierda7" class="form-label fw-bold">AGENCIA</label>
                <input list="agencia" type="text" class="form-control" id="agencia3" name="agencia3" value="${row.Agencia}" maxlength="20" readonly style="background-color: #EBEBEB; cursor: not-allowed;" autocomplete="off">
                <div id="agenciaError3" style="color: red;" class="fw-bold"></div>
              </div>
  
              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda" class="form-label fw-bold" style="background-color: #bedffb;">FECHA</label>
                  <input type="date" class="form-control" name="fecha3" id="fecha3" min="2022-08-01" max="`+today+`" value="${row.FechaInsercion}" required>
                </div>

                <div class="mb-3">
                <label for="exampleInputEmail1" id="izquierda5" class="form-label fw-bold" style="background-color: #bedffb;">ADJUNTAR ARCHIVO SINTESIS</label>
                <input type="file" class="form-control" name="archivo22" id="archivo22" accept="application/pdf" value="">
                <p class="formato-ayuda2">Formato: <strong>Sintesis-(Cédula).pdf</strong></p>
              </div> 
              
                <div class="mb-3">
                    <label for="label" id="izquierda8" class="form-label fw-bold" style="background-color: #bedffb;">ADJUNTAR ARCHIVO PN</label>
                  <input type="file" class="form-control" name="archivo11" id="archivo11" accept="application/pdf" value="">
                  <p class="formato-ayuda2">Formato: <strong>PN-(Cédula).pdf</strong></p>
                  </div>

                  <div class="mb-3">
                <label for="cedula2" id="" style="margin-left: -80%" class="form-label fw-bold" value="">INSPEKTOR</label>
                <input type="text" class="form-control" name="Inspektor2" id="Inspektor2" value="${row.Inspektor}" readonly style="background-color: #EBEBEB; cursor: not-allowed;">
                <input type="hidden" name="cedula3"  value="">
              </div>
              
                  <div class="mb-3">
                  <label for="exampleInputEmail1" id="" class="form-label fw-bold" style="background-color: #bedffb; margin-left: -70%">OBSERVACIONES</label>
                  <input type="text" class="form-control" id="reporte3" name="Observaciones" maxlength="255" value="${row.Observaciones}">
                  <div id="reporteError3" style="color: red;" class="fw-bold"></div>
              </div>


${html}
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>`;
      }else{
       editButton = `<a href="" id="modalLink_${id}" type="submit" class="btn btn-small btn-warning edit-button edit" data-bs-toggle="modal" data-bs-target="#modalEditar_${id}" data-id="${id}" style="margin-right: "><i class="fa-regular fa-pen-to-square"></i></a>
<div class="modal fade" id="modalEditar_${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!-- Contenido del modal -->
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <button type="button" data-bs-dismiss="modal" class="btn-close p-3" aria-label="Close"></button>
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <h1 class="modal-title text-center" id="modificar">MODIFICAR PJ</h1>
          </div>
          <hr>
          <div class="modal-body">
            <form action="` + url + `" class="text-center" method="POST" enctype="multipart/form-data" id="formulario" onsubmit="return validateForm2()">
              @csrf
              <!-- Resto del contenido del modal -->
              <div class="mb-3">
                <label for="cedula2" id="" class="form-label fw-bold" value="" style="margin-left:-90%">NIT</label>
                <input type="text" class="form-control" name="nit2" id="nit2" readonly value="${row.NIT}" style="background-color: #EBEBEB; cursor: not-allowed;">
                <input type="hidden" name="nit2" value="${row.NIT}">
              </div>

              <div class="mb-3">
                <label for="nombre3" id="" class="form-label fw-bold" style="margin-left: -72%">RAZÓN SOCIAL</label>
                <input type="text" class="form-control" id="razonsocial2" name="razonsocial2" value="${row.RazonSocial}" maxlength="30" readonly style="background-color: #EBEBEB; cursor: not-allowed;">
                <div id="nombreError3" style="color: red;" class="fw-bold"></div>
              </div>
        

              <div class="mb-3">
                  <label for="label"  id="izquierda" class="form-label fw-bold" style="background-color: #bedffb;">SCORE</label>
                  <input type="text" class="form-control" id="score4" name="score4" value="${row.Score}" maxlength="3" required>
                  <div id="scoreError3" style="color: red;" class="fw-bold"></div>
                  <p class="formato-ayuda">Si cuenta con score 0, ingresar <strong>S/E(Sin experiencia)</strong>.</p>
              </div>
  
              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda4" class="form-label fw-bold" style="background-color: #bedffb;">REPORTE DATACRÉDITO</label>
                  <input type="text" class="form-control" id="reporte4" name="reporte4" maxlength="15" value="${row.Reporte}" oninput="this.value = this.value.toUpperCase()">
                  <div id="reporteError3" style="color: red;" class="fw-bold"></div>
                  <p class="formato-ayuda">Ingresar N = Normal, D = Dudoso Recaudo, C = Cartera Castigada ó 1 - 6 (Si cuenta con Mora).</p>
              </div>
  
              <!--Label5-->
              <div class="mb-3">
                  <label for="click" id="izquierda7" class="form-label fw-bold">AGENCIA</label>
                  <input list="agencia" type="text" class="form-control" id="agencia4" name="agencia4" value="${row.Agencia}" maxlength="20" readonly style="background-color: #EBEBEB; cursor: not-allowed;" autocomplete="off">
                  <div id="agenciaError3" style="color: red;" class="fw-bold"></div>
              </div>
                
              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda" class="form-label fw-bold" style="background-color: #bedffb;">FECHA</label>
                  <input type="date" class="form-control" name="fecha4" id="fecha4" min="2022-08-01" max="`+today+`" value="${row.FechaInsercion}" required>
                </div>
  
              <div class="mb-3">
                <label for="exampleInputEmail1" id="izquierda5" class="form-label fw-bold" style="background-color: #bedffb;">ADJUNTAR ARCHIVO SINTESIS</label>
                <input type="file" class="form-control" name="archivo22" id="archivo22" accept="application/pdf" value="">
                <p class="formato-ayuda2">Formato: <strong>Sintesis-(NIT).pdf</strong></p>
              </div> 
              
                <div class="mb-3">
                    <label for="label" id="izquierda8" class="form-label fw-bold" style="background-color: #bedffb;">ADJUNTAR ARCHIVO PN</label>
                  <input type="file" class="form-control" name="archivo11" id="archivo11" accept="application/pdf" value="">
                  <p class="formato-ayuda2">Formato: <strong>PN-(NIT).pdf</strong></p>
                  </div>


                  <div class="mb-3">
                  <label for="exampleInputEmail1" id="" class="form-label fw-bold" style="background-color: #bedffb; margin-left: -70%">OBSERVACIONES</label>
                  <input type="text" class="form-control" id="reporte3" name="Observaciones2" maxlength="255" value="${row.Observaciones}">
                  <div id="reporteError3" style="color: red;" class="fw-bold"></div>
              </div>



${html}
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>`;

      }
  return editButton + ' ' + deleteButton;

}
  }
  ],


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
  }
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

         
        </script>
        
        
    </div>
    
    </div>
    
</div>    



    @endsection
    
 