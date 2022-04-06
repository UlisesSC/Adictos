<?php
require_once("librerias/utilerias.php");

//die(print_r($_POST)." ".print_r($_FILES));
$nombre = obtenDatos('nombre');
$apellidoPaterno = obtenDatos('apellidoPaterno');
$apellidoMaterno = obtenDatos('apellidoMaterno');
$telCliente = obtenDatos('telCliente');
$rfcCliente = obtenDatos('rfcCliente');
$email = obtenDatos('email');
$username = obtenDatos('username');
$error = obtenDatos('error');

require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuGeneral("register.php");
?>

    <!-- Register Section Begin -->
    <form action="./agregarCliente.php" method="post" class="needs-validation" novalidate>
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="register-form">
                         <form class="contact100-form validate-form">
                            <h2>Registrar</h2>
                               <form action="./agregarCliente.php" method="post" class="needs-validation" novalidate>
                            <div class="group-input">
                                <label class="label-input" for="nombre">Nombre del cliente *</label>
                                <input type="text" name="nombre" id="nombre" placeholder="Escribe tu nombre" class="form-control" maxlength="30" value="<?php echo (isset($nombre) ? $nombre : ""); ?>" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div> 
                            <div class="group-input">
                                <label class="label-input" for="apellidoPaterno">Primer apellido *</label>
                                <input type="text" name="apellidoPaterno" id="apellidoPaterno" placeholder="Escribe primer apellido" class="form-control" maxlength="30" value="<?php echo (isset($apellidoPaterno) ? $apellidoPaterno : ""); ?>" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div>
                            <div class="group-input">
                                <label class="label-input" for="apellidoMaterno">Segundo apellido *</label>
                                <input type="text" name="apellidoMaterno" id="apellidoMaterno" placeholder="Escribe tu segundo apellido" class="form-control" maxlength="30" value="<?php echo (isset($apellidoMaterno) ? $apellidoMaterno : ""); ?>" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div>
                            <div class="group-input">
                                <label class="label-input" for="telCliente">Telefono *</label>
                                <input type="text" name="telCliente" id="telCliente" placeholder="Escribe tu telefono" class="form-control" maxlength="30" value="<?php echo (isset($telCliente) ? $telCliente : ""); ?>" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div>
                            <div class="group-input">
                                <label class="label-input" for="rfcCliente">RFC *</label>
                                <input type="text" name="rfcCliente" id="rfcCliente" placeholder="Escribe tu RFC" class="form-control" maxlength="30" value="<?php echo (isset($rfcCliente) ? $rfcCliente : ""); ?>" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div>
                            <div class="group-input">
                                <label class="label-input" for="email">Correo electronico *</label>
                                <input type="text" name="email" id="email" placeholder="Escribe tu correo electrónico" class="form-control" maxlength="30" value="<?php echo (isset($email) ? $email : ""); ?>" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div>
                            <div class="group-input">
                                <label class="label-input" for="username">Nombre de usuario *</label>
                                <input type="text" name="username" id="username" placeholder="Escribe tu nombre de usuario" class="form-control" maxlength="30" value="<?php echo (isset($username) ? $username : ""); ?>" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div>
                            <div class="group-input">
                                <label class="label-input" for="password1">Contraseña *</label>
                                <input type="password" name="password1" id="password1" placeholder="Escribe tu contraseña" class="form-control" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div>
                            <div class="group-input">
                                <label class="label-input" for="password2">Ingrese nuevamente la contraseña *</label>
                                <input type="password" name="password2" id="password2" placeholder="Escribe nuevamente tu contraseña" class="form-control" required="required" >
                               <div class="invalid-feedback">
                                  El campo es requerido.
                               </div>  
                            </div>
                            <br>
                            <br>
                            <center>
                            <button type="submit" class="site-btn register-btn">REGISTRAR</button></center>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        </div>
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