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
          timer: 5000
          
    
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
          timer: 10000,
    
      });  
  </script>
  </div>
@endif



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
        <li class="dropdown-toggle text-white text-start" style=" list-style-type: none; font-size: 25px" ><a class="fw-semibold text-white" style=" font-size: 25px; text-decoration: none; text-aling:start">Solicitud Datacrédito</a></li>
         
            <ul class="dropdown-menu" style="background-color: #005E56;">
              <li class="text-center"><a class="text-center text-white dropdown-item fw-semibold " style="font-size: 25px" href="gerenciaproveedor">Proveedores y Terceros</a></li>
              <li class="text-center"><a class="text-center text-white dropdown-item fw-semibold " style="font-size: 25px" href="consultarproveedorger">Consultar Proveedores y Terceros</a></li>
            </ul>
        </ul>
          <li class="text-white dropdown-divider"></li>
            <ul class="dropend">
              <li class="dropdown-toggle text-white text-start" style=" list-style-type: none; font-size: 25px" ><a class="fw-semibold text-white" style=" font-size: 25px; text-decoration: none; text-aling:start">Registros Pagare</a></li>
               
                  <ul class="dropdown-menu" style="background-color: #005E56;">
                      <li class="text-center"><a class="text-center text-white dropdown-item fw-semibold " style="font-size: 25px" href="gerpagare"><i class="fa-solid fa-qrcode"></i> Escanear QR</a></li>
                      <li class="text-center"><a class="text-center text-white dropdown-item fw-semibold " style="font-size: 25px" href="gerpagarefiltrar"><img src="img/pdf.png" style="height: 2.0rem;"> Generar PDF</a></li>
        </ul>
      </div>

    </ul>

            <button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              Launch static backdrop modal
            </button>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title" id="staticBackdropLabel" style="font-size:30px; font-weight: bold">FILTRAR REPORTE PAGARE</h1>
                    <a href="registrarpagare"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:25px;"></button></a>
                  </div>
                  <div class="modal-body">
                    <form action="{{route('crudger.generarpdf')}}" method="POST">
                      @csrf
                      <div class="mb-3">
                        <label for="select-year" class="form-label" style="font-size:20px; font-weight: bold">Año:</label>
                        <select class="form-select" id="select-year" name="year" required>
                        <option value="">Seleccionar</option>
                          <script>
                            var currentYear = new Date().getFullYear();
                            for (var i = 2024; i <= currentYear; i++) {
                              document.write('<option value="' + i + '">' + i + '</option>');
                            }
                          </script>
                        </select>
                      </div>
                      
                      <div class="mb-3">
                        <label for="select-month" class="form-label" style="font-size: 20px; font-weight: bold">Mes:</label>
                        <select class="form-select" id="select-month" name="month" required>
                            <option value="" disabled selected>Seleccionar</option>
                            <option value="Enero">Enero</option>
                            <option value="Febrero">Febrero</option>
                            <option value="Marzo">Marzo</option>
                            <option value="Abril">Abril</option>
                            <option value="Mayo">Mayo</option>
                            <option value="Junio">Junio</option>
                            <option value="Julio">Julio</option>
                            <option value="Agosto">Agosto</option>
                            <option value="Septiembre">Septiembre</option>
                            <option value="Octubre">Octubre</option>
                            <option value="Noviembre">Noviembre</option>
                            <option value="Diciembre">Diciembre</option>
                        </select>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            // Obtener el elemento select
                            var selectMonth = document.getElementById("select-month");

                            // Obtener el mes actual (0-indexed, enero es 0, febrero es 1, etc.)
                            var currentMonth = new Date().getMonth();

                            // Habilitar las opciones de los meses anteriores y deshabilitar los meses futuros
                            for (var i = 1; i <= 12; i++) {
                                var option = selectMonth.options[i];
                                option.disabled = i > currentMonth + 1; // Deshabilitar meses futuros
                            }
                        });
                    </script>



                    <style>
                        /* Agrega estilos CSS para las opciones habilitadas */
                        #select-month option:enabled {
                            font-weight: bold;
                        }
                    </style>

                      <div class="mb-3">
                        <label for="select-month" class="form-label"  style="font-size:20px; font-weight: bold">Linea de Crédito:</label>
                        <select class="form-select" id="linea_credito" name="lineacredito" required>
                              <option value="">Seleccione una opción</option>
                              <option value="0" style="font-weight: bold;">TODAS LAS LINEAS</option>
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
                      </div>


                  </div>
                  <div class="modal-footer">
                    <a href="registrarpagare"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-size:20px; font-weight: bold">CERRAR</button></a>
                    <button onclick="" id="agregar" type="submit" class="btn btn-primary" name="btnregistrar" style="background-color: #005E56; font-size:20px; font-weight: bold" formtarget="_blank">GENERAR PDF</button>

                  </div>
                  </form>
                </div>
              </div>
            </div>

            <script>
                // Una vez que la página se haya cargado completamente, abre el modal
                $(document).ready(function() {
                    $('#staticBackdrop').modal('show');
                });
            </script>
      </div>


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


