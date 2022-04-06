<?php
require_once("librerias/utilerias.php");

$username = obtenDatos('username');
$password1 = obtenDatos('password1');

session_start();
$_SESSION['cliente'] = $username;

$resultado = revisaPasswordCliente($username,$password1);
if($resultado !== TRUE){
	header("Location: ./IniciarSesionCliente.php?username=$username&error=$resultado");
	exit();
}

header("Location: ./cliente.php?username=$username");

?>
