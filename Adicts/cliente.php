<?php
require_once("librerias/utilerias.php");
require_once("seguridadCliente.php");

$username = obtenDatos('username');
$error = obtenDatos('error');


if(!empty($_SESSION['cliente'])){ 
$cliente = $_SESSION['cliente'];
}

if(!empty($_SESSION['username'])){ 
$username = $_SESSION['username'];
}
//die(var_dump($username));

require_once("modelos/clienteModelo.php");
$cliente = obtenDetallesCliente($username);
$compras = obtenCompras($username);
$consulta = "&username=$username&error=$error";


require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuCliente("cliente.php");

?>

      <?php
        if(isset($error) && $error!=""){
          echo "
          <div class='row'>
            <div class='col-md-12 form-group'>  
              <div class='alert alert-danger' role='alert'>
                    $error
                  </div>
            </div>
          </div>";

        }
      ?>

    <section class="page-section cta" align="center" style="">
      <div class="container">
        <div class="row" >
          <div class="col-xl-12 mx-auto">
            <div class="cta-inner text-center rounded">
<!------>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Producto</th>
      <th>Imagen</th>
      <th scope="col">Cantidad</th>
      <th scope="col">Total</th>
      <th scope="col">Fecha</th>
    </tr>
  </thead>
  <tbody>
  <?php
      foreach ($compras as $compra){
        echo "
          <tr>
            <td>{$compra['producto']}</td>
             <td><img src='{$compra['urlImagen']}' width='150'></td>
            <td>{$compra['cantidad']}</td>
            <td>{$compra['total']}</td>
            <td>{$compra['fecha']}</td>
          </tr>";
    }
  ?>
    
  </tbody>
</table>
</div>
<!------>
            </div>
           </div>
          </div>
        </div>
       </div>
      </section>

<?php
require_once("vistas/piePagina.php");
?>