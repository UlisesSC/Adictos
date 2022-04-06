<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Modulo","bajas");

//die (print_r($_POST)." ".print_r($_FILES));

$modulo= obtenDatos('modulo');

require_once("modelos/moduloModelo.php");
$resultado = borrarModulo($modulo);

if($resultado !== TRUE){
	require_once("vistas/encabezado.php");
	require_once("vistas/menu.php");
	echo menuAdministracion("modulo.php");
	echo muestraError($resultado);
	require_once("vistas/piePagina.php");
	return;
}

header("Location: ./modulo.php");
?>







