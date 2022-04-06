<?php
require_once("librerias/utilerias.php");

//die(print_r($_POST)." ".print_r($_FILES));

$email = obtenDatos('username');
$error = obtenDatos('error');

require_once("vistas/encabezadoAdministracion.php");

?>


    </section>

    <section class="page-section cta" align="center" style="background-color: #96DC94;">
      <div class="container">
        <div class="row" >
          <div class="col-xl-16 mx-auto">
            <div class="cta-inner text-center rounded">
		<!-- Page Heading -->
		  <h1 class="my-4" style="color: black;">Confirma tu Usuario</h1>
			<form action="./revisaPasswordCliente2.php" method="post" class="needs-validation" novalidate>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-12 form-group" align="left" style="font-family: Berlin Sans FB; font-size: 20px;">
						<label for="email">Nombre de usuario o correo</label>
						<input type="email" name="email" id="email" placeholder="Escribe el correo electronico" class="form-control" maxlength="30" value="<?php echo (isset($email) ? $email : ""); ?>" required="required" >
						<div class="invalid-feedback">
				          El campo es requerido.
				        </div>
					</div>
					<div class="col-md-4"></div>
				</div>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-12 form-group" align="left" style="font-family: Berlin Sans FB; font-size: 20px;">
						<label for="password1">Contraseña</label>
						<input type="password" name="password1" id="password1" placeholder="Escribe la contraseña" class="form-control" required="required" >
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
						<input type="submit" value="Confirmar" class="btn btn-success form-control">
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
