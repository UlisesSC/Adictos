<?php
require_once("librerias/utilerias.php");
//require_once("seguridadCliente.php");

session_start();
if(!empty($_SESSION['carrito'])){
$productos = $_SESSION['carrito']['productos'];
}

if(!empty($_SESSION['cliente'])){	

$username = $_SESSION['cliente'];

require_once("modelos/clienteModelo.php");
$cliente = obtenDetallesCliente($username);
$idClientes = ($cliente['idCliente']);
} 


foreach ($productos as $producto) { 
	            $idProducto = $producto['id'];
	            $precioVenta = $producto['precio'];
                $cantidad = $producto['cantidad'];
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