@extends('layouts.base')

@section('content')

@include('layouts/nav-consultante')
<div>
    <h2 class="p-4 text-secondary"><b><span id="fechaActual">Consulta Proveedores</span></b></h2>
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
      elementoFecha.textContent = `Consulta Proveedores - ${obtenerFechaActual()}`;
  }


  setInterval(actualizarFechaActual, 1000);
  </script>
  <div>

    <div style="width: 40%;" class="m-4">
        <table id="personas" class="hover table table-responsive table-striped shadow-lg mt-4 table-bordered table-hover"  style="width:100%" >
          <thead class="" style="background-color: #005E56;">
            <tr class="text-white">

              <th style="font-size: 1.8125rem; width: 1%;"><span style="font-size: 2.8125rem;">Tipo</span></th>
              <th style="font-size: 1.8125rem; width: 5%;"><span style="font-size: 2.8125rem;">CC/NIT</span></th>
              <th style="font-size: 1.8125rem; width: 5%;"><span style="font-size: 2.8125rem;">SIN</span></th>
              <th style="font-size: 1.8125rem; width: 5%;"><span style="font-size: 2.8125rem;">PN</span></th>
            </tr>
          </thead>
          <tbody class="table-group-divider">






        </table>

<br><br><br><br><br><br><br><br><br><br><br><br>
        <div id="resultado"></div>
<script src="ResourcesAll/dtables/jquery-3.5.1.js"></script>
        <script src="ResourcesAll/dtables/jquerydataTables.js"></script>
        <script src="ResourcesAll/dtables/dataTablesbootstrap5.js"></script>
        <script>
          $(document).ready(function () {
              $('#personas').DataTable({
                  "ajax": "{{ route('datatable.consultante6') }}",
                  "columns": [
                      { data: 'TipoProveedor' },
                      {
        data: null,
        render: function(data, type, row) {
          if (row.Cedula === null || row.Cedula === '') {
            return row.NIT;
          } else {
            return row.Cedula;
          }
        },
                },
                {
  data: 'NombreS',
  render: function(data, type, row) {
    console.log(row.NombreS)
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
    var id = row.ID;
        var cedula = row.Cedula;
        var url = "{{ route('consultante.imprimir3', ':id') }}";
        url = url.replace(':id', id);



        var embedSrc = "Storage/files/tickets/Ticket-" + cedula + ".pdf";

        return '<td style="font-size: 2.8125rem; position: relative;" class="fw-semibold">' +
            data +
            '<a onclick="ActualizarDoc(\'' + url + '\')" id="generarPdfBtn" href="' + url + '" target="_blank" type="submit" class="text-center rounded-pill btn text-center w-50" style="position: absolute; top: 200%; left: 50%; transform: translate(-50%, -50%); background-color: #005E56; width: 180%;" name="enviar" value="ok">' +
            '<p style="font-size: 35px;" class="fw-bold text-light mt-3 ml-5">' +
            '<img src="img/pdf.png" style="height: 3.5rem;"> GENERAR PDF' +
            '</p>' +
            '</a>' +
            '<br>' +
            '<embed id="pdfEmbed" src="' + embedSrc + '" frameborder="0" width="1000" height="590" style="margin-left: 600px; margin-top: -90px; position: absolute; top: 0;">' +
            '</td>'+
            '</td>';

    if (type === 'display') {
      if (data === 'null.html' || data === null) {
        return '';
      } else {
        return '<a href="Storage/files/pn/' + data + '" download><img src="img/pdf.png" style="height: 3.5rem"></a>';
      }
    }
    return data;
  }

}],

            "lengthMenu": [[1], [1]],
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

          function ActualizarDoc(url) {
  var embed = document.getElementById('pdfEmbed');
  embed.setAttribute('src', url);
}
      function csesion(){
        var respuesta=confirm("Estas seguro que deseas cerrar sesión?")
        return respuesta
      }

  </script>
@endsection
