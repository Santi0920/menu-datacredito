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

@include('layouts/nav-consultante')
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
    <h2 class="p-1 mb-3 text-secondary text-start"><b>Registros Pagare - <span class="text-end" id="fechaActual"></b></span></h2>
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
        <table id="personas" class="hover table table-responsive table-striped shadow-lg mt-2 table-bordered table-hover">
          <thead class="" style="background-color: #005E56;">
            <tr class="text-white">
            <th scope="col">#</th>
            <!-- <th scope="col">ASEGURABILIDAD</th> -->
          <th scope="col">SCORE</th>
          <th scope="col">APROBADO</th>
          <th scope="col">AUTORIZACIÓN</th>
          <th scope="col">1 CUOTA</th>
          <th scope="col">FECHA ESCANEO</th>
          <th scope="col">GARANTIA</th>
          <th scope="col">AGENCIA</th>
          <th scope="col">INTERES PROPORCIONAL</th>
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

 var loadingTimer;
 var table = $('#personas').DataTable({
  "ajax": {
        "url": "{{ route('datatable.prueba2') }}",
        "beforeSend": function () {
          loadingTimer = setTimeout(function () {
        Swal.close(); // Cierra el cuadro de diálogo actual
        Swal.fire({
            title: 'Aún estamos validando nuevos registros en AS400...',
            showConfirmButton: false, // Oculta el botón "OK"
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }, 10000);

            Swal.fire({
                title: 'Consultando en AS400...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    const content = Swal.getHtmlContainer();
                    if (content) {
                        const dots = content.querySelector('.swal2-loading-dot');
                        if (dots) {
                            dots.classList.add('animate-dots');
                        }
                    }
                }
            });
        },
        "complete": function () {
            clearInterval(loadingTimer); // Limpiar el temporizador al completar la carga
            Swal.close();
        }
    },
  "order": [[0, 'desc']],
  "columns": [
    {
        data: 'ID',
        createdCell: function (td, cellData, rowData, row, col) {
            $(td).css({
                'font-weight': 'bold',
                'font-size': '30px'
            });
        }
    },
//     {    data: null,
//       render: function(data, type, row) {
//         var id = row.ID;
//         var url = "{{ route('crudcor.asegurabilidad', ':id') }}";
//         var url2 = "{{ route('crudcor.adjuntarasegurabilidad', ':id') }}";
//         var today = new Date().toISOString().split('T')[0];

//         url = url.replace(':id', id);
//         url2 = url2.replace(':id', id);


//         if(row.edad == 1 && row.deuda == 1){
//           var motivo = 'cuenta con más de <strong>70 años</strong> y así mismo, su deuda total es igual o mayor a <strong>20 Millones</strong>';
//         }else if(row.edad == 1 && row.deuda == 2){
//           var motivo = 'cuenta con más de <strong>70 años</strong> y así mismo, su deuda total es igual o mayor a <strong>50 Millones</strong>'
//         }else if(row.edad == 1){
//           var motivo = 'cuenta con más de <strong>70 años</strong>';
//         }else if(row.deuda == 1){
//           var motivo = 'su deuda total es igual o mayor a <strong>20 Millones</strong>'
//         }else if(row.deuda == 2){
//           var motivo = 'su deuda total es igual o mayor a <strong>50 Millones</strong>'
//         }

//         if(row.AdjuntarAsegur == 2){
//           var Formato =`<a href="Storage/files/asegurabilidad/${row.NomAsegur}" download style="display: flex; justify-content: center;"><img src="img/pdf.png" style="height: 4.0rem; width: 3.0rem"></a>`
//         }
//         else if(row.deuda == 1 && row.AdjuntarAsegur == 1 || row.edad == 1 && row.deuda == 1 && row.AdjuntarAsegur == 1 || row.edad == 1 && row.deuda == 2 && row.AdjuntarAsegur == 1 || row.deuda == 2 && row.AdjuntarAsegur == 1 || row.edad == 1 && row.AdjuntarAsegur == 1){
//           var Formato = `<div class="text-center"><a title="Modificar" href="" id="modalLink_${id}" type="submit" class="btn btn-small btn-warning edit-button edit fw-bold fs-1" data-bs-toggle="modal" data-bs-target="#modalEditar_${id}" data-id="${id}" style="margin-right: "><i class="fa-regular fa-file-pdf"></i></a></div>
//                   <div class="modal fade" id="modalEditar_${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
//                     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
//                       <div class="modal-content">


//                         <div class="">
//                         <button type="button" class="btn-close p-3" aria-label="Close" data-bs-dismiss="modal"></button>
//                         <h1 class="modal-title text-center" id="modificar"  style="margin-top: -40px">ADJUNTAR FORMATO ASEGURABILIDAD</h1>
//                         </div>
//                         <hr>
//                         <div class="modal-body">
//                           <form action="`+url2+`" class="text-center" method="POST" enctype="multipart/form-data" id="formulario">
//                             @csrf

//                             <div class="mb-3 ms-2 me-2">
//                               <label for="" id="" class="form-label text-start fs-5" style="margin-left: 0%;">Por favor, adjuntar el <strong>Formato de Asegurabilidad</strong> escaneado de <strong>${row.NombreCompleto}</strong>. Revisar que este diligenciado correctamente por el asociado.</label>
//                               <input type="file" class="form-control" name="DocuAsegurabilidad" id="asd" accept="application/pdf" required>
//                             </div>


//                             <div class="modal-footer">
//                               <button type="button" class="btn btn-secondary fs-4" data-bs-dismiss="modal">Cerrar</button>
//                               <button type="submit" href=""  name="editar" class="btn btn-primary fs-4" style="background-color: #005E56;">Guardar</button>
//                             </div>
//                           </form>
//                         </div>
//                       </div>
//                     </div>
//                   </div>`
//         }
//         else if(row.deuda == 1 || row.deuda == 2 || row.edad == 1 || row.deuda == 1 && row.edad == 1 || row.deuda == 2 && row.edad == 1){
//           var Formato = `<div class="text-center"><a title="Adjuntar formato" href="" id="modalLink_${id}" type="submit" class="btn btn-small btn-warning edit-button edit fw-bold fs-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop_${id}" data-id="${id}" style="margin-right: "><i class="fa-regular fa-file-pdf"></i></a></div>
//                           <div class="modal fade" id="staticBackdrop_${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
//                               <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog modal-xl">
//                                   <div class="modal-content">
//                                       <div class="">
//                                           <button type="button" class="btn-close p-3" aria-label="Close" data-bs-dismiss="modal" style="visibility: hidden;"></button>
//                                           <h1 class="modal-title text-center" id="modificar" style="margin-top: -40px">FORMATO ASEGURABILIDAD<img class="ms-4" src="img/Aseguradora.jpg" height="100px"></h1>
//                                       </div>
//                                       <hr>
//                                       <div class="modal-body">
//                                           <form action="${url}" class="text-center" method="POST" enctype="multipart/form-data" id="formulario" target="_blank">
//                                               @csrf
//                                               <div class="text-center fs-5 fst-italic ">
//                                                   <p>A continuación debe llenar el formato de asegurabilidad de <strong>${row.NombreCompleto}</strong> ya que ${motivo}.</p>
//                                               </div>
//                                               <hr>
//                                               <h3 class="text-decoration-underline">INFORMACIÓN DEL ASEGURADO</h3>
//                                               <div class="container-fluid">
//                                                   <div class="row">
//                                                       <div class="col-md-4" style="display:none">
//                                                         <label for="" id="" class="form-label text-start fs-5 fw-semibold" style="margin-left: 0%;">Cédula: </label>
//                                                         <input type="number" class="form-control" name="Capital" readonly value="${row.Capital}">
//                                                       </div>
//                                                       <div class="col-md-4" style="display:none">
//                                                         <label for="" id="" class="form-label text-start fs-5 fw-semibold" style="margin-left: 0%;">Cuenta Asociado: </label>
//                                                         <input type="number" class="form-control" readonly name="CuentaCoopserp" value="${row.CuentaCoop}">
//                                                       </div>

//                                                       <div class="col-md-4" style="display:none">
//                                                         <label for="" id="" class="form-label text-start fs-5 fw-semibold" style="margin-left: 0%;">Cuenta Asociado: </label>
//                                                         <input type="number" class="form-control" readonly name="ID" value="${row.ID}">
//                                                       </div>
//                                                       <div class="col-md-4" id="expe">
//                                                           <label for="" id="" class="form-label text-start fs-5 fw-semibold" style="margin-left: 0%;">Lugar Expedición: <span class="text-danger" style="font-size:20px;">*</span></label>
//                                                           <select class="form-control" id="inputCiudadLine2" name="expedicion">
//                                                             <option value="">-</option>
//                                                             <option value="Arauca">Arauca</option>
//                                                             <option value="Armenia">Armenia</option>
//                                                             <option value="Barranquilla">Barranquilla</option>
//                                                             <option value="Bogotá">Bogotá</option>
//                                                             <option value="Bucaramanga">Bucaramanga</option>
//                                                             <option value="Cali">Cali</option>
//                                                             <option value="Cartagena">Cartagena</option>
//                                                             <option value="Cúcuta">Cúcuta</option>
//                                                             <option value="Florencia">Florencia</option>
//                                                             <option value="Ibagué">Ibagué</option>
//                                                             <option value="Leticia">Leticia</option>
//                                                             <option value="Manizales">Manizales</option>
//                                                             <option value="Medellín">Medellín</option>
//                                                             <option value="Mitú">Mitú</option>
//                                                             <option value="Mocoa">Mocoa</option>
//                                                             <option value="Montería">Montería</option>
//                                                             <option value="Neiva">Neiva</option>
//                                                             <option value="Pasto">Pasto</option>
//                                                             <option value="Pereira">Pereira</option>
//                                                             <option value="Popayán">Popayán</option>
//                                                             <option value="Puerto Carreño">Puerto Carreño</option>
//                                                             <option value="Puerto Inírida">Puerto Inírida</option>
//                                                             <option value="Quibdó">Quibdó</option>
//                                                             <option value="Riohacha">Riohacha</option>
//                                                             <option value="San Andrés">San Andrés</option>
//                                                             <option value="San José del Guaviare">San José del Guaviare</option>
//                                                             <option value="Santa Marta">Santa Marta</option>
//                                                             <option value="Sincelejo">Sincelejo</option>
//                                                             <option value="Tunja">Tunja</option>
//                                                             <option value="Valledupar">Valledupar</option>
//                                                             <option value="Villavicencio">Villavicencio</option>
//                                                             <option value="Yopal">Yopal</option>
//                                                           </select>
//                                                       </div>
//                                                       <div class="col-md-4" style="display: none;" id="depart">
//                                                           <label for="" id="" class="form-label text-start fs-5 fw-semibold" style="margin-left: 0%;">Departamento: <span class="text-danger" style="font-size:20px;">*</span></label>
//                                                           <select class="form-control" id="departamentos" name="departamentos">
//                                                               <option value="">-</option>
//                                                               <option value="Amazonas">Amazonas</option>
//                                                               <option value="Antioquia">Antioquia</option>
//                                                               <option value="Arauca">Arauca</option>
//                                                               <option value="Atlántico">Atlántico</option>
//                                                               <option value="Bolívar">Bolívar</option>
//                                                               <option value="Boyacá">Boyacá</option>
//                                                               <option value="Caldas">Caldas</option>
//                                                               <option value="Caquetá">Caquetá</option>
//                                                               <option value="Casanare">Casanare</option>
//                                                               <option value="Cauca">Cauca</option>
//                                                               <option value="Cesar">Cesar</option>
//                                                               <option value="Chocó">Chocó</option>
//                                                               <option value="Córdoba">Córdoba</option>
//                                                               <option value="Cundinamarca">Cundinamarca</option>
//                                                               <option value="Guainía">Guainía</option>
//                                                               <option value="Guaviare">Guaviare</option>
//                                                               <option value="Huila">Huila</option>
//                                                               <option value="La Guajira">La Guajira</option>
//                                                               <option value="Magdalena">Magdalena</option>
//                                                               <option value="Meta">Meta</option>
//                                                               <option value="Nariño">Nariño</option>
//                                                               <option value="Norte de Santander">Norte de Santander</option>
//                                                               <option value="Putumayo">Putumayo</option>
//                                                               <option value="Quindío">Quindío</option>
//                                                               <option value="Risaralda">Risaralda</option>
//                                                               <option value="San Andrés y Providencia">San Andrés y Providencia</option>
//                                                               <option value="Santander">Santander</option>
//                                                               <option value="Sucre">Sucre</option>
//                                                               <option value="Tolima">Tolima</option>
//                                                               <option value="Valle del Cauca">Valle del Cauca</option>
//                                                               <option value="Vaupés">Vaupés</option>
//                                                               <option value="Vichada">Vichada</option>
//                                                           </select>
//                                                       </div>
//                                                       <div class="col-md-4" style="display: none;" id="naciona">
//                                                           <label for="" id="" class="form-label text-start fs-5 fw-semibold" style="margin-left: 0%;">Nacionalidad: <span class="text-danger" style="font-size:20px;">*</span></label>
//                                                           <select class="form-control" id="nacionalidad" name="nacionalidad" >
//                                                           <option value="">-</option>
//                                                                 <option value="Colombia">Colombia</option>
//                                                                 <option value="Argentina">Argentina</option>
//                                                                 <option value="Afganistán">Afganistán</option>
//                                                                 <option value="Albania">Albania</option>
//                                                                 <option value="Alemania">Alemania</option>
//                                                                 <option value="Andorra">Andorra</option>
//                                                                 <option value="Angola">Angola</option>
//                                                                 <option value="Anguilla">Anguilla</option>
//                                                                 <option value="Antártida Argentina">Antártida Argentina</option>
//                                                                 <option value="Antigua y Barbuda">Antigua y Barbuda</option>
//                                                                 <option value="Antillas Holandesas">Antillas Holandesas</option>
//                                                                 <option value="Arabia Saudita">Arabia Saudita</option>
//                                                                 <option value="Argelia">Argelia</option>
//                                                                 <option value="Armenia">Armenia</option>
//                                                                 <option value="Aruba">Aruba</option>
//                                                                 <option value="Australia">Australia</option>
//                                                                 <option value="Austria">Austria</option>
//                                                                 <option value="Azerbaiján">Azerbaiján</option>
//                                                                 <option value="Bahamas">Bahamas</option>
//                                                                 <option value="Bahrain">Bahrain</option>
//                                                                 <option value="Bangladesh">Bangladesh</option>
//                                                                 <option value="Barbados">Barbados</option>
//                                                                 <option value="Bélgica">Bélgica</option>
//                                                                 <option value="Belice">Belice</option>
//                                                                 <option value="Benin">Benin</option>
//                                                                 <option value="Bhutan">Bhutan</option>
//                                                                 <option value="Bielorusia">Bielorusia</option>
//                                                                 <option value="Bolivia">Bolivia</option>
//                                                                 <option value="Bosnia Herzegovina">Bosnia Herzegovina</option>
//                                                                 <option value="Botswana">Botswana</option>
//                                                                 <option value="Brasil">Brasil</option>
//                                                                 <option value="Brunei">Brunei</option>
//                                                                 <option value="Bulgaria">Bulgaria</option>
//                                                                 <option value="Burkina Faso">Burkina Faso</option>
//                                                                 <option value="Burundi">Burundi</option>
//                                                                 <option value="Cabo Verde">Cabo Verde</option>
//                                                                 <option value="Camboya">Camboya</option>
//                                                                 <option value="Camerún">Camerún</option>
//                                                                 <option value="Canadá">Canadá</option>
//                                                                 <option value="Chad">Chad</option>
//                                                                 <option value="Chile">Chile</option>
//                                                                 <option value="China">China</option>
//                                                                 <option value="Chipre">Chipre</option>
//                                                                 <option value="Comoros">Comoros</option>
//                                                                 <option value="Congo">Congo</option>
//                                                                 <option value="Corea del Norte">Corea del Norte</option>
//                                                                 <option value="Corea del Sur">Corea del Sur</option>
//                                                                 <option value="Costa de Marfil">Costa de Marfil</option>
//                                                                 <option value="Costa Rica">Costa Rica</option>
//                                                                 <option value="Croacia">Croacia</option>
//                                                                 <option value="Cuba">Cuba</option>
//                                                                 <option value="Darussalam">Darussalam</option>
//                                                                 <option value="Dinamarca">Dinamarca</option>
//                                                                 <option value="Djibouti">Djibouti</option>
//                                                                 <option value="Dominica">Dominica</option>
//                                                                 <option value="Ecuador">Ecuador</option>
//                                                                 <option value="Egipto">Egipto</option>
//                                                                 <option value="El Salvador">El Salvador</option>
//                                                                 <option value="Em. Arabes Un.">Em. Arabes Un.</option>
//                                                                 <option value="Eritrea">Eritrea</option>
//                                                                 <option value="Eslovaquia">Eslovaquia</option>
//                                                                 <option value="Eslovenia">Eslovenia</option>
//                                                                 <option value="España">España</option>
//                                                                 <option value="Estados Unidos">Estados Unidos</option>
//                                                                 <option value="Estonia">Estonia</option>
//                                                                 <option value="Etiopía">Etiopía</option>
//                                                                 <option value="Fiji">Fiji</option>
//                                                                 <option value="Filipinas">Filipinas</option>
//                                                                 <option value="Finlandia">Finlandia</option>
//                                                                 <option value="Francia">Francia</option>
//                                                                 <option value="Gabón">Gabón</option>
//                                                                 <option value="Gambia">Gambia</option>
//                                                                 <option value="Georgia">Georgia</option>
//                                                                 <option value="Ghana">Ghana</option>
//                                                                 <option value="Gibraltar">Gibraltar</option>
//                                                                 <option value="Grecia">Grecia</option>
//                                                                 <option value="Grenada">Grenada</option>
//                                                                 <option value="Groenlandia">Groenlandia</option>
//                                                                 <option value="Guadalupe">Guadalupe</option>
//                                                                 <option value="Guam">Guam</option>
//                                                                 <option value="Guatemala">Guatemala</option>
//                                                                 <option value="Guayana Francesa">Guayana Francesa</option>
//                                                                 <option value="Guinea">Guinea</option>
//                                                                 <option value="Guinea Ecuatorial">Guinea Ecuatorial</option>
//                                                                 <option value="Guinea-Bissau">Guinea-Bissau</option>
//                                                                 <option value="Guyana">Guyana</option>
//                                                                 <option value="Haití">Haití</option>
//                                                                 <option value="Holanda">Holanda</option>
//                                                                 <option value="Honduras">Honduras</option>
//                                                                 <option value="Hong Kong">Hong Kong</option>
//                                                                 <option value="Hungría">Hungría</option>
//                                                                 <option value="India">India</option>
//                                                                 <option value="Indonesia">Indonesia</option>
//                                                                 <option value="Irak">Irak</option>
//                                                                 <option value="Irán">Irán</option>
//                                                                 <option value="Irlanda">Irlanda</option>
//                                                                 <option value="Islandia">Islandia</option>
//                                                                 <option value="Islas Cayman">Islas Cayman</option>
//                                                                 <option value="Islas Cook">Islas Cook</option>
//                                                                 <option value="Islas Faroe">Islas Faroe</option>
//                                                                 <option value="Islas Marianas del Norte">Islas Marianas del Norte</option>
//                                                                 <option value="Islas Marshall">Islas Marshall</option>
//                                                                 <option value="Islas Solomon">Islas Solomon</option>
//                                                                 <option value="Islas Turcas y Caicos">Islas Turcas y Caicos</option>
//                                                                 <option value="Islas Vírgenes">Islas Vírgenes</option>
//                                                                 <option value="Islas Wallis y Futuna">Islas Wallis y Futuna</option>
//                                                                 <option value="Israel">Israel</option>
//                                                                 <option value="Italia">Italia</option>
//                                                                 <option value="Jamaica">Jamaica</option>
//                                                                 <option value="Japón">Japón</option>
//                                                                 <option value="Jordania">Jordania</option>
//                                                                 <option value="Kazajstán">Kazajstán</option>
//                                                                 <option value="Kenya">Kenya</option>
//                                                                 <option value="Kirguistán">Kirguistán</option>
//                                                                 <option value="Kiribati">Kiribati</option>
//                                                                 <option value="Kuwait">Kuwait</option>
//                                                                 <option value="Laos">Laos</option>
//                                                                 <option value="Lesotho">Lesotho</option>
//                                                                 <option value="Letonia">Letonia</option>
//                                                                 <option value="Líbano">Líbano</option>
//                                                                 <option value="Liberia">Liberia</option>
//                                                                 <option value="Libia">Libia</option>
//                                                                 <option value="Liechtenstein">Liechtenstein</option>
//                                                                 <option value="Lituania">Lituania</option>
//                                                                 <option value="Luxemburgo">Luxemburgo</option>
//                                                                 <option value="Macao">Macao</option>
//                                                                 <option value="Macedonia">Macedonia</option>
//                                                                 <option value="Madagascar">Madagascar</option>
//                                                                 <option value="Malasia">Malasia</option>
//                                                                 <option value="Malawi">Malawi</option>
//                                                                 <option value="Mali">Mali</option>
//                                                                 <option value="Malta">Malta</option>
//                                                                 <option value="Marruecos">Marruecos</option>
//                                                                 <option value="Martinica">Martinica</option>
//                                                                 <option value="Mauricio">Mauricio</option>
//                                                                 <option value="Mauritania">Mauritania</option>
//                                                                 <option value="Mayotte">Mayotte</option>
//                                                                 <option value="México">México</option>
//                                                                 <option value="Micronesia">Micronesia</option>
//                                                                 <option value="Moldova">Moldova</option>
//                                                                 <option value="Mónaco">Mónaco</option>
//                                                                 <option value="Mongolia">Mongolia</option>
//                                                                 <option value="Montserrat">Montserrat</option>
//                                                                 <option value="Mozambique">Mozambique</option>
//                                                                 <option value="Myanmar">Myanmar</option>
//                                                                 <option value="Namibia">Namibia</option>
//                                                                 <option value="Nauru">Nauru</option>
//                                                                 <option value="Nepal">Nepal</option>
//                                                                 <option value="Nicaragua">Nicaragua</option>
//                                                                 <option value="Níger">Níger</option>
//                                                                 <option value="Nigeria">Nigeria</option>
//                                                                 <option value="Noruega">Noruega</option>
//                                                                 <option value="Nueva Caledonia">Nueva Caledonia</option>
//                                                                 <option value="Nueva Zelandia">Nueva Zelandia</option>
//                                                                 <option value="Omán">Omán</option>
//                                                                 <option value="Pakistán">Pakistán</option>
//                                                                 <option value="Panamá">Panamá</option>
//                                                                 <option value="Papua Nueva Guinea">Papua Nueva Guinea</option>
//                                                                 <option value="Paraguay">Paraguay</option>
//                                                                 <option value="Perú">Perú</option>
//                                                                 <option value="Pitcairn">Pitcairn</option>
//                                                                 <option value="Polinesia Francesa">Polinesia Francesa</option>
//                                                                 <option value="Polonia">Polonia</option>
//                                                                 <option value="Portugal">Portugal</option>
//                                                                 <option value="Puerto Rico">Puerto Rico</option>
//                                                                 <option value="Qatar">Qatar</option>
//                                                                 <option value="RD Congo">RD Congo</option>
//                                                                 <option value="Reino Unido">Reino Unido</option>
//                                                                 <option value="República Centroafricana">República Centroafricana</option>
//                                                                 <option value="República Checa">República Checa</option>
//                                                                 <option value="República Dominicana">República Dominicana</option>
//                                                                 <option value="Reunión">Reunión</option>
//                                                                 <option value="Rumania">Rumania</option>
//                                                                 <option value="Rusia">Rusia</option>
//                                                                 <option value="Rwanda">Rwanda</option>
//                                                                 <option value="Sahara Occidental">Sahara Occidental</option>
//                                                                 <option value="Saint Pierre y Miquelon">Saint Pierre y Miquelon</option>
//                                                                 <option value="Samoa">Samoa</option>
//                                                                 <option value="Samoa Americana">Samoa Americana</option>
//                                                                 <option value="San Cristóbal y Nevis">San Cristóbal y Nevis</option>
//                                                                 <option value="San Marino">San Marino</option>
//                                                                 <option value="Santa Elena">Santa Elena</option>
//                                                                 <option value="Santa Lucía">Santa Lucía</option>
//                                                                 <option value="Sao Tomé y Príncipe">Sao Tomé y Príncipe</option>
//                                                                 <option value="Senegal">Senegal</option>
//                                                                 <option value="Serbia y Montenegro">Serbia y Montenegro</option>
//                                                                 <option value="Seychelles">Seychelles</option>
//                                                                 <option value="Sierra Leona">Sierra Leona</option>
//                                                                 <option value="Singapur">Singapur</option>
//                                                                 <option value="Siria">Siria</option>
//                                                                 <option value="Somalia">Somalia</option>
//                                                                 <option value="Sri Lanka">Sri Lanka</option>
//                                                                 <option value="Sudáfrica">Sudáfrica</option>
//                                                                 <option value="Sudán">Sudán</option>
//                                                                 <option value="Suecia">Suecia</option>
//                                                                 <option value="Suiza">Suiza</option>
//                                                                 <option value="Suriname">Suriname</option>
//                                                                 <option value="Swazilandia">Swazilandia</option>
//                                                                 <option value="Taiwán">Taiwán</option>
//                                                                 <option value="Uruguay">Uruguay</option>
//                                                         </select>
//                                                       </div>
//                                                       <div class="col-md-4" style="display: none;" id="peso">
//                                                           <label for="" id="" class="form-label text-start fs-5 fw-semibold" style="margin-left: 0%;">Peso (KG): <span class="text-danger" style="font-size:20px;">*</span></label>
//                                                           <input type="text" class="form-control" placeholder="Ingrese el peso en kg"  name="peso" id="pesoo" step="0.1">
//                                                       </div>
//                                                       <div class="col-md-4" style="display: none;" id="estatura">
//                                                           <label for="" id="" class="form-label text-start fs-5 fw-semibold" style="margin-left: 0%;">Estatura (MTs): <span class="text-danger" style="font-size:20px;">*</span></label>
//                                                           <input type="text" class="form-control" placeholder="Ingrese la estatura en MTs"  name="estatura" id="esta" step="0.01">
//                                                       </div>
//                                                       <div class="col-md-4" style="display: none;" id="mano">
//                                                           <label for="" id="" class="form-label text-start fs-5 fw-semibold" style="margin-left: 0%;">Mano Dominante: <span class="text-danger" style="font-size:20px;">*</span></label>

//                                                           <!-- Botones de tipo radio -->
//                                                           <div class="form-check text-start">
//                                                               <input class="form-check-input" type="radio" name="mano_dominante" id="diestro" value="Diestro">
//                                                               <label class="form-check-label" for="diestro">Diestro</label>
//                                                           </div>

//                                                           <div class="form-check text-start">
//                                                               <input class="form-check-input" type="radio" name="mano_dominante" id="zurdo" value="Zurdo">
//                                                               <label class="form-check-label" for="zurdo">Zurdo</label>
//                                                           </div>

//                                                           <div class="form-check text-start">
//                                                               <input class="form-check-input" type="radio" name="mano_dominante" id="ambidiestro" value="Ambidiestro">
//                                                               <label class="form-check-label" for="ambidiestro">Ambidiestro</label>
//                                                           </div>
//                                                       </div>
//                                                       <div style="display:none" id="enfermedadlista">
//                                                         <hr class="mt-3">
//                                                         <h3 class="text-decoration-underline">DECLARACIÓN DE ASEGURABILIDAD</h3>
//                                                         <p class="text-start fs-5"><span class="text-danger" style="font-size:20px;">*</span><strong>1.</strong> Ha padecido o es tratado actualmente de alguna enfermedad o incapacidad relacionada con lo siguiente?</p>
//                                                         ${row.Enfermedades}
//                                                         <p class="text-start fs-5"><span class="text-danger" style="font-size:20px;">*</span><strong>2.</strong> Ha padecido, padece o es tratado actualmente de alguna enfermedad o condición relacionada con su salud e integridad física diferente a las del numeral anterior?      <label class="form-check-label fw-bold me-1">SI </label><input class="form-check-input" type="radio" name="pregunta2" value="1" id="a"> <label class="form-check-label ms-3 fw-bold me-1">NO </label><input class="form-check-input" type="radio" name="pregunta2" value="0"></p>
//                                                         <div id="enfermedadDiv" style="display: none;" class="form-group row">
//                                                             <label for="enfermedadInput" class="fs-5 col-1 fw-bold">¿Cuál?</label>
//                                                             <div class="col-6">
//                                                                 <input type="text" id="cual" class="form-control" name="cual">
//                                                             </div>
//                                                         </div>
//                                                       </div>
//                                                       <div class="" style="display: none;" id="pregunta3">
//                                                         <p class="text-start fs-5"><span class="text-danger" style="font-size:20px;">*</span><strong>3.</strong>  Ha tenido o tiene alguna pérdida funcional o anatómica, ha padecido accidentes que impidan desempeñar labores propias de su ocupación o sabe si será hospitalizado o intervenido quirúrgicamente?      <label class="form-check-label fw-bold me-1">SI </label><input class="form-check-input" type="radio" name="pregunta3" value="1" id="p3"> <label class="form-check-label ms-3 fw-bold me-1">NO </label><input class="form-check-input" type="radio" name="pregunta3" value="0"></p>
//                                                       </div>

//                                                       <div class="" style="display: none;" id="pregunta4">
//                                                       <p class="text-start fs-5">
//                                                         <span class="text-danger" style="font-size:20px;">*</span><strong>4.</strong> Ha tenido o tiene algún procedimiento no quirúrgico pendiente?
//                                                         <label class="form-check-label fw-bold me-1">SI </label><input class="form-check-input" type="radio" name="pregunta4" value="1" id="p4"> <label class="form-check-label ms-3 fw-bold me-1">NO </label><input class="form-check-input" type="radio" name="pregunta4" value="0">
//                                                         </p>
//                                                       </div>

//                                                       <!-- Div oculto que se mostrará cuando se marque el checkbox -->
//                                                       <div id="procedimientoDiv" style="display: none;" class="form-group row">
//                                                           <table id="procedimientoTable" class="table">
//                                                               <thead>
//                                                                   <tr>
//                                                                       <th>ENFERMEDAD</th>
//                                                                       <th>FECHA DE DIAGNÓSTICO</th>
//                                                                       <th>TRATAMIENTO</th>
//                                                                   </tr>
//                                                               </thead>
//                                                               <tbody>
//                                                                   <tr>
//                                                                       <td><input type="text" class="form-control" name="enfermedad1" id="enfermedad1"></td>
//                                                                       <td><input type="date" class="form-control" name="fecha1" id="fechaa"></td>
//                                                                       <td><input type="text" class="form-control" name="tratamiento1"></td>
//                                                                   </tr>
//                                                                   <tr>
//                                                                       <td><input type="text" class="form-control" name="enfermedad2"></td>
//                                                                       <td><input type="date" class="form-control" name="fecha2"></td>
//                                                                       <td><input type="text" class="form-control" name="tratamiento2"></td>
//                                                                   </tr>
//                                                               </tbody>
//                                                           </table>
//                                                       </div>
//                                                       <div class="" style="display: none;" id="pregunta5">
//                                                         <p class="text-start fs-5"><span class="text-danger" style="font-size:20px;">*</span><strong>5.</strong>  ¿Tiene pérdida de capacidad laboral permanente?             <label class="form-check-label fw-bold me-1">SI </label><input id="p5" class="form-check-input" type="radio" name="pregunta5" value="1"> <label class="form-check-label ms-3 fw-bold me-1">NO </label><input class="form-check-input" type="radio" name="pregunta5" value="0"></p>
//                                                       </div>
//                                                       <div class="" style="display: none;" id="pregunta6">
//                                                         <p class="text-start fs-5"><span class="text-danger" style="font-size:20px;">*</span><strong>6.</strong>  ¿Le ha sido declarado legalmente pérdida de capacidad laboral permanente en el 50% o más?             <label class="form-check-label fw-bold me-1">SI </label><input id="p6" class="form-check-input" type="radio" name="pregunta6" value="1"> <label class="form-check-label ms-3 fw-bold me-1">NO </label><input class="form-check-input" type="radio" name="pregunta6" value="0"></p>
//                                                       </div>
//                                                       <div class="" style="display: none;" id="pregunta7">
//                                                         <p class="text-start fs-5"><span class="text-danger" style="font-size:20px;">*</span><strong>7.</strong>  ¿Le ha sido declarado legalmente pérdida de capacidad laboral permanente en menos del 50%?             <label class="form-check-label fw-bold me-1">SI </label><input id="p7" class="form-check-input" type="radio" readonly name="pregunta7" value="1"> <label class="form-check-label ms-3 fw-bold me-1">NO </label><input class="form-check-input" type="radio" name="pregunta7" value="0" readonly></p>
//                                                       </div>
//                                                       <div class="" style="display: none;" id="pregunta8">
//                                                         <p class="text-start fs-5"><span class="text-danger" style="font-size:20px;">*</span><strong>8.</strong>   ¿Está tramitando el reconocimiento legal de pérdida de capacidad laboral permanente?             <label class="form-check-label fw-bold me-1">SI </label><input id="p8" class="form-check-input" type="radio" name="pregunta8" value="1"> <label class="form-check-label ms-3 fw-bold me-1">NO </label><input class="form-check-input" type="radio" name="pregunta8" value="0"></p>
//                                                       </div>
//                                                       <div class="" style="display: none;" id="pregunta9">
//                                                         <hr>
//                                                         <h3 class="text-decoration-underline">FIRMA Y HUELLA</h3>
//                                                         <p class="text-start fs-5"><span class="text-danger" style="font-size:20px;">*</span><strong>1.</strong>  ¿Posee alguna póliza donde se le cobre un valor adicional a la tarifa normal por padecimiento médico, es decir, extra-prima?             <label class="form-check-label fw-bold me-1">SI </label><input id="p9" class="form-check-input" type="radio" name="pregunta9" value="1"> <label class="form-check-label ms-3 fw-bold me-1">NO </label><input class="form-check-input" type="radio" name="pregunta9" value="0"></p>
//                                                       </div>
//                                                       <div class="" style="display: none;" id="pregunta10">
//                                                         <p class="text-start fs-5"><span class="text-danger" style="font-size:20px;">*</span><strong>2.</strong>   He sido rechazado por alguna Compañía aseguradora en el momento de presentar una solicitud de seguro:<br>            <label class="form-check-label fw-bold me-1">SI </label><input id="p10" class="form-check-input" type="radio" name="pregunta10" value="1"> <label class="form-check-label ms-3 fw-bold me-1">NO </label><input class="form-check-input" type="radio" name="pregunta10" value="0"></p>
//                                                       </div>
//                                                   </div>
//                                               </div>

//                                               <div class="modal-footer d-flex justify-content-center">
//                                               <button disabled type="submit" id="boton" name="editar" class="btn btn-primary fs-4 fw-bold" style="background-color: #005E56;" onclick="setTimeout(function(){ window.location.reload(); }, 3000)">GENERAR FORMATO ASEGURABILIDAD</button>


//                                               </div>
//                                           </form>
//                                       </div>
//                                   </div>
//                               </div>
//                           </div>`;
//                           $(document).ready(function() {
//                               // Manejar el cambio en el select de expedición
//                               $("#inputCiudadLine2").change(function() {
//                                 // Obtener el valor seleccionado
//                                 var selectedExpedicion = $(this).val();

//                                 // Verificar si se seleccionó una opción
//                                 if (selectedExpedicion !== "") {
//                                   // Mostrar el div de departamentos
//                                   $("#depart").show();
//                                   $("#departamentos").focus();
//                                 } else {
//                                   // Ocultar el div de departamentos si no se selecciona nada
//                                   $("#depart").hide();
//                                 }
//                               });
//                             });


//                           $(document).ready(function() {
//                               // Manejar el cambio en el select de expedición
//                               $("#departamentos").change(function() {
//                                 // Obtener el valor seleccionado
//                                 var selectedExpedicion = $(this).val();

//                                 // Verificar si se seleccionó una opción
//                                 if (selectedExpedicion !== "") {
//                                   // Mostrar el div de departamentos
//                                   $("#naciona").show();
//                                   $("#nacionalidad").focus();
//                                 } else {
//                                   // Ocultar el div de departamentos si no se selecciona nada
//                                   $("#naciona").hide();
//                                 }
//                               });
//                             });

//                             $(document).ready(function() {
//                               // Manejar el cambio en el select de expedición
//                               $("#nacionalidad").change(function() {
//                                 // Obtener el valor seleccionado
//                                 var selectedExpedicion = $(this).val();

//                                 // Verificar si se seleccionó una opción
//                                 if (selectedExpedicion !== "") {
//                                   // Mostrar el div de departamentos
//                                   $("#peso").show();
//                                   $("#pesoo").focus();
//                                 } else {
//                                   // Ocultar el div de departamentos si no se selecciona nada
//                                   $("#peso").hide();
//                                 }
//                               });
//                             });

//                             $(document).ready(function() {
//                             $('#pesoo').on('input', function() {
//                                     if ($(this).val().trim() !== '') {
//                                         $('#estatura').show(); // Muestra el div si el input 'cual' tiene contenido
//                                     } else {
//                                         $('#estatura').hide(); // Oculta el div si el input 'cual' está vacío
//                                     }
//                                 });
//                             });

//                             $(document).ready(function() {
//                             $('#esta').on('input', function() {
//                                     if ($(this).val().trim() !== '') {
//                                         $('#mano').show(); // Muestra el div si el input 'cual' tiene contenido
//                                     } else {
//                                         $('#mano').hide(); // Oculta el div si el input 'cual' está vacío
//                                     }
//                                 });
//                             });


//                           $(document).ready(function () {
//                             // Cuando se cambia la opción de manodominante
//                             $('input[name="mano_dominante"]').change(function () {
//                               // Si se selecciona cualquier opción de manodominante, muestra enfermedadlista
//                               if ($('input[name="mano_dominante"]:checked').length > 0) {
//                                 $('#enfermedadlista').show();
//                                 var position = $("#a").position().top;

//                                 // Hacer un desplazamiento suave dentro del modal
//                                 $(`#staticBackdrop_${id} .modal-body`).animate({
//                                     scrollTop: position
//                                 }, 800);
//                               } else {
//                                 $('#enfermedadlista').hide();
//                               }
//                             });
//                           });


//                           $(document).ready(function() {
//                               // Manejar el cambio en la selección de radio buttons
//                               $('input[name="pregunta2"]').change(function() {
//                                   if ($(this).val() == '1') {
//                                       $('#enfermedadDiv').show(); // Muestra el div si el valor es 1
//                                       $('#pregunta3').hide();
//                                       $('#cual').focus();

//                                   } else {
//                                       $('#enfermedadDiv').hide(); // Oculta el div si el valor no es 1
//                                       $('#pregunta3').show();
//                                       var position = $("#p3").position().top;

//                                       // Hacer un desplazamiento suave dentro del modal
//                                       $(`#staticBackdrop_${id} .modal-body`).animate({
//                                           scrollTop: position
//                                       }, 800);
//                                   }
//                               });
//                           });
//                           $(document).ready(function() {
//                             $('#cual').on('input', function() {
//                                     if ($(this).val().trim() !== '') {
//                                         $('#pregunta3').show(); // Muestra el div si el input 'cual' tiene contenido
//                                         var position = $("#p3").position().top;

//                                         // Hacer un desplazamiento suave dentro del modal
//                                         $(`#staticBackdrop_${id} .modal-body`).animate({
//                                             scrollTop: position
//                                         }, 800);
//                                     } else {
//                                         $('#pregunta3').hide(); // Oculta el div si el input 'cual' está vacío
//                                     }
//                                 });
//                             });


//                             $(document).ready(function() {
//                               // Manejar el cambio en la selección de radio buttons
//                               $('input[name="pregunta3"]').change(function() {
//                                   if ($(this).val() == '1') {
//                                       $('#pregunta4').show();
//                                       var position = $("#p4").position().top;

//                                       // Hacer un desplazamiento suave dentro del modal
//                                       $(`#staticBackdrop_${id} .modal-body`).animate({
//                                           scrollTop: position
//                                       }, 800);

//                                   } else {
//                                       $('#pregunta4').show();
//                                       var position = $("#p4").position().top;

//                                       // Hacer un desplazamiento suave dentro del modal
//                                       $(`#staticBackdrop_${id} .modal-body`).animate({
//                                           scrollTop: position
//                                       }, 800);
//                                   }
//                               });
//                           });


//                           $(document).ready(function() {
//                               // Manejar el cambio en la selección de radio buttons
//                               $('input[name="pregunta4"]').change(function() {
//                                   if ($(this).val() == '1') {
//                                       $('#procedimientoDiv').show(); // Muestra el div si el valor es 1
//                                       $('#pregunta5').hide();
//                                       $('#enfermedad1, #fechaa, #tratamiento1').prop('required', true);


//                                   } else {
//                                       $('#procedimientoDiv').hide(); // Oculta el div si el valor no es 1
//                                       $('#pregunta5').show();
//                                       $('#enfermedad1, #fechaa, #tratamiento1').prop('required', false);

//                                   }
//                               });
//                           });
//                           $(document).ready(function() {
//                             $('#enfermedad1').on('input', function() {
//                                     if ($(this).val().trim() !== '') {
//                                         $('#pregunta5').show(); // Muestra el div si el input 'cual' tiene contenido
//                                     } else {
//                                         $('#pregunta5').hide(); // Oculta el div si el input 'cual' está vacío
//                                     }
//                                 });
//                             });

//                             $(document).ready(function() {
//                               // Manejar el cambio en la selección de radio buttons
//                               $('input[name="pregunta5"]').change(function() {
//                                   if ($(this).val() == '1') {
//                                       $('#pregunta6').show();


//                                   } else {
//                                       $('#pregunta6').hide();
//                                   }
//                               });
//                           });

//                           $(document).ready(function() {
//                           // Manejar el evento de cambio en el radio button de la pregunta 5
//                           $('input[name="pregunta5"]').change(function() {
//                               // Verificar si la respuesta es "NO"
//                               if ($(this).val() === '0') {
//                                   // Marcar automáticamente las respuestas de las preguntas 6-8 como "NO"
//                                   $('input[name="pregunta6"]').prop('checked', true);
//                                   $('input[name="pregunta7"]').prop('checked', true);
//                                   $('input[name="pregunta8"]').prop('checked', true);

//                                   // Deshabilitar las opciones de las preguntas 6-8
//                                   $('input[name="pregunta6"]').prop('disabled', true);
//                                   $('input[name="pregunta7"]').prop('disabled', true);
//                                   $('input[name="pregunta8"]').prop('disabled', true);

//                                   // Mostrar las preguntas 6-8
//                                   $('#pregunta6, #pregunta7, #pregunta8, #pregunta9').show();



//                               } else {
//                                   // Habilitar las opciones de las preguntas 6-8 si la respuesta no es "NO"
//                                   $('input[name="pregunta6"]').prop('checked', false);
//                                   $('input[name="pregunta7"]').prop('checked', false);
//                                   $('input[name="pregunta8"]').prop('checked', false);

//                                   $('input[name="pregunta6"]').prop('disabled', false);
//                                   $('input[name="pregunta7"]').prop('disabled', false);
//                                   $('input[name="pregunta8"]').prop('disabled', false);

//                                   // Ocultar las preguntas 6-8 si la respuesta no es "NO"
//                                   $('#pregunta7, #pregunta8, #pregunta9').hide();
//                                   $('#pregunta6').show();
//                               }
//                           });
//                       });


//                       $(document).ready(function() {
//                               // Manejar el cambio en la selección de radio buttons
//                               $('input[name="pregunta6"]').change(function() {
//                                   if ($(this).val() == '1') {
//                                       $('#pregunta7').show();
//                                       $('#pregunta8').show();




//                                       } else {
//                                         $('#pregunta7').show();
//                                         $('#pregunta8').show();

//                                       }
//                                     });
//                           });


//                       $(document).ready(function () {
//                       // Cuando se cambia la respuesta de la pregunta 6
//                       $('input[name="pregunta6"]').change(function () {
//                         // Obtén el valor de la respuesta de la pregunta 6
//                         var respuestaPregunta6 = $('input[name="pregunta6"]:checked').val();

//                         // Cambia la respuesta de la pregunta 7 en función de la respuesta de la pregunta 6
//                         if (respuestaPregunta6 == 1) {
//                           $('input[name="pregunta7"][value="0"]').prop('checked', true);
//                           $('input[name="pregunta7"]').prop('disabled', true);
//                         } else {
//                           $('input[name="pregunta7"][value="1"]').prop('checked', true);
//                           $('input[name="pregunta7"]').prop('disabled', true);
//                         }
//                       });
//                     });


//                     $(document).ready(function() {
//                               // Manejar el cambio en la selección de radio buttons
//                               $('input[name="pregunta8"]').change(function() {
//                                   if ($(this).val() == '1') {
//                                       $('#pregunta9').show();

//                                   } else {
//                                       $('#pregunta9').show();

//                                   }
//                               });
//                           });

//                     $(document).ready(function() {
//                         // Manejar el cambio en la selección de radio buttons
//                         $('input[name="pregunta9"]').change(function() {
//                             if ($(this).val() == '1') {
//                                 $('#pregunta10').show();
//                             } else {
//                                 $('#pregunta10').show();

//                             }
//                         });
//                     });

//                     $(document).ready(function() {
//                         // Manejar el cambio en la selección de radio buttons
//                         $('input[name="pregunta6"]').change(function() {
//                             if ($(this).val() == '1') {
//                                 $('#pregunta7').show();
//                                 $('#pregunta8').show();

//                             } else {
//                                 $('#pregunta7').show();
//                                 $('#pregunta8').show();
//                             }
//                         });
//                     });

//                     $(document).ready(function() {
//                         // Agrega un oyente de eventos al cambio del radio button
//                         $('input[name="pregunta10"]').change(function() {
//                             // Habilita el botón si se selecciona cualquiera de los dos casos
//                             $('#boton').prop('disabled', false);
//                         });
//                     });


//                     Swal.fire({
//                     title: `Generando Formulario de Asegurabilidad...`,
//                     text: ``,
//                     icon: 'info',
//                     allowOutsideClick: false,
//                     allowEscapeKey: false,
//                     showConfirmButton: false,
//                     didOpen: async () => {
//                         Swal.showLoading();

//                         try {

//                             // Simula una operación asíncrona, puedes reemplazar esto con tu lógica real
//                             await new Promise(resolve => setTimeout(resolve, 1000));

//                             // Insertar el formulario en el body
//                             document.body.insertAdjacentHTML('beforeend', Formato);

//                             // Inicializar el modal
//                             var modal = new bootstrap.Modal(document.getElementById('staticBackdrop_' + id));
//                             Swal.close();
//                             // Mostrar el modal
//                             modal.show();

//                             // Manejar el evento de cierre del modal
//                             modal.addEventListener('hidden.bs.modal', function () {
//                                 // Eliminar el elemento del modal del DOM después de cerrarlo
//                                 document.getElementById('staticBackdrop_' + id).remove();
//                             });

//                             // Cerrar el SweetAlert después de cargar el modal

//                         } catch (error) {
//                             // Manejar errores si es necesario
//                             console.error(error);
//                         }
//                     }
//                 });

//         }else{
//             var Formato = '<div class="text-center fw-bold fs-2">N/A</div>';
//         }


//   return Formato;

// }
//   },
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
    data: null,
      render: function(data, type, row) {
        if(row.ExisteDatacredito == 2){
              var AprobadoButton = '<span class="text-danger blink" style="font-weight: bold; font-size: 25px">SCORE NULO</span><br><span class="text-dark opacity-50" style="font-weight: bold; font-size: 15px">Espere a area de cumplimiento a que sea consultado.</span>';
        }else if(row.ExisteDatacredito == 1){
              var AprobadoButton = '<span class="text-danger blink" style="font-weight: bold; font-size: 25px">NO EXISTE EN DATACRÉDITO</span><br><a href="registrarpagare"><span class="text-primary-emphasis" style="font-weight: bold; font-size: 15px">Registra en datacrédito.</span></a>';
        }else if(row.Aprobado == 1){
            var AprobadoButton = '<span class="text-success" style="font-weight: bold; font-size: 30px">SI</span>';
        }else if(row.Aprobado == 0){
            var AprobadoButton = '<span class="text-danger" style="font-weight: bold; font-size: 30px">NO</span>';
        }else{
            var AprobadoButton = '<span class="" style="font-weight: bold; font-size: 30px">PENDIENTE</span>';
        }
    return AprobadoButton;

      }
    },
{    data: null,
      render: function(data, type, row) {
        var id = row.ID;
        var url = "{{ route('crudger.adjuntarautorizacion', ':id') }}";
        var today = new Date().toISOString().split('T')[0];
        url = url.replace(':id', id);

        var html = '';
      if(row.AutorizacionGerente == 0){

        var editButton = `<div class="text-center fw-bold fs-2">N/A</div>`
      }else if(row.AutorizacionGerente==1){
      var editButton = `<div class="text-center fw-bold fs-2">Notificar a Coordinación</div>`;
                }else{
                  var editButton =`<a href="Storage/files/autorizacionpagare/${row.DocuAutorizacion}" download style="display: flex; justify-content: center;"><img src="img/pdf.png" style="height: 4.0rem; width: 3.0rem"></a>`
                }
  return editButton;

}
  },
{
      data: null,
      render: function(data, type, row) {
        var Fecha1Cuota = '<strong style="font-size:25px">'+row.Fecha1Cuota+'</strong>';
        return Fecha1Cuota;
      }
    },


    {
      data: null,
      render: function(data, type, row) {
        var FechaAccion = '<strong style="font-size:25px">'+row.FechaAccion+'</strong>';
        return FechaAccion;
      }
    },
    {
      data: null,
      render: function(data, type, row) {
        var Garantia = '<span style="font-size:25px">'+row.Garantia+'</span>';
        return Garantia;
      }
    },


    {data: 'NoAgencia'},
    {
      data: null,
      render: function(data, type, row) {
        var Interes = '<span style="font-size:25px">'+row.InteresProporcional+'</span>';
        return Interes;
      }
    },
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
    { "data": "Capital",
      "render": $.fn.dataTable.render.number(',', '.', 0) // Formatea como número con 2 decimales
    },
    {data: 'NoCuotas'},
    {data: 'ValorCuota'},
    {data: 'Tasa'},
    {data: 'FechaCredito'},
    {data: 'Nomina'},
    {data: 'Direccion'},
    {data: 'TelFijo'},
    {data: 'FechaUltimaCuota'},
    {data: 'Celular'},
    {data: 'Correo'},
    {data: 'GeneradorPagare'}
  ],


  "lengthMenu": [[7], [7]],
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
    "zeroRecords": "<span class='blink' style='font-size: 40px; text-align: left;'>Lo sentimos, <span class='text-danger'>NO</span> hay registros de créditos!</span>",
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
          '<button id="btnT" class="custom-btn" title="ACTUALIZAR INFORMACIÓN"><i class="fa-solid fa-rotate-right"></i></button>' +
        //   '<button id="btnFA" class="custom-btn" title="FALTA POR APROBAR">FA</button>' +
          '</div>';
    $(buttonsHtml).prependTo('.dataTables_filter');
        $('#btnT').on('click', function() {
            table.ajax.reload(null, false);

        });
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
			},
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

</div>



    @endsection

