<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Usuario","consultas");

$fecha = obtenDatos('fecha');
$error = obtenDatos('error');

require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuAdministracion("usuario.php");

?>
    
    <div class="container">
      <div class="login-form">
        <div class="row">
          <div class="col-lg-12">
                       <br>
                 <h2>Ventas</h2>
              </div>
          </div>

      <form action="./fechaVenta.php" method="post" class="needs-validation" novalidate>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-12 form-group" align="left" style="">
            <label for="fecha">Fecha</label>
            <input type="text" name="fecha" id="fecha" placeholder="Escribe la fecha de la venta" class="form-control" maxlength="30" value="<?php echo (isset($fecha) ? $fecha : ""); ?>" required="required" >
            <div class="invalid-feedback">
                  El campo es requerido.
                </div>
          </div>
          <div class="col-md-4"></div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-12 form-group" align="center">
            <label>&nbsp;</label>
            <input type="submit" value="Buscar" class="form-control">
          </div>      
                    <div class="col-md-12"></div>
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
      </form>
    </div>
    <!-- container -->

    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            /*
        password1 = document.getElementById('password1').value;
            password2 = document.getElementById('password2').value;
            
            if(password1 !== password2){
              event.preventDefault();
                event.stopPropagation();
                alert("Las contraseñas no coinciden");
            }
            else 
              */
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
    </script>

           
          </div>
        </div>
      </div>
    </section>


<?php
require_once("vistas/piePagina.php");
?>
