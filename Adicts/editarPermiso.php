<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");

$objeto = new stdClass();
$objeto->resultado = false;
$objeto->mensaje = "Error";
$objeto->username = "";

$resultado = verificaPermiso("Permisos","cambios",TRUE);
if($resultado !== TRUE){
	$objeto->mensaje = $resultado;
	exit(json_encode($objeto));
}

$usernameModificacion = "";
// El usuario que está logeado
if(isset($_SESSION['username']))
	$usernameModificacion = $_SESSION['username'];

$accion = obtenDatos('accion');
$username = obtenDatos('username');
$modulo = obtenDatos('modulo');
$estatus = obtenDatos('estatus');


$objeto->username = $username;

require_once("modelos/permisosModelo.php");
$resultado = editarPermiso($username,$accion,$modulo,$estatus,$usernameModificacion);
if($resultado !== TRUE){
	$objeto->mensaje = $resultado;
	exit(json_encode($objeto));
}

$objeto->resultado = true;
$objeto->mensaje = "Se actualizó el permiso con éxito";

exit(json_encode($objeto));


?>