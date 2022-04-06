<?php
require_once("utilerias.php");

//die(print_r($_POST)." ".print_r($_FILES));

$username = obtenDatos('username');
$password = obtenDatos('password');


try {
		// Se crea la conexión
	  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
	  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  	
		$consulta = $conexion->prepare("SELECT * FROM usuario WHERE username = :username AND password = AES_ENCRYPT('$password','".CLAVE_ENCRIPTAR."')");
		// Se ejecuta el query

		$consulta->execute(['username' => $username]);
		$usuario = $consulta->fetch();


	  	$conexion = null;
	} catch(PDOException $e) {
  		die("Falló la conexión: " . $e->getMessage());
	}
die(print_r($usuario));
?>