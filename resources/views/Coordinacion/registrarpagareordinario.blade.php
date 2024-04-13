@extends('layouts.base')

@section('content')
    @if (session('correcto'))
        <div>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: "¡APROBADO!",
                    html: `{!! session('correcto') !!}`,
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
                    title: "{!! session('correcto2') !!}",
                    confirmButtonColor: '#005E56',


                });
            </script>
        </div>
    @endif

    @if (session('incorrecto'))
        <div>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: "¡RECHAZADO!",
                    html: `{!! session('incorrecto') !!}`,
                    confirmButtonColor: '#005E56',

                });
            </script>
        </div>
    @endif

    @if (session('incorrecto2'))
        <div>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: "{!! session('incorrecto2') !!}",
                    confirmButtonColor: '#005E56',

                });
            </script>
        </div>
    @endif


    @if (session('incorrecto3'))
        <div>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: "¡ERROR!",
                    html: `{!! session('incorrecto3') !!}`,
                    confirmButtonColor: '#005E56',

                });
            </script>
        </div>
    @endif

    @if (session('incorrecto4'))
        <div>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: "¡PAGARÉ NO REGISTRADO!",
                    html: `{!! session('incorrecto4') !!}`,
                    confirmButtonColor: '#005E56',

                });
            </script>
        </div>
    @endif


    @if (session('correcto3'))
        <div>
            <script>
                Swal.fire({
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
                Swal.fire({
                    icon: 'error',
                    title: "Error al registrar!\n{{ $message }}",
                    text: '',
                    confirmButtonColor: '#005E56'

                });
            </script>
        </div>
    @enderror

    @include('layouts/nav-coordinacion')

    <div class="contenedor2">
        <div class="agregar2">
            <a href="datacredito.php" class="btn btn-primary"
                style="font-size: 35px;font-family: 'Montserrat', sans-serif; font-weight: bold;" data-bs-toggle="modal"
                data-bs-target="#exampleModal3">
                <span style="margin-bottom: 30px; margin-top: 20px;">V1</span>
            </a>
        </div>
    </div>


    <div class="container-fluid row p-4">
        <form action="{{ route('crudger.createpagareordinario') }}" class="col m-3" method="POST"
            enctype= "multipart/form-data" id="pagare">
            @csrf
            <h2 class="p-2 text-secondary text-center"><b>Registrar Pagaré Único</b></h2>
            <style>
                .formato-ayuda {
                    color: gray;
                    font-style: italic;
                }
            </style>

            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input2" class="form-label fw-semibold">NÚMERO DE AGENCIA <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="number" class="form-control " name="NoAgencia" id="input2" autocomplete="off"
                    oninput="limitInputLength(this, 2)" required>
                <script>
                    function limitInputLength(element, maxLength) {
                        if (element.value.length > maxLength) {
                            element.value = element.value.slice(0, maxLength);
                        }
                    }
                </script>
            </div>

            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input3" class="form-label fw-semibold">CUENTA ASOCIADO <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="number" class="form-control " name="CuentaCoop" id="input3" autocomplete="off" required
                    oninput="limitInputLength(this, 8)">

            </div>

            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input4" class="form-label fw-semibold">CÉDULA <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="number" class="form-control " name="Cedula_Persona" id="input4" autocomplete="off" required
                    oninput="limitInputLength(this, 12)">

            </div>

            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input5" class="form-label fw-semibold">NOMBRE COMPLETO <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="text" class="form-control " name="NombreCompleto" id="input5" autocomplete="off" required
                    oninput="limitInputLength(this, 40)">

            </div>

            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input7" class="form-label fw-semibold">LÍNEA CRÉDITO <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <select class="form-control" name="Linea_Credito" id="input7" required>
                    <option value="">Seleccionar...</option>
                    <option value="60">60</option>
                    <option value="90">90</option>
                    <option value="94">94</option>
                    <option value="99">99</option>
                </select>
            </div>




            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input8" class="form-label fw-semibold">CAPITAL <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="number" class="form-control " name="Capital" id="input8" autocomplete="off" required
                    oninput="limitInputLength(this, 20)">

            </div>

            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input9" class="form-label fw-semibold">NÚMERO DE CUOTAS <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="number" class="form-control " name="NoCuotas" id="input9" autocomplete="off" required
                    oninput="limitInputLength(this, 3)">

            </div>

            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input10" class="form-label fw-semibold">VALOR CUOTA <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="number" class="form-control " name="ValorCuota" id="input10" autocomplete="off"
                    required oninput="limitInputLength(this, 20)">

            </div>
            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input11" class="form-label fw-semibold">TASA <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="text" class="form-control" name="Tasa" id="input11" autocomplete="off" required
                    oninput="validateTasaInput(this); limitInputLength(this, 6)" onblur="formatTasa(this)">
                <p class="formato-ayuda">Ejemplo: <strong>2,300</strong>.</p>
            </div>

            <script>
                function validateTasaInput(input) {
                    // Permitir solo caracteres numéricos y la coma
                    input.value = input.value.replace(/[^\d,]/g, '');
                }

                function formatTasa(input) {
                    // Obtener el valor actual del campo
                    let valor = input.value;

                    // Reemplazar comas por puntos para que parseFloat funcione correctamente
                    valor = valor.replace(/,/g, '.');

                    // Verificar si el valor es un número
                    if (!isNaN(parseFloat(valor)) && isFinite(valor)) {
                        // Redondear el número a dos decimales y agregar un cero si es necesario
                        valor = parseFloat(valor).toFixed(3);

                        // Reemplazar el punto decimal con coma
                        valor = valor.replace('.', ',');

                        // Actualizar el valor del campo
                        input.value = valor;
                    }
                }

                function limitInputLength(input, maxLength) {
                    // Limitar la longitud del campo
                    let valor = input.value;

                    if (valor.length > maxLength) {
                        input.value = valor.slice(0, maxLength);
                    }
                }
            </script>





            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input14" class="form-label fw-semibold">DIRECCIÓN <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="text" class="form-control " name="Direccion" id="input14" autocomplete="off" required
                    oninput="limitInputLength(this, 100)">

            </div>

            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input15" class="form-label fw-semibold">TELÉFONO FIJO <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="number" class="form-control " name="TelFijo" id="input15" autocomplete="off" required
                    oninput="limitInputLength(this, 12)">
                <p class="formato-ayuda">Ingresar: <strong>0</strong> si no cuenta con teléfono fijo.</p>
            </div>

            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input16" class="form-label fw-semibold">FECHA 1ra CUOTA <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="number" class="form-control" name="Fecha1Cuota" id="input16" autocomplete="off"
                    required oninput="validateFecha1Cuota(this)">
                <p class="formato-ayuda">Ejemplo: <strong>1240130</strong>. 124 - es el año, 01 - es el mes y 30 - es el
                    día.</p>
                <p id="errorFecha1Cuota" class="text-danger"></p>
            </div>



            <script>
                function validateFecha1Cuota(input) {
                    let valor = input.value;

                    // Utilizar expresión regular para verificar el formato YYYMMDD
                    if (/^\d{3}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])$/.test(valor)) {
                        // Limpiar el mensaje de error si el formato es correcto
                        document.getElementById('errorFecha1Cuota').textContent = "";

                        // Habilitar el botón si el formato es correcto
                        document.getElementById('agregar').disabled = false;
                    } else {
                        // Mostrar mensaje de error si el formato no es correcto
                        document.getElementById('errorFecha1Cuota').textContent = "El formato debe ser YYYMMDD.";

                        // Deshabilitar el botón si el formato no es correcto
                        document.getElementById('agregar').disabled = true;
                    }
                }
            </script>




            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input17" class="form-label fw-semibold">Fecha ULTIMA CUOTA <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="number" class="form-control" name="FechaUltimaCuota" id="input17" autocomplete="off"
                    required oninput="validateFechaUltimaCuota(this)">
                <p class="formato-ayuda">Ejemplo: <strong>1240130</strong>. 124 - es el año, 01 - es el mes y 30 - es el
                    día.</p>
                <p id="errorFechaUltimaCuota" class="text-danger"></p>
            </div>

            <script>
                function validateFechaUltimaCuota(input) {
                    let valor = input.value;

                    // Utilizar expresión regular para verificar el formato YYYMMDD
                    if (/^\d{3}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])$/.test(valor)) {
                        // Limpiar el mensaje de error si el formato es correcto
                        document.getElementById('errorFechaUltimaCuota').textContent = "";

                        // Habilitar el botón si el formato es correcto
                        document.getElementById('agregar').disabled = false;
                    } else {
                        // Mostrar mensaje de error si el formato no es correcto
                        document.getElementById('errorFechaUltimaCuota').textContent = "El formato debe ser YYYMMDD.";

                        // Deshabilitar el botón si el formato no es correcto
                        document.getElementById('agregar').disabled = true;
                    }
                }
            </script>

            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input18" class="form-label fw-semibold">CELULAR <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="number" class="form-control " name="Celular" id="input18" autocomplete="off" required
                    oninput="limitInputLength(this, 20)">

            </div>



            <div class="mb-3 w-100" title="Este campo es obligatorio">
                <label for="input19" class="form-label fw-semibold">GARANTIA <span class="text-danger"
                        style="font-size:20px;">*</span></label>
                <input type="text" class="form-control" name="Garantia" id="input19" autocomplete="off" required
                    oninput="validarGarantia(this); limitInputLength(this, 6)">
                <p class="formato-ayuda">Ingresar: <strong>X, 0, 1, 6, 7.</strong></p>
            </div>

            <script>
                function validarGarantia(input) {
                    input.value = input.value.toUpperCase();
                    // Expresión regular que permite solo los caracteres X, 0, 1, 6, 7
                    var regex = /^[X0167]+$/;

                    // Verificar si el valor actual del campo cumple con la expresión regular
                    if (!regex.test(input.value)) {
                        // Si no cumple, eliminar el último carácter ingresado
                        input.value = input.value.slice(0, -1);
                    }
                }
            </script>



            <div class="text-center">
                <button id="agregar" type="submit" class="btn btn-primary fs-4 fw-bold" name="btnregistrar"
                    style="background-color: #005E56;" disabled>Registrar</button>
            </div>

        </form>


        <script>
            var existeNominaDepenData = null;
            var loadingTimer;


            $(document).ready(function() {

                function handleInputChanges() {
                    var fechaCredito = $('#input12').val();
                    var fecha1eraCuota = $('#input16').val();

                    if (fechaCredito && fecha1eraCuota) {
                        $.ajax({
                            url: "{{ route('crudcoord.FechaReporte') }}",
                            method: 'POST',
                            data: {
                                CuentaCoop: $('#input3').val(),
                                fechaCredito: fechaCredito,
                                fecha1eraCuota: fecha1eraCuota,
                                _token: "{{ csrf_token() }}"
                            },
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Cargando...',
                                    text: 'Por favor, espere mientras se consulta al asociado.',
                                    icon: 'info',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                            },
                            success: function(response) {
                                if (response.existeNominaDepen) {
                                    existeNominaDepenData = response.existeNominaDepen;
                                    FechaValue = response.fechaCredito;
                                    FechaValue1eraCuota = response.Cuota1;
                                    Validar = response.fechaValidar;
                                    FechaReporte = response.fechaStringFechaReporteAjax;
                                }

                                // Llamar a confirmVote aquí
                                confirmVote();

                            },
                            error: function(response) {
                                document.getElementById('pagare').submit();
                            }
                        });
                    }
                }


                $('#input3').on('change', function() {
                    if ($('#input12').val() && $('#input16').val() && $('#input20').val()) {
                        handleInputChanges();
                    }
                });

            });

            function isValidEmail(email) {
                const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                return regex.test(email);
            }

            function confirmVote(event) {
                if (event && event.preventDefault) {
                    event.preventDefault();
                }

                let allInputsFilled = true;
                let isEmailValid = true;
                let emailValue = '';

                for (let i = 1; i <= 20; i++) {
                    let inputElement = document.getElementById('input' + i);
                    if (!inputElement || inputElement.value.trim() === '') {
                        allInputsFilled = false;
                        break;
                    }
                    if (inputElement.id === 'input19') {
                        emailValue = inputElement.value.trim();
                        isEmailValid = isValidEmail(emailValue);
                    }
                }
                if (!isEmailValid) {
                    Swal.fire({
                        title: '¡PAGARE DEVUELTO!',
                        html: 'El correo electrónico ingresado <strong>' + emailValue +
                            '</strong> no es válido. Por favor, ingrese un correo electrónico válido.',
                        icon: 'warning',
                        confirmButtonColor: '#005E56',
                        didClose: () => {
                            limpiarCampos();
                        }
                    });
                    return;
                }

                if (allInputsFilled && existeNominaDepenData) {
                    var dataDisplay = existeNominaDepenData.map(function(item) {
                        return "<span style='font-size: 25px'><strong>Nomina:</strong> " + item.NOMBRENOMINA +
                            '</span><br>' +
                            "<span style='font-size: 25px'><strong>Dependencia:</strong> " + item.CODDEPENDENCIA +
                            ' - ' + item.NOMDEPENDENCIA + '</span><br>' +
                            "<span style='font-size: 25px'><strong>Fecha de Reporte:</strong> <span style='font-size: 25px; text-transform: uppercase;'>" +
                            FechaReporte + '</span></span>';
                    }).join('<br><br>');

                    if (Validar === 'verdadero') {
                        showConfirmModal(dataDisplay);
                    } else {
                        let timerInterval;
                        Swal.fire({
                            icon: 'warning',
                            title: 'CARGANDO...',
                            html: dataDisplay,
                            timer: 5000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            onBeforeOpen: () => {
                                Swal.showLoading();
                                timerInterval = setInterval(() => {
                                    const content = Swal.getContent();
                                    if (content) {
                                        const b = content.querySelector('b');
                                        if (b) {
                                            b.textContent = Swal.getTimerLeft();
                                        }
                                    }
                                }, 100);
                            },
                            onClose: () => {
                                clearInterval(timerInterval);
                            }
                        }).then(() => {
                            if (existeNominaDepenData.some(item => item.FECHAREPORTE === 'SIN FECHA')) {
                                Swal.fire({
                                    title: '¡ERROR!',
                                    text: '¡NO TIENE FECHA DE REPORTE! INFORMAR AL COORDINADOR PARA ASIGNAR FECHA A LA NOMINA.',
                                    icon: 'error',
                                    confirmButtonColor: '#005E56',
                                }).then((result) => {
                                    if (result.value) {
                                        Swal.fire({
                                            title: 'Limpiando...',
                                            text: 'Limpiando los campos.',
                                            icon: 'info',
                                            allowOutsideClick: false,
                                            allowEscapeKey: false,
                                            showConfirmButton: false,
                                            timer: 1000,
                                            didOpen: () => {
                                                Swal.showLoading();
                                            }
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Procesando...',
                                    text: 'Por favor, espere se está analizando el Pagare.',
                                    icon: 'info',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                                document.getElementById('pagare').submit();
                            }
                        });
                    }
                } else if (!allInputsFilled) {
                    displayAlertWithEmptyInputs();
                }
            }

            function checkEmptyInputs() {
                let emptyInputNames = [];
                for (let i = 1; i <= 20; i++) {
                    let inputId = 'input' + i;
                    let inputElement = document.getElementById(inputId);
                    if (inputElement && inputElement.value.trim() === '') {
                        if (inputElement.name) {
                            // Remove the asterisk (*) from the name
                            let cleanName = inputElement.name.replace(/\s*\*$/, '');
                            emptyInputNames.push(cleanName);
                        }
                    }
                }
                return emptyInputNames;
            }

            function displayAlertWithEmptyInputs() {
                let emptyInputNames = checkEmptyInputs();
                let message = emptyInputNames.length > 0 ?
                    '<span style="font-size:23px">Los siguientes campos están vacíos: <strong>' + emptyInputNames.join(', ') +
                    '</strong><br>Por favor, complete todos los campos antes de registrar el pagaré!</span>';

                Swal.fire({
                    title: '¡PAGARE DEVUELTO!',
                    html: `<span>${message}</span>`,
                    icon: 'warning',
                    confirmButtonColor: '#005E56',
                    confirmButtonText: '<div style="font-size: 20px">OK</div>',
                    didClose: () => {
                        limpiarCampos();
                    }
                });
            }

            function showConfirmModal(dataDisplay) {
                Swal.fire({
                    icon: 'question',
                    title: '¿ESTÁ SEGURO DE REGISTRAR EL PAGARÉ?',
                    html: dataDisplay,
                    confirmButtonColor: '#005E56',
                    denyButtonText: '<div style="font-size: 30px">NO</div>',
                    confirmButtonText: '<div style="font-size: 30px">CONFIRMAR</div>',
                    reverseButtons: true,
                    showDenyButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Procesando...',
                            text: 'Por favor, espere se esta comprobando el Pagare.',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        document.getElementById('pagare').submit();
                    } else if (result.isDenied) {
                        Swal.fire({
                            title: 'Limpiando...',
                            text: 'Limpiando los campos.',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            timer: 1000,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                });
            }

            function limpiarCampos() {
                for (let i = 1; i <= 20; i++) {
                    let inputId = 'input' + i;
                    let inputElement = document.getElementById(inputId);
                    if (inputElement) {
                        inputElement.value = '';
                        inputElement.removeAttribute('readonly');
                    }
                }

                document.getElementById('input2').focus();
            }

            $('button[name="btnregistrar"]').on('click', function() {
                for (let i = 2; i <= 20; i++) {
                    let inputId = '#input' + i;
                    if ($(inputId).val() === '') {
                        $(inputId).css('background-color', 'mistyrose');
                        $(inputId).attr('placeholder', 'Obligatorio');
                    }
                }
            });

            $('#input2, #input3, #input4, #input5, #input6, #input7, #input8, #input9, #input10, #input11, #input12, #input13, #input14, #input15, #input16, #input17, #input18, #input19, #input20')
                .on('input', function() {
                    if ($(this).val() !== '') {
                        $(this).css('background-color', '');
                    }
                });


            document.querySelectorAll('input').forEach((input, index) => {
                input.addEventListener('keydown', (event) => {
                    if (event.key === ';') {
                        event.preventDefault();
                        input.readOnly = true; // Establece el input actual en readonly
                        const nextInput = document.getElementById('input' + (index + 1));
                        if (nextInput) {
                            nextInput.focus();
                        }
                    } else if (event.key === '*') {
                        const nextInput = document.getElementById('input' + (index));
                        if (nextInput) {
                            nextInput.focus();
                        }
                    }
                });
            });
        </script>


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
                            <th class="" scope="col">LINEA CRÉDITO</th>
                            <th scope="col">CAPITAL</th>
                            <th scope="col">NO CUOTAS</th>
                            <th scope="col">VALOR CUOTA</th>
                            <th scope="col">TASA</th>
                            <th scope="col">NOMINA</th>
                            <th scope="col">DIRECCIÓN</th>
                            <th scope="col">FIJO</th>
                            <th scope="col">ULTIMA CUOTA</th>
                            <th scope="col">CELULAR</th>
                            <th scope="col">GENERADOR PAGARE</th>

                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                    </tbody>
                </table>
                <div id="customTooltip"
                    style="font-weight:bold; display: none; position: absolute; background-color: white; color: #333; border: 1px solid #ddd; border-radius: 8px; padding: 5px; z-index: 100; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 300px; text-align: center;">
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
                "ajax": "{{ route('datatable.ordinarios') }}",
                "order": [
                    [0, 'desc']
                ],
                "columns": [{
                        data: 'ID',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '30px'
                            });
                        }
                    },
                    {
                        data: 'Score',
                        createdCell: function(td, cellData, rowData, row, col) {
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
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '30px'
                            });
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {

                            if (row.Aprobado == 1) {
                                var AprobadoButton =
                                    '<span class="text-success" style="font-weight: bold; font-size: 30px">A</span>';
                            } else if (row.Aprobado == 0) {
                                var AprobadoButton =
                                    '<span class="text-danger" style="font-weight: bold; font-size: 30px">R</span>';
                            } else {
                                var AprobadoButton =
                                    '<span class="text-secondary-emphasis" style="font-weight: bold; font-size: 30px">FA</span>';
                            }


                            return AprobadoButton;

                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var id = row.ID;
                            var url = "{{ route('crudger.adjuntarautorizacion', ':id') }}";
                            var today = new Date().toISOString().split('T')[0];
                            url = url.replace(':id', id);

                            var html = '';
                            if (row.AutorizacionGerente == 0) {

                                var editButton = `<div class="text-center fw-bold fs-2">N/A</div>`
                            } else if (row.AutorizacionGerente == 1) {
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
                          <form action="` + url + `" class="text-center" method="POST" enctype="multipart/form-data" id="formulario">
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
                            } else {
                                var editButton =
                                    `<a href="Storage/files/autorizacionpagare/${row.DocuAutorizacion}" download style="display: flex; justify-content: center;"><img src="img/pdf.png" style="height: 4.0rem; width: 3.0rem"></a>`
                            }
                            return editButton;

                        }
                    },
                    {
                        data: 'Garantia',
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).css({
                                'font-weight': 'bold',
                                'font-size': '30px'
                            });
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var Interes = '<span style="font-size:25px">' + row.InteresProporcional + '</span>';
                            return Interes;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var FechaAccion = '<strong style="font-size:25px">' + row.FechaAccion + '</strong>';
                            return FechaAccion;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var Fecha1Cuota = '<strong style="font-size:25px">' + row.Fecha1Cuota + '</strong>';
                            return Fecha1Cuota;
                        }
                    },
                    {
                        data: 'NoAgencia'
                    },
                    {
                        data: 'CuentaCoop'
                    },
                    {
                        data: 'Cedula_Persona'
                    },
                    {
                        data: 'NombreCompleto'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var NoLC = '<strong>' + row.NoLC + '</strong>';
                            var Linea_Credito = row.Linea_Credito;


                            return NoLC + '-' + Linea_Credito;
                        }
                    },
                    {
                        data: 'Capital'
                    },
                    {
                        data: 'NoCuotas'
                    },
                    {
                        data: 'ValorCuota'
                    },
                    {
                        data: 'Tasa'
                    },
                    {
                        data: 'Nomina'
                    },
                    {
                        data: 'Direccion'
                    },
                    {
                        data: 'TelFijo'
                    },
                    {
                        data: 'FechaUltimaCuota'
                    },
                    {
                        data: 'Celular'
                    },
                    {
                        data: 'GeneradorPagare'
                    },

                ],


                "lengthMenu": [
                    [10, 15],
                    [10, 15]
                ],
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
                        var newAjaxSource =
                        '{{ route('datatable.consultarpagareger') }}'; // Adjust the route as needed

                        $('#personas').DataTable().ajax.url(newAjaxSource).load();
                    });

                    $('#btnR').on('click', function() {
                        var newAjaxSource =
                        '{{ route('datatable.rechazados') }}'; // Adjust the route as needed

                        $('#personas').DataTable().ajax.url(newAjaxSource).load();
                    });

                    $('#btnA').on('click', function() {
                        var newAjaxSource =
                        '{{ route('datatable.aprobados') }}'; // Adjust the route as needed

                        $('#personas').DataTable().ajax.url(newAjaxSource).load();
                    });

                    // $('#btnFA').on('click', function() {
                    //     var newAjaxSource = '{{ route('datatable.pendientes') }}'; // Adjust the route as needed

                    //     $('#personas').DataTable().ajax.url(newAjaxSource).load();
                    // });

                },
                responsive: "true",
                dom: 'Bfrtilp',
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> ',
                        titleAttr: 'Exportar a Excel',
                        className: 'btn btn-success btn-lg'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> ',
                        titleAttr: 'Imprimir',
                        className: 'btn btn-info btn-lg'
                    }
                ]
            });





            function activar() {
                var respuesta = confirm("¿Estas seguro que deseas activar este usuario?")
                return respuesta
            }

            function desactivar() {
                var respuesta = confirm("¿Estas seguro que deseas desactivar este usuario?")
                return respuesta
            }

            function eliminar() {
                var respuesta = confirm("¿Estas seguro que deseas eliminar este registro?")
                return respuesta
            }

            function eliminar2() {
                var respuesta = confirm("¿Estas seguro que deseas eliminar definitivamente este registro?")
                return respuesta
            }

            function csesion() {
                var respuesta = confirm("¿Estas seguro que deseas cerrar sesión?")
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
            background-color: #005E56;
            /* Color Verde */
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
