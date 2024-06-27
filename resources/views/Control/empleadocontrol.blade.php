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

@include('layouts/nav-control')
<style>
  .formato-ayuda {
    color: gray;
    font-style:inherit;
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
    <h2 class="p-2 mb-0 text-secondary text-start"><b>Empleados Nuevos - <span class="text-end" id="fechaActual"></b></span></h2>
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
              <th class="" scope="col">CÉDULA</th>
              <th class="" scope="col">NOMBRE</th>
              <th class="" scope="col">APELLIDOS</th>
              <th class="" scope="col">SCORE</th>
              <th class="" scope="col">REPORTE</th>
              <th class="text-center" scope="col">AGENCIA</th>
              <th class="" scope="col">FECHAGNR</th>
              <th class="" scope="col">SIN</th>
              <th class="" scope="col">PN</th>
              <th scope="col">A</th>
              <th scope="col">IDA</th>
              <th scope="col">PDF CÉDULA</th>
              <th scope="col">INSPEKTOR</th>
              <th class="" scope="col">FECHA CORREO</th>

            </tr>
          </thead>
          <tbody class="table-group-divider">


          </tbody>



        </table>
        <input type="text" name="cedula3"  value="" style="margin-top:16%; visibility: hidden;">




        <script>



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
        <script src="ResourcesAll/dtables/dtable1.min.js"></script>
<script src="ResourcesAll/dtables/botonesdt.min.js"></script>
<script src="ResourcesAll/dtables/estilobotondt.min.js"></script>
<script src="ResourcesAll/dtables/botonimprimir.min.js"></script>
<script src="ResourcesAll/dtables/imprimir2.min.js"></script>
        <script>


 var table = $('#personas').DataTable({
  "ajax": "{{ route('datatableemp.control') }}",
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
  data: 'Score'
},
{
  data: 'Reporte',
  render: function (data, type, row) {
    if (data === 'null') {
      return '';
    } else {
      return data;
    }
  }
},
    {
      data: 'Agencia',
      render: function (data, type, row) {
        // Capitalizar la primera letra y convertir el resto en minúsculas
        var agencia = data.charAt(0).toUpperCase() + data.slice(1).toLowerCase();
        return agencia;
      }
    },
    {
  data: 'FechaInsercion',
  render: function(data, type, row) {
    var html = '';
    var fecha_insercion = new Date(data);

    var fecha_actual = new Date();
    var diferencia = Math.floor((fecha_actual - fecha_insercion) / (1000 * 60 * 60 * 24)); // Calcular la diferencia en días

    if (parseInt(row.Consulta) === 1 && diferencia > 180) {
  html += data + '<span class="fw-bold blink" style="font-size: 20px;"><br><span style="background-color: yellow;">RENOVAR</span></span>';
} else if (diferencia > 180) {
  html += data + '<span class="text-danger fw-bold blink" style="font-size: 20px;"><br>VENCIDO</span>';
} else {
  html += data + '<span class="fw-bold" style="color: #1565c0;"><br>Al día</span>';
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
          return '<a href="Storage/files/cedula/' + data + '" target="__blank" style="display: flex; justify-content: center;"><img src="img/pdf.png" style="height: 2.5rem;"></a>';
          }
        }
        return data;
      }
    },
    {data: 'Inspektor'},
    {data: 'FechaCorreo'}
  ],


  "lengthMenu": [[6], [6]],
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





$(document).ready(function() {
  $('#personas').on('click', '.edit', function() {
    var data = table.row($(this).closest('tr')).data();
    $("#estado3").val(data["Estado"]);
    $("#cedula2").val(data["Cedula"]);
    $("#nombre3").val(data["Nombre"]);
    $("#apellidos3").val(data["Apellidos"]);
    $("#score3").val(data["Score"]);
    $("#reporte3").val(data["Reporte"]);
    $("#cuenta3").val(data["CuentaAsociada"]);
    $("#agencia3").val(data["Agencia"]);
    $("#fecha3").val(data["FechaInsercion"]);




  });
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

