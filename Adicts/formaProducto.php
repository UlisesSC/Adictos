<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Producto","altas");

require_once("modelos/categoriaModelo.php");
$categorias = obtenCategorias();

require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuAdministracion("adminProductos.php");
?>

		
	</head>
	<body>
		<div class="container">
			<h1>Producto</h1>
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
						<label for="costo">costo</label>
						<input type="number" name="costo" placeholder="Escribe el costo del producto" class="form-control" step="0.01" required="required">
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
						<label for="stock">Stock</label>
						<input type="number" name="stock" placeholder="Escribe la cantidad de productos" class="form-control" step="0" required="required">
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
						<input type="submit" value="Agregar" class="btn btn-dark form-control">
					</div>
				</div>
			</form>
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