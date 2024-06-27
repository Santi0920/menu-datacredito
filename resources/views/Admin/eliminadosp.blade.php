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
      <!-- Cuentas H-->
      <li class="nav-item">
        <a class="nav-link active text-white" aria-current="page" href="#" id="data" style="cursor:not-allowed; font-size: 25px">Cuentas H</a>
      </li>
       <!-- Cartera Castigada-->
      <li class="nav-item">
        <a class="nav-link active text-white" aria-current="page" href="#" id="data" style="cursor:not-allowed; font-size: 25px">Cartera Castigada</a>
      </li>
      <!-- Fondo de Garantia-->
      <li class="nav-item" >
        <a class="nav-link active text-white" aria-current="page" href="#" id="data" style="cursor:not-allowed; font-size: 25px">Fondo de Garantía</a>
      </li>
    </ul>

    <span class="mx-4 text-white" style="font-size: 25px;"><img style="height: 2.5rem" class="mx-1" src="img/perfil.png">Bienvenid@ <strong>{{ auth()->user()->name }}</strong></span>
    <a onclick="return csesion()" href="{{route('login.destroy')}}"><button class="btn btn-light"><b style="font-size: 25px;">Cerrar Sesión</b></button></a>


  </div>
</div>
</nav>



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
                        <td title="{{ $item->email }}">{{ $item->rol == 'Asociacion' ? 'Coordinador' : $item->rol }}</td>
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




    </form>
    {{-- FECHA --}}
    <div class="col-11" style="margin-left:3.5%">
      <div class="">
        <form action="" method="post">
        <div class="" style="margin-top: 0px; margin-right: -14px;">


    </div>

    <h2 class="p-2 mb-0 text-secondary text-start"><b>Registros Proveedores Eliminados -
    <span class="text-end" id="fechaActual"></b></span></h2>
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
              <th class="" scope="col">CÉDULA</th>
              <th class="" scope="col">NOMBRE</th>
              <th class="" scope="col">APELLIDOS</th>
              <th class="" scope="col">NIT</th>
              <th class="" scope="col">RAZON SOCIAL</th>
              <th class="" scope="col">SCORE</th>
              <th class="" scope="col">REPORTE</th>
              <th class="" scope="col">AGENCIA</th>
              <th class="" scope="col" title="Fecha Generación">FECHAGNR</th>
              <th class="" scope="col" title="Sintesis">SIN</th>
              <th class="" scope="col" >PN</th>
              <th class="" scope="col" title="Autorización">A</th>
              <th class="" scope="col" title="Consecutivo Autorización">ID</th>
              <th class="" scope="col" title="Recibo de Caja">RC</th>


              <th class="" style="width: 77px"></th>
            </tr>
          </thead>
          <tbody class="table-group-divider">


          </tbody>



        </table>

        <div class="w-100 text-center text-secondary">
    <style>
        .boton {
            width: 400px; height: 50px; font-size: 30px; font-weight: bold; color: white; background-color: #005E56; border-radius: 5px; transition: all ease-in-out 400ms
        }

        .boton:hover {
            background-color: white;
            color: #005E56;
        }
    </style>
    <form class="col 3 m-3" method="GET" enctype="multipart/form-data" action="{{ route('eliminar.totalPro') }}">
        @csrf



        <h2 class="m-1"><b>Eliminación SOLO <span class="text-danger">Proveedores</span></b></h2>
        <div class="mb-3 w-100" title="Este campo es obligatorio">
          <label class="form-label fw-semibold" style="font-size: 30px">TIPO PERSONA<span class="text-danger" style="font-size:30px;">*</span></label><br>
          <div class="form-check form-check-inline">
            <input type="radio" name="tipo_persona" value="PN" id="PN" accesskey="N" onchange="toggleCamposPersona()" required>
            <label class="form-check-label" for="PN" style="font-size: 25px">Persona Natural</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" name="tipo_persona" value="PJ" id="PJ" accesskey="J" onchange="toggleCamposPersona()" required>
            <label class="form-check-label" for="PJ" style="font-size: 25px">Persona Jurídica</label>
          </div>
        </div>

        <div>
          <input class="p-3" style="width: 400px; height: 50px; font-size: 30px; border-radius: 5px;" type="number" name="eliminado" placeholder="Ej: 78755445"> <br>
          <button class="m-5 boton" type="submit">Eliminar</button>
        </div>
    </form>
</div>

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
  "ajax": "{{ route('datatable5.admin') }}",
  "columns": [
      {data: 'ID'},
      {data: 'TipoProveedor'},
    {data: 'Cedula'},
    {
      data: 'Nombre',
    },
    {data: 'Apellidos'},
    {data: 'NIT'},
    {data: 'RazonSocial'},
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
    {data: 'NombreRC',
      "render": function(data, type, row) {
        if (type === 'display') {
          if (data === 'Vacío') {
            return '';
          }else{
          return '<a href="Storage/files/rc/' + data + '" target="__blank"><img src="img/pdf.png" style="height: 2.5rem"></a>';
          }
        }
        return data;
      }
    },
    {    data: null,
      render: function(data, type, row) {
        var id = row.ID; // Obtener el ID de la fila
        var url = "{{ route('crud.update', ':id') }}";
        var today = new Date().toISOString().split('T')[0];
        url = url.replace(':id', id);
      var deleteButton = '<a onclick="return eliminar2()" href="{{ route('crud.delete4', ':id') }}" type="submit" class="btn btn-small btn-danger" name="eliminar" value="ok"><i class="fa-solid fa-trash"></i></a>'.replace(':id', row.ID);
      var activateButton = '<a onclick="return activate()" href="{{ route('crud.activate', ':id') }}" type="submit" class="btn btn-small btn-success" name="eliminar" value="ok"><i class="fa-solid fa-check"></i></a>'.replace(':id', row.ID);
  return  activateButton + ' ' + deleteButton;

}
  }
  ],



  "lengthMenu": [[5], [5]],
  "language": {
    "lengthMenu": "Mostrar _MENU_ registros por página",
    "zeroRecords": "No hay registros que hayan sido eliminados!",
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







          function activate(){
            var respuesta=confirm("¿Estas seguro que deseas recuperar este usuario?")
            return respuesta
          }

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

          function csesion(){
            var respuesta=confirm("¿Estas seguro que deseas cerrar sesión?")
            return respuesta
          }


          function eliminar2(){
            var respuesta=confirm("¿Estas seguro que deseas eliminar definitivamente este registro?")
            return respuesta
          }
        </script>


    </div>

    </div>

</div>


    @endsection

