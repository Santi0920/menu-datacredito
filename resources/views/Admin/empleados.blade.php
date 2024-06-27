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

<!-- NAV DE LISTA-->
<a name="arriba"></a>
<nav class="navbar navbar-expand-lg bg-body-secondary p-0" id="Menu">
  <div class="container-fluid menu-bar" style="" >
    <!-- Coopserp.com-->

    <!-- Botón que aparece al reducir pantalla-->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
    </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <!-- Foto Coopserp-->
  <img src="img/CoopserpPH.png" alt="Coopserp.icono" width="150px" height="60px" id="data" class="navbar-brand mb-2 mt-2" style="filter: drop-shadow(0 2px 0.8px white);">


  <ul class="navbar-nav me-auto mb-lg-0 header">
      <!-- DataCreditos-->
      <div class="dropdown nav-item">
        <li class="nav-link active text-white dropdown-toggle fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 25px">
          Datacrédito
         </li>
        <ul class="dropdown-menu" style="background-color: #005E56;">
        <ul class="dropend">
        <li class="dropdown-toggle text-white" style=" list-style-type: none; font-size: 25px" ><a class="fw-semibold text-white" style=" font-size: 25px; text-decoration: none; text-aling:start">Solicitud Datacrédito</a></li>

        <ul class="dropdown-menu" style="background-color: #005E56;">
          <li><a class="text-white dropdown-item fw-semibold" style="font-size: 25px" href="admin">CRUD Asociación</a></li>
          <li><a class="text-white dropdown-item fw-semibold"  style="font-size: 25px" href="adminempleado">CRUD Empleados</a></li>
          <li><a class="text-white dropdown-item fw-semibold"  style="font-size: 25px" href="adminproveedor">CRUD Proveedores</a></li>

        </ul>
        </ul>
        <li class="text-white dropdown-divider"></li>
        <ul class="dropend">
          <li class="dropdown-toggle text-white text-start" style=" list-style-type: none; font-size: 25px" ><a class="fw-semibold text-white" style=" font-size: 25px; text-decoration: none; text-aling:start">Eliminados</a></li>

              <ul class="dropdown-menu" style="background-color: #005E56;">
                <li><a class="text-white dropdown-item fw-semibold" style="font-size: 25px" href="admineliminadoa">Asociados</a></li>
                <li><a class="text-white dropdown-item fw-semibold"  style="font-size: 25px" href="admineliminadoe">Empleados</a></li>
                <li><a class="text-white dropdown-item fw-semibold"  style="font-size: 25px" href="admineliminadop">Proveedores</a></li>

              </ul>
          </ul></li>
          <li class="text-white dropdown-divider"></li>
    </ul>
  </div>
      <!-- Anticipados-->
      <li class="nav-item">
        <a class="nav-link active text-white" aria-current="page" href="adminpagare" id="data" style="font-size: 25px">Pagare</a>
      </li>

    </ul>

    <span class="mx-4 text-white" style="font-size: 25px;"><img style="height: 2.5rem" class="mx-1" src="img/perfil.png">Bienvenid@ <strong>{{ auth()->user()->name }}</strong></span>
    <a onclick="return csesion()" href="{{route('login.destroy')}}"><button class="btn btn-light"><b style="font-size: 25px;">Cerrar Sesión</b></button></a>


  </div>
</div>
</nav>

<div class="contenedor2">
  <div class="agregar2">
    <a href="datacredito.php" class="btn btn-primary" style="font-size: 35px;font-family: 'Montserrat', sans-serif; font-weight: bold;" data-bs-toggle="modal" data-bs-target="#exampleModal3">
      <span style="margin-bottom: 30px; margin-top: 20px;">V1</span>
    </a>
  </div>
</div>



