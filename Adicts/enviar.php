<?php
 $destino = "bunker.imp@gmail.com";
 $nombre = $_POST["nombre"];
 $email = $_POST["email"];
 $service = $_POST["service"];
 $mensaje = $_POST["message"];
 $conteido ="nombre: " . $nombre . "\nEmail: " . $email . "\nService: " . $service . "\nMessage: " . $mensaje;
 mail($destino, "Contacto", $conteido);
 header("location:gracias.html");
?>
