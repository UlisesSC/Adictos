<?php
require_once("librerias/utilerias.php");
$resultado = revisaSesionCliente();
if($resultado === TRUE){
    header("Location: ./cliente.php");
    exit();
}

$username = obtenDatos('username');
$error = obtenDatos('error');

require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuGeneral("IniciarSesionCliente.php");
//die(print_r($_POST)." ".print_r($_FILES));
?>

    <!-- Register Section Begin -->
       <div class="container">
            <div class="login-form">
               <div class="row"> 
                     <div class="col-lg-6 offset-lg-3">
                     	 <br>
                         <h2>Iniciar sesión</h2>
                             <form action="./revisaPasswordCliente.php" method="post" class="needs-validation" novalidate>
                             <label for="username">Nombre de usuario</label>
                                    <input type="text" name="username" id="username" placeholder="Escribe el nombre del usuario" class="form-control" maxlength="30" value="<?php echo (isset($username) ? $username : ""); ?>" required="required" >
                                     <div class="invalid-feedback">
                                          El campo es requerido.
                                     </div>
                                <div class="group-input">
                             <br>
                        <label for="password1">Contraseña</label>
                             <input type="password" name="password1" id="password1" placeholder="Escribe la contraseña" class="form-control" required="required" >
                                <div class="invalid-feedback">
                                    El campo es requerido.
                                </div>
                                     <br>
                                     <br>
                                <center> <button type="submit" value="Entrar" class="site-btn login-btn">Ingresar</button></center> 
                             </div>
                             </form>
                        <br>
                        <br>
                        <br>
                        <div class="switch-login">
                           <center><a href="./register.php" class="or-login">CREAR CUENTA</a></center> 
                        </div>
                    </div>
                </div> 
            </div>
             <br>
            <?php
                if(isset($error) && $error!=""){
                    echo "
                    <div class='row'>
                        <div class='col-lg-6 offset-lg-3'>  
                            <div class='alert alert-danger' role='alert'>
                              $error
                            </div>
                        </div>
                    </div>";
                 }
            ?>    
    </div>
             <br>
               
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