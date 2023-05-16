@extends('layouts.base')

@section('content')


<div>
    <h2 class="p-3 mb-0 text-secondary"><b><span id="fechaActual">Consulta Datacrédito</span></b></h2>
  </div>
  <div class="contenedor2">
    <div class="agregar2">
      <a href="datacredito.php" class="btn btn-primary" style="font-size: 35px;font-family: 'Montserrat', sans-serif; font-weight: bold;" data-bs-toggle="modal" data-bs-target="#exampleModal3">
        <span style="margin-bottom: 30px; margin-top: 20px;">V1</span>
      </a>
    </div>
  </div>
  <script>
  const agregar3 = document.querySelector('.agregar3 a');
  
  // Verificar si hay un valor guardado en localStorage
  if (localStorage.getItem('rebote-detenido') === 'true') {
    agregar3.style.animationPlayState = 'paused';
  }
  
  // Agregar evento de clic al botón "agregar3"
  agregar3.addEventListener('click', function() {
    agregar3.style.animationPlayState = 'paused';
    localStorage.setItem('rebote-detenido', 'true');
  });
  </script>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-semibold text-center"  style="font-size: 40px; margin-left: 180px;" id="exampleModalLabel3">VERSIÓN #1</h5>
          <button type="button" data-bs-dismiss="modal" class="btn-close p-3" aria-label="Close"></button>
        </div>
        <div class="modal-body texto-justificado">
          <!-- Contenido del modal -->
          <p style="font-size: 20px;" class="text-justify">
          Esta  aplicación fue creada para el control en la generación de datacréditos.
          </p>
          <ul style="font-size: 20px; text-justify:distribute-all-lines">
            <li>El datacrédito tiene vigencia de <strong>180 días/6 meses</strong>.</li>
            <li>El sistema genera advertencias una vez los documentos esten <strong>vencidos</strong>.</li>
            <li>El sistema genera <strong>tickets</strong> con la información de la persona para su posterior impresión.</li>
            <li>El sistema es compatible con impresora <strong>LabelWriter 450</strong>  con tickets referencia: <strong>30336 1 in x 2-1/8 in</strong> con escala <strong>35</strong>.</li>
          </ul>
        </div>
        <div class="modal-footer">
        <h5 class="fw-semibold text-secondary" style="font-size: 35px; margin-right: 320px;">Abr 2023</h5>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-size: 20px;">Cerrar</button>
  
        </div>
      </div>
    </div>
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
      
      // Convertir las horas a formato de 12 horas y establecer el valor de AM/PM
      if (horas > 12) {
          horas -= 12;
          amPm = 'PM';
      } else if (horas === 0) {
          horas = 12;
      }
  
      const minutos = fecha.getMinutes();
      const segundos = fecha.getSeconds();
      
      // Utilizar padStart() para agregar un cero inicial si los minutos y segundos son menores a 10
      return `${mes} ${dia}, ${anio} - ${horas}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')} ${amPm}`;
  }
  
  // Función para actualizar el elemento con la fecha y hora actual
  function actualizarFechaActual() {
      const elementoFecha = document.getElementById('fechaActual');
      elementoFecha.textContent = `Consulta Datacrédito - ${obtenerFechaActual()}`;
  }
  
  // Actualizar la fecha y hora actual cada segundo
  setInterval(actualizarFechaActual, 1000);
  </script>
  <div>
    <embed src="Storage/files/tickets/Ticket- .pdf" frameborder="0" width="1000" height="590" style="margin-left: 850px; margin-top: 160px; position: absolute; top: 0;">
    <div style="width: 40%;" class="m-4">
        <table id="personas" class="hover table table-responsive table-striped shadow-lg mt-4 table-bordered table-hover"  style="width:100%" >
          <thead class="" style="background-color: #005E56;">
            <tr class="text-white">
            
              <th style="font-size: 1.8125rem; width: 1%;"><span style="font-size: 2.8125rem;">Cédula:</span></th>
              <th style="font-size: 1.8125rem; width: 5%;"><span style="font-size: 2.8125rem;">Cuenta:</span></th>
              <th style="font-size: 1.8125rem; width: 40%;"><span style="font-size: 2.8125rem;">Agencia:</span></th>
            </tr> 
          </thead> 
          <tbody class="table-group-divider">
            @foreach($datos as $item)
            <tr>
              <td style="font-size: 2.8125rem;" class="fw-semibold">{{$item->Cedula}}</td>
              <td style="font-size: 2.8125rem; position: relative;" class="fw-semibold">{{$item->CuentaAsociada}}
                <a onclick="enviar()" id="generarPdfBtn" href="{{route("consultante.imprimir", $item->ID)}}" target="_blank" type="submit" class="text-center rounded-pill btn text-center" style="position: absolute; top: 320%; left: 50%; transform: translate(-50%, -50%); background-color: #005E56; width: 180%;" name="enviar" value="ok">
                  <p style="font-size: 35px;" class="fw-bold text-light mt-3 ml-5">
                    <img src="img/pdf.png" style="height: 3.5rem;"> GENERAR PDF
                  </p>
                </a>
          
              </td>
              <td style="font-size: 2.8125rem;" class="fw-semibold">{{$item->Agencia}}</td>
            </tr>
          @endforeach
              
    
          
        </table>
        
<br><br><br><br><br><br><br><br><br><br><br><br>

<script src="ResourcesAll/dtables/jquery-3.5.1.js"></script>
        <script src="ResourcesAll/dtables/jquerydataTables.js"></script>
        <script src="ResourcesAll/dtables/dataTablesbootstrap5.js"></script>
        <script>
          $(document).ready(function () {
          $('#personas').DataTable({
            
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

      function csesion(){
        var respuesta=confirm("Estas seguro que deseas cerrar sesión?")
        return respuesta
      }
      
  </script>
@endsection