<?php
require_once("librerias/utilerias.php");
//require_once("seguridadCliente.php");

require_once("modelos/carritoModelo.php");
vaciarCarrito();


$objeto = new stdClass();
$objeto->resultado = true;
$objeto->mensaje = "Se vació el carrito con éxito";

exit(json_encode($objeto));
?>