<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Modulo","cambios");

$moduloAnterior = obtenDatos('moduloAnterior');
$modulo = obtenDatos('modulo');
$habilitado = obtenDatos('habilitado');

require_once("modelos/moduloModelo.php");
$resultado = editarModulo($moduloAnterior,$modulo,$habilitado);

if($resultado !== TRUE){
	header("Location: ./formaEditarModulo.php?modulo=$modulo&error=$resultado");
	exit();
}

header("Location: ./modulo.php");
?>