<?php
require_once("librerias/utilerias.php");

$username = obtenDatos('username');

require_once("modelos/clienteModelo.php");
$cliente = obtenDetallesCliente($username);

require_once("modelos/ciudadModelo.php");
$ciudades = obtenCiudades();

require_once("modelos/estadosModelo.php");
$estados = obtenEstados();

$colDireccion = obtenDatos('colDireccion');
$calleDireccion = obtenDatos('calleDireccion');
$nintDireccion = obtenDatos('nintDireccion');
$nextDireccion = obtenDatos('nextDireccion');
$cpDireccion = obtenDatos('cpDireccion');
$estado = obtenDatos('estado');
$ciudad = obtenDatos('ciudad');
$error = obtenDatos('error');


require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuGeneral("register.php");
?>

   <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="./index.php"><i class="fa fa-home"></i>Inicio</a>
                        <span>Registrar direccion</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Form Section Begin -->

    <!-- Register Section Begin -->
    <form action="./agregarDireccion.php" method="post" class="needs-validation" novalidate>
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="register-form">
                         <form class="contact100-form validate-form">
                         	<h2 style="color: black;">¡Estas por terminar tu registro!</h2>
                         	<br>
                            <h2>Ingresa datos de tu direccion</h2>
                               <form action="./agregarDireccion.php" method="post" class="needs-validation" novalidate>
                            <input type="hidden" name="idCliente" value="<?php echo $cliente['idCliente']; ?>">
                            <div class="group-input">
                                <label class="label-input" for="colDireccion">Colonia *</label>
                                <input type="text" name="colDireccion" id="colDireccion" placeholder="Escribe tu direccion" class="form-control" maxlength="30" value="<?php echo (isset($colDireccion) ? $colDireccion : ""); ?>" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div> 
                            <div class="group-input">
                                <label class="label-input" for="calleDireccion">Calle *</label>
                                <input type="text" name="calleDireccion" id="calleDireccion" placeholder="Escribe tu calle" class="form-control" maxlength="30" value="<?php echo (isset($calleDireccion) ? $calleDireccion : ""); ?>" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div>
                            <div class="group-input">
                                <label class="label-input" for="nintDireccion">Número interior *</label>
                                <input type="text" name="nintDireccion" id="nintDireccion" placeholder="Escribe tu número interior" class="form-control" maxlength="30" value="<?php echo (isset($nintDireccion) ? $nintDireccion : ""); ?>" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div>
                            <div class="group-input">
                                <label class="label-input" for="nextDireccion">Número Exterior *</label>
                                <input type="text" name="nextDireccion" id="nextDireccion" placeholder="Escribe tu número exterior" class="form-control" maxlength="30" value="<?php echo (isset($nextDireccion) ? $nextDireccion : ""); ?>" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div>
                            <div class="group-input">
                                <label class="label-input" for="cpDireccion">cp *</label>
                                <input type="text" name="cpDireccion" id="cpDireccion" placeholder="Escribe tu CP" class="form-control" maxlength="30" value="<?php echo (isset($cpDireccion) ? $cpDireccion : ""); ?>" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div>
                            <div class="group-input">
                                <label class="label-input" for="estado">Estado *</label>
                                <select name="estado" class="form-control" required="required">
							         <option value="">Seleccione un Estado</option>
							        <?php foreach ($estados as $estadoLeido) {
									         echo "
									         <option value='{$estadoLeido['idEstado']}' ".(($estadoLeido['idEstado'] == $estado)?"selected":"").">{$estadoLeido['nombreEstado']}</option>";            }

							        ?>
						        </select>
						        <div class="invalid-feedback">
					                 El campo es requerido.
					            </div>
                            </div>
                            <br>
                            <br>
                            <button type="submit" class="site-btn register-btn">REGISTRAR</button>
                        </form>
                        <div class="switch-login">
                            <a href="./iniciarSesionCliente.php" class="or-login">O iniciar sesión</a>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
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
    </div>
    <!-- Register Form Section End -->

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
    
<?php
require_once("vistas/piePagina.php");
?>