<!-- Modal para agregar consultante -->
<form action="{{route('rol.store')}}" class="text-center" id="" method="POST" enctype="multipart/form-data" onsubmit="validateForm3()">
  @csrf
    <div class="container">
         <div class="agregar">
            <a href="datacredito.php"  type="button" class="" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="fa-solid fa-plus icono"></i></a>
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
                        <td title="{{ $item->email }}">{{$item->rol == 'Asociacion' ? 'Coordinador' : $item->rol }}</td>
                        <td><a onclick="return activar()" type="submit" href="{{route('rol.activo',$item->id)}}" name="activar" id="activar" class="btn btn-small btn-warning">Activar</a></td>
                        <td><a onclick="return desactivar()" type="submit" href="{{route('rol.desactivar',$item->id)}}" name="desactivar" id="desactivar" class="btn btn-small btn-secondary">Desactivar</a></td>
                        <td><a onclick="return eliminar()" href="{{route('rol.delete',$item->id)}}" type="submit" class="btn btn-small btn-danger" name="eliminar" value="ok"><i class="fa-solid fa-trash"></i></a></td>
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

        <style>
          .password-toggle-icon {
              position: absolute;
              right: 10px;
              top: 50%;
              transform: translateY(-50%);
              cursor: pointer;
          }
        </style>
          <div class="mb-3">
            <label for="exampleInputEmail1" id="consul3" class="form-label fw-bold">CONTRASEÑA</label>
            <div style="position: relative;">
                <input type="password" class="form-control" name="password" id="password" required>
                <i class="password-toggle-icon fa fa-eye" onclick="togglePasswordVisibility('password')"></i>
            </div>
            <div id="contraseñaError" style="color: red;" class="fw-bold"></div>
          </div>
            <script>

            function togglePasswordVisibility(inputId) {
                    var input = document.getElementById(inputId);
                    var icon = input.nextElementSibling;
                    if (input.type === "password") {
                        input.type = "text";
                        icon.classList.remove("fa-eye");
                        icon.classList.add("fa-eye-slash");
                    } else {
                        input.type = "password";
                        icon.classList.remove("fa-eye-slash");
                        icon.classList.add("fa-eye");
                    }
                }
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



            <div class="mb-3">
              <label for="label" id="consul4" class="form-label fw-bold">CONFIRMAR CONTRASEÑA</label>
              <div style="position: relative;">
                  <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                  <i class="password-toggle-icon fa fa-eye" onclick="togglePasswordVisibility('password_confirmation')"></i>
              </div>
              <div id="ccontraseñaError" style="color: red;" class="fw-bold"></div>
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
              <option value="Coordinacion">Coordinador</option>
              <option value="Credito">Credito</option>
              <option value="Consultante">Consultante</option>
              <option value="Thumano">Talento Humano</option>
              <option value="Control">Control</option>
              <option value="NuevoEmpleado">Nuevos Empleados</option>
              <option value="Jefatura">Jefatura</option>
              <option value="ControlMasivo">Control Masivo</option>
            </select>
          </div>

          <div class="mb-3 w-100">
            <label for="agenciaU" class="form-label fw-bold" style="margin-left: -71%;">AGENCIA / ÁREA<span class="text-danger" style="font-size:20px;"></label>
            <select class="form-control " name="agenciau" id="agenciau" required>
              <option value="">Seleccione una opción</option>
              <option value="Medellín">Medellín</option>
              <option value="Cali">Cali</option>
              <option value="Barranquilla">Barranquilla</option>
              <option value="Cartagena">Cartagena</option>
              <option value="Jamundí">Jamundí</option>
              <option value="San Andrés">San Andrés</option>
              <option value="CaliBC">CaliBC</option>
              <option value="Palmira">Palmira</option>
              <option value="Buga">Buga</option>
              <option value="Buenaventura">Buenaventura</option>
              <option value="Tuluá">Tuluá</option>
              <option value="Sevilla">Sevilla</option>
              <option value="Caicedonia">Caicedonia</option>
              <option value="La Unión">La Unión</option>
              <option value="Roldanillo">Roldanillo</option>
              <option value="Cartago">Cartago</option>
              <option value="Zarzal">Zarzal</option>
              <option value="S Quilichao">S Quilichao</option>
              <option value="Yumbo">Yumbo</option>
              <option value="Pasto">Pasto</option>
              <option value="Popayán">Popayán</option>
              <option value="Ipiales">Ipiales</option>
              <option value="Leticia">Leticia</option>
              <option value="Soacha">Soacha</option>
              <option value="Pereira">Pereira</option>
              <option value="Manizales">Manizales</option>
              <option value="Monteria">Monteria</option>
              <option value="Sincelejo">Sincelejo</option>
              <option value="Valledupar">Valledupar</option>
              <option value="Villavicencio">Villavicencio</option>
              <option value="Santa Marta">Santa Marta</option>
              <option value="Duitama">Duitama</option>
              <option value="Bogotá Norte">Bogotá Norte</option>
              <option value="Pasto">Pasto</option>
              <option value="Bogotá Centro">Bogotá Centro</option>
              <option value="Bogotá Elemento">Bogotá Elemento</option>
              <option value="Bogotá TC">Bogotá TC</option>
              <option value="Tunja">Tunja</option>
              <option value="Ibagué">Ibagué</option>
              <option value="Bucaramanga">Bucaramanga</option>
              <option value="Cúcuta">Cúcuta</option>
              <option value="Zipaquirá">Zipaquirá</option>
              <option value="Armenia">Armenia</option>
              <option value="Neiva">Neiva</option>
              <option value="Riohacha">Riohacha</option>
              <option value="Yopal">Yopal</option>
              <option value="Facatativá">Facatativá</option>
              <option value="Girardot">Girardot</option>
              <option value="Reporte Bogota">Reporte Bogota</option>
    <option value="Reporte Cali">Reporte Cali</option>
    <option value="Juridico Zona Centro">Juridico Zona Centro</option>
    <option value="Juridico Zona Norte">Juridico Zona Norte</option>
    <option value="Juridico Zona Sur">Juridico Zona Sur</option>
    <option value="Gerencia General">Gerencia General</option>
    <option value="Tesoreria">Tesoreria</option>
    <option value="Contabilidad">Contabilidad</option>
    <option value="Sistemas">Sistemas</option>
    <option value="Talento Humano">Talento Humano</option>
    <option value="Auditoria Interna">Auditoria Interna</option>
    <option value="Oficial de Cumplimiento">Oficial de Cumplimiento</option>
    <option value="Coordinacion 1">Coordinacion 1</option>
    <option value="Coordinacion 2">Coordinacion 2</option>
    <option value="Coordinacion 3">Coordinacion 3</option>
    <option value="Coordinacion 4">Coordinacion 4</option>
    <option value="Coordinacion 5">Coordinacion 5</option>
    <option value="Coordinacion 6">Coordinacion 6</option>
    <option value="Coordinacion 7">Coordinacion 7</option>
    <option value="Coordinacion 8">Coordinacion 8</option>
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


