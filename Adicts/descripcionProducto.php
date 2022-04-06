<?php
require_once("librerias/utilerias.php");
require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuGeneral("productos.php");

require_once("modelos/categoriaModelo.php");
$categorias = obtenCategorias();

$id = obtenDatos('id');
require_once("modelos/productoModelo.php");
$producto = detallesProducto($id);

if(!is_array($producto)){
  require_once("vistas/encabezado.php");
  require_once("vistas/menu.php");
  echo menuAdministracion("productos.php");
  echo muestraError($producto);
  require_once("vistas/piePagina.php");
  return;
}

?>



  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">
        <h1 class="my-4">Printer Capital</h1>
        <div class="list-group">
          <?php
            foreach ($categorias as $categoria) {
              echo "
              <a href='./productos.php?categoria={$categoria['idCategoria']}' class='list-group-item'>{$categoria['nombre']}</a>";
            }
          ?>
        </div>
      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">

        <div class="card mt-4">
          <img class="card-img-top img-fluid" src="<?php echo $producto['urlImagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
          <div class="card-body">
            <h3 class="card-title"><?php echo $producto['nombre']; ?></h3>
            <h4>$<?php echo number_format($producto['precio'],2); ?></h4>
            <p class="card-text"><?php echo $producto['descripcion']; ?></p>
            <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
            4.0 stars
          </div>
        </div>
        <!-- /.card -->

        <div class="card card-outline-secondary my-4">
          <div class="card-header">
            Product Reviews
          </div>
          <div class="card-body">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
            <small class="text-muted">Posted by Anonymous on 3/1/17</small>
            <hr>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
            <small class="text-muted">Posted by Anonymous on 3/1/17</small>
            <hr>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
            <small class="text-muted">Posted by Anonymous on 3/1/17</small>
            <hr>
            <a href="#" class="btn btn-success">Leave a Review</a>
          </div>
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col-lg-9 -->

    </div>

  </div>
  <!-- /.container -->

<?php
require_once("vistas/piePagina.php");
?>