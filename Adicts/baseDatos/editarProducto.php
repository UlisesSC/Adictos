<?php
$servidor = "localhost";
$baseDatos = "adictos";
$usuario = "root";
$password = "";


$id = "";
if(!empty($_POST['id']))
	$id = $_POST['id'];

$nombre = "";
if(!empty($_POST['nombre']))
	$nombre = $_POST['nombre'];

$descripcion = "";
if(!empty($_POST['descripcion']))
	$descripcion = $_POST['descripcion'];

$precio = "";
if(!empty($_POST['precio']))
	$precio = $_POST['precio'];

$categoria = "";
if(!empty($_POST['categoria']))
	$categoria = $_POST['categoria'];

try {
		// Se crea la conexión
	  	$conexion = new PDO("mysql:host=$servidor;dbname=$baseDatos", $usuario, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
	  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  	/*
	  	$consulta = $conexion->prepare("INSERT INTO producto (nombre,descripcion,precio,urlImagen,categoria) VALUES ('$nombre','$descripcion','$precio','','$categoria')");
	  	$consulta->execute();
	  	*/
	  	$consulta = $conexion->prepare("UPDATE producto SET nombre = :nombre, descripcion = :descripcion, precio = :precio, urlImagen = '', categoria = :categoria WHERE id = :id");
		
		// Se ejecuta el query
		$consulta->execute(['nombre' => $nombre,
							'descripcion' => $descripcion,
							'precio' => $precio,
							'categoria' => $categoria,
							'id' => $id,
						  ]);
	  	$conexion = null;
	} catch(PDOException $e) {
  		die("Falló la conexión: " . $e->getMessage());
	}
header("Location: ./index.php");
?>