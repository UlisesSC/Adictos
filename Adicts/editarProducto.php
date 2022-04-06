<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Producto","cambios");

$id = obtenDatos('id');
$nombre = obtenDatos('nombre');
$descripcion = obtenDatos('descripcion');
$precio = obtenDatos('precio');
$categoria = obtenDatos('categoria');


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
$resultado = editarProducto($nombre,$descripcion,$precio,$categoria,$id,$objetoResultado->ruta);

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








