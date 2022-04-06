<?php
require_once("librerias/utilerias.php");
//require_once("seguridadCliente.php");

$objeto = new stdClass();
$objeto->resultado = false;
$objeto->mensaje = "Error";
$objeto->idProducto = 0;
$objeto->cantidadProducto = 0;
$objeto->precioTotalProducto = 0;
$objeto->precioTotal = 0;
$objeto->numeroProductos = 0;
$objeto->precioTotalPayPal = 0;

/*
$resultado = verificaPermiso("Permisos","cambios",TRUE);
if($resultado !== TRUE){
	$objeto->mensaje = $resultado;
	exit(json_encode($objeto));
}

$usernameModificacion = "";
// El usuario que está logeado
if(isset($_SESSION['username']))
	$usernameModificacion = $_SESSION['username'];
*/

$idProducto = obtenDatos('idProducto');

require_once("modelos/carritoModelo.php");
$objetoResultado = disminuirProducto($idProducto);


if($objetoResultado->resultado !== TRUE){
	$objeto->mensaje = $objetoResultado->mensaje;
	exit(json_encode($objeto));
}


$objeto->resultado = true;
if($objetoResultado->cantidadProducto>0)
	$objeto->mensaje = "Se disminuyó el producto con éxito";
else
	$objeto->mensaje = "La cantidad de este producto en tu carrito es de cero elementos";

$objeto->idProducto = $objetoResultado->idProducto;
$objeto->cantidadProducto = $objetoResultado->cantidadProducto;
$objeto->precioTotalProducto = "$".number_format($objetoResultado->precioTotalProducto,2);
$objeto->precioTotal = "$".number_format($objetoResultado->precioTotal,2);
$objeto->numeroProductos = $objetoResultado->numeroProductos;
$objeto->precioTotalPayPal = $objetoResultado->precioTotal;



exit(json_encode($objeto));


?>