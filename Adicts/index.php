<?php 
require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuGeneral("index.php");

require_once("modelos/categoriaModelo.php");
$categorias = obtenCategorias();

require_once("modelos/productoModelo.php");
$productos = obtenProductos("","","",0,6);
?>
<body>
<link rel="stylesheet" href="css/whatsapp.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<a href="https://api.whatsapp.com/send?phone=+525550127999&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20Printer%20Capital%20." class="float" target="_blank">
<i class="fa fa-whatsapp my-float"></i>
</a>
</body>
  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">
      	<br>
      	<br>

        <img class="card-img-top" src="./imagenes/index/adicts.jpg" alt="">
        <br>
        <br>
        <br>
        <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action bg-danger" style="color:#ffffff" aria-current="true">
                                        ¿Qué estas buscando?
                                    </a>
          <a href="./productos.php?categoria=1" class="list-group-item">Laptops</a>
          <a href="./productos.php?categoria=2" class="list-group-item">Impresoras</a>
          <a href="./productos.php?categoria=3" class="list-group-item">Consumibles</a>
          <a href="./productos.php?categoria=4" class="list-group-item">IoT</a>
          <a href="./productos.php?categoria=5" class="list-group-item">Computadoras de escritorio</a>
        </div>

      </div>
      <!-- /.col-lg-3 -->

</a>

      <div class="col-lg-9">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
          </ol>
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid" src="./imagenes/index/12.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="./imagenes/index/13.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="./imagenes/index/17.jpg" alt="Third slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="./imagenes/index/14.jpg" alt="fifth slide">
            </div>
          <div class="carousel-item">
              <img class="d-block img-fluid" src="./imagenes/index/18.jpg" alt="fourth slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

          <div class="row">
            <?php
            if($productos != null){
                foreach ($productos as $producto) {
                        echo "
                          <div class='col-lg-4 col-md-6 mb-4'>
                            <div class='card h-100'>
                              <a href='#'><img class='card-img-top' src='{$producto['urlImagen']}' alt='{$producto['nombre']}'></a>
                              <div class='card-body'>
                                <h4 class='card-title'>
                                  <a href='./descripcionProducto.php?id={$producto['id']}'>{$producto['nombre']}</a>
                                </h4>
                                <h5 class='card-title'>
                                  <a href='#'>{$producto['nombreCategoria']}</a>
                                </h5>
                                <h5>$".number_format($producto['precio'],2)."</h5>
                                <p class='card-text'>".substr($producto['descripcion'],0,255)."...</p>
                              </div>
                              <div class='card-footer'>
                                <small class='text-muted'>&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                              </div>
                            </div>
                          </div>";
                }
            }
            ?>
        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
<?php
require_once("vistas/piePagina.php");
?>