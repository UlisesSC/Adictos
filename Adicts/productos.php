<?php
require_once("librerias/utilerias.php");
require_once("vistas/encabezado.php");
require_once("vistas/menu.php");

echo menuGeneral("productos.php");

$categoria = obtenDatos('categoria');
$nombre = obtenDatos('nombre');
$descripcion = obtenDatos('descripcion');
$stock = obtenDatos('stock');
$registroActual = obtenDatos('registroActual');
$numeroRegistrosPorPagina = obtenDatos('numeroRegistrosPorPagina');

if(!is_numeric($registroActual))
      $registroActual=0;
if(!is_numeric($numeroRegistrosPorPagina))
      $numeroRegistrosPorPagina = 6;

require_once("modelos/productoModelo.php");
$productos = obtenProductos($nombre,$descripcion,$categoria,$stock,$registroActual,$numeroRegistrosPorPagina);
$total = obtenProductos($nombre,$descripcion,$categoria,$stock,$registroActual,$numeroRegistrosPorPagina,TRUE);
$consulta = "&nombre=$nombre&descripcion=$descripcion&categoria=$categoria&stock=$stock";
//die(print_r($productos));

$linksPaginas = paginacion("./productos.php",$registroActual,$numeroRegistrosPorPagina,$consulta,$total);
?>


  <!-- Page Content -->
<div class="container">

  <!-- Page Heading -->
  <h1 class="my-4">Productos
    <?php 
      if(!empty($categoria) && $categoria>0){
        require_once("modelos/categoriaModelo.php");
        $nombreCategoria = obtenNombreCategoria($categoria);
        echo "<small>$nombreCategoria</small>";
      }
    ?>
  </h1>

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
                      <button class='btn btn-dark form-control' onclick=\"agregarCarrito('{$producto['id']}')\">Agregar al carrito</button>
                    </div>
                  </div>
                </div>";
      }
    }
    ?>
  </div>
  <!-- /.row -->

  <!-- Pagination -->
  <?php echo $linksPaginas; ?>


</div>
<!-- /.container -->

    <script type="text/javascript">
      function agregarCarrito(idProducto=""){
        
        var peticion = new XMLHttpRequest();
        peticion.onreadystatechange = function() {
          // Cuando finalice la petición y la respuesta se OK
        if (this.readyState == 4 && this.status == 200) {
            var objeto = JSON.parse(this.responseText);
            var resultado = objeto.resultado;
            var mensaje = objeto.mensaje;
            var numeroProductos = objeto.numeroProductos;
            if(resultado == false){
              enviarAlerta("Error",mensaje,true);
            }
            else{
              //document.getElementById('numeroProductosCarrito').innerHTML = numeroProductos;
              enviarAlerta("OK",mensaje,false);
            }
          }
        };
        peticion.open("GET", "actualizaCarrito.php?idProducto="+idProducto, true);
        peticion.send();
      }
      
    </script>

<?php
require_once("vistas/piePagina.php");
?>


