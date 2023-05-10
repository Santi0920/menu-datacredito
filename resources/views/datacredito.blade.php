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
    <div class="contenedor2">
      <div class="agregar2">
        <a href="datacredito.php" class="btn btn-primary" style="font-size: 35px;font-family: 'Montserrat', sans-serif; font-weight: bold;" data-bs-toggle="modal" data-bs-target="#exampleModal3">
          <span style="margin-bottom: 30px; margin-top: 20px;">V1</span>
        </a>
      </div>
    </div>
    <script>
    const agregar2 = document.querySelector('.agregar2 a');
    
    // Verificar si hay un valor guardado en localStorage
    if (localStorage.getItem('rebote-detenido') === 'true') {
      agregar2.style.animationPlayState = 'paused';
    }
    
    // Agregar evento de clic al botón "agregar2"
    agregar2.addEventListener('click', function() {
      agregar2.style.animationPlayState = 'paused';
      localStorage.setItem('rebote-detenido', 'true');
    });
    </script>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-semibold text-center"  style="font-size: 40px; margin-left: 180px;" id="exampleModalLabel3">VERSIÓN #1</h5>
            <button type="button" data-bs-dismiss="modal" class="btn-close p-3" aria-label="Close"></button>
          </div>
          <div class="modal-body texto-justificado">
            <!-- Contenido del modal -->
            <p style="font-size: 20px;" class="text-justify">
            Esta  aplicación fue creada para el control en la generación de datacréditos.
            </p>
            <ul style="font-size: 20px; text-justify:distribute-all-lines" class="">
              <li>El datacrédito tiene vigencia de <strong>180 días/6 meses</strong>.</li>
              <li>El sistema genera advertencias una vez los documentos estén <strong>vencidos</strong>.</li>
              <li>El sistema genera <strong>tickets</strong> con la información de la persona para su posterior impresión.</li>
              <li>El sistema es compatible con impresora <strong>LabelWriter 450</strong>  con tickets referencia: <strong>30336 1 in x 2-1/8 in</strong> con escala <strong>35</strong>.</li>
            </ul>
          </div>
          <div class="modal-footer">
          <h5 class="fw-semibold text-secondary" style="font-size: 35px; margin-right: 320px;">Abr 2023</h5>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-size: 20px;">Cerrar</button>
    
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal para agregar consultante -->
    <form action="{{route("rol.store")}}" class="text-center" id="" method="POST" enctype="multipart/form-data" onsubmit="validateForm3()">
      @csrf
        <div class="container">
             <div class="agregar">
                <a href="datacredito.php" type="button" class="" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="fa-solid fa-plus icono"></i></a>
            </div>
        </div>
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                <button type="button" data-bs-dismiss="modal" class="btn-close p-3" aria-label="Close"></button>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        
                        <h1 class="modal-title text-center fw-semibold" id="modificar">AGREGAR ROL</h1>
    
                     </div>
                    <hr>
    
                    <div class="modal-body">
        
                    
                    <div style="max-height: 12.5rem; overflow: auto;">
                    <table class="table">
                        <thead class="" style="background-color: #005E56;">
                          <tr class="text-white">
                            
                            <th scope="col">USUARIO</th>
                            <th>ROL</th>
                            {{-- <th>EMAIL</th> --}}
                            <th></th>
                            <th></th>
                            <th></th>
                            
    
                            
                          </tr>
                          </thead>
                        
    
                          <tbody>
                            @foreach($datos2 as $item)
                            <tr>
                            
                            <td title="{{ $item->email }}">{{$item->name}}</td>
                            <td title="{{ $item->email }}">{{$item->rol}}</td>
                            <td><a onclick="return eliminar()" type="submit" href="{{route("rol.activo",$item->id)}}" name="activar" id="activar" class="btn btn-small btn-warning">Activar</a></td>
                            <td><a onclick="return eliminar()" type="submit" href="{{route("rol.desactivar",$item->id)}}" name="desactivar" id="desactivar" class="btn btn-small btn-secondary">Desactivar</a></td>
                            <td><a onclick="return eliminar()" href="{{route("rol.delete",$item->id)}}" type="submit" class="btn btn-small btn-danger" name="eliminar" value="ok"><i class="fa-solid fa-trash"></i></a></td>
                          </tr>
                            @endforeach
                        
                          </tbody>
                    </table>
                    </div>
                   <hr>
                <!--Label1-->  
                <div class="mb-3 mt-3">
                    <label for="label" id="consul1" class="form-label fw-bold" value="">NOMBRE COMPLETO</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                    <div id="nameError" style="color: red;" class="fw-bold"></div>
                </div>
                <!--VALIDACION CAMPO USUARIO--> 
                <script>
                var usernameInput = document.getElementById('name');
                var usernameError = document.getElementById('nameError');
    
                usernameInput.addEventListener('keyup', function() {
                  var username = usernameInput.value.trim();
    
                  if (/^[a-zA-Z\sñÑ]+$/u.test(username)) {
                    usernameError.innerHTML = '';
                  } else {
                    usernameError.innerHTML = 'El nombre de usuario solo debe contener letras';
                  }
                });
                usernameInput.setAttribute("maxlength", "20");

                </script>

  
         
                <!--Label2--> 
                <div class="mb-3">
                    <label for="label" id="consul2" class="form-label fw-bold">CORREO ELECTRÓNICO</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                    <div id="emailError" style="color: red;" class="fw-bold"></div>
                </div>
                <script>
                  var correoInput = document.getElementById('email');
                  var correoError = document.getElementById('emailError');
                  var correo = correoInput.value.trim();
    
                correoInput.setAttribute("maxlength", "40");
                </script>
                
                <div class="mb-3">
                    <label for="exampleInputEmail1" id="consul3" class="form-label fw-bold">CONTRASEÑA</label>
                    <input type="password" class="form-control " name="password" id="password" required>
                    <div id="contraseñaError" style="color: red;" class="fw-bold"></div>
                </div>
                <script>
                  var contraseñaInput = document.getElementById('password');
                  var contraseñaError = document.getElementById('contraseñaError');
    
                  contraseñaInput.addEventListener('keyup', function() {
                    var contraseña = contraseñaInput.value.trim();
    
                    if (/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,12}$/.test(contraseña)) {
                      contraseñaError.innerHTML = '';
                    } else {
                      contraseñaError.innerHTML = 'La contraseña debe tener entre 8 y 12 caracteres y contener al menos una letra, un número y un símbolo';
                    }
                  });
    
                  contraseñaInput.setAttribute("maxlength", "12");
                </script>
    
    
                <!--Label3-->
                <div class="mb-3">
                    <label for="label"  id="consul4" class="form-label fw-bold">CONFIRMAR CONTRASEÑA</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                    <div id="ccontraseñaError" style="color: red;" class="fw-bold"></div>
                    <div id="ccontraseñaSucces" style="color: green;" class="fw-bold"></div>
                </div>
                <script>
                  var ccontraseñaInput = document.getElementById('password_confirmation');
                  var ccontraseñaError = document.getElementById('ccontraseñaError');
                  var ccontraseñaSucces = document.getElementById('ccontraseñaSucces');
                  ccontraseñaInput.addEventListener('keyup', function() {
                  var contraseña = contraseñaInput.value.trim();
                  var ccontraseña = ccontraseñaInput.value.trim();
    
                  if (contraseña === ccontraseña) {
                    ccontraseñaError.innerHTML = '';
                    ccontraseñaSucces.innerHTML = 'Las contraseñas si coinciden!';
                  } else {
                    ccontraseñaError.innerHTML = 'Las contraseñas no coinciden!';
                    ccontraseñaSucces.innerHTML = '';
                  }
                  });
                </script>

              <div class="mb-3 w-100">
                <label for="estado" class="form-label fw-bold" style="margin-left: -93%;">ROL<span class="text-danger" style="font-size:20px;"></label>
                <select class="form-control " name="rol" id="rol" required>
                  <option value="">Seleccione una opción</option>
                  <option value="Proveedor">Consultante</option>
                  <option value="Asociacion">Asociación</option>
                  <option value="Credito">Credito</option>
                  <option value="Proveedor">Proveedor</option>
                </select>
              </div>
            </div>
            <div class="text-center p-2">
            <button  type="submit" class=" btn btn-primary w-50" name="btnregistrar2" style="background-color: #005E56;">Registrar</button>
            </div>
                
                </div>
            </div>
        </div>
        </form>
  
    
    <div class="container-fluid row p-5 mb-1">
    <form action="{{route("crud.create")}}" class="col 3" method="POST" enctype= "multipart/form-data" onsubmit="return validateForm()">
      <h2 class="p-3 text-secondary text-center"><b>Datacrédito</b></h2>
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
      var nombreInput = document.getElementById('Nombre');
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
    
     
      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="exampleInputEmail1" class="form-label fw-semibold">SCORE <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Score" id="score" required placeholder="0 - 950">
        <div id="scoreError" style="color: red;" class="fw-bold"></div>
        <div id="scoreError2" style="color: red;" class="fw-bold"></div>
        <p class="formato-ayuda">Si cuenta con score 0, ingresar S/E(Sin experiencia).</p>
        
      </div>
     

    <!--VALIDACION CAMPO SCORE--> 
      <script>
    var scoreInput = document.getElementById('score');
    var reporteInput = document.getElementById('reporte');
    
    scoreInput.addEventListener('keyup', function() {
      var score = scoreInput.value.trim();
    
      if (/^(0*[1-9]|[1-9][0-9]{0,2}|950|S\/E)$/.test(score)) {
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
    } else {
      $('#NombrePN, #NombreS').prop('disabled', false);
    }
  });
});


      </script>
    
    
      <div class="mb-3  w-100">
        <label for="exampleInputEmail1" class="form-label fw-semibold">REPORTE DATACRÉDITO <span class="text-danger" style="font-size:20px; display: none;">*</span></label>
        <input type="text" class="form-control" name="Reporte" id="reporte" placeholder="EJ: N,D,C,2">
        <p class="formato-ayuda">Ingresar N = Normal, D = Dudoso Recaudo, C = Cartera Castigada ó 1 - 6 (Si cuenta con Mora).</p>
        <div id="reporteError" style="color: red;" class="fw-bold"></div>
        <div id="reporteError2" style="color: red;" class="fw-bold"></div>
      </div>
      <!--script para vaildar el estado !-->
     <script>
      $(document).ready(function(){
  $('#score').on('input', function(){
    if($(this).val().toUpperCase() === 'S/E'){
      $('#reporte').prop('disabled', true);
    }else{
      $('#reporte').prop('disabled', false);
    }
  });
});

