<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Usuario","cambios");

$usernameAnterior = obtenDatos('usernameAnterior');
$username = obtenDatos('username');
$email = obtenDatos('email');
$password1 = obtenDatos('password1');
$password2 = obtenDatos('password2');

require_once("modelos/usuarioModelo.php");
$resultado = editarUsuario($usernameAnterior,$username,$email,$password1,$password2);

if($resultado !== TRUE){
	header("Location: ./formaEditarUsuario.php?username=$username&error=$resultado");
	exit();
}

header("Location: ./usuario.php");
?>