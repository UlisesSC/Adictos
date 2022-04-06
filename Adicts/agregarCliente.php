<?php
require_once("librerias/utilerias.php");

//die(print_r($_POST)." ".print_r($_FILES));

$nombre = obtenDatos('nombre');
$apellidoPaterno = obtenDatos('apellidoPaterno');
$apellidoMaterno = obtenDatos('apellidoMaterno');
$telCliente = obtenDatos('telCliente');
$rfcCliente = obtenDatos('rfcCliente');
$email = obtenDatos('email');
$username = obtenDatos('username');
$password1 = obtenDatos('password1');
$password2 = obtenDatos('password2');


require_once("modelos/clienteModelo.php");
$resultado = agregarCliente($nombre,$apellidoPaterno,$apellidoMaterno,$telCliente,$rfcCliente,$email,$username,$password1,$password2);

if($resultado !== TRUE){
	header("Location: ./register.php?nombre=$nombre&apellidoPaterno=$apellidoPaterno&apellidoMaterno=$apellidoMaterno&telCliente=$telCliente&rfcCliente=$rfcCliente&email=$email&username=$username&error=$resultado");
		exit();
}
header("Location: ./formaDireccion.php?username=$username");
?>