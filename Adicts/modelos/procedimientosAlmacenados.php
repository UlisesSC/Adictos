<?php
	require_once("constantes.php");

	function obtenProductos($cate=""){
		$categorias = array();
		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	
			  	// Se genera una consulta 
			$consulta = $conexion->prepare("CALL categoria (?)");
			// Se ejecuta el query
			$consulta->bindParam(1,$cate);
			$consulta->execute();
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$categorias = $consulta->fetchAll();
			//print_r($productos);
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $categorias;
	}

	function obtenVentasFecha($fecha=""){
		$ventas = array();
		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	
			  	// Se genera una consulta 
			$consulta = $conexion->prepare("CALL ventas (?)");
			// Se ejecuta el query
			$consulta->bindParam(1,$fecha);
			$consulta->execute();
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$ventas = $consulta->fetchAll();
			//print_r($productos);
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $ventas;
	}

?>