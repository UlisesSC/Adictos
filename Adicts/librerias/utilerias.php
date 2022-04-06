<?php
require_once("./modelos/constantes.php");

	function obtenDatos($entrada=""){
		$resultado = "";

		if(isset($_GET[$entrada]))
			$resultado = $_GET[$entrada];

		else if(isset($_POST[$entrada]))
			$resultado = $_POST[$entrada];

		// Le quita los espacios al inicio y al final
		$resultado = trim($resultado);
		// Le quita los caracteres de html
		$resultado = htmlspecialchars($resultado);

		return $resultado;
	}

	function subirArchivo($archivoSubido="",$directorio="",$tiposValidos="jpg|png|jpeg|gif",$tamanio=2000000){
		$resultado = new stdClass();
		$resultado->error = true;
		$resultado->ruta = "";
		$resultado->mensaje = "";

		if(empty($_FILES[$archivoSubido])){
			$resultado->mensaje = "El nombre del archivo subido no puede ir vacío";
			return $resultado;
		}

		$archivo = $_FILES[$archivoSubido];	

		if($archivo['size'] > $tamanio){
			$resultado->mensaje = "No se pueden subir archivos mayores a $tamanio, su archivo tiene {$archivo['size']}";
			return $resultado;
		}

		$arregloTiposValidos = explode("|", $tiposValidos);
		$esValido = false;
		foreach ($arregloTiposValidos as $tipo) {
			if(strpos($archivo['type'], $tipo))
				$esValido = true;
		}			

		if(!$esValido){
			$resultado->mensaje = "No se puede subir archivos diferentes a $tiposValidos su tipo de archivo es {$archivo['type']}";
			return $resultado;
		}

		$fecha = new DateTime('NOW');
		$parteUnica = $fecha->format('mdYHisu');

		$nombreActual = $archivo['name'];
		$nombreActual = str_replace(" ", "-", $nombreActual);
		$nuevoNombre = $directorio.$parteUnica."-".$nombreActual;


		if(!move_uploaded_file($archivo['tmp_name'], $nuevoNombre)){
			$resultado->mensaje = "No se pudo subir el archivo {$archivo['name']}";
			return $resultado;
		}

		$resultado->error = false;
		$resultado->ruta = $nuevoNombre;
		$resultado->mensaje = "Archivo subido satisfactoriamente";
		return $resultado;
	}

	function revisaPassword($username="",$password=""){
		if(empty($username) || $username == "")
			return "El nombre de usuario no puede ir vacío";

		if(empty($password) || $password == "")
			return "La contraseña no puede ir vacía";

		if(strlen($password)<8)
			return "La contraseña tiene que tener al menos 8 caracteres";
			

		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	//echo "Se conectó";
			  	// Se crea un String con la instruccion a ejecutar
			  	$instruccion = "SELECT * FROM usuario WHERE password = AES_ENCRYPT('$password','".CLAVE_ENCRIPTAR."') AND username=:username";

			  	//die($instruccion);
			  	// Se crea un objeto para realizar el Query
				$consulta = $conexion->prepare($instruccion);

				$consulta->execute(['username' => $username]);
				// Se obtiene el usuario
				$usuario = $consulta->fetch();

				if(empty($usuario) || $usuario == null)
					return "El nombre del usuario o contraseña no coinciden";

				$valorAleatorio = rand(0,9999999999);
				$sesion = password_hash($valorAleatorio, PASSWORD_BCRYPT);

				$instruccion = "UPDATE usuario SET sesion = :sesion WHERE username=:username";
				//die($instruccion);
			  	// Se crea un objeto para realizar el Query
				$consulta = $conexion->prepare($instruccion);

				$consulta->execute([
									'sesion' => $sesion,
									'username' => $username
								   ]);

				
				// liberamos la conexión
			  	$conexion = null;
			  		
			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}
			session_start();

			$_SESSION["username"] = $usuario['username'];
			$_SESSION["sesion"] = $sesion;

			return TRUE;
	}


	function revisaSesion(){

		session_start();

		$username = "";
		if(isset($_SESSION['username']))
			$username = $_SESSION['username'];

		$valorSesion = "";
		if(isset($_SESSION['sesion']))
			$valorSesion = $_SESSION['sesion'];


		if(empty($username) || $username == "")
			return "El nombre de usuario no puede ir vacío";

		if(empty($valorSesion) || $valorSesion == "")
			return "No existe una sesión valida";


		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	//echo "Se conectó";
			  	// Se crea un String con la instruccion a ejecutar
			  	$instruccion = "SELECT * FROM usuario WHERE username=:username";

			  	//die($instruccion);
			  	// Se crea un objeto para realizar el Query
				$consulta = $conexion->prepare($instruccion);

				$consulta->execute(['username' => $username]);
				// Se obtiene el usuario
				$usuario = $consulta->fetch();

				if(empty($usuario) || $usuario == null)
					return "El usuario no existe";

				$sesionLeida = $usuario['sesion'];
				if($sesionLeida != $valorSesion)
					return "No existe una sesión valida";
				
				// liberamos la conexión
			  	$conexion = null;
			  		
			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}

			return TRUE;
	}


	function salir(){
		session_start();
		$_SESSION["username"] = "";
		$_SESSION["sesion"] = "";
		//session_unset();	// Se borra el contenido del archivo
		//session_destroy();	// Se destruye todo el archivo de sesion en el servidor	
	}