$(document).ready(function() {
  $('#score').on('input', function() {
    if ($(this).val() > 0) {
    
      $('#reporte').prop('required', true);
    } else {
  
      $('#reporte').prop('required', false);
    }
  });
});
    
      
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
    </style>
      
      
      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="exampleInputEmail1" class="form-label fw-semibold">NÚMERO CUENTA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="CuentaAsociada" id="cuenta" required> 
        <p class="formato-ayuda">Si la persona no tiene cuenta, ingresar N/A(No aplica).</p>
        <div id="cuentaError" style="color: red;" class="fw-bold"></div>
        <div id="cuentaError2" style="color: red;" class="fw-bold"></div>
      </div>
    
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
    
    $(function() {
      $.ajax({
        url: '../ResourcesAll/json/cuenta.json',
        dataType: 'json',
        success: function(data) {
          $('#cuenta').autocomplete({
            source: data.cuenta
          });
        }
      });
    });
    
      </script>
    
    
      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="exampleInputEmail1" class="form-label fw-semibold">AGENCIA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Agencia" id="Agencia" required >
        <div id="agenciaError" style="color: red;" class="fw-bold"></div>
        <div id="agenciaError2" style="color: red;" class="fw-bold"></div>
      </div>
    
    
      <!--VALIDACION CAMPO AGENCIA--> 
      <script>
    var agenciaInput = document.getElementById('agencia');
    var agenciaError = document.getElementById('agenciaError');
    
    agenciaInput.addEventListener('keyup', function() {
      var agencia = agenciaInput.value.trim();
    
      if (/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/.test(agencia)) {
        agenciaError.innerHTML = '';
      } else {
        agenciaError.innerHTML = 'Ingrese solo letras!';
      }
    });
    
    agenciaInput.setAttribute("maxlength", "20");
    
    $(function() {
      $.ajax({
        url: 'ResourcesAll/agencia.json',
        dataType: 'json',
        success: function(data) {
          $('#Agencia').autocomplete({
            source: data.Agencia
          });
        }
      });
    });
      </script>
    
    <div class="mb-3 w-100" title="Este campo es obligatorio">
      <label for="exampleInputEmail1" class="form-label fw-semibold">FECHA EXPEDICIÓN DATACRÉDITO <span class="text-danger" style="font-size:20px;">*</span></label>
      <input type="date" class="form-control " name="FechaInsercion" min="2022-05-01" max="<?php echo date('Y-m-d'); ?>" required>
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
    
      <div class="mb-3  w-100">
        <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR ARCHIVO SÍNTESIS</label>
        <input type="file" class="form-control " name="NombreS" id="NombreS">
      </div>
    
      <div class="mb-3 w-100">
        <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR ARCHIVO PN</label>
        <input type="file" class="form-control" name="NombrePN" id="NombrePN">
      </div>
    
    
      <div class="mb-3 w-100">
        <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR FORMATO </label>
        <input type="file" class="form-control" name="NombreT" id="archivo3">
      </div>
    
      <div class="mb-3 w-100" title="Este campo es obligatorio">
      <label for="exampleInputEmail1" class="form-label fw-semibold">CONSECUTIVO FORMATO <span class="text-danger" style="font-size:20px;">*</span></label>
      <input type="text" class="form-control" name="Consecutivof" id="consecutivof" value="" required>
      <div id="consecutivofError" style="color: red;" class="fw-bold"></div>
      <div id="consecutivofError2" style="color: red;" class="fw-bold"></div>
      <p class="formato-ayuda">Si la persona no tiene T1 ó T2, ingresar N/A(No aplica).</p>
    </div>

    
    
    
    <script>
      $(document).ready(function() {
        $('#consecutivof').change(function() {
          if ($(this).val().toLowerCase() === 'n/a') {
            $('#archivo3').val('');
            $('#archivo3').attr('disabled', true);
          } else {
            $('#archivo3').attr('disabled', false);
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
    
    <script>
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
      <div>
      <button  id="agregar" type="submit" class="btn btn-primary" name="btnregistrar" value="ok" style="background-color: #005E56;" name="registrar">Registrar</button>
      </div>
      <script>
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
    
    //SCORE
    var scoreInput = document.getElementById('score');
    var scoreError2 = document.getElementById('scoreError2');
    
    if (!/^(0*[1-9]|[1-9][0-9]{0,2}|950|S\/E)$/.test(scoreInput.value)) {   
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'El campo SCORE debe contener un valor del 1-950 ó S/E!',
        confirmButtonColor: '#005E56'
      });
      
      scoreError2.textContent = '';
      scoreInput.focus();
      return false;
    }
    
    //Reporte
    var reporteInput = document.getElementById('reporte');
    var reporteError2 = document.getElementById('reporteError2');
    
    if (!/^[\w,]*$/i.test(reporteInput.value)) {   
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'El campo REPORTE debe contener solo letras, números o comas!',
        confirmButtonColor: '#005E56'
      });
      
      reporteError2.textContent = '';
      reporteInput.focus();
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
    
        var agenciaInput = document.getElementById('agencia');
        var agenciaError2 = document.getElementById('agenciaError2');
        
        if (!/^[a-zA-Z\sñÑáéíóúÁÉÍÓÚ]+$/u.test(agenciaInput.value)) {   
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'El campo AGENCIA debe contener solo caracteres alfabéticos!',
            confirmButtonColor: '#005E56'
          });
          
          agenciaError2.textContent = '';
          agenciaInput.focus();
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
        return true;
      }
    
    </script>
    
    </form>
    
    <div class="col-9">
      <div class="mb-3">
        <form action="" method="post">
        <div class="" style="margin-top: -50px; margin-right: -14px;">
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
    <div style="overflow: auto;">
        <table id="personas" class="hover table table-responsive table-striped shadow-lg mt-4 table-bordered table-hover"  style="width:100%" >
          <thead class="" style="background-color: #005E56;">
            <tr class="text-white">
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
              <th class="" scope="col">T</th>
              <th class="" scope="col">ID</th>
              <th class="" style="width: 8%"></th>
            </tr> 
          </thead> 
          <tbody class="table-group-divider">
            @foreach($datos as $item)
              <tr>
             
                <td class="text-uppercase">{{$item->Cedula}}</td>
                <td class="">{{ ucwords(strtolower($item->Nombre)) }}</td>
                <td class="text-uppercase">{{$item->Apellidos}}</td>
                <td class="text-uppercase">{{$item->Score}}@if($item->Score == 'S/E')
                  <span class="fw-bold" style="color: #1565c0;"><br></span>
                  @elseif (650 <= $item->Score && $item->Score <= 699)
                      <span class="fw-bold" style="color: #1565c0;"><br>NORMAL</span>
                  @elseif (700 <= $item->Score && $item->Score <= 749)
                      <span class="fw-bold" style="color: #1565c0;"><br>BUENO</span>
                  @elseif ($item->Score >= 750)
                      <span class="fw-bold" style="color: #1565c0;"><br>EXCELENTE</span>
                  @else
                      <span class="fw-bold" style="color: #1565c0;"><br>BAJO</span>
                  @endif</td>
                <td class="text-uppercase">{{$item->Reporte}}</td>
                <td class="text-uppercase">{{$item->CuentaAsociada}}</td>
                <td class="text-uppercase text-center">{{$item->Agencia}}</td>
                <td class="text-uppercase" class="">{{$item->FechaInsercion}}
                @php
                    $fecha_actual = now();
                    $fecha_insercion = \Carbon\Carbon::parse($item->FechaInsercion);
                    $diferencia = $fecha_actual->diff($fecha_insercion);
                    $max_date = now()->format('Y-m-d');
                @endphp
                
                @if ($diferencia->days > 180)
                    <span class="text-danger fw-bold blink" style="font-size: 20px;"><BR>RENOVAR</span>
                @else
                    <span class="fw-bold" style="color: #1565c0;"><BR>Al día</span>
                @endif
                <td class="text-uppercase text-center">{{$item->Estado}}</td>
                @php 
                $html = ""; 
                $html2 = "";
                $html3 = "";  
                if (is_file("Storage/files/sintesis/".$item->NombreS)) { 
                    $html .= '<a href="' . asset("Storage/files/sintesis/".$item->NombreS) . '" download><img src="img/pdf.png" style="height: 2.5rem"></a>';
                } else {
                 
                }
                
                $dir2 = "Storage/files/pn/";
                $ruta_carga3 = $dir2 . $item->NombrePN;
                if (is_file($ruta_carga3)) { 
                    $html2 .= '<a href="' . asset("Storage/files/pn/".$item->NombrePN) . '" download><img src="img/pdf.png" style="height: 2.5rem"></a>';
                } else {
              
                }
                
                $html3 = "";  
                if ($item->Tipof == "T1") {
                    $dir3 = "Storage/files/t1/";
                    $ruta_carga3 = $dir3 . $item->NombreT;
                } elseif ($item->Tipof == "T2") {
                    $dir3 = "Storage/files/t2/";
                    $ruta_carga3 = $dir3 . $item->NombreT;
                }
                if (is_file($ruta_carga3)) { 
                    $html3 .= '<a href="' . asset($ruta_carga3) . '" download><img src="img/pdf.png" style="height: 2.5rem"></a>';
                } else {
                  
                }
                @endphp
                <td>{!! $html !!}</td>
                <td>{!! $html2 !!}</td>
                <td>{!! $html3 !!}</td>
                <td class="text-uppercase">'{{$item->Consecutivof}}</td>
                <td><a href="" type="submit" class="btn btn-small btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditar" style="margin-right: 6%"><input type="hidden" name=""><i class="fa-regular fa-pen-to-square"></i><a onclick="return eliminar()" href="{{route("crud.delete",$item->ID)}}" type="submit" class="btn btn-small btn-danger" name="eliminar" value="ok"><i class="fa-solid fa-trash"></i></a></a>
                
              <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
              <button type="button" data-bs-dismiss="modal" class="btn-close p-3" aria-label="Close"></button>
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
                      
                      <h1 class="modal-title text-center" id="modificar">MODIFICAR</h1>
  
                    </div>
                  <hr>
  
                  <div class="modal-body">
      
              <form action="{{route("crud.update", $item->ID)}}" class="text-center" method="POST" enctype="multipart/form-data" onsubmit="return validateForm2()">
                @csrf
              <!--Label1-->  
              <div class="mb-3">
                  <label for="label" id="izquierda7" class="form-label fw-bold" value="">CÉDULA</label>
                  <input type="text" class="form-control" name="cedula2" readonly value="{{$item->Cedula}}" style="background-color: #EBEBEB;">
                  <input type="hidden" name="cedula3" value="">
              </div>
  
              <div class="mb-3">
                <label for="nombre3" id="izquierda3" class="form-label fw-bold">NOMBRE</label>
                <input type="text" class="form-control" id="nombre3" name="nombre3" value="{{$item->Nombre}}" required>
                <div id="nombreError3" style="color: red;" class="fw-bold"></div>
              </div>
        
              
              
              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda6" class="form-label fw-bold">APELLIDOS</label>
                  <input type="text" class="form-control" id="apellidos3" name="apellidos3" value="{{$item->Apellidos}}" required>
                  <div id="apellidosError3" style="color: red;" class="fw-bold"></div>
              </div>
  
  
              <!--Label3-->
              <div class="mb-3">
                  <label for="label"  id="izquierda" class="form-label fw-bold">SCORE</label>
                  <input type="text" class="form-control" id="score3" name="score3" value="{{$item->Score}}" required>
                  <div id="scoreError3" style="color: red;" class="fw-bold"></div>
              </div>
  
              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda4" class="form-label fw-bold">REPORTE DATACRÉDITO</label>
                  <input type="text" class="form-control" id="reporte3" name="reporte3" value="{{$item->Reporte}}">
                  <div id="reporteError3" style="color: red;" class="fw-bold"></div>
              </div>
  
              <!--Label4-->
              <div class="mb-3 ">
                  <label for="label" id="izquierda2" class="form-label fw-bold">CUENTA ASOCIADA</label>
                  <input type="text" class="form-control" name="cuenta3" readonly value="{{$item->CuentaAsociada}}" style="background-color: #EBEBEB;">
                  <input type="hidden" name="cuenta" value="">
              </div>
  
              <!--Label5-->
              <div class="mb-3">
                  <label for="click" id="izquierda7" class="form-label fw-bold">AGENCIA</label>
                  <input type="text" class="form-control" id="agencia3" name="agencia3" value="{{$item->Agencia}}" required>
                  <div id="agenciaError3" style="color: red;" class="fw-bold"></div>
              </div>
  
              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda" class="form-label fw-bold">FECHA</label>
                  <input type="date" class="form-control" name="fecha3" id="fecha3" min="2022-08-01" max="{{$max_date}}" value="{{$item->FechaInsercion}}" required>
                </div>
  
              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda9" class="form-label fw-bold">ESTADO</label>
                  <select class="form-control" name="estado3">
                      <option value="{{$item->Estado}}">{{$item->Estado}}</option>
                      <option value="N">Normal</option>
                      <option value="B">Bloqueado</option>
                      <option value="S">Suspendido</option>
                      <option value="J">Judicial</option>
                      <option value="I">Insolvente</option>
                      <option value="R">Renovar</option>
                  </select>
                  
              </div>
  
              <div class="mb-3">
                <label for="exampleInputEmail1" id="izquierda5" class="form-label fw-bold">ADJUNTAR ARCHIVO SINTESIS</label>
                <input type="file" class="form-control" name="archivo22" id="archivo22" accept="application/pdf" value="{{$item->NombreS}}">
              </div> 
              
                <div class="mb-3">
                    <label for="label" id="izquierda8" class="form-label fw-bold">ADJUNTAR ARCHIVO PN</label>
                  <input type="file" class="form-control" name="archivo11" id="archivo11" accept="application/pdf" value="{{$item->NombrePN}}">
                  </div>
                  
                  {{-- <div class="mb-3 w-100">
                  <label for="exampleInputEmail1" id="izquierda10" class="form-label fw-bold">ADJUNTAR FORMATO </label>
                  <input type="file" class="form-control" name="archivo33" accept="application/pdf" value="{{$ruta_carga3}}">
                </div> --}}
              
                <div class="mb-3 w-100">
                  <label for="exampleInputEmail1" id="izquierda11" class="form-label fw-bold">CONSECUTIVO FORMATO</label>
                  <input type="text" class="form-control " name="consecutivof3" id="consecutivof" readonly value="{{$item->Consecutivof}}" style="background-color: #EBEBEB;">
                  <input type="hidden" name="consecutivof" value="">
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  <button type="submit" href=""  name="editar" class="btn btn-primary" style="background-color: #005E56;">Guardar</button>
                </div>
            </form>
            </div>
                
                
                </td>
                
                
              </tr>
         @endforeach
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
    
    //SCORE
    var scoreInput = document.getElementById('score3');
    var scoreError2 = document.getElementById('scoreError3');
    
    if (!/^(0*[1-9]|[1-9][0-9]{0,2}|950|S\/E)$/.test(scoreInput.value)) {   
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'El campo SCORE debe contener un valor del 1-950 ó S/E!',
        confirmButtonColor: '#005E56'
      });
      
      scoreError2.textContent = 'Ingrese un número del 1 al 950 ó S/E!';
      return false;
    }
    
    //Reporte
    var reporteInput = document.getElementById('reporte3');
    var reporteError2 = document.getElementById('reporteError3');
    
    if (!/^[\w,]*$/i.test(reporteInput.value)) {   
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'El campo REPORTE debe contener solo letras, números o comas!',
        confirmButtonColor: '#005E56'
      });
      
      reporteError2.textContent = 'Ingresar solo letras, números o comas!';
      return false;
    }
    var agenciaInput = document.getElementById('agencia3');
        var agenciaError2 = document.getElementById('agenciaError3');
        
        if (!/^[a-zA-Z\sñÑáéíóúÁÉÍÓÚ]+$/u.test(agenciaInput.value)) {   
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'El campo AGENCIA debe contener solo caracteres alfabéticos!',
            confirmButtonColor: '#005E56'
          });
          
          agenciaError2.textContent = 'Ingrese solo letras!';
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

    {{-- <script>
       function validateForm3() {
              var nombreInput = document.getElementById('name');
              var nombreError2 = document.getElementById('nameError');
              
              if (!/^[a-zA-Z\sñÑ]+$/u.test(nombreInput.value)) {   
                Swal.fire({
                  icon: 'error',
                  title: '¡Error!',
                  text: 'El campo NOMBRE debe contener solo caracteres alfabéticos!',
                  confirmButtonColor: '#005E56'
                });
                window.scrollTo({ top: 0, behavior: 'smooth' });
                nombreError2.textContent = '';
                return false;
              }

              var passwordInput = document.getElementById('password');
              var passwordError = document.getElementById('passwordError');
              var passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,12}$/;

              if (!passwordRegex.test(passwordInput.value)) {   
                Swal.fire({
                  icon: 'error',
                  title: '¡Error!',
                  text: 'La contraseña debe contener al menos una letra, un número, un carácter especial (@$!%*?&) y tener entre 8 y 12 caracteres!',
                  confirmButtonColor: '#005E56'
                });
                window.scrollTo({ top: 0, behavior: 'smooth' });
                passwordError.textContent = '';
                return false;
              }
              return true;
            }
    </script> --}}

          </div>
        </div>
    
    
        <script src="ResourcesAll/dtables/jquery-3.5.1.js"></script>
        <script src="ResourcesAll/dtables/jquerydataTables.js"></script>
        <script src="ResourcesAll/dtables/dataTablesbootstrap5.js"></script>
        <script>
          $(document).ready(function () {
          $('#personas').DataTable({
            
            "lengthMenu": [[1,5], [1,5]],
            "language": 
            {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No existe!",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": 
                {
                  "next": "Siguiente",
                  "previous": "Anterior"
                }

            } 
            });
          });

          function eliminar(){
            var respuesta=confirm("Estas seguro que deseas eliminar este registro?")
            return respuesta
          }
    
          function csesion(){
            var respuesta=confirm("Estas seguro que deseas cerrar sesión?")
            return respuesta
          }
        </script>
    </div>
    
    </div>
    
</div>    
    @endsection
   