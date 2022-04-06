<?php
require_once("librerias/utilerias.php");

$username= obtenDatos('username');

$resultado = revisaSesionCliente();
if($resultado !== TRUE){
	header("Location: ./IniciarSesionCliente.php?username=$username&error=$resultado");
	exit();
}
?>