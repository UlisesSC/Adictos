<?php
	require_once("constantes.php");


	function obtenModulos($modulo="",$habilitado="",$registroActual=0,$numeroRegistrosPorPagina=6,$contar=FALSE){

		$modulos = array();

		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	// Se crea un String con la instruccion a ejecutar
		  	if($contar===TRUE)
		  		$instruccion = 'SELECT COUNT(*) FROM modulo';
		  	else
		  		$instruccion = 'SELECT * FROM modulo';

		  	if($modulo != "" || $habilitado != ""){
		  		$instruccion .= " WHERE";

		  		$busqueda = "";
		  		
		  		if($modulo != "")
		  			$busqueda = " modulo LIKE :modulo";

		  		if($habilitado != ""){
		  			if($habilitado > 0)
					  	$habilitado = 1;
					else
					  	$habilitado = 0;
		  			if($busqueda != "")
		  				$busqueda .= " AND ";
		  			$busqueda .= " habilitado = '$habilitado'";
		  		}

		  		$instruccion .= $busqueda;
		  	}

		  	if($contar!==TRUE){
		  		$instruccion .= " ORDER BY modulo LIMIT $numeroRegistrosPorPagina OFFSET $registroActual";
		  	}


		  	//die($instruccion);
		  	// Se crea un objeto para realizar el Query
			$consulta = $conexion->prepare($instruccion);

			if($modulo != ""){
				$texto = "%$modulo%";
				$consulta->bindParam('modulo',$texto);
			}
			/*
			if($habilitado != ""){
				$consulta->bindParam('habilitado',$habilitado);
			}
			*/
			

			$consulta->execute();
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$modulos = $consulta->fetchAll();
			
			// liberamos la conexión
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		if($contar === TRUE){
			return $modulos[0]['COUNT(*)'];
		}
		
		return $modulos;
	}

	

	function obtenModulo($modulo=""){

		if($modulo == "")
			return "El nombre del módulo no puede ir vacío";

		$moduloLeido = null;

		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	
			$consulta = $conexion->prepare("SELECT * FROM modulo WHERE modulo = :modulo");
			// Se ejecuta el query

			$consulta->execute(['modulo' => $modulo]);
			
			$moduloLeido = $consulta->fetch();

		  	$conexion = null;
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}
		return $moduloLeido;
	}



	function agregarModulo($modulo="",$habilitado=""){
		if(empty($modulo) || $modulo == ""){
			return "El nombre del módulo no puede ir vacío";
		}
		if($habilitado == ""){
			return "El campo habilitado no puede ir vacío";
		}

		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	
				$consulta = $conexion->prepare("INSERT INTO modulo (modulo,fechaCreacion,habilitado) VALUES (:modulo,:fechaCreacion,:habilitado)");
				// Se ejecuta el query
				$fechaCreacion = date('Y-m-d H:i:s');

				$consulta->execute(['modulo' => $modulo,
									'fechaCreacion' => $fechaCreacion,
									'habilitado' => $habilitado,
								  ]);

				$instruccion = "SELECT username FROM usuario";

				$consulta = $conexion->prepare($instruccion);

				$consulta->execute();

				$usuarios = $consulta->fetchAll();

				foreach ($usuarios as $usuario) {
					$consulta = $conexion->prepare("INSERT INTO permisos (username,modulo,usernameModificacion,fechaModificacion) VALUES (:username,:modulo,'',:fechaModificacion)");
					// Se ejecuta el query
					$fechaModificacion = date('Y-m-d H:i:s');

					$consulta->execute(['username' => $usuario['username'],
										'modulo' => $modulo,
										'fechaModificacion' => $fechaModificacion,
									  ]);
				}

			  	$conexion = null;
			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}

		return TRUE;
	}



	function borrarModulo($modulo = ""){
		if($modulo == "")
			return "El nombre del módulo no puede ir vacío";

		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$consulta = $conexion->prepare("DELETE FROM modulo WHERE modulo = :modulo");
				// Se ejecuta el query
				$consulta->execute(['modulo' => $modulo]);

				$consulta = $conexion->prepare("DELETE FROM permisos WHERE modulo = :modulo");
				// Se ejecuta el query
				$consulta->execute(['modulo' => $modulo]);

			  	$conexion = null;

			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}
		return TRUE;
	}



	function editarModulo($moduloAnterior="",$modulo="",$habilitado=""){

		if(empty($moduloAnterior) || $moduloAnterior == ""){
			return "El nombre anterior del módulo no puede ir vacío";
		}
		if(empty($modulo) || $modulo == ""){
			return "El nombre del módulo no puede ir vacío";
		}
		if($habilitado == ""){
			return "El campo habilitado no puede ir vacío";
		}

		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			  	$instruccion = "UPDATE modulo SET modulo = :modulo, habilitado = :habilitado 
			  					WHERE modulo = :moduloAnterior";

			  	$consulta = $conexion->prepare($instruccion);

			  	$consulta->execute(['modulo' => $modulo,
									'habilitado' => $habilitado,
									'moduloAnterior' => $moduloAnterior,
								  ]);

			  	if($modulo !== $moduloAnterior){
			  		$fechaModificacion = date('Y-m-d H:i:s');

			  		$instruccion = "UPDATE permisos SET modulo = :modulo, fechaModificacion = :fechaModificacion 
			  						WHERE modulo = :moduloAnterior";

			  		$consulta = $conexion->prepare($instruccion);

			  		$consulta->execute(['modulo' => $modulo,
										'fechaModificacion' => $fechaModificacion,
										'moduloAnterior' => $moduloAnterior,
								  ]);
			  	}

			  	$conexion = null;

			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}

		return TRUE;
	}

?>











