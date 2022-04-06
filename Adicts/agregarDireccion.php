<?php
require_once("librerias/utilerias.php");

//die(print_r($_POST)." ".print_r($_FILES));
$idCliente = obtenDatos('idCliente');
$colDireccion = obtenDatos('colDireccion');
$calleDireccion = obtenDatos('calleDireccion');
$nintDireccion = obtenDatos('nintDireccion');
$nextDireccion = obtenDatos('nextDireccion');
$cpDireccion = obtenDatos('cpDireccion');
$estado = obtenDatos('estado');
$ciudad = obtenDatos('ciudad');


require_once("modelos/clienteModelo.php");
$resultado = agregarDireccion($colDireccion,$calleDireccion,$nintDireccion,$nextDireccion,$cpDireccion,$idCliente,$ciudad);


if($resultado !== TRUE){
	header("Location: ./formaDireccion.php?colDireccion=$colDireccion&calleDireccion=$calleDireccion&nintDireccion=$nintDireccion&nextDireccion=$nextDireccion&cpDireccion=$cpDireccion&error=$resultado");
	exit();
}

header("Location: ./IniciarSesionCliente.php");
?>