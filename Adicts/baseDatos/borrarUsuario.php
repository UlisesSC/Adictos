<?php
require_once("utilerias.php");

//die (print_r($_POST)." ".print_r($_FILES));

$id = obtenDatos('id');

try {
		// Se crea la conexión
	  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
	  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  	
	  	$consulta = $conexion->prepare("SELECT urlImagen FROM producto WHERE id = :id");
	  	// Se ejecuta el query
		$consulta->execute([
							'id' => $id
						  ]);
		$producto = $consulta->fetch();
		$urlImagenAnterior = $producto['urlImagen'];

		$consulta = $conexion->prepare("DELETE FROM producto WHERE id = :id");
		// Se ejecuta el query
		$consulta->execute(['id' => $id]);
	  	$conexion = null;

	  	if(file_exists($urlImagenAnterior))
			unlink($urlImagenAnterior);

	} catch(PDOException $e) {
  		die("Falló la conexión: " . $e->getMessage());
	}
header("Location: ./index.php");
?>








