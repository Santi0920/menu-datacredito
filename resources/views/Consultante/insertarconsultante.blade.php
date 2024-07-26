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

@if (session("correcto2"))
  <div>
  <script>
    Swal.fire
      ({
          icon: 'success',
          title: "{{session('correcto')}}",
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
          confirmButtonColor: '#005E56'

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
<form action="{{route('crud.create2')}}" class="col 3 m-3" method="POST" enctype= "multipart/form-data" onsubmit="return validateForm()">
  <h2 class="p-2 text-secondary text-center"><b>Asociación Datacrédito</b></h2>

 @csrf


  <div class="mb-3 w-100" title="Este campo es obligatorio">
    <label for="cedula" class="form-label fw-semibold">CÉDULA<span class="text-danger" style="font-size:20px;">*</span></label>
    <input type="text" class="form-control" name="Cedula" id="cedula" required>
    <div id="cedulaError" style="color: red;" class="fw-bold"></div>
    <div id="cedulaError2" style="color: red;" class="fw-bold"></div>
</div>

  <!--VALIDACION CAMPO CEDULA-->
  <script>
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

  <div class="mb-3 w-100" title="Este campo es obligatorio">
    <label for="exampleInputEmail1" class="form-label fw-semibold">NOMBRE <span class="text-danger" style="font-size:20px;">*</span></label>
    <input type="text" class="form-control " name="Nombre" id="nombre" required>
    <div id="nombreError" style="color: red;" class="fw-bold"></div>
    <div id="nombreError2" style="color: red;" class="fw-bold"></div>
  </div>
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
nombreInput.setAttribute("maxlength", "30");

  </script>


  <div class="mb-3 w-100" title="Este campo es obligatorio">
    <label for="exampleInputEmail1" class="form-label fw-semibold">APELLIDOS <span class="text-danger" style="font-size:20px;">*</span></label>
    <input type="text" class="form-control " name="Apellidos" id="apellidos" required>
    <div id="apellidosError" style="color: red;" class="fw-bold"></div>
    <div id="apellidosError2" style="color: red;" class="fw-bold"></div>
  </div>

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

apellidosInput.setAttribute("maxlength", "60");

  </script>


  <div class="mb-3 w-100" title="Este campo es obligatorio" style="display: none;">
    <label for="exampleInputEmail1" class="form-label fw-semibold">SCORE <span class="text-danger" style="font-size:20px;">*</span></label>
    <input list="ScoreL" type="text" class="form-control " name="Score" id="score" placeholder="0 - 950" autocomplete="off" value="ok">
    <div id="scoreError" style="color: red;" class="fw-bold"></div>
    <div id="scoreError2" style="color: red;" class="fw-bold"></div>
    <p class="formato-ayuda">Si cuenta con score 0, ingresar <strong>S/E(Sin experiencia)</strong>.</p>

  </div>

  <datalist id="ScoreL">
    <option value="S/E"></option>
  </datalist>


<!--VALIDACION CAMPO SCORE-->
  <script>
var scoreInput = document.getElementById('score');
var reporteInput = document.getElementById('reporte');

scoreInput.addEventListener('keyup', function() {
  var score = scoreInput.value.trim();

  if (/^(0*[0-9]|[0-9][0-9]{0,2}|950|S\/E)$/.test(score)) {
    scoreError.innerHTML = '';
    if (score.toUpperCase() === 'S/E') {
      reporteInput.placeholder = 'EJ: N,D,C,2';
    } else {
      reporteInput.placeholder = 'EJ: N,D,C,2';
    }
  } else {
    scoreError.innerHTML = 'Ingrese un número del 1 al 950 o S/E!';
  }
});


scoreInput.setAttribute("maxlength", "3");

$(document).ready(function() {
$('#score').on('input', function() {
var scoreVal = $(this).val().toUpperCase();
if (scoreVal === 'S/E') {
  $('#NombrePN, #NombreS').val('');
  $('#NombrePN, #NombreS').prop('disabled', true);
  $('#FechaInsercion').prop('disabled', true);
} else {
  $('#NombrePN, #NombreS').prop('disabled', false);
  $('#FechaInsercion').prop('disabled', false);

}
});
});


  </script>


  <div class="mb-3  w-100" style="display: none;">
    <label for="exampleInputEmail1" class="form-label fw-semibold">REPORTE DATACRÉDITO <span class="text-danger" style="font-size:20px; display: none;">*</span></label>
    <input type="text" class="form-control" name="Reporte" id="reporte" placeholder="EJ: N,D,C,2" value="ok">
    <p class="formato-ayuda">Ingresar N = Normal, D = Dudoso Recaudo, C = Cartera Castigada ó 1 - 6 (Si cuenta con Mora).</p>
    <div id="reporteError" style="color: red;" class="fw-bold"></div>
    <div id="reporteError2" style="color: red;" class="fw-bold"></div>
  </div>

 <script>



 var reporteInput = document.getElementById('reporte');
var reporteError = document.getElementById('reporteError');

reporteInput.addEventListener('keyup', function() {
  var reporte = reporteInput.value.trim();

  if (/^[a-zA-Z0-9,]*$/.test(reporte)) {
      reporteError.innerHTML = '';
    } else {
      reporteError.innerHTML = 'Ingresar solo letras, números o comas!';
    }
});
reporteInput.setAttribute("maxlength", "15");
 </script>
  <style>
.formato-ayuda {
  color: gray;
  font-style: italic;
}
.formato-ayuda2 {
  color: gray;
  font-style: normal;
}
</style>


  <div class="mb-3 w-100" title="Este campo es obligatorio">
    <label for="exampleInputEmail1" class="form-label fw-semibold">NÚMERO CUENTA <span class="text-danger" style="font-size:20px;">*</span></label>
    <input list="cuentaL" type="text" class="form-control " name="CuentaAsociada" id="cuenta" required autocomplete="off">
    <p class="formato-ayuda">Si la persona no tiene cuenta, ingresar <strong>N/A(No aplica)</strong>.</p>
    <div id="cuentaError" style="color: red;" class="fw-bold"></div>
    <div id="cuentaError2" style="color: red;" class="fw-bold"></div>
  </div>

  <datalist id="cuentaL">
    <option value="N/A"></option>
  </datalist>

  <!--VALIDACION CAMPO NUMERO DE CUENTA-->
  <script>
var cuentaInput = document.getElementById('cuenta');
var cuentaError = document.getElementById('cuentaError');

cuentaInput.addEventListener('keyup', function() {
  var cuenta = cuentaInput.value.trim();

  if (/^\d{0,10}$|^N\/A$/i.test(cuenta)) {
  cuentaError.innerHTML = '';
} else {
  cuentaError.innerHTML = 'Ingrese solo números o "N/A"!';
}

cuentaInput.setAttribute("maxlength", "7");
});



  </script>


<div class="mb-3 w-100" title="Este campo es obligatorio" style="display: none;">
  <label for="exampleInputEmail1" class="form-label fw-semibold">FECHA EXPEDICIÓN DATACRÉDITO <span class="text-danger" style="font-size:20px;">*</span></label>
  <input type="date" class="form-control " name="FechaInsercion" id="FechaInsercion" min="2022-05-01" max="<?php echo date('Y-m-d'); ?>" value="ok">
</div>

<div class="mb-3 w-100" title="Este campo es obligatorio">
  <label for="estado" class="form-label fw-semibold">ESTADO <span class="text-danger" style="font-size:20px;">*</span></label>
  <select class="form-control " name="Estado" id="estado" required>
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

  <div class="mb-3  w-100" style="display: none;">
    <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR ARCHIVO SÍNTESIS</label>
    <input type="file" class="form-control " name="NombreS" id="NombreS" value="ok">
  </div>

  <div class="mb-3 w-100" style="display: none;">
    <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR ARCHIVO PN</label>
    <input type="file" class="form-control" name="NombrePN" id="NombrePN" value="ok">
  </div>


  <div class="mb-3 w-100">
    <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR FORMATO <span class="text-danger" style="font-size:20px;">*</span></label>
    <input type="file" class="form-control" name="NombreT" id="archivo3">
    <p class="formato-ayuda2">Debe contener el formato: <strong>T1-(Cédula).pdf</strong> o <strong>T2-(Cédula).pdf</strong></p>
  </div>

  <div class="mb-3 w-100" title="Este campo es obligatorio">
  <label for="exampleInputEmail1" class="form-label fw-semibold">CONSECUTIVO FORMATO <span class="text-danger" style="font-size:20px;">*</span></label>
  <input list="Consecutivo" type="text" class="form-control" name="Consecutivof" id="consecutivof" value="" required autocomplete="off">
  <div id="consecutivofError" style="color: red;" class="fw-bold"></div>
  <div id="consecutivofError2" style="color: red;" class="fw-bold"></div>
  <p class="formato-ayuda">Si la persona no tiene T1 ó T2, ingresar N/A(No aplica).</p>
</div>

  <datalist id="Consecutivo">
    <option value="N/A"></option>
  </datalist>



<script>
    var consecutivofInput = document.getElementById('consecutivof');
var consecutivofError = document.getElementById('consecutivofError');

consecutivofInput.addEventListener('keyup', function() {
  var consecutivof = consecutivofInput.value.trim();

  if (!/^\d{0,10}$|^N\/A$/i.test(consecutivof)) {
    consecutivofError.innerHTML = '';
  } else {
    consecutivofError.innerHTML = 'Ingrese un consecutivo correcto!';
  }
});
$(document).ready(function() {
  $('#consecutivof').change(function() {
    if ($(this).val().toLowerCase() === 'n/a') {
      $('#archivo3').val('');
      $('#archivo3').prop('disabled', true);
      $('#NombreA').prop('required', true);
      $('#consecutivoa').prop('required', true);
    } else {
      $('#archivo3').prop('disabled', false);
      $('#NombreA').prop('required', false);
      $('#consecutivoa').prop('required', false);
    }
  });
});

$(document).ready(function() {
  $('#consecutivof').change(function() {
    if ($(this).val().toLowerCase() === 'n/a') {
      $('#archivo3').prop('disabled', true);
      $('#NombreA').prop('required', true);
      $('#consecutivoa').prop('required', true);
      $('#consecutivoa').prop('required', true).off('input').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
      });
    } else {
      $('#archivo3').prop('disabled', false);
      $('#NombreA').prop('required', false);
      $('#consecutivoa').prop('required', false);
            $('#consecutivoa').prop('required', false).val('').off('input').on('input', function() {
        this.value = this.value.replace(!/^[0-9]+$|^N\/A$/, '');
      });
    }
    if($.isNumeric($(this).val())) {
        $("#tipof option[value='N/A']").prop("disabled", false);
        $("#tipof").val("").trigger("change", false);
      } else {
        $("#tipof option[value='N/A']").prop("disabled", false);
      }
  });
});

  $(document).ready(function() {
    $("#consecutivof").on("input", function() {
      if($.isNumeric($(this).val())) {
        $("#tipof option[value='N/A']").prop("disabled", true);
        $("#tipof").val("").trigger("change");
      } else {
        $("#tipof option[value='N/A']").prop("disabled", false);
      }
    });

    $("#consecutivof").on("blur", function() {
      if($(this).val().toUpperCase() === "N/A") {
        $("#tipof").val("N/A").prop("disabled", true);
      } else {
        $("#tipof").prop("disabled", false);
      }
    });
  });
  </script>

