<?php
require_once("librerias/utilerias.php");
require_once("seguridadCliente.php");

//die (print_r($_POST)." ".print_r($_FILES));

$username = obtenDatos('username');

require_once("modelos/clienteModelo.php");
$cliente = obtenDetallesCliente($username);
$id = ("{$cliente['idCliente']}");
$resultado = borrarCliente($id);


if($resultado !== TRUE){
	header("Location: ./confirmarBorrarCliente.php?username=$username&error=$resultado");
	exit();
}

header("Location: ./iniciarSesionCliente.php");
?>