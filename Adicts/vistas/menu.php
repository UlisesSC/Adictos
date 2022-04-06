<?php

  function menuGeneral($pagina="index.php"){
        $menu = "
        <!-- Navigation -->
        <nav class='navbar navbar-expand-lg navbar-dark bg-dark fixed-top'>
          <div class='container'>
            <a class='navbar-brand' href='./index.php'>ADICTS</a>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarResponsive' aria-controls='navbarResponsive' aria-expanded='false' aria-label='Toggle navigation'>
              <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarResponsive'>
              <ul class='navbar-nav ml-auto'>
                <li class='nav-item ".(($pagina == "index.php")?"active":"")."'>
                  <a class='nav-link' href='./index.php'>Inicio</a>
                </li>
                <li class='nav-item ".(($pagina == "productos.php")?"active":"")."'>
                  <a class='nav-link' href='./productos.php'>Catálogo
                    <span class='sr-only'>(current)</span>
                  </a>
                </li>
                <li class='nav-item ".(($pagina == "sucursales.php")?"active":"")."'>
                  <a class='nav-link' href='./quienessomos.php'>¿Quiénes somos?</a>
                </li>
                <li class='nav-item ".(($pagina == "contactanos.php")?"active":"")."'>
                  <a class='nav-link' href='./formulario.php'>Sucursales</a>
                </li>
                <li class='nav-item ".(($pagina == "IniciarSesionCliente.php")?"active":"")."'>
                  <a class='nav-link' href='./IniciarSesionCliente.php'>Iniciar sesión</a>
                </li>
                <li class='nav-item ".(($pagina == "carrito.php")?"active":"")."'>
                  <a class='nav-link' href='./carrito.php'>
                  <svg width='1.2em' height='1.2em' viewBox='0 0 16 16' class='bi bi-cart-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                    <path fill-rule='evenodd' d='M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z'/>
                  </svg>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>";

        return $menu;
  }

  function menuAdministracion($pagina="usuario.php"){
        $menu = "
        <!-- Navigation -->
        <nav class='navbar navbar-expand-lg navbar-dark bg-dark fixed-top'>
          <div class='container'>
            <a class='navbar-brand' href='./index.php'>ADICTS</a>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarResponsive' aria-controls='navbarResponsive' aria-expanded='false' aria-label='Toggle navigation'>
              <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarResponsive'>
              <ul class='navbar-nav ml-auto'>
                <li class='nav-item ".(($pagina == "usuario.php")?"active":"")."'>
                  <a class='nav-link' href='./usuario.php'>Usuarios</a>
                </li>
                <li class='nav-item ".(($pagina == "modulo.php")?"active":"")."'>
                  <a class='nav-link' href='./productosPorTerminar.php'>Productos por terminar</a>
                </li>
                <li class='nav-item ".(($pagina == "modulo.php")?"active":"")."'>
                  <a class='nav-link' href='./productosNoVendidos.php'>Productos no vendidos</a>
                </li>
                <li class='nav-item ".(($pagina == "modulo.php")?"active":"")."'>
                  <a class='nav-link' href='./reporteVentas.php'>Reporte de ventas</a>
                </li>
                <li class='nav-item ".(($pagina == "modulo.php")?"active":"")."'>
                  <a class='nav-link' href='./modulo.php'>Módulos</a>
                </li>
                <li class='nav-item ".(($pagina == "adminProductos.php")?"active":"")."'>
                  <a class='nav-link' href='./adminProductos.php'>Productos
                    <span class='sr-only'>(current)</span>
                  </a>
                </li>
                <li class='nav-item ".(($pagina == "salir.php")?"active":"")."'>
                  <a class='nav-link' href='./salir.php'>Salir</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>";

        return $menu;
  }
  function menuCliente($pagina="cliente.php"){
        $menu = "
        <!-- Navigation -->
        <nav class='navbar navbar-expand-lg navbar-dark bg-dark fixed-top'>
          <div class='container'>
            <a class='navbar-brand' href='./index.php'>Printer Capital</a>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarResponsive' aria-controls='navbarResponsive' aria-expanded='false' aria-label='Toggle navigation'>
              <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarResponsive'>
              <ul class='navbar-nav ml-auto'>
                
                
                <li class='nav-item ".(($pagina == "productos.php")?"active":"")."'>
                  <a class='nav-link' href='./productos.php'>Cátalogo
                    <span class='sr-only'>(current)</span>
                  </a>
                </li>
                <li class='nav-item ".(($pagina == "salirCliente.php")?"active":"")."'>
                  <a class='nav-link' href='./salirCliente.php'>Salir</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>";

        return $menu;
  }


 function menuClientes($pagina="cliente.php"){
        $menu = "
        <!-- Navigation -->
        <nav class='navbar navbar-expand-lg navbar-dark bg-dark fixed-top'>
          <div class='container'>
            <a class='navbar-brand' href='./index.php'>Printer Capital</a>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarResponsive' aria-controls='navbarResponsive' aria-expanded='false' aria-label='Toggle navigation'>
              <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarResponsive'>
              <ul class='navbar-nav ml-auto'>
               
                <li class='nav-item ".(($pagina == "adminProductos.php")?"active":"")."'>
                  <a class='nav-link' href='./productos.php'>Productos
                    <span class='sr-only'>(current)</span>
                  </a>
                </li>
                <li class='nav-item ".(($pagina == "salirCliente.php")?"active":"")."'>
                  <a class='nav-link' href='./salirCliente.php'>Salir</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>";

        return $menu;
  }

  ?>

  
