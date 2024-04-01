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
              <li class="text-center"><a class="text-center text-white dropdown-item fw-semibold " style="font-size: 25px" href="jefaturaproveedor">Proveedores y Terceros</a></li>
              <li class="text-center"><a class="text-center text-white dropdown-item fw-semibold " style="font-size: 25px" href="consultarproveedor">Consultar Proveedores y Terceros</a></li>
            </ul>
        </ul>
      </div>

    </ul>
    
    <span class="mx-4 text-white" style="font-size: 25px;"><img style="height: 2.5rem" class="mx-1" src="img/perfil.png">Bienvenid@ <strong>{{ auth()->user()->name }}</strong></span>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
      <symbol id="circle-half" viewBox="0 0 16 16" class="text-white">
        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
      </symbol>

      <symbol id="moon-stars-fill" viewBox="0 0 16 16" class="text-white">
        <path
          d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"
        />
        <path
          d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"
        />
      </symbol>

      <symbol id="sun-fill" viewBox="0 0 16 16" class="text-white">
        <path
          d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"
        />
      </symbol>
    </svg>
    <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

          <ul class="navbar-nav mb-lg-0 me-2">
            <li class="nav-item dropdown w-25" data-bs-theme="light">
              <button
                class="btn btn-link nav-link py-1 px-0 px-lg-2 dropdown-toggle d-flex align-items-center text-white"
                id="bd-theme"
                type="button"
                aria-expanded="false"
                data-bs-toggle="dropdown"
                data-bs-display="static"
                
              >
                <svg
                  class="bi my-1 theme-icon-active"
                  width="16"
                  height="16"
                  fill="currentColor"
                >
                  <use href="#circle-half"></use>
                </svg>
                <span class="d-lg-none ms-2">Toggle theme</span>
              </button>

              <ul
                class="dropdown-menu dropdown-menu-end px-1" style="background-color: #005E56;"
                aria-labelledby="bd-theme"
              >
                <li>
                  <button
                    type="button"
                    class="dropdown-item d-flex align-items-center text-white fw-bold"
                    data-bs-theme-value="light"
                  >
                    <svg
                      class="bi me-2 opacity-50 theme-icon"
                      width="16"
                      height="16"
                      fill="currentColor"
                    >
                      <use href="#sun-fill"></use>
                    </svg>
                    Claro
                  </button>
                </li>
                <li>
                  <button
                    type="button"
                    class="dropdown-item d-flex align-items-center text-white fw-bold"
                    data-bs-theme-value="dark"
                  >
                    <svg
                      class="bi me-2 opacity-50 theme-icon"
                      width="16"
                      height="16"
                      fill="currentColor"
                    >
                      <use href="#moon-stars-fill"></use>
                    </svg>
                    Oscuro
                  </button>
                </li>
                <li>
                  <button
                    type="button"
                    class="dropdown-item d-flex align-items-center active text-white fw-bold"
                    data-bs-theme-value="auto"
                  >
                    <svg
                      class="bi me-2 opacity-50 theme-icon"
                      width="16"
                      height="16"
                      fill="currentColor"
                    >
                      <use href="#circle-half"></use>
                    </svg>
                    Automatico
                  </button>
                </li>
              </ul>
            </li>
          </ul>
    </button>
    <a onclick="return csesion()" href="{{route('login.destroy')}}"><button class="btn btn-light"><b style="font-size: 25px;">Cerrar Sesión</b></button></a>

   
  </div>
</div>
</nav>