function revisaPasswordCliente($username="",$password=""){

		if(empty($username) || $username == "")
			return "El usuario no puede ir vacío";

		if(empty($password) || $password == "")
			return "La contraseña no puede ir vacía";

		if(strlen($password)<8)
			return "La contraseña tiene que tener al menos 8 caracteres";
			

		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	//echo "Se conectó";
			  	// Se crea un String con la instruccion a ejecutar
			  	$instruccion = "SELECT * FROM cliente WHERE password = AES_ENCRYPT('$password','".CLAVE_ENCRIPTAR."') AND username=:username";

			  	//die($instruccion);
			  	// Se crea un objeto para realizar el Query
				$consulta = $conexion->prepare($instruccion);

				$consulta->execute(['username' => $username]);
				// Se obtiene el usuario
				$usuario = $consulta->fetch();

				if(empty($username) || $username == null)
					return "El correo usuario o contraseña no coinciden";

				$valorAleatorio = rand(0,9999999999);
				$sesion = password_hash($valorAleatorio, PASSWORD_BCRYPT);

				$instruccion = "UPDATE cliente SET sesion = :sesion WHERE username=:username";
				//die($instruccion);
			  	// Se crea un objeto para realizar el Query
				$consulta = $conexion->prepare($instruccion);

				$consulta->execute([
									'sesion' => $sesion,
									'username' => $username
								   ]);

			  	$conexion = null;
			  		
			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}
			session_start();

			$_SESSION["username"] = $usuario['username'];
			$_SESSION["sesion"] = $sesion;

			return TRUE;
	}


	function revisaSesionCliente(){

		session_start();

		$username = "";
		if(isset($_SESSION['username']))
			$username = $_SESSION['username'];

		$valorSesion = "";
		if(isset($_SESSION['sesion']))
			$valorSesion = $_SESSION['sesion'];


		if(empty($username) || $username == "")
			return "El usuarios o contraseña no coinciden";

		if(empty($valorSesion) || $valorSesion == "")
			return "No existe una sesión valida";


		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	//echo "Se conectó";
			  	// Se crea un String con la instruccion a ejecutar
			  	$instruccion = "SELECT * FROM cliente WHERE username=:username";

			  	//die($instruccion);
			  	// Se crea un objeto para realizar el Query
				$consulta = $conexion->prepare($instruccion);

				$consulta->execute(['username'=>$username]);
				// Se obtiene el usuario
				$usuario = $consulta->fetch();

				if(empty($usuario) || $usuario == null)
					return "El usuario no existe";

				$sesionLeida = $usuario['sesion'];
				if($sesionLeida != $valorSesion)
					return "No existe una sesión valida";
				
				$instruccion = "SELECT * FROM cliente WHERE username=:username";

			  	//die($instruccion);
			  	// Se crea un objeto para realizar el Query
				$consulta = $conexion->prepare($instruccion);

				$consulta->execute(['username'=>$username]);
				// Se obtiene el usuario
				
				while($cliente = $consulta->fetch()){
					$clie = $cliente['idCliente'];
				}

				$_SESSION['cliente'] = $clie;

				// liberamos la conexión
			  	$conexion = null;
			  		
			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}

			return TRUE;
	}


	function salirCliente(){
		session_start();
		$_SESSION["username"] = "";
		$_SESSION["sesion"] = "";
		session_unset();	// Se borra el contenido del archiv
		session_destroy();	// Se destruye todo el archivo de sesion en el servidor	
	}

	function muestraError($error=""){
		return "
		<div class='container'>
			<h1>$error</h1>
		</div>";
	}


	function paginacion($url="",$registroActual=0,$numeroRegistrosPorPagina=10,$consulta="",$total=0){
		$linksPaginas = "";

		if($registroActual>$total)
			$registroActual=$total;
	
		if($numeroRegistrosPorPagina<=0)
			$numeroRegistrosPorPagina = 10;
		
		// Siempre se van a mostrar máximo 10 numeros de página	
		$cantidadPaginas  = intval($total)/$numeroRegistrosPorPagina;
		
		$botonInicio = 0;
		$botonFinal = intval($cantidadPaginas)*$numeroRegistrosPorPagina;
		if($botonFinal>=$total)
			$botonFinal = (intval($cantidadPaginas)-1)*$numeroRegistrosPorPagina;
		
		$paginaActual =	$registroActual/$numeroRegistrosPorPagina;
		
		// Siempre se van a mostrar máximo 10 numeros de página		
		$botonAnterior = 0;
		if($paginaActual>1)
			$botonAnterior = $paginaActual*$numeroRegistrosPorPagina-$numeroRegistrosPorPagina;
			
		// Siempre se van a mostrar máximo 10 numeros de página	
		$botonSiguiente = intval($cantidadPaginas)*$numeroRegistrosPorPagina;
		if($paginaActual<intval($cantidadPaginas))
			$botonSiguiente = $paginaActual*$numeroRegistrosPorPagina+$numeroRegistrosPorPagina;
		
		if($botonSiguiente>$botonFinal)
			$botonSiguiente = $botonFinal;
			
		// Siempre se van a mostrar máximo 10 numeros de página	
		if($cantidadPaginas>0 && $cantidadPaginas<=10){
			$inicioFor = 0;
			$finFor = $cantidadPaginas;
		}
		else if($cantidadPaginas>10 && $paginaActual<=5){
			$inicioFor = 0;
			$finFor = 10;
		}
		else if($cantidadPaginas>10 && $paginaActual>5){
			$inicioFor = $paginaActual-5;
			$finFor = $paginaActual+5;
			if($finFor>$cantidadPaginas)
				$finFor = $cantidadPaginas;
		}
		else{
			$inicioFor = 0;
			$finFor = 0;
		}
		/*	
		echo "Inicio for $inicioFor  Fin for $finFor Número de registros por p&aacute;gina $numeroRegistrosPorPagina
		      Total $total Cantidad $cantidadPaginas P&aacute;gina actual $paginaActual<br/>";
		*/	
		if ($cantidadPaginas > 0){  // se verifica que haya mas de una pagina

			// registroActual=intval($i*$numeroRegistrosPorPagina)&numeroRegistrosPorPagina=$numeroRegistrosPorPagina$consulta
			$linksPaginas = "
				<ul class='pagination justify-content-center'>
					<li class='page-item'><a class='page-link' href='$url?registroActual=$botonInicio&numeroRegistrosPorPagina=$numeroRegistrosPorPagina$consulta'> Inicio </a></li>
					<li class='page-item'><a class='page-link' href='$url?registroActual=$botonAnterior&numeroRegistrosPorPagina=$numeroRegistrosPorPagina$consulta'> &laquo;</a></li>";

			for($i=$inicioFor; $i<$finFor; $i++){
				if($paginaActual!=$i)
					$linksPaginas .= "
					<li class='page-item'><a class='page-link' href='$url?registroActual=".intval($i*$numeroRegistrosPorPagina)."&numeroRegistrosPorPagina=$numeroRegistrosPorPagina$consulta'>".intval($i+1)."</a></li>";
				else
					$linksPaginas .= "
					<li class='page-item active'><a class='page-link' href='$url?registroActual=".intval($i*$numeroRegistrosPorPagina)."&numeroRegistrosPorPagina=$numeroRegistrosPorPagina$consulta'>".intval($i+1)."</a></li>";
			}
				
			$linksPaginas .= "
					<li class='page-item'><a class='page-link' href='$url?registroActual=$botonSiguiente&numeroRegistrosPorPagina=$numeroRegistrosPorPagina$consulta'>  &raquo;</a></li>
					<li class='page-item'><a class='page-link' href='$url?registroActual=$botonFinal&numeroRegistrosPorPagina=$numeroRegistrosPorPagina$consulta'> Fin </a></li>
				</ul>";
		}

		return $linksPaginas;
	}


	function verificaPermiso($modulo="",$accion="",$json=FALSE){
		$username = "";
		if(isset($_SESSION['username']))
			$username = $_SESSION['username'];

		require_once("modelos/permisosModelo.php");
		$permiso = tienePermiso($username,$modulo,$accion);

		$mensajeError = "No tiene permiso para $accion en el módulo $modulo";

		if($json === TRUE ){
			if($permiso == 0)
				return $mensajeError;
			else
				return TRUE;
		}


		if($permiso == 0){
		  require_once("vistas/encabezado.php");
		  require_once("vistas/menu.php");
		  echo menuAdministracion("usuarios.php");
		  echo muestraError($mensajeError);
		  require_once("vistas/piePagina.php");
		  exit();
		}
	}

?>