<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Usuario","altas");

//die(print_r($_POST)." ".print_r($_FILES));

$username = obtenDatos('username');
$email = obtenDatos('email');
$password1 = obtenDatos('password1');
$password2 = obtenDatos('password2');

require_once("modelos/usuarioModelo.php");
$resultado = agregarUsuario($username,$email,$password1,$password2);

if($resultado !== TRUE){
	header("Location: ./formaUsuario.php?username=$username&email=$email&error=$resultado");
	exit();
}

header("Location: ./usuario.php");
?>