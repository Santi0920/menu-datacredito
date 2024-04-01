<!doctype html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datacrédito</title>
    <link href="ResourcesAll/Bootstrap/Bootstrap.css" rel="stylesheet">
    <link type="text/css" href="css/datacredito.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/logoo.png" type="image/png">
    <script src="ResourcesAll/jquery/jquery-3.6.0.js"></script>
    <script src="ResourcesAll/jquery/jquery-ui.js"></script>
    
    <script src="ResourcesAll/fontawesome/fontawesome.js"></script>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <script src="ResourcesAll/Sweetalert/sweetalert2.js"></script>
    <link rel="stylesheet" href="ResourcesAll/Sweetalert/sweetalert2.css">
    <link rel="stylesheet" href="ResourcesAll/Bootstrap/Bootstrap2.css">
    <link rel="stylesheet" href="ResourcesAll/Bootstrap/dataTablesbootstrap5.css">
    <style>@media print {@page {size: landscape;}}</style>
    <script src="js/index.js" defer></script>
  </head>
  
  
  <body data-bs-theme="auto">


      
      <div class="contenedor2">
        <div class="agregar2">
          <a href="datacredito.php" class="btn btn-primary" style="font-size: 35px;font-family: 'Montserrat', sans-serif; font-weight: bold;" data-bs-toggle="modal" data-bs-target="#exampleModal3">
            <span style="margin-bottom: 30px; margin-top: 20px;">V1</span>
          </a>
        </div>
      </div>
      
      <!-- Modal -->
      <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title fw-semibold text-center"  style="font-size: 2.5rem; margin-left: 30%;" id="exampleModalLabel3">VERSIÓN #1.3</h5>
              <button type="button" data-bs-dismiss="modal" class="btn-close p-3" aria-label="Close"></button>
            </div>
            <div class="modal-body texto-justificado">
              <!-- Contenido del modal -->
              <p style="font-size: 20px;" class="text-justify">
              Esta  aplicación fue creada para el control en la generación de datacréditos.
              </p>
              <ul style="font-size: 20px; text-justify:distribute-all-lines" class="">
                <li><strong>Se adicionó en la parte superior derecha cambio del color de fondo(claro,oscuro, automatico).</strong></li>
                <li>El datacrédito tiene vigencia de <strong>180 días/6 meses</strong>.</li>
                <li>El campo agencia <strong>desaparece</strong>.</li>
                <li>El sistema genera advertencias una vez los documentos estén <strong>vencidos</strong>.</li>
                <li>El sistema genera <strong>tickets</strong> con la información de la persona para su posterior impresión.</li>
                <li>El sistema es compatible con impresora <strong>LabelWriter 450</strong>  con tickets referencia: <strong>30336 1 in x 2-1/8 in</strong> con escala <strong>35</strong>.</li>
                <li>Propiedad de <strong>COOPSERP</strong>.</li>
              </ul>
            </div>
            <div class="modal-footer">
            <h5 class="fw-semibold text-secondary" style="font-size: 35px; margin-right: 48%;">Enero 2024</h5>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-size: 20px;">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
    <div>
      @yield('nav')
    </div>
    <div class="" >
        @yield('content')
    </div>
         
    <!-- Pie de pagina -->
            <footer class="mt-2">
            <div class="container-fluid">
              <div class="row p-5 pb-2 text-white text-left" style="background-color: #005E56;">
      
                <div class="col-xs-12 col-md-6 col-lg-3">
                  <p class="h3">&copy; Coopserp Web</p>
                  <p class="text-secondaty text-left">Cali, Colombia</p>
                  <img src="img/CoopserpPH.png" alt="Coopserp.png" width="250" height="90">
                </div>
                <div class="col-xs-12 col-md-6 col-lg-3 aling-elements">
                  <p class="h5 mb-3 text-left"><b>Servicios</b></p>
                  <div class="mb-2">
                    <a href="#arriba" class="text-light text-decoration-none">Datacrédito</a>
                  </div>
                  <div class="mb-2">
                    <a href="#" class="text-light text-decoration-none">Anticipos</a>
                  </div>
                  <div class="mb-2">
                    <a href="#" class="text-light text-decoration-none">Cuentas H</a>
                  </div>
                  <div class="mb-2">
                    <a href="#" class="text-light text-decoration-none">Cartera Castigada</a>
                  </div>
                  <div class="mb-2">
                    <a href="#" class="text-light text-decoration-none">Fondo de Garantía</a>
                  </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-3">
                  <p class="h5 mb-3 text-left"><b>Enlaces</b></p>
                  <div class="mb-2">
                    <a href="#" class="text-light text-decoration-none">Términos & Condiciones</a>
                  </div>
                  <div class="mb-2">
                    <a href="#" class="text-light text-decoration-none">Política de Privacidad</a>
                  </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-3">
                  <p class="h5 mb-3 text-left"><b>Otros Contactos</b></p>
                  <div class="mb-2">
                    <a href="#" class="text-light text-decoration-none"><i class="bi bi-instagram"></i> Instagram</a>
                  </div>
                  <div class="mb-2">
                    <a href="#" class="text-light text-decoration-none"><i class="bi bi-twitter"></i> Twitter</a>
                  </div>
                  <div class="mb-2">
                    <a href="https://github.com/Santi0920/Coopserp" class="text-light text-decoration-none">Github</a>
                  </div>
                </div>
                <p class="text-center text-white mt-4">Coopserp Web &copy; 2024 Diseñado y Desarrollado por <a class="text-warning text-decoration-none fw-semibold" target="_blank" href="https://github.com/Santi0920">Santiago Henao</a></p>
              </div>
            </div>
          </footer>
      <script src="ResourcesAll/Bootstrap/bootstrap.js"></script>
    </body>
    </html>