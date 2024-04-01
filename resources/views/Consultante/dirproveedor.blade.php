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
          timer: 10000
    
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


<div class="container-fluid row p-4">
<form action="{{route('crudc.createproveedor')}}" class="col 3 m-3" method="POST" enctype= "multipart/form-data" onsubmit="return validateForm()">
  <h2 class="p-2 text-secondary text-center"><b>Proveedores y Terceros</b></h2>
  
 @csrf
 
 <div class="mb-3 w-100" title="Este campo es obligatorio">
  <label class="form-label fw-semibold">TIPO PERSONA<span class="text-danger" style="font-size:20px;">*</span></label><br>
  <div class="form-check form-check-inline">
    <input type="radio" name="tipo_persona" value="PN" id="PN" accesskey="N" onchange="toggleCamposPersona()" required>
    <label class="form-check-label" for="PN" style="font-size: 18px">Persona Natural</label>
  </div>
  <div class="form-check form-check-inline">
    <input type="radio" name="tipo_persona" value="PJ" id="PJ" accesskey="J" onchange="toggleCamposPersona()" required>
    <label class="form-check-label" for="PJ" style="font-size: 18px">Persona Jurídica</label>
  </div>
</div>

<!-- Campos para Persona Natural -->
<div id="camposPersonaNatural" style="display: none;">
  <div class="mb-3 w-100" title="Este campo es obligatorio">
    <label for="cedula" class="form-label fw-semibold">CÉDULA<span class="text-danger" style="font-size:20px;">*</span></label>
    <input type="text" class="form-control" name="cedula" id="cedula" pattern="[0-9]+" title="Ingresa solo números">
    <div id="cedulaError" style="color: red;" class="fw-bold"></div>
  </div>


  <div class="mb-3 w-100" title="Este campo es obligatorio">
    <label for="nombre" class="form-label fw-semibold">NOMBRE <span class="text-danger" style="font-size:20px;">*</span></label>
    <input type="text" class="form-control " name="nombre" id="nombre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Ingresa solo letras, incluyendo tildes y la letra 'ñ'">
    <div id="nombreError" style="color: red;" class="fw-bold"></div>
  </div>

  <div class="mb-3 w-100" title="Este campo es obligatorio">
    <label for="apellidos" class="form-label fw-semibold">APELLIDOS <span class="text-danger" style="font-size:20px;">*</span></label>
    <input type="text" class="form-control " name="apellidos" id="apellidos" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Ingresa solo letras, incluyendo tildes y la letra 'ñ'">
    <div id="apellidosError" style="color: red;" class="fw-bold"></div>
  </div>
</div>

<!-- Campos para Persona Jurídica -->
<div id="camposPersonaJuridica" style="display: none;">
  <div class="mb-3 w-100" title="Este campo es obligatorio">
    <label for="nit" class="form-label fw-semibold">NIT<span class="text-danger" style="font-size:20px;">*</span></label>
    <input type="text" class="form-control" name="nit" id="nit" pattern="[0-9]+" title="Ingresa solo números" maxlength="15">
    <div id="nitError" style="color: red;" class="fw-bold"></div>
  </div>

  <div class="mb-3 w-100" title="Este campo es obligatorio">
    <label for="razonSocial" class="form-label fw-semibold">RAZÓN SOCIAL <span class="text-danger" style="font-size:20px;">*</span></label>
    <input type="text" class="form-control " name="razonSocial" id="razonSocial" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" title="Ingresa solo letras, incluyendo tildes y la letra 'ñ'" maxlength="25">
    <div id="razonSocialError" style="color: red;" class="fw-bold"></div>
  </div>
</div>  

 <style>
.formato-ayuda2 {
  color: gray;
  font-style: normal;
}
</style>

  <!--VALIDACION CAMPO CEDULA--> 
  <script>
