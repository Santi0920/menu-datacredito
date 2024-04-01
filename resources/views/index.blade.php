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
    <div class="container-fluid"  style="background-color: #005E56;">
      <!-- Coopserp.com-->
      
      <!-- Botón que aparece al reducir pantalla--> 
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
      </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Foto Coopserp--> 
    <a class="navbar-brand" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"><img src="img/CoopserpPH.png" alt="Coopserp.icono" width="150px" height="60px" id="data" class="navbar-brand mb-2 mt-2" style="filter: drop-shadow(0 2px 0.8px white);"></a>
      <ul class="navbar-nav me-auto mb-lg-0">        
       
      </ul>
      <a href="{{route('login.index')}}"><button class="btn btn-light"><b style="font-size: 25px;">Iniciar Sesión</b></button></a>
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

<!-- Introducción -->
<section class="w-50 mx-auto text-center pt-2" id="intro">
        <p class="p-2 fs-4"><b class="text-success">Coopserp Web </b> es una página que tiene como propósito gestionar sectores de la <b class="text-success">empresa</b>.</p>
      </section>
     <!-- SLIDER IMAGENES-->
      <div id="carouselExampleIndicators" class="carousel carousel-dark slide mt-2" data-bs-ride="true">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" class="active" aria-current="true" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" class="active" aria-current="true" aria-label="Slide 3"></button> 
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" class="active" aria-current="true" aria-label="Slide 4"></button>      
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active" data-bs-interval="4000">
            <img src="img/fondo-datacredito.jpg" class="d-block w-100" alt="CreditoSalud">
          </div>
          
          <div class="carousel-item" data-bs-interval="4000">
            <img src="img/foto1.jpg" class="d-block w-100" alt="CreditoVehiculo">
          </div>

          <div class="carousel-item" data-bs-interval="4000">
            <img src="img/foto3.jpg" class="d-block w-100" alt="CreditoEducacion">
          <div class="carousel-content">
            <p>Crédito de Educación</p>
          </div>
          </div>

          <div class="carousel-item" data-bs-interval="4000">
            <img src="img/foto4.jpg" class="d-block w-100" alt="CreditoVivienda">
            <div class="carousel-content">
            <p>Crédito de Vivienda</p>
          </div>
          </div>

          
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next " type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
<!-- Servicios que ofrece la pagina -->
<section class="container-fluid">
        <h1 class=" mt-2 p-3 fs-2 text-center"><b>Nuestros Servicios Principales</b></h1>
        <style>
        .click-transform {
              transition: transform 0.3s ease;
        }

        .click-transform:hover {
              transform: scale(0.8);
        }
        </style>
        <div class="row w-75 mx-auto servicio-fila">
          <div class="col-lg-6 col-md-12 col-sm-12 my-5 icono-wrap text-center">
            <img style="" src="img/adquisitivo.png" class="rounded img-fluid click-transform" alt="Datacrédito" width="190" height="210" >
            <a href="#" class="text-decoration-none">
            <h2 class="fs-4 mt-4 px-4 pb-1 text-dark text-center  fw-bold">Datacrédito</h2></a>
            <p class="px-4 fs-5">Se encarga de almacenar y suministrar información sobre el comportamiento financiero de las <span class="text-success">personas</span> y las <span class="text-success">empresas</span>.</p>
          </div>
          <div class="col-lg-6 col-md-12 col-sm-12 my-5 icono-wrap text-center">
           
            <img src="img/anticipo.png" class="rounded img-fluid click-transform" alt="Anticipos" width="188">
            <a href="#" class="text-decoration-none">
            <h2 class="fs-4 mt-4 px-4 pb-1 text-dark text-center fw-bold">Aprobación de Créditos</h2></a>
            <p class="px-4 fs-5">Se encarga de <span class="text-success">aprobar</span> o <span class="text-danger">rechazar</span> los créditos según la fecha de reporte de las nominas.</p>
            <!-- <p class="px-4 fs-5">Se refiere a un pago que se realiza por adelantado para recibir un <span class="text-success">bien</span> o <span class="text-success">servicio</span>.</p> -->
          </div>
        </div>

        <div class="row w-75 mx-auto servicio-fila d-none">
          <div class="col-lg-6 col-md-12 col-sm-12 my-5 icono-wrap text-center">
            <img src="img/letter-h.png" class="rounded img-fluid click-transform" alt="Cuentas H" width="200" >
            <a href="#" class="text-decoration-none">
            <h2 class="fs-4 mt-4 px-4 pb-1 text-dark text-center">Cuentas H</h2></a>
            <p class="px-4 fs-5 text-left">Son aquellas cuentas de asociados que no generan descuento de aportes durante <span class="text-success">6 meses continuos</span>.</p>
          </div>
          <div class="col-lg-6 col-md-12 col-sm-12 my-5 icono-wrap text-center">
            <img src="img/revisar.png" class="rounded img-fluid click-transform" alt="CarteraCastigada" width="196" >
            <a href="#" class="text-decoration-none">
            <h2 class="fs-4 mt-4 px-4 pb-1 text-dark text-center">Cartera Castigada</h2></a>
            <p class="px-4 fs-5 text-left">Son préstamos o créditos concedidos que no están siendo pagados de manera regular y han sido considerados como <span class="text-success">irrecuperables</span>.</p>
          </div>

          <div class="col-lg-6 col-md-12 col-sm-12 my-5 icono-wrap text-center" id="centrar">
            <img src="img/garantia.png" class="rounded img-fluid click-transform" alt="FondoGarantia" width="200" >
            <a href="#" class="text-decoration-none">
            <h2 class="fs-4 mt-4 px-4 pb-1 text-dark text-center">Cartera Castigada</h2></a>
            <p class="px-4 fs-5 text-left">Es un mecanismo de protección que se utiliza para cubrir las <span class="text-success">obligaciones</span>.</p>
          </div>

          
        </div>
      </section>

      <!-- Pie de pagina -->
      <footer>
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
                <a href="./datacredito.php" class="text-light text-decoration-none">Datacrédito</a>
              </div>
              <div class="mb-2">
                <a href="./anticipos.php" class="text-light text-decoration-none">Anticipos</a>
              </div>
              <div class="mb-2">
                <a href="./cuentash.php" class="text-light text-decoration-none">Cuentas H</a>
              </div>
              <div class="mb-2">
                <a href="./carteracastigada.php" class="text-light text-decoration-none">Cartera Castigada</a>
              </div>
              <div class="mb-2">
                <a href="./fgarantia.php" class="text-light text-decoration-none">Fondo de Garantía</a>
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
                <a href="https://github.com/Santi0920/Coopserp" class="text-light text-decoration-none">Github </a>
              </div>
            </div>
            <p class="text-center text-white mt-4">Coopserp Web &copy; 2023 Diseñado y Desarrollado por <a class="text-warning text-decoration-none fw-semibold" href="https://github.com/Santi0920">Santiago Henao</a></p>
          </div>
        </div>
      </footer>


      <script src="ResourcesAll/Bootstrap/bootstrap.js"></script>
</body>
</html>