<div class="mb-3 w-100" title="Este campo es obligatorio">
  <label for="tipo" class="form-label fw-semibold">TIPO FORMATO <span class="text-danger" style="font-size:20px;">*</span></label>
  <select class="form-control" name="Tipof" id="tipof" required>
    <option value="">Seleccione una opción</option>
    <option value="N/A">N/A</option>
    <option value="T1">Formato T1</option>
    <option value="T2">Formato T2</option>
  </select>
</div>

<div class="mb-3 w-100">
    <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR AUTORIZACIÓN <span class="text-danger" style="font-size:20px;">*</span></label>
    <input type="file" class="form-control" name="NombreA" id="NombreA">
    <p class="formato-ayuda2">Debe contener el formato: <strong>Autorizacion-(Cédula).pdf</strong></strong></p>
  </div>




  <div class="mb-3 w-100" title="Este campo es obligatorio">
  <label for="exampleInputEmail1" class="form-label fw-semibold">CONSECUTIVO AUTORIZACIÓN <span class="text-danger" style="font-size:20px;">*</span></label>
  <input list="Consecutivo" type="text" class="form-control" name="consecutivoa" id="consecutivoa" value="" required autocomplete="off" maxlength="10">
  <div id="consecutivoaError" style="color: red;" class="fw-bold"></div>
  <div id="consecutivoaError2" style="color: red;" class="fw-bold"></div>
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

      var consecutivoaInput = document.getElementById('consecutivoa');
    var consecutivoaError = document.getElementById('consecutivoaError');

    consecutivoaInput.addEventListener('keyup', function() {
      var consecutivoa = consecutivoaInput.value.trim();

      if (/^[0-9]+$|^N\/A$/.test(consecutivoa)) {
        consecutivoaError.innerHTML = '';
      } else {
        consecutivoaError.innerHTML = 'Ingrese un consecutivo correcto!';
      }
    });

    $(document).ready(function() {
      $('#consecutivoa').change(function() {
        if ($(this).val().toLowerCase() === 'n/a') {
          $('#NombreA').val('').prop('disabled', true);
          $('#archivo3').prop('required', true);
          $('#consecutivof').prop('required', true).off('input').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
          });
          $('#tipof').prop('required', true);
        } else {
          $('#NombreA').prop('disabled', false);
          $('#archivo3').prop('required', false);
          $('#consecutivof').prop('required', false).off('input');
          $('#tipof').prop('required', false);
        }
      });
    });






    var reporteInput = document.getElementById('reporte');
    reporteInput.addEventListener('input', function() {
      reporteInput.value = reporteInput.value.toUpperCase();
    });
    var scoreInput = document.getElementById('score');
    scoreInput.addEventListener('input', function() {
    scoreInput.value = scoreInput.value.toUpperCase();
    });

    var cuentaInput = document.getElementById('cuenta');
    cuentaInput.addEventListener('input', function() {
      cuentaInput.value = cuentaInput.value.toUpperCase();
    });

    var consecutivofInput = document.getElementById('consecutivof');
    var tipofSelect = document.getElementById('tipof');

    consecutivofInput.addEventListener('input', function() {
      consecutivofInput.value = consecutivofInput.value.toUpperCase();
    });

    consecutivofInput.addEventListener('keyup', function() {
      var consecutivof = consecutivofInput.value.trim();

      if (/^\d{0,10}$|^N\/A$/i.test(consecutivof)) {
      consecutivofError.innerHTML = '';
    } else {
      consecutivofError.innerHTML = 'Solo ingrese números o "N/A"!';
    }

    });

    consecutivofInput.setAttribute("maxlength", "6");