<div class="container-fluid row p-4">
<form action="{{route('cruda.create2')}}" class="col 3 m-3" method="POST" enctype= "multipart/form-data" onsubmit="return validateForm()">
  <h2 class="p-2 text-secondary text-center"><b>Empleados</b></h2>

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


  <div class="mb-3 w-100" title="Este campo es obligatorio">
    <label for="exampleInputEmail1" class="form-label fw-semibold">SCORE <span class="text-danger" style="font-size:20px;">*</span></label>
    <input list="ScoreL" type="text" class="form-control " name="Score" id="score" required placeholder="0 - 950" autocomplete="off">
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


  <div class="mb-3  w-100">
    <label for="exampleInputEmail1" class="form-label fw-semibold">REPORTE DATACRÉDITO <span class="text-danger" style="font-size:20px; display: none;">*</span></label>
    <input type="text" class="form-control" name="Reporte" id="reporte" placeholder="EJ: N,D,C,2">
    <p class="formato-ayuda">Ingresar N = Normal, D = Dudoso Recaudo, C = Cartera Castigada ó 1 - 6 (Si cuenta con Mora).</p>
    <div id="reporteError" style="color: red;" class="fw-bold"></div>
    <div id="reporteError2" style="color: red;" class="fw-bold"></div>
  </div>

 <script>
