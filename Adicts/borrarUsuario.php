<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Usuario","bajas");

//die (print_r($_POST)." ".print_r($_FILES));

$username = obtenDatos('username');

require_once("modelos/usuarioModelo.php");
$resultado = borrarUsuario($username);

if($resultado !== TRUE){
	require_once("vistas/encabezado.php");
	require_once("vistas/menu.php");
	echo menuAdministracion("usuario.php");
	echo muestraError($resultado);
	require_once("vistas/piePagina.php");
	return;
}

header("Location: ./usuario.php");
?>







