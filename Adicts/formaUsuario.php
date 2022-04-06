<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Usuario","altas");

//die(print_r($_POST)." ".print_r($_FILES));

$username = obtenDatos('username');
$email = obtenDatos('email');
$error = obtenDatos('error');

require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuAdministracion("usuario.php");
?>
	<body>
		<div class="container">
			<div class="jumbotron">
				<h1>Usuario</h1>
			</div>
			<form action="./agregarUsuario.php" method="post" class="needs-validation" novalidate>
				<div class="row">
					<div class="col-md-12 form-group">
						<label for="username">Nombre de usuario</label>
						<input type="text" name="username" id="username" placeholder="Escribe el nombre del usuario" class="form-control" maxlength="30" value="<?php echo (isset($username) ? $username : ""); ?>" required="required" >
						<div class="invalid-feedback">
				          El campo es requerido.
				        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label for="email">Correo electrónico</label>
						<input type="email" name="email" id="email" placeholder="Escribe el correo electrónico" class="form-control" maxlength="255" value="<?php echo (isset($email) ? $email : ""); ?>" required="required" >
						<div class="invalid-feedback">
				          El campo es requerido.
				        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label for="password1">Contraseña</label>
						<input type="password" name="password1" id="password1" placeholder="Escribe la contraseña" class="form-control" required="required" >
						<div class="invalid-feedback">
				          El campo es requerido.
				        </div>
					</div>
				</div>
				<div class="row">
					<div class="group-input">
						<label for="password2">Contraseña *</label>
						<input type="password" name="password2" id="password2" placeholder="Escribe nuevamente la contraseña" class="form-control" required="required" >
						<div class="invalid-feedback">
				          El campo es requerido.
				        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label>&nbsp;</label>
						<input type="submit" value="Agregar" class="btn btn-primary form-control">
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