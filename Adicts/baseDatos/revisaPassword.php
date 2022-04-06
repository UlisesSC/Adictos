<?php
require_once("utilerias.php");

$username = obtenDatos('username');
$password1 = obtenDatos('password1');

$resultado = revisaPassword($username,$password1);
if($resultado !== TRUE){
	header("Location: ./formaPedirPassword.php?username=$username&error=$resultado");
	exit();
}

header("Location: ./usuario.php");

?>





















