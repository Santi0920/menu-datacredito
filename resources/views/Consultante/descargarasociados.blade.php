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

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menú | Coopserp</title>
    <link href="ResourcesAll/Bootstrap/Bootstrap.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/logoo.png" type="img/png">
  </head>
  
  
<body>
    <!-- NAV DE LISTA-->
  <nav class="navbar navbar-expand-lg bg-body-secondary p-0" id="Menu">
    <div class="container-fluid">
      <!-- Coopserp.com-->
      
      <!-- Botón que aparece al reducir pantalla--> 
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
      </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Foto Coopserp--> 
    <a class="navbar-brand" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"><img src="img/CoopserpPH.png" alt="Coopserp.icono" width="150px" height="60px" id="data"></a>
      <ul class="navbar-nav me-auto mb-lg-0">        
       
      </ul>
      <a href="{{route('login.index')}}"><button class="btn btn-outline-success"><b style="font-size: 18px;">Iniciar Sesión</b></button></a>
    </div>
  </div>
</nav>
<!-- Despliege al tocar imagen-->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasExampleLabel">Información</h5>
        <!-- Cerrar botón-->
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <!-- cuerpo del despliegue-->
        <div class="offcanvas-body">
          <div>
            <h1 class="p-3 fs-4 text-center">Coopserp Web</h1>
            <p class="p-3 fs-6 text-center">Es una página web la cual está distribuida en 6 interfaces,
              la cual cuenta con la página principal(índex) que es la que da vía a las demás como datacrédito,
              anticipos, cuentas H, carteras castigadas y fondo de garantía. Con el fin de filtrar
              información de la base de datos de la cooperativa. Toda esta información está sujeta a la
              ley de protección de datos.

            </p>
          </div>
        </div>
        <p class="copyright text-center">&copy;Coopserp Web</p>
      </div>
<style>
    .tabla-container {
      width: 100%;
      max-width: 800px;
      margin: 0 auto;
      overflow: auto;
    }

    table.table {
      width: 100%;
      margin: 3% auto;
      text-align: center;
    }

    table.table thead th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    table.table tbody td {
      text-align: initial;
      font-weight: 500;
      padding: 10px;
    }

    .dataTables_paginate {
      margin-top: 16px;
    }
  </style>
  <br><br>

      <br>

  
      <br><br><br><br>
      <div class="row tm-content-row">
    <div class="tabla-container">
      <div class="col-11" style="margin-left:3.5%">
        <div class="">
          <form action="" method="post">
            <div class="" style="margin-top: 0px; margin-right: -14px;">
              <!-- Elimina el elemento innecesario: </b></h2> -->
            </div>
            <h2 class="p-2 mb-0 text-secondary text-start"><b>DESCARGAR DOCUMENTOS - <span class="text-end" id="horaActual"></span></b></h2>
            <script>
              function obtenerHoraActual() {
                const fecha = new Date();
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

                return `${horas}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')} ${amPm}`;
              }

              function actualizarHoraActual() {
                const elementoHora = document.getElementById('horaActual');
                elementoHora.textContent = obtenerHoraActual();
              }

              setInterval(actualizarHoraActual, 1000);
            </script>
          </form>  
        </div>
      </div>
      <div class="">
        <table id="personas" class="table">
          <thead>
            <tr>
              <th scope="col" style="font-size: 280%;">CC</th>
              <th scope="col" style="font-size: 280%;border-left: 2px solid black;">TICKET</th>
              <th scope="col" style="font-size: 280%;border-left: 2px solid black;">SIN</th>
              <th scope="col" style="font-size: 280%;border-left: 2px solid black;">PN</th> 
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
<br><br><br><br><br><br>
  <script>

$(document).ready(function() {
  var table = $('#personas').DataTable({
    "paging": false,
    "ordering": false,
    "searching": false,
    "ajax": "{{ route('datatable.documentos', ['id' => $id]) }}",
    "columns": [
      { 
        data: 'Cedula',
        "createdCell": function(td, cellData, rowData, row, col) {
          $(td).css('font-size', '16px'); 
        }
      },
      {
  data: 'Cedula',
  render: function(data, type, row) {
    if (type === 'display') {
      if (data === 'null') {
        return '';
      } else {
        return '<a href="Storage/files/tickets/Ticket-' + data + '.pdf" download ><img src="img/pdf.png" style="height: 3.5rem;"></a>';
      }
    }
    return data;
  }
},
      {
  data: 'NombreS',
  render: function(data, type, row) {
    if (type === 'display') {
      if (data === null) {
        return '';
      } else {
        return '<a href="Storage/files/sintesis/' + data + '" download ><img src="img/pdf.png" style="height: 3.5rem;"></a>';
      }
    }
    return data;
  }
},
{
  data: 'NombrePN',
  render: function(data, type, row) {
    if (type === 'display') {
      if (data === 'null.html' || data === null) {
        return '';
      } else {
        return '<a href="Storage/files/pn/' + data + '" download><img src="img/pdf.png" style="height: 3.5rem"></a>';
      }
    }
    return data;
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
});

  </script>



          </div>
        </div>
        <script src="ResourcesAll/dtables/jquery-3.5.1.js"></script>
        <script src="ResourcesAll/dtables/jquerydataTables.js"></script>
        <script src="ResourcesAll/dtables/dataTablesbootstrap5.js"></script>
        <script>
 




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
    
 