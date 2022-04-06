<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Usuario","consultas");

$cate = obtenDatos("cate");
$error = obtenDatos('error');

require_once("modelos/ProcedimientosAlmacenados.php");
$categorias = obtenProductos($cate);

require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuAdministracion("usuario.php");
?>
     <div class="container">
      <div class="login-form">
        <div class="row">
          <div class="col-lg-12">
                       <br>
                 <h2>Productos por categoria</h2>
              </div>
          </div>

      <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
              <tr>
                <th>Descripcion</th>
              </tr>
            </thead>
            <tbody>
        <?php
        foreach ($categorias as $leido){
          echo "
              <tr>
                <td>{$leido['descripcion']}</td>
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