$(document).ready(function() {
  $('#consecutivof').on('input', function() {
    var valor = $(this).val();

    if ($.isNumeric(valor)) {
      $('#archivo3').prop('required', true);
    } else {
      $('#archivo3').prop('required', false);
    }
  });
});

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


  <div class="mb-3 w-100" title="Este campo es obligatorio" style="display: none">
    <label for="exampleInputEmail1" class="form-label fw-semibold">NÚMERO CUENTA <span class="text-danger" style="font-size:20px;">*</span></label>
    <input list="cuentaL" type="text" class="form-control " name="CuentaAsociada" id="cuenta" autocomplete="off">
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


  <div class="mb-3 w-100" title="Este campo es obligatorio">
    <label for="exampleInputEmail1" class="form-label fw-semibold">AGENCIA <span class="text-danger" style="font-size:20px;">*</span></label>
    <input list="agencia" type="text" class="form-control " name="Agencia" id="Agencia" required autocomplete="off">
    <div id="agenciaError" style="color: red;" class="fw-bold"></div>
    <div id="agenciaError2" style="color: red;" class="fw-bold"></div>
  </div>

  <datalist id="agencia">
    <option value="Medellín"></option><option value="Cali"></option><option value="Barranquilla"></option><option value="Cartagena"></option><option value="Jamundí"></option><option value="San Andrés"></option><option value="CaliBC"></option><option value="Palmira"></option><option value="Buga"></option><option value="Buenaventura"></option><option value="Tuluá"></option><option value="Sevilla"></option><option value="Caicedonia"></option><option value="La Unión"></option>
    <option value="Roldanillo"></option><option value="Cartago"></option><option value="Zarzal"></option><option value="S Quilichao"></option><option value="Yumbo"></option><option value="Pasto"></option><option value="Popayán"></option><option value="Ipiales"></option><option value="Leticia"></option><option value="Soacha"></option><option value="Pereira"></option><option value="Manizales"></option><option value="Monteria"></option><option value="Sincelejo"></option>
    <option value="Valledupar"></option><option value="Villavicencio"></option><option value="Santa Marta"></option><option value="Duitama"></option><option value="Bogotá Norte"></option><option value="Pasto"></option><option value="Bogotá Centro"></option><option value="Bogotá Elemento"></option><option value="Bogotá TC"></option><option value="Tunja"></option><option value="Ibagué"></option><option value="Bucaramanga"></option><option value="Cúcuta"></option><option value="Zipaquirá"></option>
    <option value="Armenia"></option><option value="Neiva"></option><option value="Riohacha"></option><option value="Yopal"></option><option value="Facatativá"></option><option value="Girardot">
  </datalist>


  <!--VALIDACION CAMPO AGENCIA-->
  <script>
  var agenciaInput = document.getElementById('Agencia');
  var agenciaError = document.getElementById('agenciaError');

  agenciaInput.addEventListener('input', function() {
    var agencia = agenciaInput.value.trim();
    var opcionesAgencia = document.getElementById('agencia').options;
    var valorValido = false;

    for (var i = 0; i < opcionesAgencia.length; i++) {
      if (agencia.toLowerCase() === opcionesAgencia[i].value.toLowerCase()) {
        valorValido = true;
        break;
      }
    }

    if (valorValido) {
      agenciaError.innerHTML = '';
    } else {
      agenciaError.innerHTML = 'Seleccione una opción de la lista';
    }
  });

  agenciaInput.setAttribute('maxlength', '20');

</script>

