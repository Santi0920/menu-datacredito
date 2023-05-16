<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datacrédito</title>
    <link href="ResourcesAll/Bootstrap/Bootstrap.css" rel="stylesheet">
    <link type="text/css" href="css/datacredito.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/logoo.png" type="image/png">
    <script src="ResourcesAll/jquery/jquery-3.6.0.js"></script>
    <script src="ResourcesAll/jquery/jquery-ui.js"></script>
    <link rel="stylesheet" href="css/Bootstrap/jquery-1.13.css">
    <script src="ResourcesAll/fontawesome/fontawesome.js"></script>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <script src="ResourcesAll/Sweetalert/sweetalert2.js"></script>
    <link rel="stylesheet" href="ResourcesAll/Sweetalert/sweetalert2.css">
    <link rel="stylesheet" href="ResourcesAll/Bootstrap/Bootstrap2.css">
    <link rel="stylesheet" href="ResourcesAll/Bootstrap/dataTablesbootstrap5.css">
    <style>@media print {@page {size: landscape;}}</style>
  </head>
  
  
  <body>

    <!-- HEADER DEL CONTACTO-->
      <header class="container-fluid d-flex justify-content-center top-fixed text-white" style="background-color: #005E56;">
        <p class="mb-0 p-2 fs-6">Contáctame 321-871-2282</p>
      </header>
      
      <!-- NAV DE LISTA-->
      <a name="arriba"></a>
      <nav class="navbar navbar-expand-lg bg-body-secondary p-0" id="Menu">
        <div class="container-fluid">
          <!-- Coopserp.com-->
          
          <!-- Botón que aparece al reducir pantalla--> 
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
          </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Foto Coopserp--> 
        <img src="img/CoopserpPH.png" alt="Coopserp.icono" width="150px" height="60px" id="data" class="navbar-brand mb-2 mt-2">
          
        
        <ul class="navbar-nav me-auto mb-lg-0 header">        
            <!-- DataCreditos-->       
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active text-primary text-opacity-50" href="#" id="data" role="button" data-bs-toggle="dropdown" aria-expanded="false">Datacredito</a>
                <ul class="dropdown-menu" aria-labelledby="data">
                    <li><a class="dropdown-item" href="#p">Datacredito Asociación</a></li>
                    <li><a class="dropdown-item" href="#">Datacredito Crédito</a></li>
                    <li><a class="dropdown-item" href="#">Datacredito Proveedores</a></li>
                </ul>
          </li>
            <!-- Anticipados-->  
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#" id="data" >Anticipos</a>
            </li>
            <!-- Cuentas H-->  
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#" id="data">Cuentas H</a>
            </li>
             <!-- Cartera Castigada-->  
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#" id="data">Cartera Castigada</a>
            </li>
            <!-- Fondo de Garantia-->
            <li class="nav-item" >
              <a class="nav-link active" aria-current="page" href="#" id="data">Fondo de Garantía</a>
            </li>
          </ul>
          
          <span class="mx-4" style="font-size: 25px;"><img style="height: 2.5rem" class="mx-3" src="img/perfil.png">Bienvenid@ <strong>{{ auth()->user()->name }}</strong></span>
          <a onclick="return csesion()" href="{{route('login.destroy')}}"><button class="btn btn-outline-success"><b style="font-size: 18px;">Cerrar Sesión</b></button></a>

         
        </div>
      </div>
    </nav>

    <div class="">
        @yield('content')
    </div>
         
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
                    <a href="#arriba" class="text-light text-decoration-none">Datacrédito</a>
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
                    <a href="https://github.com/Santi0920/Coopserp" class="text-light text-decoration-none">Github</a>
                  </div>
                </div>
                <p class="text-center text-white mt-4">Coopserp Web &copy; 2023 Diseñado y Desarrollado por <a class="text-warning text-decoration-none fw-semibold" href="https://github.com/Santi0920">Santiago Henao</a></p>
              </div>
            </div>
          </footer>
      <script src="ResourcesAll/Bootstrap/bootstrap.js"></script>
    </body>
    </html>