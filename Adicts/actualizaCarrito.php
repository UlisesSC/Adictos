<?php
require_once("librerias/utilerias.php");


$objeto = new stdClass();
$objeto->resultado = false;
$objeto->mensaje = "Error";
$objeto->idProducto = 0;
$objeto->cantidadProducto = 0;
$objeto->precioTotalProducto = 0;
$objeto->precioTotal = 0;
$objeto->numeroProductos = 0;
$objeto->precioTotalPayPal = 0;


$idProducto = obtenDatos('idProducto');

require_once("modelos/carritoModelo.php");
$objetoResultado = agregarProducto($idProducto);


if($objetoResultado->resultado !== TRUE){
	$objeto->mensaje = $objetoResultado->mensaje;
	exit(json_encode($objeto));
}


$objeto->resultado = true;
$objeto->mensaje = "Se agregó el producto con éxito";

$objeto->idProducto = $objetoResultado->idProducto;
$objeto->cantidadProducto = $objetoResultado->cantidadProducto;
$objeto->precioTotalProducto = "$".number_format($objetoResultado->precioTotalProducto,2);
$objeto->precioTotal = "$".number_format($objetoResultado->precioTotal,2);
$objeto->numeroProductos = $objetoResultado->numeroProductos;
$objeto->precioTotalPayPal = $objetoResultado->precioTotal;

exit(json_encode($objeto));

?>