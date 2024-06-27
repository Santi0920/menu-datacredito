@extends('layouts.base')

@section('content')
    @if (session('correcto'))
        <div>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: "{{ session('correcto') }}",
                    text: '',
                    confirmButtonColor: '#005E56',

                });
            </script>
        </div>
    @endif

    @if (session('correcto2'))
        <div>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: "{{ session('correcto') }}",
                    text: '',
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

    @include('layouts/nav-consultante')



    <div class="container-fluid row p-4">
        <form action="{{ route('crudc.createcredito') }}" class="col 3 m-3" method="POST" enctype= "multipart/form-data"
            onsubmit="return validateForm()">
            <h2 class="p-2 text-secondary text-center"><b>Crédito Asociados</b></h2>

            @csrf


            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="cedula" class="form-label fw-semibold">CÉDULA<span class="text-danger"
                        style="font-size:20px;">*</span></label>
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
                <label for="exampleInputEmail1" class="form-label fw-semibold">NOMBRE <span class="text-danger"
                        style="font-size:20px;">*</span></label>
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
                <label for="exampleInputEmail1" class="form-label fw-semibold">APELLIDOS <span class="text-danger"
                        style="font-size:20px;">*</span></label>
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
                <label for="exampleInputEmail1" class="form-label fw-semibold">SCORE <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input list="ScoreL" type="text" class="form-control " name="Score" id="score"
                    placeholder="0 - 950" autocomplete="off" value="ok">
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
                <label for="exampleInputEmail1" class="form-label fw-semibold">REPORTE DATACRÉDITO <span class="text-danger"
                        style="font-size:20px; display: none;">*</span></label>
                <input type="text" class="form-control" name="Reporte" id="reporte" placeholder="EJ: N,D,C,2"
                    value="ok">
                <p class="formato-ayuda">Ingresar N = Normal, D = Dudoso Recaudo, C = Cartera Castigada ó 1 - 6 (Si cuenta
                    con Mora).</p>
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
                <label for="exampleInputEmail1" class="form-label fw-semibold">NÚMERO CUENTA <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input list="" type="text" class="form-control " name="CuentaAsociada" id="cuenta"
                    required autocomplete="off">
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

                    if (/^[0-9]{1,10}$/.test(cuenta)) {
                        cuentaError.innerHTML = '';
                    } else {
                        cuentaError.innerHTML = 'Ingrese solo números!';
                    }

                    cuentaInput.setAttribute("maxlength", "7");
                });
            </script>


            <div class="mb-3 w-100" title="Este campo es obligatorio" style="display: none;">
                <label for="exampleInputEmail1" class="form-label fw-semibold">FECHA EXPEDICIÓN DATACRÉDITO <span
                        class="text-danger" style="font-size:20px;">*</span></label>
                <input type="date" class="form-control " name="FechaInsercion" id="FechaInsercion" min="2022-05-01"
                    max="<?php echo date('Y-m-d'); ?>" value="ok">
            </div>

            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="estado" class="form-label fw-semibold">ESTADO <span class="text-danger"
                        style="font-size:20px;">*</span></label>
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





            <datalist id="Consecutivo">
                <option value="N/A"></option>
            </datalist>



            <script>
                var consecutivoanalisisInput = document.getElementById('ConsecutivoAnalisis');
                var consecutivoanalisisError = document.getElementById('consecutivoAnalisisError');

                consecutivoanalisisInput.addEventListener('keyup', function() {
                    var consecutivoanalisis = consecutivoanalisisInput.value.trim();

                    if (/^\d{0,10}$|^N\/A$/i.test(consecutivoanalisis)) {
                        consecutivoanalisisError.innerHTML = '';
                    } else {
                        consecutivoanalisisError.innerHTML = 'Ingrese un consecutivo correcto!';
                    }
                });
            </script>


            <div class="mb-3 w-100">
                <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR AUTORIZACIÓN o ANÁLISIS</label>
                <input type="file" class="form-control" name="NombreA" id="NombreA" required>
                <p class="formato-ayuda2">Debe contener el formato: <strong>Autorizacion-(Cédula).pdf o
                        Analisis-(Cédula).pdf</strong></strong></p>
            </div>




            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="exampleInputEmail1" class="form-label fw-semibold">CONSECUTIVO AUTORIZACIÓN o ANÁLISIS<span
                        class="text-danger" style="font-size:20px;">*</span></label>
                <input type="text" class="form-control" name="consecutivoa" id="consecutivoa" value=""
                    required autocomplete="off" maxlength="10">
                <div id="consecutivoaError" style="color: red;" class="fw-bold"></div>
                <div id="consecutivoaError2" style="color: red;" class="fw-bold"></div>
            </div>

            <div class="mb-3 w-100">
                <label for="exampleInputEmail1" class="form-label fw-semibold">ADJUNTAR RECIBO DE CAJA</label>
                <input type="file" class="form-control" name="NombreAnalisis" id="NombreAnalisis" required>
                <p class="formato-ayuda2">Debe contener el formato: <strong>RC-(Cédula).pdf</strong></p>
            </div>



            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="exampleInputEmail1" class="form-label fw-semibold">CONSECUTIVO RECIBO DE CAJA <span
                        class="text-danger" style="font-size:20px;">*</span></label>
                <input list="Consecutivo" type="text" class="form-control" name="ConsecutivoRC"
                    id="ConsecutivoAnalisis" value="" required autocomplete="off" maxlength="10"
                    pattern="[0-9]+|N/A" title="Debe ingresar solo números o 'N/A'">
                <div id="consecutivoAnalisisError" style="color: red;" class="fw-bold"></div>
                <div id="consecutivoAError2" style="color: red;" class="fw-bold"></div>
            </div>

            <datalist id="Consecutivo">
                <option value="N/A"></option>
            </datalist>


            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="exampleInputEmail1" class="form-label fw-semibold">OBSERVACIÓN RECIBO DE CAJA</label>
                <input list="" type="text" class="form-control" name="ObRC" id="ConsecutivoAnalisis"
                    value="" autocomplete="off" maxlength="200">
                <div id="consecutivoAnalisisError" style="color: red;" class="fw-bold"></div>
                <div id="consecutivoAError2" style="color: red;" class="fw-bold"></div>
            </div>



            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="estado" class="form-label fw-semibold">LINEA DE CRÉDITO <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <select class="form-control " name="Linea" id="estado" required>
                    <option value="">Seleccione una opción</option>
                    <option value="16">16</option>
                    <option value="18">18</option>
                    <option value="20">20</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="60">60</option>
                    <option value="61">61</option>
                    <option value="62">62</option>
                    <option value="63">63</option>
                    <option value="64">64</option>
                    <option value="65">65</option>
                    <option value="70">70</option>
                    <option value="76">76</option>
                    <option value="77">77</option>
                    <option value="78">78</option>
                    <option value="79">79</option>
                    <option value="80">80</option>
                    <option value="81">81</option>
                    <option value="82">82</option>
                    <option value="83">83</option>
                    <option value="84">84</option>
                    <option value="85">85</option>
                    <option value="86">86</option>
                    <option value="87">87</option>
                    <option value="88">88</option>
                    <option value="89">89</option>
                    <option value="90">90</option>
                    <option value="93">93</option>
                    <option value="94">94</option>
                    <option value="99">99</option>
                </select>
                <div id="estadoError" style="color: red;" class="fw-bold"></div>
            </div>


            <datalist id="Consecutivo">
                <option value="N/A"></option>
            </datalist>


            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="exampleInputEmail1" class="form-label fw-semibold">MONTO <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input list="" type="text" class="form-control" name="Monto" id="Monto" value=""
                    required autocomplete="off" maxlength="15">
                <div id="consecutivoMError" style="color: red;" class="fw-bold"></div>
                <div id="consecutivoMError2" style="color: red;" class="fw-bold"></div>
            </div>


            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="" class="form-label fw-semibold">INSPEKTOR <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input list="Consecutivo" autocomplete="off" type="text" class="form-control" name="Inspektor"
                    id="Inspektor" required>
                <div id="InspektorError" style="color: red;" class="fw-bold"></div>
                <div id="Inspektorrror2" style="color: red;" class="fw-bold"></div>
                <p class="formato-ayuda"><strong>N/A(No aplica)</strong>.</p>

            </div>

            <script>
                var InspektorInput = document.getElementById('Inspektor');
                var InspektorError = document.getElementById('InspektorError');

                InspektorInput.addEventListener('keyup', function() {
                    var Inspektor = InspektorInput.value.trim();

                    if (/^\d{0,10}$|^N\/A$/i.test(Inspektor)) {
                        InspektorError.innerHTML = '';
                    } else {
                        InspektorError.innerHTML = 'Ingrese un número de INSPEKTOR correcto!';
                    }
                });

                InspektorInput.setAttribute("maxlength", "10");

                var MontoInput = document.getElementById('Monto');
                var MontoError = document.getElementById('consecutivoMError');

                MontoInput.addEventListener('keyup', function() {
                    var Monto = MontoInput.value.trim();

                    if (/^[0-9]{1,10}$/.test(Monto)) {
                        MontoError.innerHTML = '';
                    } else {
                        MontoError.innerHTML = 'Ingrese un Monto correcto!';
                    }
                });



                var consecutivoaInput = document.getElementById('consecutivoa');
                var consecutivoaError = document.getElementById('consecutivoaError');

                consecutivoaInput.addEventListener('keyup', function() {
                    var consecutivoa = consecutivoaInput.value.trim();

                    if (/^[0-9]+$/.test(consecutivoa)) {
                        consecutivoaError.innerHTML = '';
                    } else {
                        consecutivoaError.innerHTML = 'Ingrese un consecutivo correcto!';
                    }
                });

                $(document).ready(function() {
                    $('#ConsecutivoAnalisis').change(function() {
                        if ($(this).val().toLowerCase() === 'n/a') {
                            $('#NombreAnalisis').val('');
                            $('#NombreAnalisis').attr('disabled', true);
                        } else {
                            $('#NombreAnalisis').attr('disabled', false);
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
            <div>
                <button onclick="return confirmar()" id="agregar" type="submit" class="btn btn-primary"
                    name="btnregistrar" value="ok" style="background-color: #005E56;"
                    name="registrar">Registrar</button>
            </div>
            <script>
                @if (session('showLoadingAlert'))
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
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
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
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
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

                    if (!/^[0-9]+$/.test(cuentaInput.value)) {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: 'El campo NÚMERO DE CUENTA debe contener dígitos numéricos!',
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



                    var consecutivofInput = document.getElementById('ConsecutivoAnalisis');
                    var consecutivofError2 = document.getElementById('consecutivoAError2');

                    if (!/^\d{0,10}$|^N\/A$/i.test(consecutivofInput.value)) {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: 'El campo CONSECUTIVO ANÁLISIS debe contener dígitos numéricos ó N/A!',
                            confirmButtonColor: '#005E56'
                        });

                        consecutivofError2.textContent = '';
                        consecutivofInput.focus();
                        return false;
                    }

                    var consecutivoaInput = document.getElementById('consecutivoa');
                    var consecutivoaError2 = document.getElementById('consecutivoaError2');

                    if (!/^[0-9]+$/.test(consecutivoaInput.value)) {
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

                    var MontoInput = document.getElementById('Monto');
                    var MontoError2 = document.getElementById('consecutivoMError2');

                    if (!/^[0-9]+$/.test(MontoInput.value)) {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: 'El campo MONTO debe contener solo registros numéricos!',
                            confirmButtonColor: '#005E56'
                        });
                        MontoError2.textContent = '';
                        MontoInput.focus();
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
                <table id="personas"
                    class="hover table table-striped shadow-lg mt-4 table-bordered table-hover col-md-5">
                    <thead class="" style="background-color: #005E56;">
                        <tr class="text-white">
                            <th class="" scope="col">#</th>
                            <th class="" scope="col">CÉDULA</th>
                            <th class="" scope="col">NOMBRE</th>
                            <th class="" scope="col">APELLIDOS</th>
                            <th class="" scope="col">OBSERVACIONES</th>
                            <th class="" scope="col">CUENTA</th>
                            <th class="text-center" scope="col">AGENCIA</th>
                            <th class="" scope="col">ESTADO</th>
                            <th class="" scope="col" title="">AUTORIZACIÓN Y/O ANÁLISIS</th>
                            <th class="" scope="col" title="Consecutivo Autorización">IDA</th>
                            <th class="" scope="col" title="Análisis">RC</th>

                            <th class="" scope="col">OBSERVACIONES RC</th>
                            <th class="" scope="col">LINEA</th>
                            <th class="" scope="col">MONTO</th>
                            <th class="" scope="col">TOTAL DEUDA</th>
                            <th class="" scope="col">FECHA GNR</th>
                            <th class="" scope="col">INSPEKTOR</th>
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
                "ajax": "{{ route('datatable.directorcredito') }}",
                "columns": [{
                        data: null,
                        title: '#',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'Cedula'
                    },
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
                    {
                        data: 'Apellidos'
                    },
                    {
                        data: 'Observaciones',
                        render: function(data, type, row) {
                            var html = '<span style="font-weight: 700;">' + data + '</span>';
                            return html;
                        }
                    },
                    {
                        data: 'CuentaAsociada'
                    },
                    {
                        data: 'Agencia',
                        render: function(data, type, row) {
                            var agencia = data.charAt(0).toUpperCase() + data.slice(1).toLowerCase();
                            return agencia;
                        }
                    },
                    {
                        data: 'Estado'
                    },
                    {
                        data: 'NombreA',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                if (data === null) {
                                    return '';
                                } else {
                                    return '<a href="Storage/files/autorizacion/' + data +
                                        '" target="__blank"><img src="img/pdf.png" style="height: 2.5rem"></a>';
                                }
                            }
                            return data;
                        }
                    },
                    {
                        data: 'ConsecutivoA'
                    },
                    {
                        data: 'NombreAnalisis',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                if (data === null) {
                                    return '';
                                } else {
                                    return '<a href="Storage/files/rccreditos/' + data +
                                        '" target="__blank"><img src="img/pdf.png" style="height: 2.5rem"></a>';
                                }
                            }
                            return data;
                        }
                    },

                    {
                        data: 'ObRC'
                    },
                    {
                        data: 'Linea'
                    },
                    {
                        data: 'Monto'
                    },
                    {
                        data: 'DeudaEsp'
                    },
                    {
                        data: 'FechaInsercion',
                        render: function(data, type, row) {
                            var html = '';
                            var fecha_insercion = new Date(data);

                            var fecha_actual = new Date();
                            var diferencia = Math.floor((fecha_actual - fecha_insercion) / (1000 * 60 * 60 *
                                24));

                            if (parseInt(row.Consulta) === 1 && diferencia > 180) {
                                html += data +
                                    '<span class="text-danger fw-bold blink" style="font-size: 20px;"><br><span style="background-color: yellow;">RENOVAR</span></span>';
                            } else if (diferencia > 180) {
                                html += data +
                                    '<span class="text-danger fw-bold blink" style="font-size: 20px;"><br>VENCIDO</span>';
                            } else if (diferencia <= 175 && diferencia > 179) {
                                html += data +
                                    '<span class="text-danger fw-bold blink" style="font-size: 20px;"><br><span style="background-color: yellow;">Pronto a vencerse en ' +
                                    (diferencia + 1) + ' días</span>';
                            } else if (diferencia === 179) {
                                html += data +
                                    '<span class="text-danger fw-bold blink" style="font-size: 20px;"><br><span style="background-color: yellow;">Se vence en 2 dias</span>';
                            } else if (diferencia === 180) {
                                html += data +
                                    '<span class="text-danger fw-bold blink" style="font-size: 20px;"><br><span style="background-color: yellow;">¡Se vence mañana!</span>';
                            } else {
                                html += data +
                                '<span class="fw-bold" style="color: #1565c0;"><br>Al día</span>';
                            }

                            return html;
                        }
                    },
                    {
                        data: "Inspektor"
                    },

                    {
                        data: 'FechaCorreo'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var id = row.ID; // Obtener el ID de la fila
                            var url = "{{ route('crud.updatecredito', ':id') }}";
                            var today = new Date().toISOString().split('T')[0];
                            url = url.replace(':id', id);

                            var html = '';
                            var fecha_insercion = new Date(data
                            .FechaInsercion); // Assuming "FechaInsercion" is a property in the "data" object
                            var fecha_actual = new Date();
                            var diferencia = Math.floor((fecha_actual - fecha_insercion) / (1000 * 60 * 60 *
                                24));

                            function toggleCheckbox() {
                                var checkbox = document.getElementById("Consulta");
                                checkbox.checked = !checkbox.checked;
                            }
                            if (row.Consulta == 1) {
                                html
                            } else if (diferencia > 180) {
                                html += `
  <div class="mb-3 ">
      <label for="label" id="izquierda2" class="form-label fw-bold" style="margin-left: -70%">RECIBO DE CAJA</label>
      <input list="Consecutivo" type="number" class="form-control" name="recibo" id="recibo" value="" max="999999999999">
      <input type="hidden" name="cuenta" value="">
  </div>

  <div class="mb-3 w-100 text-start" title="Datacredito vencido!">
    <input type="checkbox" id="Consulta" name="Consulta" value="1" style="width: 25px; height: 20px;">
    <label for="Consulta" class="fw-semibold" style="font-size: 25px" onclick="toggleCheckbox()">SOLICITAR CONSULTA</label>
    </div>


    <datalist id="Consecutivo">
    <option value="N/A"></option>
  </datalist>`;


                            }
                            var deleteButton =
                                '<a onclick="showUnauthorizedMessage()" href="#" type="" class="btn btn-small btn-danger" name="eliminar" value="ok"><i class="fa-solid fa-trash"></i></a>'
                                .replace(':id', row.ID);
                            var editButton = `<a href="" id="modalLink_${id}" type="submit" class="btn btn-small btn-warning edit-button edit" data-bs-toggle="modal" data-bs-target="#modalEditar_${id}" data-id="${id}" style="margin-right: "><i class="fa-regular fa-pen-to-square"></i></a>
    <div class="modal fade" id="modalEditar_${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content" style="color: black">
                        <button type="button" data-bs-dismiss="modal" class="btn-close p-3" aria-label="Close"></button>
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                          <h1 class="modal-title text-center" id="modificar" style="color: black">MODIFICAR</h1>
                        </div>
                        <hr>
                        <div class="modal-body">
                          <form action="` + url + `" class="text-center" method="POST" enctype="multipart/form-data" id="formulario" onsubmit="return validateForm2()">
                            @csrf
                            <!-- Resto del contenido del modal -->
              <div class="mb-3">
                <label for="cedula2" id="izquierda7" class="form-label fw-bold" value="">CÉDULA</label>
                <input type="text" class="form-control" name="cedula2" id="cedula2" readonly value="${row.Cedula}" style="background-color: #EBEBEB; cursor: not-allowed;">
                <input type="hidden" name="cedula3"  value="">
              </div>

              <div class="mb-3">
                <label for="nombre3" id="izquierda3" class="form-label fw-bold"">NOMBRE</label>
                <input type="text" class="form-control" id="nombre3" name="nombre3" value="${row.Nombre}" maxlength="30" required>
                <div id="nombreError3" style="color: red;" class="fw-bold"></div>
              </div>



              <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda6" class="form-label fw-bold"">APELLIDOS</label>
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
                  <label for="label" id="izquierda2" class="form-label fw-bold"">CUENTA ASOCIADA</label>
                  <input type="text" class="form-control" name="cuenta3" id="cuenta3" value="${row.CuentaAsociada}">
                  <input type="hidden" name="cuenta" value="">
              </div>

              <!--Label5-->
              <div class="mb-3">
                  <label for="click" id="izquierda7" class="form-label fw-bold" >AGENCIA</label>
                  <input list="agencia" type="text" class="form-control" id="agencia3" name="agencia3" value="${row.Agencia}" maxlength="20" required autocomplete="off" style="background-color: #EBEBEB; cursor: not-allowed;" readonly>
                  <div id="agenciaError3" style="color: red;" class="fw-bold"></div>
              </div>

              <div class="mb-3" style="display: none;>
                  <label for="exampleInputEmail1" id="izquierda" class="form-label fw-bold" >FECHA</label>
                  <input type="date" class="form-control" name="fecha3" id="fecha3" min="2022-08-01" max="` + today + `" value="${row.FechaInsercion}" required>
                </div>

                <div class="mb-3">
                <label for="exampleInputEmail1" id="izquierda9" class="form-label fw-bold"">ESTADO</label>
                <select class="form-control" name="estado3" id="estado3">
                  <option value=""></option>
                  <option value="N" ${row.Estado === 'N' ? 'selected' : ''}>Normal</option>
                  <option value="B" ${row.Estado === 'B' ? 'selected' : ''}>Bloqueado</option>
                  <option value="S" ${row.Estado === 'S' ? 'selected' : ''}>Suspendido</option>
                  <option value="J" ${row.Estado === 'J' ? 'selected' : ''}>Judicial</option>
                  <option value="I" ${row.Estado === 'I' ? 'selected' : ''}>Insolvente</option>
                  <option value="R" ${row.Estado === 'R' ? 'selected' : ''}>Renovar</option>
                </select>
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
                    <label for="label" id="" class="form-label fw-bold" style="margin-left: -28%;">ADJUNTAR AUTORIZACIÓN Y/O ANÁLISIS</label>
                  <input type="file" class="form-control" name="archivo3" id="archivo3" accept="application/pdf" value="">
                  <p class="formato-ayuda2">Debe contener el formato: <strong>Autorizacion-(Cédula).pdf</strong></strong></p>
                  </div>

                  <div class="mb-3">
  <label for="label" id="izquierda11" class="form-label fw-bold" style="margin-left: -23%;">CONSECUTIVO AUTORIZACIÓN Y/O ANÁLISIS</label>
  <input type="text" class="form-control" name="consecutivoa33" id="consecutivoa33" value="${row.ConsecutivoA}" maxlength="8">
  <div id="consecutivoError3" style="color: red;" class="fw-bold"></div>
</div>




<div class="mb-3">
                <label for="exampleInputEmail1" id="" class="form-label fw-bold" style="margin-left: -68%">LINEA DE CRÉDITO</label>
                <select class="form-control" name="linea2" id="linea2">
                  <option value=""></option>
                  <option value="16" ${row.Linea === '16' ? 'selected' : ''}>16</option>
                  <option value="18" ${row.Linea === '18' ? 'selected' : ''}>18</option>
                  <option value="20" ${row.Linea === '20' ? 'selected' : ''}>20</option>
                  <option value="32" ${row.Linea === '32' ? 'selected' : ''}>32</option>
                  <option value="33" ${row.Linea === '33' ? 'selected' : ''}>33</option>
                  <option value="34" ${row.Linea === '34' ? 'selected' : ''}>34</option>
                  <option value="39" ${row.Linea === '39' ? 'selected' : ''}>39</option>
                  <option value="40" ${row.Linea === '40' ? 'selected' : ''}>40</option>
                  <option value="60" ${row.Linea === '60' ? 'selected' : ''}>60</option>
                  <option value="61" ${row.Linea === '61' ? 'selected' : ''}>61</option>
                  <option value="62" ${row.Linea === '62' ? 'selected' : ''}>62</option>
                  <option value="63" ${row.Linea === '63' ? 'selected' : ''}>63</option>
                  <option value="64" ${row.Linea === '64' ? 'selected' : ''}>64</option>
                  <option value="65" ${row.Linea === '65' ? 'selected' : ''}>65</option>
                  <option value="70" ${row.Linea === '70' ? 'selected' : ''}>70</option>
                  <option value="76" ${row.Linea === '76' ? 'selected' : ''}>76</option>
                  <option value="77" ${row.Linea === '77' ? 'selected' : ''}>77</option>
                  <option value="78" ${row.Linea === '78' ? 'selected' : ''}>78</option>
                  <option value="79" ${row.Linea === '79' ? 'selected' : ''}>79</option>
                  <option value="80" ${row.Linea === '80' ? 'selected' : ''}>80</option>
                  <option value="81" ${row.Linea === '81' ? 'selected' : ''}>81</option>
                  <option value="82" ${row.Linea === '82' ? 'selected' : ''}>82</option>
                  <option value="83" ${row.Linea === '83' ? 'selected' : ''}>83</option>
                  <option value="84" ${row.Linea === '84' ? 'selected' : ''}>84</option>
                  <option value="85" ${row.Linea === '85' ? 'selected' : ''}>85</option>
                  <option value="86" ${row.Linea === '86' ? 'selected' : ''}>86</option>
                  <option value="87" ${row.Linea === '87' ? 'selected' : ''}>87</option>
                  <option value="88" ${row.Linea === '88' ? 'selected' : ''}>88</option>
                  <option value="89" ${row.Linea === '89' ? 'selected' : ''}>89</option>
                  <option value="90" ${row.Linea === '90' ? 'selected' : ''}>90</option>
                  <option value="93" ${row.Linea === '93' ? 'selected' : ''}>93</option>
                  <option value="94" ${row.Linea === '94' ? 'selected' : ''}>94</option>
                  <option value="99" ${row.Linea === '99' ? 'selected' : ''}>99</option>

                </select>
              </div>

                <div class="mb-3">
                  <label for="nombre3" id="" class="form-label fw-bold" style="margin-left: -86%">MONTO</label>
                  <input type="text" class="form-control" id="monto" name="monto" value="${row.Monto}" pattern="[0-9]+|N/A" title="Debe ingresar solo números" maxlength="10" oninput="this.value = this.value.toUpperCase(); toggleFields()">
                  <div id="nombreError3" style="color: red;" class="fw-bold"></div>
                </div>

                <div class="mb-3">
                  <label for="cedula2" id="" style="margin-left: -80%;" class="form-label fw-bold" value="">INSPEKTOR</label>
                  <input list="Consecutivo" autocomplete="off" type="text" class="form-control" name="Inspektor2" id="Inspektor2" value="${row.Inspektor}" title="Solo números o N/A">
                  <input type="hidden" name="cedula3"  value="">
                  <p class="formato-ayuda"><strong>N/A(No aplica)</strong>.</p>
                </div>

                <div class="mb-3">
                  <label for="exampleInputEmail1" id="izquierda15" class="form-label fw-bold" style="margin-left: -73%">ADJUNTAR RC</label>
                  <input type="file" class="form-control" name="archivo33" id="archivo33" accept="application/pdf" value="">
                  <p class="formato-ayuda2">Formato: <strong>RC-(Cédula).pdf</strong></p>
                </div>

                <div class="mb-3 w-100" title="Este campo es obligatorio">
                  <label for="exampleInputEmail1" class="form-label fw-bold" style="margin-left: -46%">OBSERVACIÓN RECIBO DE CAJA</label>
                  <input list="" type="text" class="form-control" name="ObRC3" id="ConsecutivoAnalisis" value="${row.ObRC}" autocomplete="off" maxlength="200" >
                  <div id="consecutivoAnalisisError" style="color: red;" class="fw-bold"></div>
                  <div id="consecutivoAError2" style="color: red;" class="fw-bold"></div>
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

                            return editButton + ' ' + deleteButton;

                        }
                    }
                ],

                "lengthMenu": [
                    [1, 5],
                    [1, 5]
                ],
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




            function eliminar() {
                var respuesta = confirm("¿Estas seguro que deseas eliminar este registro?")
                return respuesta
            }


            function csesion() {
                var respuesta = confirm("¿Estas seguro que deseas cerrar sesión?")
                return respuesta
            }

            function confirmar() {
                var respuesta = confirm("POR FAVOR REVISAR LA CÉDULA. LOS CAMBIOS PUEDEN SER IRREVERSIBLES.")
                return respuesta
            }
        </script>


    </div>

    </div>

    </div>
@endsection
