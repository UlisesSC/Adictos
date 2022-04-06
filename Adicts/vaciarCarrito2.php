<?php
require_once("librerias/utilerias.php");
//require_once("seguridadCliente.php");



session_start();
if(!empty($_SESSION['carrito'])){
$verProducto = $_SESSION['carrito']['productos'];
}

if(!empty($_SESSION['cliente'])){	

$username = $_SESSION['cliente'];

require_once("modelos/clienteModelo.php");
$cliente = obtenDetallesCliente($username);
$idCliente = ($cliente['idCliente']);
}


foreach ($verProducto as $productos) { 
	            $idProducto = $productos['id'];
                $cantidad = $productos['cantidad'];
                $precioVenta = $productos['precio'];
                require_once("modelos/carritoModelo.php");
                actualizaStock($cantidad,$idProducto,$precioVenta,$idCliente);
				}


require_once("modelos/carritoModelo.php");
vaciarCarrito();


$objeto = new stdClass();
$objeto->resultado = true;
$objeto->mensaje = "Se vació el carrito con éxito";

exit(json_encode($objeto));


?>