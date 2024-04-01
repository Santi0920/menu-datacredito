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
    Swal.fire({
      icon: 'success',
      title: "¡ASIGNADO CORRECTAMENTE!",
      html: "{!! session('correcto2') !!}",
      confirmButtonColor: '#005E56',
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
<style>
  .formato-ayuda {
    color: gray;
    font-style:inherit;
  }
  </style>
  

    </form>
    <br>
    {{-- FECHA --}}
    <div class="col-lg-11" style="margin-left:3.5%">
      <div class="">
        <form action="" method="post">
        <div class="" style="margin-top: 8px;">

            <h2 class="mb-3 text-secondary text-start"><b><span id="fechaActual"></span></b></h2>
        </div> 
        </form>  
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
        
        
        return `Actualizar Fecha Reporte Pagare - ${mes} ${dia}, ${anio} - ${horas}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')} ${amPm}`;
    }
    
    
    function actualizarFechaActual() {
        const elementoFecha = document.getElementById('fechaActual');
        elementoFecha.textContent = `${obtenerFechaActual()}`;
    }
    
    
    setInterval(actualizarFechaActual, 1000);
    </script>
    
    

    <div class="table-responsive" style="">
        <table id="personas" class="table table-striped shadow-lg mt-2 table-bordered table-hover">
          <thead class="" style="background-color: #005E56;">
            <tr class="text-white">
            <th>#</th>
            <th ># NOMINA</th>
            <th >NOMBRE NOMINA</th>
            <th ># ENTIDAD</th>
            <th ># DEPEDENCIA</th>
            <th class="" >DEPENDENCIA</th>
            <th class="">FECHA REPORTE</th>
            <th class="">ACCIONES</th>
            </tr> 
          </thead> 
          <tbody class="">
           
            
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
  "ajax": "{{ route('datatable.data7') }}",
  "columns": [
    {
      data: null,
      title: '#',
      render: function (data, type, row, meta) {
        return meta.row + 1;
      }
    },
    {data: 'CODNOMINA'},
    {data: 'NOMBRENOMINA'},
    {data: 'CODENTIDAD'},
    {data: 'CODDEPENDENCIA'},
    {data: 'NOMDEPENDENCIA'},
    {data: 'FECHAREPORTE'},
    {    data: null,
      render: function(data, type, row) {
        var id = row.ID; 
        var url = "{{ route('crud.updateFechaReporte', ':id') }}";
        var today = new Date().toISOString().split('T')[0];
        url = url.replace(':id', id);

        var html = '';
      var editButton = `<div class="text-center"><a title="Modificar" href="" id="modalLink_${id}" type="submit" class="btn btn-small btn-warning edit-button edit" data-bs-toggle="modal" data-bs-target="#modalEditar_${id}" data-id="${id}" style="margin-right: "><i class="fa-regular fa-pen-to-square"></i></a></div>
                  <div class="modal fade" id="modalEditar_${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <button type="button" data-bs-dismiss="modal" class="btn-close p-3" aria-label="Close"></button>
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                          <h1 class="modal-title text-center" id="modificar">FECHA REPORTE</h1>
                        </div>
                        <hr>
                        <div class="modal-body">
                          <form action="`+url+`" class="text-center" method="POST" enctype="multipart/form-data" id="formulario" onsubmit="return validateForm2()">
                            @csrf
                       
              <div class="mb-3">
                <label for="cedula2" id="" class="form-label fw-bold" value="" style="margin-left: -85%">NOMINA</label>
                <input type="text" class="form-control" name="cedula2" id="CODNOMINA" value="${row.CODNOMINA}" maxlength="0" readonly style="background-color: #EBEBEB; cursor: not-allowed;" required>
                <input type="hidden" name="CODNOMINA"  value="">
              </div>
  
              <div class="mb-3">
                <label for="nombre3" id="" class="form-label fw-bold" style="margin-left: -69%">NOMBRE NOMINA</label>
                <input type="text" class="form-control" id="nombre3" name="NOMBRENOMINA" value="${row.NOMBRENOMINA}" maxlength="0" readonly style="background-color: #EBEBEB; cursor: not-allowed;" required>
                <div id="nombreError3" style="color: red;" class="fw-bold"></div>
              </div>
        
              
              
              <div class="mb-3">
                  <label for="exampleInputEmail1" id="" class="form-label fw-bold" style="margin-left: -84%">ENTIDAD</label>
                  <input type="text" class="form-control" id="apellidos3" name="CODENTIDAD" value="${row.CODENTIDAD}" maxlength="0" oninput="this.value = this.value.toUpperCase()" readonly style="background-color: #EBEBEB; cursor: not-allowed;" required>
                  <div id="apellidosError3" style="color: red;" class="fw-bold"></div>
              </div>
  
              <!--Label5-->
              <div class="mb-3">
                  <label for="click" id="" class="form-label fw-bold" style="margin-left: -76%">DEPENDENCIA</label>
                  <input list="agencia" type="text" class="form-control" id="agencia3" name="CODDEPENDENCIA" value="${row.CODDEPENDENCIA}" maxlength="0" autocomplete="off" readonly style="background-color: #EBEBEB; cursor: not-allowed;" required>
                  <div id="agenciaError3" style="color: red;" class="fw-bold"></div>
              </div>

              <div class="mb-3">
                  <label for="click" id="" style="margin-left: -60%" class="form-label fw-bold">NOMBRE DEPENDENCIA</label>
                  <input list="agencia" type="text" class="form-control" id="valorcompra1" name="NOMDEPENDENCIA" value="${row.NOMDEPENDENCIA}" maxlength="0" readonly style="background-color: #EBEBEB; cursor: not-allowed;" required>
                  <div id="agenciaError3" style="color: red;" class="fw-bold"></div>
              </div>

              <div class="mb-3">
                <label for="label" id="izquierda11" class="form-label fw-bold" style="margin-left: -73%;">TIPOS REPORTE</label><br>
                <div class="form-check form-check-inline">
                  <label class="form-check-label" style="font-size: 18px; font-weight: bold">
                    <input type="radio" name="tipo_fecha" value="0" required>
                    Mes Actual
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <label class="form-check-label" style="font-size: 18px; font-weight: bold">
                    <input type="radio" name="tipo_fecha" value="1" required>
                    Mes Anterior
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <label class="form-check-label" style="font-size: 18px; font-weight: bold">
                    <input type="radio" name="tipo_fecha" value="3" required>
                    Entremes
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <label class="form-check-label" style="font-size: 18px; font-weight: bold">
                    <input type="radio" name="tipo_fecha" value="2" required>
                    Sin Fecha
                  </label>
                </div>
              </div>
                     
                  <div class="mb-3">
                <label for="label" id="izquierda11" class="form-label fw-bold" style="margin-left: -73%;">FECHA REPORTE</label>
                <select class="form-control " name="diafecha" id="diafecha" required>
                    <option value="">Seleccione una opción</option>
                    <option value="0">SIN FECHA</option>
                    <option value="1">1 Mes</option>
                    <option value="2">2 Mes</option>
                    <option value="3">3 Mes</option>
                    <option value="4">4 Mes</option>
                    <option value="5">5 Mes</option>
                    <option value="6">6 Mes</option>
                    <option value="7">7 Mes</option>
                    <option value="8">8 Mes</option>
                    <option value="9">9 Mes</option>
                    <option value="10">10 Mes</option>
                    <option value="11">11 Mes</option>
                    <option value="12">12 Mes</option>
                    <option value="13">13 Mes</option>
                    <option value="14">14 Mes</option>
                    <option value="15">15 Mes</option>
                    <option value="16">16 Mes</option>
                    <option value="17">17 Mes</option>
                    <option value="18">18 Mes</option>
                    <option value="19">19 Mes</option>
                    <option value="20">20 Mes</option>
                    <option value="21">21 Mes</option>
                    <option value="22">22 Mes</option>
                    <option value="23">23 Mes</option>
                    <option value="24">24 Mes</option>
                    <option value="25">25 Mes</option>
                    <option value="26">26 Mes</option>
                    <option value="27">27 Mes</option>
                    <option value="28">28 Mes</option>
                    <option value="29">29 Mes</option>
                    <option value="30">30 Mes</option>
                </select>
                <div id="consecutivoError3" style="color: red;" class="fw-bold"></div>
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

  return editButton;

}
  }
  ],


  "lengthMenu": [[7], [7]],
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
  },
  responsive: "true",
        dom: 'Bfrtilp',       
        buttons:[ 
			{
				extend:    'excelHtml5',
				text:      '<i class="fas fa-file-excel"></i> ',
				titleAttr: 'Exportar a Excel',
				className: 'btn btn-success btn-lg'
			},
			{
				extend:    'print',
				text:      '<i class="fa fa-print"></i> ',
				titleAttr: 'Imprimir',
				className: 'btn btn-info btn-lg'
			}
      ]	
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
    
 