function toggleCamposPersona() {
  var tipoPersona = document.querySelector('input[name="tipo_persona"]:checked').value;
  var camposPersonaNatural = document.getElementById('camposPersonaNatural');
  var camposPersonaJuridica = document.getElementById('camposPersonaJuridica');

  if (tipoPersona === 'PN') {
    camposPersonaNatural.style.display = 'block';
    camposPersonaJuridica.style.display = 'none';

    document.getElementById('cedula').required = true;
    document.getElementById('nombre').required = true;
    document.getElementById('apellidos').required = true;

    document.getElementById('nit').removeAttribute('required');
    document.getElementById('razonSocial').removeAttribute('required');
  } else if (tipoPersona === 'PJ') {
    camposPersonaNatural.style.display = 'none';
    camposPersonaJuridica.style.display = 'block';

    document.getElementById('nit').required = true;
    document.getElementById('razonSocial').required = true;

    document.getElementById('cedula').removeAttribute('required');
    document.getElementById('nombre').removeAttribute('required');
    document.getElementById('apellidos').removeAttribute('required');
  }
}
var cedulaInput = document.getElementById('cedula');
var cedulaError = document.getElementById('cedulaError');

cedulaInput.addEventListener('keyup', function() {
  var cedula = cedulaInput.value.trim();

  if (/^[0-9]{1,10}$/.test(cedula)) {
    cedulaError.innerHTML = '';
  } else {
    cedulaError.innerHTML = 'Ingrese una cédula correcta!';
  }
});

cedulaInput.setAttribute("maxlength", "10");
</script>
   <!--VALIDACION CAMPO NOMBRE--> 
  <script>
  var nombreInput = document.getElementById('nombre');
  var nombreError = document.getElementById('nombreError');

nombreInput.addEventListener('keyup', function() {
  var nombre = nombreInput.value.trim();

  if (/^[a-zA-Z\s]{1,30}$/.test(nombre)) {
    nombreError.innerHTML = '';
  } else {
    nombreError.innerHTML = 'Ingrese solo letras!';
  }
});
nombreInput.setAttribute("maxlength", "25");

  </script>


  <!--VALIDACION CAMPO APELLIDOS--> 
  <script>
  var apellidosInput = document.getElementById('apellidos');
var apellidosError = document.getElementById('apellidosError');

apellidosInput.addEventListener('keyup', function() {
  var apellidos = apellidosInput.value.trim();

  if (/^[a-zA-ZñÑ\s]{1,60}$/.test(apellidos)) {
    apellidosError.innerHTML = '';
  } else {
    apellidosError.innerHTML = 'Ingrese solo letras!';
  }
});

apellidosInput.setAttribute("maxlength", "30");

  </script>


  <div class="mb-3 w-100" title="Este campo es obligatorio">
  <label for="exampleInputEmail1" class="form-label fw-semibold">VALOR COMPRA | SERVICIO <span class="text-danger" style="font-size:20px;">*</span></label>
  <input list="" type="text" class="form-control" name="valorcompra" id="valorcompra" value="" required autocomplete="off" pattern="[0-9]+" title="Ingresa solo números" maxlength="11">
  <div id="valorcompraError" style="color: red;" class="fw-bold"></div>
  <div id="valorcompraError2" style="color: red;" class="fw-bold"></div>
  
</div>


<div class="mb-3 w-100" title="Este campo es obligatorio" style="display: none">
  <label for="exampleInputEmail1" class="form-label fw-semibold">FECHA EXPEDICIÓN DATACRÉDITO <span class="text-danger" style="font-size:20px;">*</span></label>
  <input type="date" class="form-control " name="FechaInsercion" id="FechaInsercion" min="2022-05-01" max="<?php echo date('Y-m-d'); ?>">
</div>

