<?php
$servidor = "localhost";
$baseDatos = "adictos";
$usuario = "root";
$password = "";

try {
		// Se crea la conexión
	  	$conexion = new PDO("mysql:host=$servidor;dbname=$baseDatos", $usuario, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
	  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  	
		$consulta = $conexion->prepare('SELECT * FROM categoria');
		// Se ejecuta el query
		$consulta->execute();
		// Se obtienen todos los renglones obtenidos de la ejecución del Query
		$categorias = $consulta->fetchAll();
		//print_r($productos);
	  	$conexion = null;
	} catch(PDOException $e) {
  		die("Falló la conexión: " . $e->getMessage());
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Prodcuto</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../bootstrap-4.5.3-dist/css/bootstrap.min.css">
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
	</head>
	<body>
		<div class="container">
			<div class="jumbotron">
				<h1>Producto</h1>
			</div>
			<form action="./agregarProducto.php" method="post" enctype='multipart/form-data' class="needs-validation" novalidate>
				<div class="row">
					<div class="col-md-12 form-group">
						<label for="nombre">Nombre</label>
						<input type="text" name="nombre" placeholder="Escribe el nombre del producto" class="form-control" maxlength="255" required="required">
						<div class="invalid-feedback">
				          El campo es requerido.
				        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label for="descripcion">Descripción</label>
						<textarea name="descripcion" class="form-control" required="required"></textarea>
						<div class="invalid-feedback">
				          El campo es requerido.
				        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label for="precio">Precio</label>
						<input type="number" name="precio" placeholder="Escribe el precio" class="form-control" step="0.01" required="required">
						<div class="invalid-feedback">
				          El campo es requerido.
				        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label for="urlImagen">Imágen</label>
						<input type="file" name="urlImagen" placeholder="Selecciona la imagen" class="form-control" required="required">
						<div class="invalid-feedback">
				          El campo es requerido.
				        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label for="categoria">Categoría</label>
						<select name="categoria" class="form-control" required="required">
							<option value="">Seleccione una categoría</option>
							<?php
								foreach ($categorias as $categoriaLeida) {
									echo "
									<option value='{$categoriaLeida['idCategoria']}' ".(($categoriaLeida['idCategoria'] == $categoria)?"selected":"").">{$categoriaLeida['nombre']}</option>";
								}
							?>
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
	</body>
</html>