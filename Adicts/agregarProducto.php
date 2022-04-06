<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Producto","altas");

//die(print_r($_POST)." ".print_r($_FILES));

$nombre = obtenDatos('nombre');
$descripcion = obtenDatos('descripcion');
$costo = obtenDatos('costo');
$categoria = obtenDatos('categoria');
$stock = obtenDatos('stock');


$objetoResultado = subirArchivo("urlImagen","./imagenes/");

if($objetoResultado->error === true){
	require_once("vistas/encabezado.php");
	require_once("vistas/menu.php");
	echo menuAdministracion("productos.php");
	echo muestraError($objetoResultado->mensaje);
	require_once("vistas/piePagina.php");
	return;
}

require_once("modelos/productoModelo.php");
$resultado = subirProducto($nombre,$descripcion,$costo,$categoria,$stock,$objetoResultado->ruta);

if($resultado !== TRUE){
	require_once("vistas/encabezado.php");
	require_once("vistas/menu.php");
	echo menuAdministracion("productos.php");
	echo muestraError($resultado);
	require_once("vistas/piePagina.php");
	return;
}

header("Location: ./adminProductos.php");
?>
















