<?php
require_once("librerias/utilerias.php");

$email = obtenDatos('username');
$password1 = obtenDatos('password1');

$resultado = revisaPasswordCliente($username,$password1);
if($resultado !== TRUE){
	header("Location: ./IniciarSesionCliente.php?username=$username&error=$resultado");
	exit();
}

header("Location: ./borrarCliente.php?username=$username");

?>
