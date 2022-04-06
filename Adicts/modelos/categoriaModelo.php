<?php
	require_once("constantes.php");

	function obtenCategorias(){

		$categorias = array();
		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	
			  	// Se genera una consulta para obtener todas las categorías
			$consulta = $conexion->prepare('SELECT * FROM categoria');
			// Se ejecuta el query
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

	function obtenNombreCategoria($idCategoria=0){
		$nombreCategoria = "";
		if($idCategoria<=0)
			return $nombreCategoria;

		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	
			  	// Se genera una consulta para obtener todas las categorías
			$consulta = $conexion->prepare('SELECT nombre FROM categoria WHERE idCategoria = :idCategoria');
			// Se ejecuta el query
			$consulta->execute(["idCategoria" => $idCategoria]);
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$categoria = $consulta->fetch();
			$nombreCategoria = $categoria['nombre'];
			//print_r($productos);
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $nombreCategoria;
	}

?>