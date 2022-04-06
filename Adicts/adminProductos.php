<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");

verificaPermiso("Producto","consultas");

$categoria = obtenDatos('categoria');
$nombre = obtenDatos('nombre');
$descripcion = obtenDatos('descripcion');
$stock = obtenDatos('stock');
$registroActual = obtenDatos('registroActual');
$numeroRegistrosPorPagina = obtenDatos('numeroRegistrosPorPagina');

if(!is_numeric($registroActual))
      $registroActual=0;
if(!is_numeric($numeroRegistrosPorPagina))
      $numeroRegistrosPorPagina = 5;

require_once("modelos/productoModelo.php");
$productos = obtenProductos($nombre,$descripcion,$categoria,$stock,$registroActual,$numeroRegistrosPorPagina);
$total = obtenProductos($nombre,$descripcion,$categoria,$stock,$registroActual,$numeroRegistrosPorPagina,TRUE);
$consulta = "&nombre=$nombre&descripcion=$descripcion&categoria=$categoria&stock=$stock";
//die(print_r($productos));

$linksPaginas = paginacion("./adminProductos.php",$registroActual,$numeroRegistrosPorPagina,$consulta,$total);


require_once("modelos/categoriaModelo.php");
$categorias = obtenCategorias();


require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuAdministracion("adminProductos.php");
?>


		<div class="container">
			<h1>Productos</h1>

			<form method="get">
				<div class="row">
					<div class="col-md-4 form-group">
						<label for="nombre">Nombre</label>
						<input type="text" name="nombre" placeholder="Escribe el nombre del producto" class="form-control" maxlength="255" value="<?php if(!empty($nombre)) echo $nombre; ?>" >
					</div>

					<div class="col-md-4 form-group">
						<label for="descripcion">Descripción</label>
						<input type="text" name="descripcion" placeholder="Escribe la descripción" class="form-control" maxlength="255" value="<?php if(!empty($descripcion)) echo $descripcion; ?>">
					</div>

					<div class="col-md-4 form-group">
						<label for="categoria">Categorías</label>
						<select name="categoria" class="form-control">
							<option value="">Seleccione una categoría</option>
							<?php
								foreach ($categorias as $categoriaLeida) {
									echo "
									<option value='{$categoriaLeida['idCategoria']}' ".(($categoriaLeida['idCategoria'] == $categoria)?"selected":"").">{$categoriaLeida['nombre']}</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4 form-group">
						<label>&nbsp;</label>
						<input type="submit" value="Buscar" class="btn btn-primary form-control">
					</div>
					<div class="col-md-4"></div>
				</div>
			</form>

			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4 form-group">
					<button class="btn btn-success form-control" onclick="location.href='./formaProducto.php'">Agregar</button>
				</div>
				<div class="col-md-4"></div>
			</div>

			<div class="table-responsive">
				<table class="table">
						<thead class="thead-dark">
							<tr>
								<th>Id</th>
								<th>Nombre</th>
								<th>Descripción</th>
								<th>Precio</th>
								<th>Imagen</th>
								<th>Categoría</th>
								<th>Stock</th>
								<th colspan="2">Acciones</th>
							</tr>
						</thead>
						<tbody>
				<?php
				for($i=0; $i<count($productos); $i++){
					$producto = $productos[$i];
					echo "
							<tr>
								<td>{$producto['id']}</td>
								<td>{$producto['nombre']}</td>
								<td>".substr($producto['descripcion'],0,255)."...</td>
								<td>$".number_format($producto['precio'],2)."</td>
								<td><img src='{$producto['urlImagen']}' alt='{$producto['nombre']}' width='150'></td>
								<td>{$producto['nombreCategoria']}</td>
								<td>{$producto['stock']}</td>
								<td><button class='btn btn-light form-control' onclick=\"location.href='./formaEditarProducto.php?id={$producto['id']}'\" >Editar</button></td>
								<td><button class='btn btn-dark form-control' onclick=\"borrarProducto({$producto['id']})\">Borrar</button></td>
							</tr>";
				}
				?>
					</tbody>
				</table>
			</div>
		</div>

		<!-- Pagination -->
  		<?php echo $linksPaginas; ?>
		
		<!-- container -->
		<script type="text/javascript">
		function borrarProducto(idProducto){
			if (confirm('¿Esta seguro que quiere borrar el producto con id '+ idProducto + '?')) {
			  	location.href = "./borrarProducto.php?id=" + idProducto;
			} 
		}
		</script>

<?php
require_once("vistas/piePagina.php");
?>

