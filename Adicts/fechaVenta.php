<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Usuario","consultas");

$fecha = obtenDatos("fecha");
$error = obtenDatos('error');

require_once("modelos/ProcedimientosAlmacenados.php");
$ventas = obtenVentasFecha($fecha);

require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuAdministracion("usuario.php");
?>

  

     <div class="container">
      <div class="login-form">
        <div class="row">
          <div class="col-lg-12">
                       <br>
                 <h2>Venta por fecha</h2>
              </div>
          </div>

      <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
              <tr>
                <th>ID de venta</th>
                <th>Nombre</th>
                <th>Apellido paterno</th>
                <th>Apellido materno</th>
              </tr>
            </thead>
            <tbody>
        <?php
        foreach ($ventas as $leido){
          echo "
              <tr>
                <td>{$leido['idVenta']}</td>
                <td>{$leido['nombre']}</td>
                <td>{$leido['apellidoPaterno']}</td>
                <td>{$leido['apellidoMaterno']}</td>
              </tr>";
        }
        ?>
          </tbody>
        </table>
      </div>
    </div>
      <?php
        if(isset($error) && $error!=""){
          echo "
          <div class='row'>
            <div class='col-md-4'></div>
            <div class='col-md-12 form-group'>  
              <div class='alert alert-danger' role='alert'>
                    $error
                  </div>
            </div>
            <div class='col-md-4'></div>
          </div>";

        }
      ?>

    <!-- Pagination -->
        </div>
        </div>
      </div>
    </section>
    
    <!-- container -->


<?php
require_once("vistas/piePagina.php");
?>