<div class="mb-3 w-100" title="Este campo es obligatorio" style="display: none">
  <label for="estado" class="form-label fw-semibold">ESTADO <span class="text-danger" style="font-size:20px;">*</span></label>
  <select class="form-control " name="Estado" id="estado">
    <option value="">Seleccione una opción</option>
    <option value="N">Normal</option>
    <option value="B">Bloqueado</option>
    <option value="S">Suspendido</option>
    <option value="J">Judicial</option>
    <option value="I">Insolvente</option>
    <option value="R">Renovar</option>
  </select>
  <div id="estadoError" style="color: red;" class="fw-bold"></div>
</div>
  <script>
 var estadoInput = document.getElementById('estado');
var estadoError = document.getElementById('estadoError');
 estadoInput.setAttribute("maxlength", "20");

 </script>
  <style>
.formato-ayuda {
  color: gray;
  font-style: italic;
}
</style>

  <div class="mb-3  w-100" style="display: none">
    <label for="exampleInputEmail1" class="form-label fw-semibold" >ADJUNTAR ARCHIVO SÍNTESIS</label>
    <input type="file" class="form-control " name="NombreS" id="NombreS">
  </div>

  <div class="mb-3 w-100" style="display: none">
    <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR ARCHIVO PN</label>
    <input type="file" class="form-control" name="NombrePN" id="NombrePN">
  </div>
  
  <div class="mb-3 w-100">
  <label for="NombreRC" class="form-label fw-semibold">ADJUNTAR RECIBO DE CAJA</label>
  <input type="file" class="form-control" name="NombreRC" id="NombreRC" accept="application/pdf">
  <p class="formato-ayuda2">Debe contener el formato: <strong>RC-(Cédula).pdf o RC-(NIT).pdf</strong></strong></p>
</div>

<div class="mb-3 w-100">
    <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR AUTORIZACIÓN</label>
    <input type="file" class="form-control" name="NombreA" id="NombreA" required>
  </div>




  <div class="mb-3 w-100" title="Este campo es obligatorio">
  <label for="exampleInputEmail1" class="form-label fw-semibold">CONSECUTIVO AUTORIZACIÓN <span class="text-danger" style="font-size:20px;">*</span></label>
  <input type="text" class="form-control" name="consecutivoa" id="consecutivoa" value="" required autocomplete="off">
  <div id="consecutivofError" style="color: red;" class="fw-bold"></div>
  <div id="consecutivofError2" style="color: red;" class="fw-bold"></div>
  <p class="formato-ayuda2">Debe contener el formato: <strong>Autorización-(Cédula).pdf o Autorización-(NIT).pdf</strong></strong></p>
</div>

  <datalist id="Consecutivo">
    <option value="N/A"></option>
  </datalist>

  
  <div class="mb-3 w-100" title="Este campo es obligatorio">
    <label for="cedula" class="form-label fw-semibold">INSPEKTOR <span class="text-danger" style="font-size:20px;">*</span></label>
    <input type="text" class="form-control" name="Inspektor" id="Inspektor" required>
    <div id="InspektorError" style="color: red;" class="fw-bold"></div>
    <div id="Inspektorrror2" style="color: red;" class="fw-bold"></div>
</div>

<script>

var InspektorInput = document.getElementById('Inspektor');
var InspektorError = document.getElementById('InspektorError');

InspektorInput.addEventListener('keyup', function() {
  var Inspektor = InspektorInput.value.trim();

  if (/^[0-9]{1,10}$/.test(Inspektor)) {
    InspektorError.innerHTML = '';
  } else {
    InspektorError.innerHTML = 'Ingrese un número de INSPEKTOR correcto!';
  }
});

InspektorInput.setAttribute("maxlength", "10");

  $(document).ready(function() {
    $('#consecutivoa').change(function() {
      if ($(this).val().toLowerCase() === 'n/a') {
        $('#NombreA').val('');
        $('#NombreA').attr('disabled', true);
      } else {
        $('#NombreA').attr('disabled', false);
      }
    });
  });

  </script>





  <datalist id="Consecutivo">
    <option value="N/A"></option>
  </datalist>

  