</script>
      <!-- boton -->
      <div>
        <button onclick="return confirmar()" id="agregar" type="submit" class="btn btn-primary" name="btnregistrar" value="ok" style="background-color: #005E56;" name="registrar">Registrar</button>
      </div>
      <script>
    // function confirmar() {
    //     Swal.fire({
    //         icon: 'info',
    //         title: 'Cargando',
    //         text: 'Por favor, espere...',
    //         allowOutsideClick: false,
    //         showConfirmButton: false,
    //         willOpen: () => {
    //             Swal.showLoading();
    //         },
    //     });

    //       @if(session('showLoadingAlert'))
    //               Swal.fire({
    //                   icon: 'info',
    //                   title: 'Cargando',
    //                   text: 'Enviando al generador de consulta...',
    //                   allowOutsideClick: false,
    //                   showConfirmButton: false,
    //                   willOpen: () => {
    //                       Swal.showLoading();
    //                   },
    //                   didOpen: () => {
    //                       setTimeout(() => {
    //                           Swal.close();
    //                           Swal.fire({
    //                               icon: 'success',
    //                               title: '¡Enviado correctamente!',
    //                               html: 'Se envió correctamente al generador de consulta.<br><br>El registro será visible cuando el generador de consulta adjunte la información!',
    //                               showConfirmButton: true,
    //                               confirmButtonColor: '#005E56'
    //                           });
    //                       }, 2000);
    //                   }
    //               });
    //           @endif
    // }


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
                        html: 'Se envió correctamente al generador de consulta.<br><br>El registro será visible cuando el generador de consulta adjunte la información!',
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
        if ($('#apellidos').val() === '') {
            $('#apellidos').css('background-color', 'mistyrose');
            $('#apellidos').attr('placeholder', 'Obligatorio');
        }
        if ($('#score').val() === '') {
            $('#score').css('background-color', 'mistyrose');
            $('#score').attr('placeholder', 'Obligatorio');
        }
        if ($('#cuenta').val() === '') {
            $('#cuenta').css('background-color', 'mistyrose');
            $('#cuenta').attr('placeholder', 'Obligatorio');
        }
        if ($('#agencia').val() === '') {
            $('#agencia').css('background-color', 'mistyrose');
            $('#agencia').attr('placeholder', 'Obligatorio');
        }
        if ($('#estado').val() === '') {
            $('#estado').css('background-color', 'mistyrose');
            $('#estado').attr('placeholder', 'Obligatorio');
        }
        if ($('#tipof').val() === '') {
            $('#tipof').css('background-color', 'mistyrose');
            $('#tipof').attr('placeholder', 'Obligatorio');
        }
    });

    $('#cedula, #nombre, #apellidos, #score, #cuenta, #agencia, #estado, #tipof').on('input', function() {
        if ($(this).val() !== '') {
            $(this).css('background-color', '');
            $(this).attr('placeholder', '');
        }
    });

    //VALIDACION REGISTRO
      function validateForm() {
        //Cedula
    var cedulaInput = document.getElementById('cedula');
    var cedulaError2 = document.getElementById('cedulaError2');

    if (!/^[0-9]+$/.test(cedulaInput.value)) {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'El campo CÉDULA debe contener solo registros numéricos!',
        confirmButtonColor: '#005E56'
      });
      window.scrollTo({ top: 0, behavior: 'smooth' });
      cedulaError2.textContent = '';
      cedulaInput.focus();
      return false;
    }

    //Nombre
    var nombreInput = document.getElementById('nombre');
    var nombreError2 = document.getElementById('nombreError2');

    if (!/^[a-zA-Z\sñÑ]+$/u.test(nombreInput.value)) {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'El campo NOMBRE debe contener solo caracteres alfabéticos!',
        confirmButtonColor: '#005E56'
      });
      window.scrollTo({ top: 0, behavior: 'smooth' });
      nombreError2.textContent = '';
      nombreInput.focus();
      return false;
    }

    //Apellidos
    var apellidosInput = document.getElementById('apellidos');
    var apellidosError2 = document.getElementById('apellidosError2');

    if (!/^[a-zA-Z\sñÑ]+$/u.test(apellidosInput.value)) {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'El campo APELLIDOS debe contener solo caracteres alfabéticos!',
        confirmButtonColor: '#005E56'
      });

      apellidosError2.textContent = '';
      apellidosInput.focus();
      return false;
    }


    //Núm. de Cuenta
    var cuentaInput = document.getElementById('cuenta');
    var cuentaError2 = document.getElementById('cuentaError2');

    if (!/^\d{0,10}$|^N\/A$/i.test(cuentaInput.value)) {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'El campo NÚMERO DE CUENTA debe contener dígitos numéricos ó N/A!',
        confirmButtonColor: '#005E56'
      });

      cuentaError2.textContent = '';
          cuentaInput.focus();
          return false;
        }

        if (cuentaInput.value.length > 7) {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'El número de cuenta no puede ser mayor a 7 dígitos.',
        confirmButtonColor: '#005E56'
      });

      return false;
    }


        var consecutivofInput = document.getElementById('consecutivof');
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

        var consecutivoaInput = document.getElementById('consecutivoa');
    var consecutivoaError2 = document.getElementById('consecutivoaError2');

    if (!/^[0-9]+$|^N\/A$/.test(consecutivoaInput.value)) {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'El campo CONSECUTIVO AUTORIZACIÓN debe contener solo registros numéricos!',
        confirmButtonColor: '#005E56'
      });
      consecutivoaError2.textContent = '';
      consecutivoaInput.focus();
      return false;
    }
        return true;
      }

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
    <div style="overflow: auto;" class="table-responsive">
        <table id="personas" class="hover table table-striped shadow-lg mt-4 table-bordered table-hover col-md-5">
          <thead class="" style="background-color: #005E56;">
            <tr class="text-white">
              <th class="" scope="col"></th>
              <th class="" scope="col">CÉDULA</th>
              <th class="" scope="col">NOMBRE</th>
              <th class="" scope="col">APELLIDOS</th>
              <th class="" scope="col">OBSERVACIONES</th>
              <th class="" scope="col">CUENTA</th>
              <th class="" scope="col">AGENCIA</th>
              <th class="" scope="col">ESTADO</th>
              <th class="" scope="col">T</th>
              <th class="" scope="col">ID</th>
              <th class="" scope="col">TIPO</th>
              <th class="" scope="col">FECHA GNR</th>
              <th class="" scope="col">INSPEKTOR</th>
              <th scope="col">A</th>
          <th scope="col">ID</th>
          <th scope="col">FECHA CORREO</th>
              <th class="" style="width: 77px"></th>
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
  "ajax": "{{ route('datatable.consultante') }}",
  "columns": [
        {
      data: null,
      title: '#',
      render: function (data, type, row, meta) {
        return meta.row + 1;
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
    {
  data: 'Observaciones',
  render: function(data, type, row) {
    var html = '<span style="font-weight: 700;">' + data + '</span>';
    return html;
  }
},
    {data: 'CuentaAsociada'},
    {
      data: 'Agencia',
      render: function (data, type, row) {
        var agencia = data.charAt(0).toUpperCase() + data.slice(1).toLowerCase();
        return agencia;
      }
    },
    {data: 'Estado'},
    {
  data: 'NombreT',
  render: function(data, type, row) {
    if (type === 'display') {
      var html = '';
      if (row.Tipof === 'T1') {
        if (data === null) {
          return '';
        } else {
          html += '<a href="Storage/files/t1/' + data + '" target="__blank"><img src="img/pdf.png" style="height: 2.5rem"></a>';
        }
      } else if (row.Tipof === 'T2') {
        if (data === null) {
          return '';
        } else {
          html += '<a href="Storage/files/t2/' + data + '" target="__blank"><img src="img/pdf.png" style="height: 2.5rem"></a>';
        }
      }
      return html;
    }
    return data;
  }
},
    {data: 'Consecutivof'},
    {data: 'Tipof'},
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
{data:"Inspektor"},

{data: 'NombreA',
      "render": function(data, type, row) {
        if (type === 'display') {
          if (data === null) {
            return '';
          }else{
          return '<a href="Storage/files/autorizacion/' + data + '" target="__blank"><img src="img/pdf.png" style="height: 2.5rem"></a>';
          }
        }
        return data;
      }
    },
    {data: 'ConsecutivoA'},

    {data: 'FechaCorreo'},
    {    data: null,
      render: function(data, type, row) {
          var today = new Date().toISOString().split('T')[0];
          var id = row.ID;
          var url = "{{ route('crud.update2', ':id') }}";
        url = url.replace(':id', id);

        var html = '';
        var fecha_insercion = new Date(data.FechaInsercion); // Assuming "FechaInsercion" is a property in the "data" object
        var fecha_actual = new Date();
        var diferencia = Math.floor((fecha_actual - fecha_insercion) / (1000 * 60 * 60 * 24));
        function toggleCheckbox() {
            var checkbox = document.getElementById("Consulta");
            checkbox.checked = !checkbox.checked;
        }

        function toggleCheckbox2() {
            var checkbox2 = document.getElementById("Tipoasociado");
            checkbox2.checked = !checkbox2.checked;
        }
    console.log(url)
      var deleteButton = '<a onclick="showUnauthorizedMessage()" href="#" type="" class="btn btn-small btn-danger" name="" value=""><i class="fa-solid fa-trash"></i></a>';
      var editButton = `<a href="" id="modalLink_${id}" type="submit" class="btn btn-small btn-warning edit-button edit" data-bs-toggle="modal" data-bs-target="#modalEditar_${id}" data-id="${id}" style="margin-right: "><i class="fa-regular fa-pen-to-square"></i></a>
    <div  class="modal fade" id="modalEditar_${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                      <div class="modal-content" style="color: black">
                        <button type="button" data-bs-dismiss="modal" class="btn-close p-3 text-dark" aria-label="Close"></button>
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                          <h1 class="modal-title text-center" id="modificar" style="color: black">MODIFICAR</h1>
                        </div>
                        <hr>
                        <div class="modal-body">
                          <form action="`+url+`" class="text-center" method="POST" enctype="multipart/form-data" id="formulario" onsubmit="return validateForm2()">
                            @csrf
                            <!-- Resto del contenido del modal -->
              <div class="mb-3">
                <label for="cedula2" id="izquierda7" class="form-label fw-bold" value="">CÉDULA</label>
                <input type="text" class="form-control" name="cedula2" id="cedula2" readonly value="${row.Cedula}" style="background-color: #EBEBEB; cursor: not-allowed;">
                <input type="hidden" name="cedula3"  value="">
              </div>

              <div class="mb-3">
                <label for="nombre3" id="izquierda3" class="form-label fw-bold">NOMBRE</label>
                <input type="text" class="form-control" id="nombre3" name="nombre3" value="${row.Nombre}" maxlength="30" required>
                <div id="nombreError3" style="color: red;" class="fw-bold"></div>
              </div>



              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda6" class="form-label fw-bold">APELLIDOS</label>
                  <input type="text" class="form-control" id="apellidos3" name="apellidos3" value="${row.Apellidos}" maxlength="60" oninput="this.value = this.value.toUpperCase()" required>
                  <div id="apellidosError3" style="color: red;" class="fw-bold"></div>
              </div>


              <div class="mb-3" style="display: none;>
                  <label for="label"  id="izquierda" class="form-label fw-bold">SCORE</label>
                  <input type="text" class="form-control" id="score3" name="score3" value="${row.Score}" maxlength="3" required>
                  <div id="scoreError3" style="color: red;" class="fw-bold"></div>
                  <p class="formato-ayuda">Si cuenta con score 0, ingresar <strong>S/E(Sin experiencia)</strong>.</p>
              </div>

              <div class="mb-3" style="display: none;>
                  <label for="exampleInputEmail1" id="izquierda4" class="form-label fw-bold">REPORTE DATACRÉDITO</label>
                  <input type="text" class="form-control" id="reporte3" name="reporte3" maxlength="15" value="${row.Reporte}" oninput="this.value = this.value.toUpperCase()">
                  <div id="reporteError3" style="color: red;" class="fw-bold"></div>
                  <p class="formato-ayuda">Ingresar N = Normal, D = Dudoso Recaudo, C = Cartera Castigada ó 1 - 6 (Si cuenta con Mora).</p>
              </div>

              <div class="mb-3 ">
                  <label for="label" id="izquierda2" class="form-label fw-bold">CUENTA ASOCIADA</label>
                  <input type="text" class="form-control" name="cuenta3" id="cuenta3" value="${row.CuentaAsociada}" >
                  <input type="hidden" name="cuenta" value="">
              </div>

              <!--Label5-->
              <div class="mb-3">
                  <label for="click" id="izquierda7" class="form-label fw-bold">AGENCIA</label>
                  <input list="agencia" type="text" class="form-control" id="agencia3" name="agencia3" value="${row.Agencia}" maxlength="20" required autocomplete="off" style="background-color: #EBEBEB; cursor: not-allowed;" readonly>
                  <div id="agenciaError3" style="color: red;" class="fw-bold"></div>
              </div>

              <div class="mb-3" style="display: none;>
                  <label for="exampleInputEmail1" id="izquierda" class="form-label fw-bold">FECHA</label>
                  <input type="date" class="form-control" name="fecha3" id="fecha3" min="2022-08-01" max="`+today+`" value="${row.FechaInsercion}" required>
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

              <div class="mb-3" style="display: none;>
                <label for="exampleInputEmail1" id="izquierda5" class="form-label fw-bold">ADJUNTAR ARCHIVO SINTESIS</label>
                <input type="file" class="form-control" name="archivo22" id="archivo22" accept="application/pdf" value="${row.NombreS}">
              </div>

                <div class="mb-3" style="display: none;>
                    <label for="label" id="izquierda8" class="form-label fw-bold">ADJUNTAR ARCHIVO PN</label>
                  <input type="file" class="form-control" name="archivo11" id="archivo11" accept="application/pdf" value="${row.NombrePN}">
                  </div>

                  <div class="mb-3">
                    <label for="label" id="izquierda10" class="form-label fw-bold">ADJUNTAR FORMATO</label>
                  <input type="file" class="form-control" name="archivo33" id="archivo33" accept="application/pdf" value="${row.NombreT}">
                  <p class="formato-ayuda2">Debe contener el formato: <strong>T1-(Cédula).pdf</strong> o <strong>T2-(Cédula).pdf</strong></p>
                  </div>

                  <div class="mb-3">
                    <label for="label" id="izquierda11" class="form-label fw-bold">CONSECUTIVO FORMATO</label>
                  <input type="text" class="form-control" name="consecutivof33" id="consecutivof33" value="${row.Consecutivof}" oninput="validarCampos()" onkeyup="this.value = this.value.toUpperCase();">
                  </div>

                  <div class="mb-3 w-100">
                      <label for="tipo" class="form-label fw-bold" id="izquierda16">TIPO FORMATO</label>
                      <select class="form-control" name="tipof3" id="tipof3" required oninput="validarCampos()" required>
                        <option value="">Seleccione una opción</option>
                        <option value="N/A" ${row.Tipof === 'N/A' ? 'selected' : ''}>N/A</option>
                        <option value="T1" ${row.Tipof === 'T1' ? 'selected' : ''}>Formato T1</option>
                        <option value="T2" ${row.Tipof === 'T2' ? 'selected' : ''}>Formato T2</option>
                      </select>
                    </div>

                    <div class="mb-3">
                    <label for="label" id="" class="form-label fw-bold" style="margin-left: -53%;">ADJUNTAR AUTORIZACIÓN</label>
                  <input type="file" class="form-control" name="archivo3" id="archivo3" accept="application/pdf" value="">
                  <p class="formato-ayuda2">Debe contener el formato: <strong>Autorizacion-(Cédula).pdf</strong></strong></p>
                  </div>

                  <div class="mb-3">
  <label for="label" id="izquierda11" class="form-label fw-bold" style="margin-left: -47%;">CONSECUTIVO AUTORIZACIÓN</label>
  <input type="text" class="form-control" name="consecutivoa33" id="consecutivoa33" value="${row.ConsecutivoA}" title="Ingresar números o N/A" maxlength="8">
  <div id="consecutivoError3" style="color: red;" class="fw-bold"></div>
</div>

<div class="mb-3">
                <label for="cedula2" id="" style="margin-left: -80%" class="form-label fw-bold" value="">INSPEKTOR</label>
                <input type="text" class="form-control" name="Inspektor2" id="Inspektor2" value="${row.Inspektor}">
                <input type="hidden" name="cedula3"  value="">
              </div>

<div class="mb-3 ">
      <label for="label" id="izquierda2" class="form-label fw-bold" style="margin-left: -70%">RECIBO DE CAJA</label>
      <input type="number" class="form-control" name="recibo" id="recibo" value="" max="999999999999">
      <input type="hidden" name="cuenta" value="">
  </div>

  <div class="mb-3 w-100 text-start" title="">
    <input type="checkbox" id="Tipoasociado" name="Tipoasociado" value="1" style="width: 25px; height: 20px;">
    <label for="Consulta" class="fw-semibold" style="font-size: 25px" onclick="toggleCheckbox2()">SOLICITAR CRÉDITO</label>
</div>


                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  <button type="submit" href=""  name="editar" class="btn btn-primary" style="background-color: #005E56;">Guardar</button>
                </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>`;

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







function validarCampos() {
  var consecutivof33 = document.getElementById('consecutivof33');
  var archivo33 = document.getElementById('archivo33');
  var tipof3 = document.getElementById('tipof3');

  if (consecutivof33.value === 'N/A') {
    archivo33.disabled = true;
    archivo33.value = '';
    tipof3.value = 'N/A';
    tipof3.disabled = true;
  } else {
    archivo33.disabled = false;
    tipof3.disabled = false;

    var naOption = tipof3.querySelector("option[value='N/A']");
    naOption.disabled = (consecutivof33.value !== '');
  }
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

