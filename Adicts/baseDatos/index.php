<?php
require_once("utilerias.php");
/*
Include no permite que continue el codigo
include_once();
Si ya se incluyo mas de una vez, no funciona
require();
include();
*/
$servidor = "localhost";
$baseDatos = "adictos";
$usuario = "root";
$password = "";

$categoria = 0;
if(!empty($_GET['categoria']))
	$categoria = $_GET['categoria'];

$nombre = "";
if(!empty($_GET['nombre']))
	$nombre = $_GET['nombre'];

$descripcion = "";
if(!empty($_GET['descripcion']))
	$descripcion = $_GET['descripcion'];

try {
		// Se crea la conexión
	  	$conexion = new PDO("mysql:host=$servidor;dbname=$baseDatos", $usuario, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
	  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  	//echo "Se conectó";
	  	// Se crea un String con la instruccion a ejecutar
	  	$instruccion = 'SELECT *, (SELECT nombre FROM categoria WHERE idCategoria=categoria) as nombreCategoria FROM producto';
	  	if($nombre != "" || $descripcion != "" || $categoria > 0){
	  		$instruccion .= " WHERE";

	  		$busqueda = "";
	  		
	  		if($categoria > 0)
	  			$busqueda = " categoria = :categoria";

	  		if($nombre != ""){
	  			if($busqueda != "")
	  				$busqueda .= " AND ";
	  			$busqueda .= " nombre LIKE :nombre";
	  		}

	  		if($descripcion != ""){
	  			if($busqueda != "")
	  				$busqueda .= " AND ";
	  			$busqueda .= " descripcion LIKE :descripcion";
	  		}

	  		$instruccion .= $busqueda;
	  	}


	  	//die($instruccion);
	  	// Se crea un objeto para realizar el Query
		$consulta = $conexion->prepare($instruccion);

		if($categoria > 0)
			$consulta->bindParam('categoria',$categoria);
		if($nombre != ""){
			$texto = "%$nombre%";
			$consulta->bindParam('nombre',$texto);
		}
		if($descripcion != ""){
			$texto = "%$descripcion%";
			$consulta->bindParam('descripcion',$texto);
		}

		$consulta->execute();
		// Se obtienen todos los renglones obtenidos de la ejecución del Query
		$productos = $consulta->fetchAll();
		// Se genera una consulta para obtener todas las categorías
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
		<title>Productos</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
		<script type="text/javascript">
			function borrarProducto(idProducto){
				if (confirm('¿Esta seguro que quiere borrar el producto con id '+ idProducto + '?')) {
				  	location.href = "./borrarProducto.php?id=" + idProducto;
				} 
			}
		</script>
	</head>
	<body>
		<div class="container">
			<div class="jumbotron">
				<h1>Productos</h1>
			</div>
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
								<td>{$producto['descripcion']}</td>
								<td>$".number_format($producto['precio'],2)."</td>
								<td>{$producto['urlImagen']}</td>
								<td>{$producto['nombreCategoria']}</td>
								<td><button class='btn btn-light form-control' onclick=\"location.href='./formaEditarProducto.php?id={$producto['id']}'\">Editar</button></td>
								<td><button class='btn btn-dark form-control' onclick=\"borrarProducto({$producto['id']})\">Borrar</button></td>
							</tr>";
				}
				?>
					</tbody>
				</table>
			</div>
	</body>
</html>