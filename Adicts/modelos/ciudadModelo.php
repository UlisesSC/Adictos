<?php
	require_once("constantes.php");

	function obtenCiudades($idEstado=""){

		$ciudades = array();
		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	
			  	// Se genera una consulta para obtener todas las categorías
			$consulta = $conexion->prepare('SELECT * FROM ciudade WHERE idEstado = :idEstado');
			// Se ejecuta el query
			$consulta->execute(["idEstado" => $idEstado]);
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$ciudades = $consulta->fetchAll();
			//print_r($productos);
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $ciudades;
	}

	function obtenNombreCiudad($idCiudad=0){
		$nombreCiudad = "";
		if($idCiudad<=0)
			return $nombreCiudad;

		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	
			  	// Se genera una consulta para obtener todas las categorías
			$consulta = $conexion->prepare('SELECT nombreCiudad FROM ciudad WHERE idCiudad = :idCiudad');
			// Se ejecuta el query
			$consulta->execute(["idCiudad" => $idCiudad]);
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$ciudad = $consulta->fetch();
			$nombreCiudad = $ciudad['nombreCiudad'];
			//print_r($productos);
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $nombreCiudad;
	}

?>