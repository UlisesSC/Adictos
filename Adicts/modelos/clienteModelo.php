<?php
	require_once("constantes.php");

	function obtenDetallesCliente($username=""){

		if($username == "")
			return "El username del cliente no puede ir vacío";

		$cliente = null;
		
		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	
			$consulta = $conexion->prepare("SELECT * FROM cliente WHERE username = :username");
			// Se ejecuta el query

			$consulta->execute(['username' => $username]);
			
			$cliente = $consulta->fetch();

		  	$conexion = null;
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}
		return $cliente;
	}

	function obtenClientes(){

		$clientes = array();

		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	
			  	// Se genera una consulta para obtener todas las categorías
			$consulta = $conexion->prepare('SELECT * FROM cliente');
			// Se ejecuta el query
			$consulta->execute();
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$clientes = $consulta->fetchAll();
			//print_r($productos);
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $clientes;
	}
	
	
	function agregarCliente($nombre="",$apellidoPaterno="",$apellidoMaterno="",$telCliente="",$rfcCliente="",$email="",$username="",$password1="",$password2=""){

		if(empty($nombre) || $nombre == ""){
			return "El nombre no puede ir vacío";
		}
		if(empty($apellidoPaterno) || $apellidoPaterno == ""){
			return "El apellido paterno no puede ir vacío";
		}
		if(empty($apellidoMaterno) || $apellidoMaterno == ""){
			return "El apellido materno no puede ir vacío";
		}
		if(empty($telCliente) || $telCliente == ""){
			return "El telefono no puede ir vacío";
		}
		if(empty($rfcCliente) || $rfcCliente == ""){
			return "El RFC no puede ir vacío";
		}
		if(empty($email) || $email == ""){
			return "El correo electrónico no puede ir vacío";
		}
		if(empty($username) || $username == ""){
			return "El usuario no puede ir vacío";
		}
		if($password1 != $password2){
			return "Las contraseñas no coinciden";
		}
		if(empty($password1) || $password1 == ""){
			return "La contraseña no puede ir vacía";
		}
		if(strlen($password1)<8){
			return "La contraseña tiene que tener al menos 8 caracteres";
		}

		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	
				$consulta = $conexion->prepare("INSERT INTO cliente (nombre,apellidoPaterno,apellidoMaterno,telCliente,rfcCliente,email,username,password) VALUES  (:nombre,:apellidoPaterno,:apellidoMaterno,:telCliente,:rfcCliente,:email,:username,AES_ENCRYPT('$password1','".CLAVE_ENCRIPTAR."'))");
				// Se ejecuta el query
				//die(print("ya inserte en la tabla"));
				$consulta->execute(['nombre' => $nombre,
									'apellidoPaterno' => $apellidoPaterno,
									'apellidoMaterno' => $apellidoMaterno,
									'telCliente' => $telCliente,
									'rfcCliente' => $rfcCliente,
									'email' => $email,
									'username' => $username
								  ]);

			  	$conexion = null;
			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}

		return TRUE;
	}


	function agregarDireccion($colDireccion="",$calleDireccion="",$nintDireccion="",$nextDireccion="",$cpDireccion="",$idCliente=""){
		
		if(empty($colDireccion) || $colDireccion == ""){
			return "El campo colonia no puede ir vacío";
		}
		if(empty($calleDireccion) || $calleDireccion == ""){
			return "El campo calle no puede ir vacío";
		}
		if(empty($nintDireccion) || $nintDireccion == ""){
			return "El campo número interior no puede ir vacío";
		}
		if(empty($nextDireccion) || $nextDireccion == ""){
			return "El campo número exterior no puede ir vacío";
		}
		if(empty($cpDireccion) || $cpDireccion == ""){
			return "El campo CP no puede ir vacío";
		}
		if(empty($idCliente) || $idCliente == ""){
			return "El campo ID no puede ir vacío";
		}

		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	
				$consulta = $conexion->prepare("INSERT INTO direccion (colDireccion,calleDireccion,nintDireccion,nextDireccion,cpDireccion,idCliente) VALUES  (:colDireccion,:calleDireccion,:nintDireccion,:nextDireccion,:cpDireccion,:idCliente)");
				// Se ejecuta el query
				$consulta->execute(['colDireccion' => $colDireccion,
									'calleDireccion' => $calleDireccion,
									'nintDireccion' => $nintDireccion,
									'nextDireccion' => $nextDireccion,
									'cpDireccion' => $cpDireccion,
									'idCliente' => $idCliente
								  ]);

			  	$conexion = null;
			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}

		return TRUE;
	}



	function borrarCliente($idCliente=""){
		if($idCliente == "")
			return "El ID no puede ir vacío";

		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
				$consulta = $conexion->prepare("DELETE FROM cliente WHERE idCliente = :idCliente");
				// Se ejecuta el query
				$consulta->execute(['idCliente' => $idCliente]);
			  	$conexion = null;

			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}
		return TRUE;
	}

	function obtenCompras($username=""){

		$compras = array();
		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	
			  	// Se genera una subconsulta para obtener todas sus compras
			$consulta = $conexion->prepare('
				                            SELECT producto.nombre as producto, cantidad, totalVenta as total, fechaVenta as fecha, urlImagen
                                            FROM cliente
                                            INNER JOIN venta ON (cliente.idCliente = venta.idCliente)
                                            INNER JOIN detalleVenta ON (venta.idVenta = detalleVenta.idVenta) 
                                            INNER JOIN inventario ON (detalleVenta.idInventario = inventario.idInventario)
                                            INNER JOIN producto ON (inventario.idProducto = producto.id)
                                            WHERE username = :username;
				                          ');

			// Se ejecuta el query
			$consulta->execute(['username'=>$username]);
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$compras = $consulta->fetchAll();
			//print_r($productos);
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		return $compras;
	}

?>

