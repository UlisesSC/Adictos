<?php
	require_once("constantes.php");


	function productoPorTerminar(){

		$porTerminar = array();
		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	
			  	// Se genera una consulta para obtener todas las categorías
			$consulta = $conexion->prepare('
				                            SELECT producto.id, descripcion, stock
                                            from inventario inner join producto
                                            on(inventario.idProducto=producto.id)
                                            where inventario.idInventario in(select detalleVenta.idInventario
                                            from inventario inner join detalleVenta on(inventario.idInventario=detalleVenta.idInventario)
                                            where inventario.stock<=5)	
				                          ');
			// Se ejecuta el query
			$consulta->execute();
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$porTerminar = $consulta->fetchAll();
			//print_r($productos);
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $porTerminar;
	}

	function productoNoVendidos(){

		$noVendidos = array();
		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	
			  	// Se genera una consulta para obtener todas las categorías
			$consulta = $conexion->prepare('
				                            SELECT producto.id, nombre, descripcion
                                            from inventario inner join producto
                                            on(inventario.idProducto=producto.id)
                                            where inventario.idInventario not in(select detalleVenta.idInventario from inventario
                                            inner join detalleVenta on(inventario.idInventario=detalleVenta.idInventario))
				                          ');
			// Se ejecuta el query
			$consulta->execute();
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$noVendidos = $consulta->fetchAll();
			//print_r($productos);
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $noVendidos;
	}

?>