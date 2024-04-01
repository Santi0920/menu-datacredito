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
                    timer: 3000

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

    @include('layouts/nav-coordinacion')
    <style>
        .formato-ayuda {
            color: gray;
            font-style: inherit;
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
                <h2 class="p-1 mb-3 text-secondary text-start"><b>Registros Pagare - <span class="text-end"
                            id="fechaActual"></b></span></h2>
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
            <table id="personas"
                class="hover table table-responsive table-striped shadow-lg mt-2 table-bordered table-hover">
                <thead class="" style="background-color: #005E56;">
                    <tr class="text-white">
                        <th scope="col">#</th>
                        <th scope="col">SCORE</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col">APROBADO</th>
                        <th scope="col">AGENCIA</th>
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
                        <th scope="col">1 CUOTA</th>
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
    <script>
        var table = $('#personas').DataTable({
            "ajax": "{{ route('datatable.coordipagare') }}",
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
                                '<span class="text-success" style="font-weight: bold; font-size: 30px">SI</span>';
                        } else if (row.Aprobado == 0) {
                            var AprobadoButton =
                                '<span class="text-danger" style="font-weight: bold; font-size: 30px">NO</span>';
                        } else {
                            var AprobadoButton =
                                '<span class="" style="font-weight: bold; font-size: 30px">PENDIENTE</span>';
                        }
                        return AprobadoButton;

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
                    data: 'ID_Pagare'
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
                    data: 'FechaCredito'
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
                    data: 'Fecha1Cuota'
                },
                {
                    data: 'FechaUltimaCuota'
                },
                {
                    data: 'Celular'
                },
                {
                    data: 'Correo'
                },
                {
                    data: 'GeneradorPagare'
                }
            ],


            "lengthMenu": [
                [7],
                [7]
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

        function fecha() {
            var respuesta = confirm("Recuerda cambiar la FECHA ya que el datacrédito esta vencido!")
            return respuesta
        }

        function eliminar() {
            var respuesta = confirm("¿Estas seguro que deseas eliminar este registro?")
            return respuesta
        }

        function csesion() {
            var respuesta = confirm("¿Estas seguro que deseas cerrar sesión?")
            return respuesta
        }
    </script>


    </div>

    </div>

    </div>
@endsection
