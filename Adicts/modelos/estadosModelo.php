<?php
	require_once("constantes.php");

	function obtenEstados(){

		$estados = array();
		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	
			  	// Se genera una consulta para obtener todas las categorías
			$consulta = $conexion->prepare('SELECT * FROM estado');
			// Se ejecuta el query
			$consulta->execute();
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$estados = $consulta->fetchAll();
			//print_r($productos);
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $estados;
	}

	function obtenNombreEstado($idEstado=0){
		$nombreEstado = "";
		if($idEstado<=0)
			return $nombreEstado;

		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	
			  	// Se genera una consulta para obtener todas las categorías
			$consulta = $conexion->prepare('SELECT nombreEstado FROM estado WHERE idEstado = :idEstado');
			// Se ejecuta el query
			$consulta->execute(["idEstado" => $idEstado]);
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$estado = $consulta->fetch();
			$nombreEstado = $estado['nombreEstado'];
			//print_r($productos);
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $nombreEstado;
	}
?>