<div class="container-fluid row p-4">
    <form action="{{ route('crudger.createpagare')}}" class="col m-3" method="POST" enctype= "multipart/form-data">
    @csrf 
    <h2 class="p-2 text-secondary text-center"><b>Escanear Pagaré</b></h2>
    

    <div class="mb-3 w-100" title="Este campo es obligatorio" id="input1">
        <label for="input1" class="form-label fw-semibold">ID <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control" id="nombre" autocomplete="off" autofocus required>
        
      </div>


      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input2" class="form-label fw-semibold">NÚMERO DE AGENCIA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="number" class="form-control " name="NoAgencia" id="input2" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input3" class="form-label fw-semibold">CUENTA ASOCIADO <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="number" class="form-control " name="CuentaCoop" id="input3" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input4" class="form-label fw-semibold">CÉDULA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="number" class="form-control " name="Cedula_Persona" id="input4" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input5" class="form-label fw-semibold">NOMBRE COMPLETO <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="NombreCompleto" id="input5" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input6" class="form-label fw-semibold">ID PAGARE <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="number" class="form-control " name="ID_Pagare" id="input6" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input7" class="form-label fw-semibold">LÍNEA CRÉDITO <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Linea_Credito" id="input7" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input8" class="form-label fw-semibold">CAPITAL <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Capital" id="input8" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input9" class="form-label fw-semibold">NÚMERO DE CUOTAS <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="NoCuotas" id="input9" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input10" class="form-label fw-semibold">VALOR CUOTA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="ValorCuota" id="input10" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input11" class="form-label fw-semibold">TASA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Tasa" id="input11" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input12" class="form-label fw-semibold">FECHA CRÉDITO <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="FechaCredito" id="input12" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input13" class="form-label fw-semibold">NOMINA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Nomina" id="input13" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input14" class="form-label fw-semibold">DIRECCIÓN <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Direccion" id="input14" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input15" class="form-label fw-semibold">TELÉFONO FIJO <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="number" class="form-control " name="TelFijo" id="input15" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input16" class="form-label fw-semibold">FECHA 1ra CUOTA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Fecha1Cuota" id="input16" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input17" class="form-label fw-semibold">Fecha ULTIMA CUOTA <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="FechaUltimaCuota" id="input17" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input18" class="form-label fw-semibold">CELULAR <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="number" class="form-control " name="Celular" id="input18" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input19" class="form-label fw-semibold">CORREO <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="Correo" id="input19" autocomplete="off" required>
        
      </div>

      <div class="mb-3 w-100" title="Este campo es obligatorio">
        <label for="input20" class="form-label fw-semibold">GENERADOR PAGARE <span class="text-danger" style="font-size:20px;">*</span></label>
        <input type="text" class="form-control " name="GeneradorPagare" id="input20" autocomplete="off" required>
      </div>

      

      <div>
          <!-- onclick="return confirmar()" -->
          <button onclick="return confirmar()" id="agregar" type="submit" class="btn btn-primary" name="btnregistrar" style="background-color: #005E56;">Registrar</button>
      </div>
    
    </form>

    <script>

    function confirmar(){
      var respuesta=confirm("Estas seguro?")
      return respuesta
    }


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
          <th scope="col">SCORE</th>
          <th scope="col">REPORTE</th>
          <th scope="col">ESTADO</th>
          <th scope="col">AUTORIZACIÓN</th>
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
        <script>
 

 var table = $('#personas').DataTable({
  "ajax": "{{ route('datatable.consultarpagareger') }}",
  "columns": [
    {
      data: null,
      title: '#',
      render: function (data, type, row, meta) {
        return meta.row + 1;
      }
    },
    {
        data: 'Score',
        createdCell: function (td, cellData, rowData, row, col) {
            $(td).css({
                'font-weight': 'bold',
                'font-size': '30px'
            });
        }
    },
    {
        data: 'Estado',
        createdCell: function (td, cellData, rowData, row, col) {
            $(td).css({
                'font-weight': 'bold',
                'font-size': '30px'
            });
        }
    },
    {    data: null,
      render: function(data, type, row) {

        if(row.Aprobado == 1){
            var AprobadoButton = '<span class="text-success" style="font-weight: bold; font-size: 30px">A</span>';
        }else if(row.Aprobado == 0){
            var AprobadoButton = '<span class="text-danger" style="font-weight: bold; font-size: 30px">R</span>';
        }else{
            var AprobadoButton = '<span class="text-secondary-emphasis" style="font-weight: bold; font-size: 30px">FA</span>';
        }
    
                 
  return AprobadoButton;

}
  },
    {data: 'NoAgencia'},
    {data: 'CuentaCoop'},
    {data: 'Cedula_Persona'},
    {data: 'NombreCompleto'},
    {data: 'ID_Pagare'},
    {
      data: null,
      render: function(data, type, row) {
        var NoLC = '<strong>'+row.NoLC+'</strong>'; 
        var Linea_Credito = row.Linea_Credito;
        

        return NoLC+'-'+Linea_Credito;
      }
    },
    {data: 'Capital'},
    {data: 'NoCuotas'},
    {data: 'ValorCuota'},
    {data: 'Tasa'},
    {data: 'FechaCredito'},
    {data: 'Nomina'},
    {data: 'Direccion'},
    {data: 'TelFijo'},
    {data: 'Fecha1Cuota'},
    {data: 'FechaUltimaCuota'},
    {data: 'Celular'},
    {data: 'Correo'},
    {data: 'GeneradorPagare'},
    
  ],


  "lengthMenu": [[5,10], [5,10]],
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
          '<button id="btnFA" class="custom-btn" title="FALTA POR APROBAR">FA</button>' +
          '</div>';
    $(buttonsHtml).prependTo('.dataTables_filter');
        $('#btnT').on('click', function() {
            var newAjaxSource = '{{ route("datatable.consultarpagareger") }}'; // Adjust the route as needed

            $('#personas').DataTable().ajax.url(newAjaxSource).load();
        });

        $('#btnR').on('click', function() {
            var newAjaxSource = '{{ route("datatable.rechazados") }}'; // Adjust the route as needed

            $('#personas').DataTable().ajax.url(newAjaxSource).load();
        });

        $('#btnA').on('click', function() {
            var newAjaxSource = '{{ route("datatable.aprobados") }}'; // Adjust the route as needed

            $('#personas').DataTable().ajax.url(newAjaxSource).load();
        });

        $('#btnFA').on('click', function() {
            var newAjaxSource = '{{ route("datatable.pendientes") }}'; // Adjust the route as needed

            $('#personas').DataTable().ajax.url(newAjaxSource).load();
        });

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
   <style>
    .custom-buttons {
    display: inline-block;
    margin-right: 10px;
    }

    .custom-btn {
        background-color: #005E56; /* Color Verde */
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
    
 