<div class="mb-3 w-100" title="Este campo es obligatorio">
  <label for="exampleInputEmail1" class="form-label fw-semibold">FECHA EXPEDICIÓN DATACRÉDITO <span class="text-danger" style="font-size:20px;">*</span></label>
  <input type="date" class="form-control " name="FechaInsercion" id="FechaInsercion" min="2022-05-01" max="<?php echo date('Y-m-d'); ?>">
</div>

<div class="mb-3 w-100" title="Este campo es obligatorio">
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
.formato-ayuda2 {
  color: gray;
  font-style: normal;
}
</style>

  <div class="mb-3  w-100">
    <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR ARCHIVO SÍNTESIS</label>
    <input type="file" class="form-control " name="NombreS" id="NombreS">
    <p class="formato-ayuda2">Formato: <strong>Sintesis-(Cédula).pdf</strong></p>
  </div>

  <div class="mb-3 w-100">
    <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR ARCHIVO PN</label>
    <input type="file" class="form-control" name="NombrePN" id="NombrePN">
    <p class="formato-ayuda2">Formato: <strong>PN-(Cédula).pdf</strong></p>
  </div>

  <div class="mb-3 w-100">
    <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR AUTORIZACIÓN</label>
    <input type="file" class="form-control" name="NombreA" id="NombreA">
    <p class="formato-ayuda2">Formato: <strong>Autorizacion-(Cédula).pdf</strong></p>
  </div>




  <div class="mb-3 w-100" title="Este campo es obligatorio">
  <label for="exampleInputEmail1" class="form-label fw-semibold">CONSECUTIVO AUTORIZACIÓN <span class="text-danger" style="font-size:20px;">*</span></label>
  <input list="Consecutivo" type="text" class="form-control" name="consecutivoa" id="consecutivoa" value="" required autocomplete="off">
  <div id="consecutivofError" style="color: red;" class="fw-bold"></div>
  <div id="consecutivofError2" style="color: red;" class="fw-bold"></div>
  <p class="formato-ayuda2">Si la persona no tiene Autorización, ingresar N/A(No aplica).</p>
</div>

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

  $(document).ready(function() {
    $('#consecutivoa').change(function() {
      var consecutivoValue = $(this).val().trim();
      if (consecutivoValue !== '' && !isNaN(consecutivoValue)) {
        $('#NombreA').attr('required', true);
        $('#contrato').attr('required', true);
      } else {
        $('#NombreA').removeAttr('required');
        $('#contrato').removeAttr('required');
      }
    });
  });


  </script>

<div class="mb-3 w-100">
    <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR CONTRATO</label>
    <input type="file" class="form-control" name="contrato" id="contrato">
    <p class="formato-ayuda2">Formato: <strong>Contrato-(Cédula).pdf</strong></p>

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



