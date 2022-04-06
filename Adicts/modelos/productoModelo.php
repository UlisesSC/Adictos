<?php
	require_once("constantes.php");

	function obtenProductos($nombre="",$descripcion="",$categoria=0,$stock=0,$registroActual=0,$numeroRegistrosPorPagina=6,$contar=FALSE){
		$productos = array();
		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	// Se crea un String con la instruccion a ejecutar
		  	if($contar===TRUE){
		  		$instruccion = 'SELECT COUNT(*) FROM producto';
		  	}
		  	else{
		  		$instruccion = 'SELECT *, (SELECT nombre FROM categoria WHERE idCategoria=categoria) as nombreCategoria, inventario.stock FROM producto INNER JOIN inventario ON inventario.idProducto = producto.id';
		  	}
		  	
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
		  	if($contar!==TRUE){
		  		$instruccion .= " ORDER BY id DESC LIMIT $numeroRegistrosPorPagina OFFSET $registroActual";
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
			//print_r($productos);
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		if($contar === TRUE){
			return $productos[0]['COUNT(*)'];
		}

		return $productos;
	}

    function subirProducto($nombre="",$descripcion="",$costo="",$categoria="",$stock="",$rutaImagen=""){

		if(empty($nombre) || $nombre == ""){
			return "El nombre del producto no puede ir vacío";
		}

		if(empty($descripcion) || $descripcion == ""){
			return "La descripción del producto no puede ir vacía";
		}

		if(empty($costo) || $costo == ""){
			return "El costo del producto no puede ir vacío";
		}

		if(empty($categoria) || $categoria == ""){
			return "La categoria del producto no puede ir vacía";
		}

		if(empty($stock) || $stock == ""){
			return "El stock no puede ir vacío";
		}

		if(empty($rutaImagen) || $rutaImagen == ""){
			return "El ruta de la imagen no puede ir vacía";
		}

		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	//comienza la transaccion
			  	$conexion->beginTransaction();


				$consulta = $conexion->prepare("INSERT INTO producto (nombre,descripcion,costo,urlImagen,categoria) VALUES (:nombre,:descripcion,:costo,:ruta,:categoria)");
				// Se ejecuta el query
				$consulta->execute(['nombre' => $nombre,
									'descripcion' => $descripcion,
									'costo' => $costo,
									'categoria' => $categoria,
									'ruta' => $rutaImagen

								  ]);

				$idProducto=$conexion->lastInsertId();

				$consulta = $conexion->prepare("INSERT INTO inventario (stock,idProducto) VALUES (:stock,:idProducto)");
				// Se ejecuta el query
				$consulta->execute(['stock' => $stock,
									'idProducto' => $idProducto
								  ]);
				$conexion->commit();


			  	$conexion = null;
			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			$conexion->rollback();
			}
		return TRUE;
	}
    

	function borrarProducto($id=""){
		if(empty($id) || $id == ""){
			return "El ID no puede ir vacío";
		}
		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	
		  	$consulta = $conexion->prepare("SELECT urlImagen FROM producto WHERE id = :id");
		  	// Se ejecuta el query
			$consulta->execute([
								'id' => $id
							  ]);
			$producto = $consulta->fetch();
			$urlImagenAnterior = $producto['urlImagen'];

			$consulta = $conexion->prepare("DELETE FROM producto WHERE id = :id");
			// Se ejecuta el query
			$consulta->execute(['id' => $id]);
		  	$conexion = null;

		  	if(file_exists($urlImagenAnterior))
				unlink($urlImagenAnterior);

		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return TRUE;
	}


	function detallesProducto($id=""){
		if(empty($id) || $id == ""){
			return "El ID no puede ir vacío";
		}

		$producto = null;
		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		  	$consulta = $conexion->prepare('SELECT * FROM producto WHERE id = :id');
			// Se ejecuta el query
			$consulta->execute(['id' => $id]);

			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$producto = $consulta->fetch();
			//print_r($productos);
		  	$conexion = null;
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $producto;
	}


	function editarProducto($nombre="",$descripcion="",$precio="",$categoria="",$id="",$rutaImagen=""){

		if(empty($nombre) || $nombre == ""){
			return "El nombre del producto no puede ir vacío";
		}

		if(empty($descripcion) || $descripcion == ""){
			return "La descripción del producto no puede ir vacía";
		}

		if(empty($precio) || $precio == ""){
			return "El precio del producto no puede ir vacío";
		}

		if(empty($categoria) || $categoria == ""){
			return "La categoria del producto no puede ir vacía";
		}

		if(empty($id) || $id == ""){
			return "El ID no puede ir vacío";
		}

		if(empty($rutaImagen) || $rutaImagen == ""){
			return "El ruta de la imagen no puede ir vacía";
		}


		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


		  	$consulta = $conexion->prepare("SELECT urlImagen FROM producto WHERE id = :id");
		  	// Se ejecuta el query
			$consulta->execute([
								'id' => $id
							  ]);
			$producto = $consulta->fetch();
			$urlImagenAnterior = $producto['urlImagen'];
			
			if(file_exists($urlImagenAnterior))
				unlink($urlImagenAnterior);

		  	$consulta = $conexion->prepare("UPDATE producto SET nombre = :nombre, descripcion = :descripcion, precio = :precio, urlImagen = :ruta, categoria = :categoria WHERE id = :id");
			
			//$consulta = $conexion->prepare("UPDATE inventario SET stock = :stock WHERE id = :id");//  
			// Se ejecuta el query
			$consulta->execute(['nombre' => $nombre,
								'descripcion' => $descripcion,
								'precio' => $precio,
								'categoria' => $categoria,
								'id' => $id,
								'ruta' => $rutaImagen,
							  ]);
		  	$conexion = null;
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return TRUE;
	}

	

?>