<script>
  $(document).ready(function() {
    $('#consecutivoa').change(function() {
      if ($(this).val().toLowerCase() === 'n/a') {
        $('#NombreA').val('');
        $('#NombreA').attr('disabled', true);
      } else {
        $('#NombreA').attr('disabled', false);
      }
    });
  });

  $(document).ready(function() {
    $('#consecutivoa').change(function() {
      if ($(this).val().toLowerCase() === 'n/a') {
        $('#contrato').val('');
        $('#contrato').attr('disabled', true);
      } else {
        $('#contrato').attr('disabled', false);
      }
    });
  });



  </script>

      <div>
      <button onclick="return confirmar()" id="agregar" type="submit" class="btn btn-primary" name="btnregistrar" value="ok" style="background-color: #005E56;" name="registrar">Registrar</button>
      </div>
      <script>
         @if(session('showLoadingAlert'))
        Swal.fire({
            icon: 'info',
            title: 'Cargando',
            text: 'Enviando al generador de consulta...',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            },
            didOpen: () => {
                setTimeout(() => {
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Enviado correctamente!',
                        html: 'Se envió correctamente al encargado de <strong>Talento Humano</strong>.<br><br>El registro será visible cuando el generador de consulta adjunte la información!',
                        showConfirmButton: true,
                        confirmButtonColor: '#005E56'
                    });
                }, 2000);
            }
        });
    @endif
      $('button[name="btnregistrar"]').on('click', function() {
        if ($('#cedula').val() === '') {
            $('#cedula').css('background-color', 'mistyrose');
            $('#cedula').attr('placeholder', 'Obligatorio');
        }
        if ($('#nombre').val() === '') {
            $('#nombre').css('background-color', 'mistyrose');
            $('#nombre').attr('placeholder', 'Obligatorio');
        }
        if ($('#Agencia').val() === '') {
            $('#Agencia').css('background-color', 'mistyrose');
            $('#Agencia').attr('placeholder', 'Obligatorio');
        }
        if ($('#nit').val() === '') {
            $('#nit').css('background-color', 'mistyrose');
            $('#nit').attr('placeholder', 'Obligatorio');
        }
        if ($('#razonSocial').val() === '') {
            $('#razonSocial').css('background-color', 'mistyrose');
            $('#razonSocial').attr('placeholder', 'Obligatorio');
        }
        if ($('#apellidos').val() === '') {
            $('#apellidos').css('background-color', 'mistyrose');
            $('#apellidos').attr('placeholder', 'Obligatorio');
        }
        if ($('#cuenta').val() === '') {
            $('#cuenta').css('background-color', 'mistyrose');
            $('#cuenta').attr('placeholder', 'Obligatorio');
        }
        if ($('#estado').val() === '') {
            $('#estado').css('background-color', 'mistyrose');
            $('#estado').attr('placeholder', 'Obligatorio');
        }
        if ($('#consecutivoa').val() === '') {
            $('#consecutivoa').css('background-color', 'mistyrose');
            $('#consecutivoa').attr('placeholder', 'Obligatorio');
        }
    });
    
    $('#cedula, #nombre, #apellidos, #score, #cuenta, #agencia, #estado, #consecutivoa').on('input', function() {
        if ($(this).val() !== '') {
            $(this).css('background-color', '');
            $(this).attr('placeholder', '');
        }
    });
    
   
    </script>
    
    </form>
    {{-- FECHA --}}
    <div class="col-9">
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
          <th scope="col">TIPO</th>
          <th class="" scope="col">NIT</th>
          <th class="" scope="col">RAZÓN SOCIAL</th>
          <th class="" scope="col">CÉDULA</th>
          <th class="" scope="col">NOMBRE</th>
          <th class="" scope="col">APELLIDOS</th>
          <th class="" scope="col">AGENCIA</th>
          <th scope="col">VALOR SERVICIO</th>
          <th scope="col">VALOR ACUMULADO</th>
          <th scope="col">RECIBO CAJA</th>
          <th scope="col">A</th>
          <th scope="col">ID</th>
          <th scope="col">FECHA GNR</th>
          <th scope="col">FECHA CORREO</th>
          <th scope="col">INSPEKTOR</th>
          <th scope="col">OBSERVACIONES</th>
          <th style="width: 77px"></th>
        </tr> 
      </thead> 
      <tbody class="table-group-divider">
        
      </tbody>
    </table>
        
      

        <script>
              //VALIDACION REGISTRO
      function validateForm2() {
    
    //Nombre
    var nombreInput = document.getElementById('nombre3');
    var nombreError2 = document.getElementById('nombreError3');
    
    if (!/^[a-zA-Z\sñÑ]+$/u.test(nombreInput.value)) {   
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'El campo NOMBRE debe contener solo caracteres alfabéticos!',
        confirmButtonColor: '#005E56'
      });
      nombreError2.textContent = 'Ingrese solo letras!';
      return false;
    }
    
    //Apellidos
    var apellidosInput = document.getElementById('apellidos3');
    var apellidosError2 = document.getElementById('apellidosError3');
    
    if (!/^[a-zA-Z\sñÑ]+$/u.test(apellidosInput.value)) {   
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'El campo APELLIDOS debe contener solo caracteres alfabéticos!',
        confirmButtonColor: '#005E56'
      });
      
      apellidosError2.textContent = 'Ingrese solo letras!';
      return false;
    }

      var consecutivofInput = document.getElementById('consecutivof33');
        var consecutivofError2 = document.getElementById('consecutivofError2');
        
        if (!/^\d{0,10}$|^N\/A$/i.test(consecutivofInput.value)) {   
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'El campo CONSECUTIVO debe contener dígitos numéricos ó N/A!',
            confirmButtonColor: '#005E56'
          });
          
          consecutivofError2.textContent = '';
          consecutivofInput.focus();
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
  "ajax": "{{ route('datatable.directorproovedor') }}",
  "columns": [
    {
      data: null,
      title: '#',
      render: function (data, type, row, meta) {
        return meta.row + 1;
      }
    },
    {data: 'TipoProveedor'},
    {data: 'NIT'},
    {data: 'RazonSocial'},
    {data: 'Cedula'},
    {data: 'Nombre'},
    {data: 'Apellidos'},
    {data: 'Agencia'},
    {data: 'ValorCompra'},
    {data: 'ValorAcumulado'},
    {
  data: 'NombreRC',
  render: function(data, type, row) {
    if (type === 'display') {
      if (data === 'Vacío') {
        return '';
      } else {
        return '<a href="Storage/files/rc/' + data + '" download><img src="img/pdf.png" title="'+data+'" style="height: 2.5rem"></a>';
      }
    }
    return data;
  }
},
{data: 'NombreA',
      "render": function(data, type, row) {
        if (type === 'display') {
          if (data === 'Vacío') {
            return '';
          }else{
          return '<a href="Storage/files/autorizacion/' + data + '" download><img src="img/pdf.png" style="height: 2.5rem"></a>';
          }
        }
        return data;
      }
    },
    {data: 'ConsecutivoA'},
    {  data: 'FechaInsercion',
  render: function(data, type, row) {
    var html = '';
    var fecha_insercion = new Date(data);

    var fecha_actual = new Date();
    var diferencia = Math.floor((fecha_actual - fecha_insercion) / (1000 * 60 * 60 * 24));

    if (parseInt(row.Consulta) === 1 && diferencia > 180) {
  html += data + '<span class="text-danger fw-bold blink" style="font-size: 20px;"><br><span style="background-color: yellow;">RENOVAR</span></span>';
} else if (diferencia > 180) {
  html += data + '<span class="text-danger fw-bold blink" style="font-size: 20px;"><br>VENCIDO</span>';
}else if (diferencia <= 175 && diferencia > 179) {
  html += data + '<span class="text-danger fw-bold blink" style="font-size: 20px;"><br><span style="background-color: yellow;">Pronto a vencerse en ' + (diferencia + 1) + ' días</span>';
} else if (diferencia === 179) {
  html += data + '<span class="text-danger fw-bold blink" style="font-size: 20px;"><br><span style="background-color: yellow;">Se vence en 2 dias</span>';
} else if (diferencia === 180) {
  html += data + '<span class="text-danger fw-bold blink" style="font-size: 20px;"><br><span style="background-color: yellow;">¡Se vence mañana!</span>';
} else {
  html += data + '<span class="fw-bold" style="color: #1565c0;"><br>Al día</span>';
}

    return html;
  }
},
{data: 'FechaCorreo'},
{data: 'Inspektor'},
{data: 'Observaciones'},
    {    data: null,
      render: function(data, type, row) {
        var id = row.ID; // Obtener el ID de la fila
        var url = "{{ route('crud.updateproveedor', ':id') }}";
        var today = new Date().toISOString().split('T')[0];
        url = url.replace(':id', id);

        var html = '';
var fecha_insercion = new Date(data.FechaInsercion); // Assuming "FechaInsercion" is a property in the "data" object
var fecha_actual = new Date();
var diferencia = Math.floor((fecha_actual - fecha_insercion) / (1000 * 60 * 60 * 24));
function toggleCheckbox() {
    var checkbox = document.getElementById("Consulta");
    checkbox.checked = !checkbox.checked;
}
if(row.Consulta == 1){
  html
}
else if (diferencia > 180) {
  html += `
  <div class="mb-3 ">
      <label for="label" id="izquierda2" class="form-label fw-bold" style="margin-left: -70%">RECIBO DE CAJA</label>
      <input type="number" class="form-control" name="recibo" id="recibo" value="" max="999999999999">
      <input type="hidden" name="cuenta" value="">
  </div>
  
  <div class="mb-3 w-100 text-start" title="Datacredito vencido!">
    <input type="checkbox" id="Consulta" name="Consulta" value="1" style="width: 25px; height: 20px;">
    <label for="Consulta" class="fw-semibold" style="font-size: 25px" onclick="toggleCheckbox()">SOLICITAR CONSULTA</label>
    </div>`;
} 
      var deleteButton = '<a onclick="showUnauthorizedMessage()" href="#" type="" class="btn btn-small btn-danger" name="eliminar" value="ok"><i class="fa-solid fa-trash"></i></a>';
      if(data.TipoProveedor== 'PN'){
      var editButton = `<a href="" id="modalLink_${id}" type="submit" class="btn btn-small btn-warning edit-button edit" data-bs-toggle="modal" data-bs-target="#modalEditar_${id}" data-id="${id}" style="margin-right: "><i class="fa-regular fa-pen-to-square"></i></a>
                  <div class="modal fade" id="modalEditar_${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content" style="color: black">
                        <button type="button" data-bs-dismiss="modal" class="btn-close p-3" aria-label="Close"></button>
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                          <h1 class="modal-title text-center" id="modificar" style="color: black">MODIFICAR PN</h1>
                        </div>
                        <hr>
                        <div class="modal-body">
                          <form action="`+url+`" class="text-center" method="POST" enctype="multipart/form-data" id="formulario" onsubmit="return validateForm2()">
                            @csrf
                       
              <div class="mb-3">
                <label for="cedula2" id="" class="form-label fw-bold" value="" style="margin-left: -85%">CÉDULA</label>
                <input type="text" class="form-control" name="cedula2" id="cedula2" value="${row.Cedula}" readonly style="background-color: #EBEBEB; cursor: not-allowed;>
                <input type="hidden" name="cedula3"  value="">
              </div>
  
              <div class="mb-3">
                <label for="nombre3" id="izquierda3" class="form-label fw-bold">NOMBRE</label>
                <input type="text" class="form-control" id="nombre3" name="nombre3" value="${row.Nombre}" maxlength="30">
                <div id="nombreError3" style="color: red;" class="fw-bold"></div>
              </div>
        
              
              
              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda6" class="form-label fw-bold">APELLIDOS</label>
                  <input type="text" class="form-control" id="apellidos3" name="apellidos3" value="${row.Apellidos}" maxlength="60" oninput="this.value = this.value.toUpperCase()">
                  <div id="apellidosError3" style="color: red;" class="fw-bold"></div>
              </div>
  
              <!--Label5-->
              <div class="mb-3">
                  <label for="click" id="izquierda7" class="form-label fw-bold">AGENCIA</label>
                  <input list="agencia" type="text" class="form-control" id="agencia3" name="agencia3" value="${row.Agencia}" maxlength="20" autocomplete="off">
                  <div id="agenciaError3" style="color: red;" class="fw-bold"></div>
              </div>

              <div class="mb-3">
                  <label for="click" id="" style="margin-left: -72%" class="form-label fw-bold">VALOR SERVICIO</label>
                  <input list="agencia" type="text" class="form-control" id="valorcompra1" name="valorcompra1" value="${row.ValorCompra}" maxlength="20">
                  <div id="agenciaError3" style="color: red;" class="fw-bold"></div>
              </div>

              <div class="mb-3">
                    <label for="label" id="" class="form-label fw-bold" style="margin-left: -53%;">ADJUNTAR RECIBO DE CAJA</label>
                  <input type="file" class="form-control" name="archivo4" id="archivo4" accept="application/pdf" value="">
                  </div>
              
              <div class="mb-3">
                    <label for="label" id="" class="form-label fw-bold" style="margin-left: -53%;">ADJUNTAR AUTORIZACIÓN</label>
                  <input type="file" class="form-control" name="archivo3" id="archivo3" accept="application/pdf" value="">
                  </div>
                     
                  <div class="mb-3">
                <label for="label" id="izquierda11" class="form-label fw-bold" style="margin-left: -48%;">CONSECUTIVO AUTORIZACIÓN</label>
                <input type="text" class="form-control" name="consecutivoa44" id="consecutivoa44" value="${row.ConsecutivoA}" title="Ingresar números o N/A" maxlength="8">
                <div id="consecutivoError3" style="color: red;" class="fw-bold"></div>
              </div>


              <div class="mb-3">
                <label for="cedula2" id="" style="margin-left: -80%" class="form-label fw-bold" value="">INSPEKTOR</label>
                <input type="text" class="form-control" name="Inspektor3" id="Inspektor3" value="${row.Inspektor}">
                <input type="hidden" name="cedula3"  value="">
              </div>
                              
              ${html}

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" href=""  name="editar" class="btn btn-primary" style="background-color: #005E56;">Guardar</button>
              </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>`;
      }else{
        editButton = `<a href="" id="modalNuevoLink${id}" type="submit" class="btn btn-small btn-warning edit-button edit" data-bs-toggle="modal" data-bs-target="#modalNuevo${id}" data-id="${id}" style="margin-right: "><i class="fa-regular fa-pen-to-square"></i></a>
  <div class="modal fade" id="modalNuevo${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content" style="color: black">
        <button type="button" data-bs-dismiss="modal" class="btn-close p-3" aria-label="Close"></button>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <h1 class="modal-title text-center" id="modificar" style="color: black">MODIFICAR PJ</h1>
        </div>
        <hr>
        <div class="modal-body">
          <form action="${url}" class="text-center" method="POST" enctype="multipart/form-data" id="formulario" onsubmit="return validateFormNuevo()">
            @csrf
            <div class="mb-3">
                <label for="cedula2" id="" class="form-label fw-bold" value="" style="margin-left: -91%">NIT</label>
                <input type="text" class="form-control" name="nit2" id="nit2" value="${row.NIT}" readonly style="background-color: #EBEBEB; cursor: not-allowed;>
                <input type="hidden" name="cedula3"  value="">
              </div>
  
              <div class="mb-3">
                <label for="nombre3" id="" class="form-label fw-bold" style="margin-left: -73%">RAZÓN SOCIAL</label>
                <input type="text" class="form-control" id="razonsocial2" name="razonsocial2" value="${row.RazonSocial}" maxlength="30">
                <div id="nombreError3" style="color: red;" class="fw-bold"></div>
              </div>
      
  
              <!--Label5-->
              <div class="mb-3">
                  <label for="click" id="izquierda7" class="form-label fw-bold">AGENCIA</label>
                  <input list="agencia" type="text" class="form-control" id="agencia4" name="agencia4" value="${row.Agencia}" maxlength="20" autocomplete="off">
                  <div id="agenciaError3" style="color: red;" class="fw-bold"></div>
              </div>

              <div class="mb-3">
                  <label for="click" id="" style="margin-left: -72%" class="form-label fw-bold">VALOR SERVICIO</label>
                  <input list="" type="text" class="form-control" id="valorcompra2" name="valorcompra2" value="${row.ValorCompra}" maxlength="20">
                  <div id="agenciaError3" style="color: red;" class="fw-bold"></div>
              </div>

              <div class="mb-3">
                    <label for="label" id="" class="form-label fw-bold" style="margin-left: -53%;">ADJUNTAR RECIBO DE CAJA</label>
                  <input type="file" class="form-control" name="archivo4" id="archivo4" accept="application/pdf" value="">
                  <p class="formato-ayuda2">Debe contener el formato: <strong>RC-(Cédula).pdf o RC-(NIT).pdf</strong></strong></p>
                  </div>
              
              <div class="mb-3">
                    <label for="label" id="" class="form-label fw-bold" style="margin-left: -53%;">ADJUNTAR AUTORIZACIÓN</label>
                  <input type="file" class="form-control" name="archivo3" id="archivo3" accept="application/pdf" value="">
                  <p class="formato-ayuda2">Debe contener el formato: <strong>Autorización-(Cédula).pdf o Autorización-(NIT).pdf</strong></strong></p>
                  </div>
                     
                  <div class="mb-3">
                <label for="label" id="izquierda11" class="form-label fw-bold" style="margin-left: -48%;">CONSECUTIVO AUTORIZACIÓN</label>
                <input type="text" class="form-control" name="consecutivoa33" id="consecutivoa33" value="${row.ConsecutivoA}" title="Ingresar números o N/A" maxlength="8">
                <div id="consecutivoError3" style="color: red;" class="fw-bold"></div>
              </div>


              <div class="mb-3">
                <label for="cedula2" id="" style="margin-left: -80%" class="form-label fw-bold" value="">INSPEKTOR</label>
                <input type="text" class="form-control" name="Inspektor2" id="Inspektor2" value="${row.Inspektor}">
                <input type="hidden" name="cedula3"  value="">
              </div>
              
                ${html}

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  <button type="submit" href=""  name="editar" class="btn btn-primary" style="background-color: #005E56;">Guardar</button>
                </div>
          </form>
        </div>
      </div>
    </div>
  </div>`;

      }
  return editButton + ' ' + deleteButton;

}
  }
  ],


  "lengthMenu": [[1,5], [1,5]],
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

          function confirmar(){
            var respuesta=confirm("POR FAVOR REVISAR LA CÉDULA. LOS CAMBIOS PUEDEN SER IRREVERSIBLES.")
            return respuesta
          }

          function showUnauthorizedMessage() {
  Swal.fire({
    icon: 'error',
    title: '¡Permiso no autorizado!',
    text: 'No tienes permiso para realizar esta acción.',
    confirmButtonColor: '#005E56'
  });
  
  return false;
}

         
        </script>
        
        
    </div>
    
    </div>
   
</div>    


    @endsection
    
 