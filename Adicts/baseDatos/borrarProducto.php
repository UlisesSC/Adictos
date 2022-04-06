<?php
$servidor = "localhost";
$baseDatos = "adictos";
$usuario = "root";
$password = "";

//die (print_r($_POST)." ".print_r($_FILES));

$id = "";
if(!empty($_GET['id']))
	$id = $_GET['id'];


try {
		// Se crea la conexión
	  	$conexion = new PDO("mysql:host=$servidor;dbname=$baseDatos", $usuario, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
	  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  	/*
	  	$consulta = $conexion->prepare("INSERT INTO producto (nombre,descripcion,precio,urlImagen,categoria) VALUES ('$nombre','$descripcion','$precio','','$categoria')");
	  	$consulta->execute();
	  	*/
		$consulta = $conexion->prepare("DELETE FROM producto WHERE id = :id");
		// Se ejecuta el query
		$consulta->execute(['id' => $id]);
	  	$conexion = null;

	} catch(PDOException $e) {
  		die("Falló la conexión: " . $e->getMessage());
	}
header("Location: ./index.php");
?>
