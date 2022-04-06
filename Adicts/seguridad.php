<?php
require_once("librerias/utilerias.php");

$resultado = revisaSesion();
if($resultado !== TRUE){
	header("Location: ./formaPedirPassword.php?username=$usuario&error=$resultado");
	exit();
}
?>