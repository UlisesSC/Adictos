<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Modulo","altas");

//die(print_r($_POST)." ".print_r($_FILES));

$modulo = obtenDatos('modulo');
$habilitado = obtenDatos('habilitado');

require_once("modelos/moduloModelo.php");
$resultado = agregarModulo($modulo,$habilitado);

if($resultado !== TRUE){
	header("Location: ./formaModulo.php?modulo=$modulo&habilitado=$habilitado&error=$resultado");
	exit();
}

header("Location: ./modulo.php");
?>