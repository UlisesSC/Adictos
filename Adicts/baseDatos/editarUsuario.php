<?php
require_once("utilerias.php");

$usernameAnterior = obtenDatos('usernameAnterior');
$username = obtenDatos('username');
$email = obtenDatos('email');
$password1 = obtenDatos('password1');
$password2 = obtenDatos('password2');

if($usernameAnterior == ""){
	header("Location: ./formaEditarUsuario.php?username=$username&error=El nombre de usuario anterior no puede ir vacío");
}
else if($username == ""){
	header("Location: ./formaEditarUsuario.php?username=$username&error=El nombre de usuario no puede ir vacío");
}
else if($email == ""){
	header("Location: ./formaEditarUsuario.php?username=$username&error=El correo electrónico no puede ir vacío");
}
else if($password1 != "" && $password1 != $password2){
	header("Location: ./formaEditarUsuario.php?username=$username&error=Las contraseñas no coinciden");
}
else if($password1 != "" && strlen($password1)<8){
	header("Location: ./formaEditarUsuario.php?username=$username&error=La contraseña tiene que tener al menos 8 caracteres");
}

try {
		// Se crea la conexión
	  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
	  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	  	$instruccion = "UPDATE usuario SET username = :username, email = :email";

	  	if(!empty($password1) && $password1 != ""){
	  		$instruccion .= ", password = AES_ENCRYPT('$password1','".CLAVE_ENCRIPTAR."')";
	  	}

	  	$instruccion .= ", fechaModificacion = :fechaModificacion WHERE username = :usernameAnterior";


	  	$consulta = $conexion->prepare($instruccion);
		
		$fechaModificacion = date('Y-m-d H:i:s');

		$consulta->execute(['username' => $username,
							'email' => $email,
							'fechaModificacion' => $fechaModificacion,
							'usernameAnterior' => $usernameAnterior
						  ]);
	  	$conexion = null;
	} catch(PDOException $e) {
  		die("Falló la conexión: " . $e->getMessage());
	}
header("Location: ./usuario.php");
?>