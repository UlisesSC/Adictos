<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Modulo","altas");

//die(print_r($_POST)." ".print_r($_FILES));

$modulo = obtenDatos('modulo');
$habilitado = obtenDatos('habilitado');
$error = obtenDatos('error');

require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuAdministracion("modulo.php");
?>
	<body>
		<div class="container">
			<div class="jumbotron">
				<h1>Módulo</h1>
			</div>
			<form action="./agregarModulo.php" method="post" class="needs-validation" novalidate>
				<div class="row">
					<div class="col-md-12 form-group">
						<label for="modulo">Nombre del módulo</label>
						<input type="text" name="modulo" id="modulo" placeholder="Escribe el nombre del módulo" class="form-control" maxlength="45" value="<?php echo (isset($modulo) ? $modulo : ""); ?>" required="required" >
						<div class="invalid-feedback">
				          El campo es requerido.
				        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label for="habilitado">habilitado</label>
						<select name="habilitado" class="form-control" required="required">
							<option value="">Seleccione una opción</option>
							<option value="0" <?php echo (($habilitado == "0") ? "selected" : ""); ?>>Deshabilitado</option>
							<option value="1" <?php echo (($habilitado == "1") ? "selected" : ""); ?>>Habilitado</option>
						</select>
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