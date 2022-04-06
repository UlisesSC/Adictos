<?php
require_once("../modelos/constantes.php");


try {
        // Se crea la conexión
          $conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
          // A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
          $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          //echo "Se conectó";
          // Consulta de de ventas totales por fecha
          $ventasTotales="select sum(totalVenta) as total from venta where fechaVenta>='".$_POST["inicio"]."' and fechaVenta<='".$_POST["fin"]."'";
          $consulta = $conexion->prepare($ventasTotales);
          $consulta->execute();
          $vT = $consulta->fetch();
          $resultado["ventas"]=$vT["total"];

          $v="select date_format(fechaVenta, '%Y') as anio, date_format(fechaVenta, '%m %Y') as mes, date_format(fechaVenta, '%M %Y') as fecha, sum(totalVenta) as total from venta where fechaVenta>='".$_POST["inicio"]."' and fechaVenta<='".$_POST["fin"]."' GROUP BY anio,mes,fecha";
          $consulta1 = $conexion->prepare($v);
          $consulta1->execute();
          $resultado["ticket"]=$consulta1->fetchAll();
          
          echo json_encode($resultado);
       
        
         
        // liberamos la conexión
          $conexion = null;
              
    } catch(PDOException $e) {
          return "Falló la conexión: " . $e->getMessage();
    }

    
    
   
?>