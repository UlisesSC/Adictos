<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Producto","bajas");

//die (print_r($_POST)." ".print_r($_FILES));

$id = obtenDatos('id');

require_once("modelos/productoModelo.php");
$resultado = borrarProducto($id);

if($resultado !== TRUE){
	require_once("vistas/encabezado.php");
	require_once("vistas/menu.php");
	echo menuAdministracion("usuario.php");
	echo muestraError($resultado);
	require_once("vistas/piePagina.php");
	return;
}

header("Location: ./adminProductos.php");
?>








