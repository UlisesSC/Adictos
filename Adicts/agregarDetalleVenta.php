<?php
	
	require_once("modelos/detalleVentaModelo.php");

	$resultado = agregaDetalleVenta();

	if($resultado!==TRUE){
		header("Location: carrito.php?username=$username&error=$resultado");
	}
	
	header("Location: carrito.php");

?>