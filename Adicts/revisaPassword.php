<?php
require_once("librerias/utilerias.php");

$username = obtenDatos('username');
$password1 = obtenDatos('password1');

$resultado = revisaPassword($username,$password1);
if($resultado !== TRUE){
	header("Location: ./sesion.php?username=$username&error=$resultado");
	exit();
}

header("Location: ./usuario.php");

?>
