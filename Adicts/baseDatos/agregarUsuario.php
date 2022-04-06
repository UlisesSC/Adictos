<?php
require_once("utilerias.php");

//die(print_r($_POST)." ".print_r($_FILES));

$username = obtenDatos('username');
$email = obtenDatos('email');
$password1 = obtenDatos('password1');
$password2 = obtenDatos('password2');

if($username == ""){
	header("Location: ./formaUsuario.php?username=$username&email=$email&error=El nombre de usuario no puede ir vacío");
}
else if($email == ""){
	header("Location: ./formaUsuario.php?username=$username&email=$email&error=El correo electrónico no puede ir vacío");
}
else if($password1 != $password2){
	header("Location: ./formaUsuario.php?username=$username&email=$email&error=Las contraseñas no coinciden");
}
else if($password1 == ""){
	header("Location: ./formaUsuario.php?username=$username&email=$email&error=La contraseña no puede ir vacía");
}
else if(strlen($password1)<8){
	header("Location: ./formaUsuario.php?username=$username&email=$email&error=La contraseña tiene que tener al menos 8 caracteres");
}

try {
		// Se crea la conexión
	  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
	  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  	
		$consulta = $conexion->prepare("INSERT INTO usuario (username,email,password,fechaModificacion) VALUES (:username,:email,AES_ENCRYPT('$password1','".CLAVE_ENCRIPTAR."'),:fechaModificacion)");
		// Se ejecuta el query
		$fechaModificacion = date('Y-m-d H:i:s');

		$consulta->execute(['username' => $username,
							'email' => $email,
							'fechaModificacion' => $fechaModificacion,
						  ]);
	  	$conexion = null;
	} catch(PDOException $e) {
  		die("Falló la conexión: " . $e->getMessage());
	}
header("Location: ./usuario.php");
?>