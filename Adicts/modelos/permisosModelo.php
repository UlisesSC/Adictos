<?php
	require_once("constantes.php");


	function tienePermiso($username="",$modulo="",$accion=""){

		if(empty($username) || $username == "")
			return FALSE;
		if(empty($modulo) || $modulo == "")
			return FALSE;
		if(empty($accion) || $accion == "")
			return FALSE;

		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	// Se crea un String con la instruccion a ejecutar
		  	$instruccion = "SELECT $accion FROM permisos WHERE username = :username AND modulo = :modulo";

		  	//die($instruccion);
		  	// Se crea un objeto para realizar el Query
			$consulta = $conexion->prepare($instruccion);

			$consulta->execute([
								'username' => $username,
								'modulo' => $modulo
								]);
			// Se obtiene el valor
			$permiso = $consulta->fetch();
			
			// liberamos la conexión
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $permiso[$accion];
	}


	function obtenPermisos($username=""){

		if(empty($username) || $username == "")
			return "El nombre de usuario no puede ir vacío";

		$permisos = array();

		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	// Se crea un String con la instruccion a ejecutar
		  	$instruccion = "SELECT * FROM permisos WHERE username = :username";

		  	//die($instruccion);
		  	// Se crea un objeto para realizar el Query
			$consulta = $conexion->prepare($instruccion);

			$consulta->execute([
								'username' => $username,
								]);
			// Se obtiene el valor
			$permisos = $consulta->fetchAll();
			
			// liberamos la conexión
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $permisos;
	}


	function editarPermiso($username="",$accion="",$modulo="",$estatus="",$usernameModificacion=""){

		if(empty($username) || $username == ""){
			return "El nombre de usuario no puede ir vacío";
		}
		if($accion != "altas" && $accion != "bajas" && $accion != "consultas" && $accion != "cambios"){
			return "La acción no existe $accion";
		}
		if(empty($modulo) || $modulo == ""){
			return "El módulo no puede ir vacío";
		}
		if(empty($usernameModificacion) || $usernameModificacion == ""){
			return "El username que modifica los permisos no puede ir vacío";
		}

		if($estatus == "true")
			$estatus = 1;
		else
			$estatus = 0;


		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			  	$instruccion = "UPDATE permisos SET $accion = $estatus, 
			  					usernameModificacion = :usernameModificacion,
			  					fechaModificacion = :fechaModificacion
			  					WHERE
			  					username = :username AND
			  					modulo = :modulo";

			  	$consulta = $conexion->prepare($instruccion);
				
				$fechaModificacion = date('Y-m-d H:i:s');

				$consulta->execute(['usernameModificacion' => $usernameModificacion,
									'fechaModificacion' => $fechaModificacion,
									'username' => $username,
									'modulo' => $modulo,
								  ]);
			  	$conexion = null;
			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}

		return TRUE;
	}

	
?>











