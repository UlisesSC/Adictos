<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Respaldar","consultas");

require_once("modelos/usuarioModelo.php");
$resultado = respaldarUsuarios();

if($resultado !== TRUE){
	header("Location: ./ListaUsuarios.php?error=$resultado");
	exit();
}

header("Location: ./ListaUsuarios.php");
?>