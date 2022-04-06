<?php
	require_once("librerias/utilerias.php");
	require_once("modelos/constantes.php");
	
//var_dump($_SESSION['carrito']);
	//var_dump($_SESSION['carrito']['precioTotal']);

	/* function obtenDetalleVentas($n_vta=""){
		$detalles = array();
		if(empty($n_vta) || $n_vta==""){
			return "venta no puede ir vacio";
		}
		try{
			$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


		  	$instruccion = $conexion->prepare('SELECT * FROM detalle WHERE nVenta = ?');

		  	$instruccion->bindParam(1, $n_vta);

		  	$instruccion->execute();

		  	$detalles = $instruccion->fetchAll();

		  	$conexion = null;

		}catch(PDOException $e){
			return "Falló la conexión: " . $e->getMessage();
		}
		return $detalles;
	}*/
	function agregaDetalleVenta(){


        try{
        		session_start();
			    if(!empty($_SESSION['carrito'])&&!empty($_SESSION['username'])){
					$prod = $_SESSION['carrito']['productos'];
					$clie = $_SESSION['cliente'];
					$cantidadTotal = $_SESSION['carrito']['cantidad'];
				}
          		
          		$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			  	$fechaVenta = date('Y-m-d H:i:s');

			  	$totalVenta = 0;

			  	$cantidad = $cantidadTotal;

			  	$cliente = $clie;

			  	$instruccion = 'INSERT INTO venta (fechaVenta, totalVenta, idCliente) VALUES (?,?,?)';

			  	$ventas = $conexion->prepare($instruccion);

			  	$ventas->bindParam(1,$fechaVenta);
			  	$ventas->bindParam(2,$totalVenta);
			  	$ventas->bindParam(3,$cliente);

			  	if($ventas->execute()){
			  		
			  		
			  		for($i = 0; $i<count($prod);$i++){	

			  			$carrito = $prod[$i];

						$idProducto = $carrito['id'];	

						$cantidad = $carrito['cantidad'];

						$precio = $carrito['precio'];

						$instruccion = 'SELECT idInventario, idProducto FROM inventario WHERE idProducto = ?';

						$inventarios = $conexion->prepare($instruccion);

						$inventarios->bindParam(1,$idProducto);

						$inventarios->execute(); 

						while($row = $inventarios->fetch()){
							$idInv = $row['idInventario'];
						}

						$instruccion = 'SELECT MAX(idVenta) as maximoVentas from venta';

						$idVentas = $conexion->prepare($instruccion);

						$idVentas->execute();

						while($row = $idVentas->fetch()){
							$nVenta = $row['maximoVentas'];
						}

						$precioTotal = $precio * $cantidad;
						/*$instruccion = 'INSERT INTO ventaDetalle(username, idProd, n_vta, cantidad, idAlm, precio, subtotal) VALUES (:cliente,:idProducto,:nVenta,:cantidad,:idAlm,:precio,:precioTotal)';*/
						

						$detalleVta = 'INSERT INTO detalleVenta(cantidad, precioVenta,idVenta,idInventario,subtotal) VALUES (?,?,?,?,?)';

						$detalle = $conexion->prepare($detalleVta);

						$detalle->bindParam(1, $cantidad);
                        $detalle->bindParam(2, $precio);
                        $detalle->bindParam(3, $nVenta);
						$detalle->bindParam(4, $idInv);
						$detalle->bindParam(5, $precioTotal);
						
						

						$detalle->execute();
						
					}
			  	}

			  	$conexion = null;
        }catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
		}
		return TRUE;
	}

	

?>