var consecutivofInput = document.getElementById('consecutivoa');
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


            var agenciaInput = document.getElementById('Agencia');
      var agenciaError = document.getElementById('agenciaError');

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



      var consecutivofInput = document.getElementById('consecutivoa');
      var consecutivofError2 = document.getElementById('consecutivofError2');

      if (!/^\d{0,10}$|^N\/A$/i.test(consecutivofInput.value)) {
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'El campo CONSECUTIVO AUTORIZACIÓN debe contener dígitos numéricos o N/A!',
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
              <th class="" scope="col">#</th>
              <th class="" scope="col">CÉDULA</th>
              <th class="" scope="col">NOMBRE</th>
              <th class="" scope="col">APELLIDOS</th>
              <th class="" scope="col">SCORE</th>
              <th class="" scope="col">REPORTE</th>
              <th class="text-center" scope="col">AGENCIA</th>
              <th class="" scope="col">FECHAGNR</th>
              <th class="" scope="col">SIN</th>
              <th class="" scope="col">PN</th>
              <th class="" scope="col">A</th>
              <th class="" scope="col">ID</th>
              <th class="" scope="col">CONTRATO</th>
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

      var consecutivoaInput = document.getElementById('consecutivof33');
var consecutivoaError = document.getElementById('consecutivoError3');

if (!/^\d+|N\/A$/i.test(consecutivoaInput.value)) {
  Swal.fire({
    icon: 'error',
    title: '¡Error!',
    text: 'El campo CONSECUTIVO AUTORIZACIÓN debe contener solo números o N/A',
    confirmButtonColor: '#005E56'
  });

  consecutivoaError.textContent = 'Ingresar solo números o N/A';
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
  "ajax": "{{ route('datatable.data3') }}",
  "columns": [
    {data: 'ID'},
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
  data: 'Score',
  render: function(data, type, row) {
    var html = ''; // Variable para almacenar el HTML generado

    if (data === 'S/E') {
      html += data+'<span class="fw-bold" style="color: #1565c0;"><br></span>';
    } else if (650 <= data && data <= 699) {
      html += data+'<span class="fw-bold" style="color: #1565c0;"><br>NORMAL</span>';
    } else if (700 <= data && data <= 749) {
      html += data+'<span class="fw-bold" style="color: #1565c0;"><br>BUENO</span>';
    } else if (data >= 750) {
      html += data+'<span class="fw-bold" style="color: #1565c0;"><br>EXCELENTE</span>';
    } else {
      html += data+'<span class="fw-bold" style="color: #1565c0;"><br>BAJO</span>';
    }


    return html;
  }
},
    {data: 'Reporte'},
    {
      data: 'Agencia',
      render: function (data, type, row) {
        // Capitalizar la primera letra y convertir el resto en minúsculas
        var agencia = data.charAt(0).toUpperCase() + data.slice(1).toLowerCase();
        return agencia;
      }
    },
    {data: 'FechaInsercion',
    render: function(data, type, row) {
        var html = '';
        var fecha_insercion = new Date(data);

        var fecha_actual = new Date();
        var diferencia = Math.floor((fecha_actual - fecha_insercion) / (1000 * 60 * 60 * 24)); // Calcular la diferencia en días

        if (diferencia > 180) {
            html += data+'<span class="text-danger fw-bold blink" style="font-size: 20px;"><br>RENOVAR</span>';
        } else {
            html += data+'<span class="fw-bold" style="color: #1565c0;"><br>Al día</span>';
        }

        return html;
    }
},
    {
  data: 'NombreS',
  render: function(data, type, row) {
    if (type === 'display') {
      if (data === 'Vacío') {
        return '';
      } else {
        return '<a href="Storage/files/sintesis/' + data + '" target="__blank"><img src="img/pdf.png" style="height: 2.5rem"></a>';
      }
    }
    return data;
  }
},
    {data: 'NombrePN',
      "render": function(data, type, row) {
        if (type === 'display') {
          if (data === 'Vacío') {
            return '';
          }else{
          return '<a href="Storage/files/pn/' + data + '" target="__blank"><img src="img/pdf.png" style="height: 2.5rem"></a>';
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
          return '<a href="Storage/files/autorizacion/' + data + '" target="__blank"><img src="img/pdf.png" style="height: 2.5rem"></a>';
          }
        }
        return data;
      }
    },
    {data: 'ConsecutivoA'},
    {data: 'NombreContrato',
      "render": function(data, type, row) {
        if (type === 'display') {
          if (data === 'Vacío') {
            return '';
          }else{
          return '<a href="Storage/files/contrato/' + data + '" target="__blank" style="display: flex; justify-content: center;"><img src="img/pdf.png" style="height: 2.5rem;"></a>';
          }
        }
        return data;
      }
    },
    {    data: null,
      render: function(data, type, row) {
        var id = row.ID; // Obtener el ID de la fila
        var url = "{{ route('cruda.update2', ':id') }}";
        var today = new Date().toISOString().split('T')[0];
        url = url.replace(':id', id);
      var deleteButton = '<a onclick="return eliminar()" href="{{ route('crud.deactivate', ':id') }}" type="submit" class="btn btn-small btn-danger" name="eliminar" value="ok"><i class="fa-solid fa-trash"></i></a>'.replace(':id', row.ID);
      var editButton = `<a href="" id="modalLink_${id}" type="submit" class="btn btn-small btn-warning edit-button edit" data-bs-toggle="modal" data-bs-target="#modalEditar_${id}" data-id="${id}" style="margin-right: "><i class="fa-regular fa-pen-to-square"></i></a>
    <div class="modal fade" id="modalEditar_${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <button type="button" data-bs-dismiss="modal" class="btn-close p-3" aria-label="Close"></button>
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                          <h1 class="modal-title text-center" id="modificar">MODIFICAR</h1>
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


              <!--Label3-->
              <div class="mb-3">
                  <label for="label"  id="izquierda" class="form-label fw-bold">SCORE</label>
                  <input type="text" class="form-control" id="score3" name="score3" value="${row.Score}" maxlength="3" required>
                  <div id="scoreError3" style="color: red;" class="fw-bold"></div>
                  <p class="formato-ayuda">Si cuenta con score 0, ingresar <strong>S/E(Sin experiencia)</strong>.</p>
              </div>

              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda4" class="form-label fw-bold">REPORTE DATACRÉDITO</label>
                  <input type="text" class="form-control" id="reporte3" name="reporte3" maxlength="15" value="${row.Reporte}" oninput="this.value = this.value.toUpperCase()">
                  <div id="reporteError3" style="color: red;" class="fw-bold"></div>
                  <p class="formato-ayuda">Ingresar N = Normal, D = Dudoso Recaudo, C = Cartera Castigada ó 1 - 6 (Si cuenta con Mora).</p>
              </div>



              <!--Label5-->
              <div class="mb-3">
                  <label for="click" id="izquierda7" class="form-label fw-bold">AGENCIA</label>
                  <input list="agencia" type="text" class="form-control" id="agencia3" name="agencia3" value="${row.Agencia}" maxlength="20" required autocomplete="off">
                  <div id="agenciaError3" style="color: red;" class="fw-bold"></div>
              </div>



              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda" class="form-label fw-bold">FECHA</label>
                  <input type="date" class="form-control" name="fecha3" id="fecha3" min="2022-08-01" max="`+today+`" value="${row.FechaInsercion}">
                </div>



              <div class="mb-3">
                <label for="exampleInputEmail1" id="izquierda5" class="form-label fw-bold">ADJUNTAR ARCHIVO SINTESIS</label>
                <input type="file" class="form-control" name="archivo22" id="archivo22" accept="application/pdf" value="${row.NombreS}">
              </div>

                <div class="mb-3">
                    <label for="label" id="izquierda8" class="form-label fw-bold">ADJUNTAR ARCHIVO PN</label>
                  <input type="file" class="form-control" name="archivo11" id="archivo11" accept="application/pdf" value="${row.NombrePN}">
                  </div>

                  <div class="mb-3">
                    <label for="label" id="" class="form-label fw-bold" style="margin-left: -53%;">ADJUNTAR AUTORIZACIÓN</label>
                  <input type="file" class="form-control" name="archivo3" id="archivo3" accept="application/pdf" value="${row.NombreA}">
                  </div>

                  <div class="mb-3">
                    <label for="label" id="izquierda11" class="form-label fw-bold" style="margin-left: -47%;">CONSECUTIVO AUTORIZACIÓN</label>
                    <input type="text" class="form-control" name="consecutivof33" id="consecutivof33" value="${row.ConsecutivoA}">
                    <div id="consecutivoError3" style="color: red;" class="fw-bold"></div>
                  </div>

                <div class="mb-3">
                    <label for="label" id="" class="form-label fw-bold" style="margin-left: -60%;">ADJUNTAR CONTRATO</label>
                  <input type="file" class="form-control" name="contrato1" id="contrato1" accept="application/pdf" value="${row.NombreContrato}">
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

</div>


    @endsection

