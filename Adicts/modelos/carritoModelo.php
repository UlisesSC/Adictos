<?php
	require_once("constantes.php");

	function agregarProducto($idProducto=""){

		session_start();

		$objeto = new stdClass();
		$objeto->resultado = false;
		$objeto->mensaje = "Error";
		$objeto->idProducto = 0;
		$objeto->cantidadProducto = 0;
		$objeto->precioTotalProducto = 0;
		$objeto->precioTotal = 0;
		$objeto->numeroProductos = 0;

		$cantidadProducto = 0;
		$precioTotalProducto = 0;

		if(empty($idProducto) || $idProducto == ""){
			$objeto->mensaje = "El id del producto no puede ir vacío";
			return $objeto;
		}

		$producto = null;
		$Inventario = "";
		$existencia = 0;

		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	// Se crea un String con la instruccion a ejecutar
		  	$consulta = $conexion->prepare('SELECT stock FROM inventario WHERE idProducto=:idProducto');
		  	$consulta->execute([
								'idProducto' => $idProducto
								]);
			
            $Inventario = $consulta->fetch();
            $existencia = $Inventario['stock'];
			if($existencia > 0 && $_SESSION['carrito']['cantidad']<$existencia){

		  	$instruccion = 'SELECT *, (SELECT nombre FROM categoria WHERE idCategoria=categoria) as nombreCategoria FROM producto WHERE id=:idProducto';
		  	

		  	//die($instruccion);
		  	// Se crea un objeto para realizar el Query
			$consulta = $conexion->prepare($instruccion);

			$consulta->execute([
								'idProducto' => $idProducto
								]);
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$producto = $consulta->fetch();
			//print_r($productos);
		  	$conexion = null;
		  }
		  		
		} catch(PDOException $e) {
	  		$objeto->mensaje = "Falló la conexión: " . $e->getMessage();
	  		return $objeto;
		}

		if($producto == null){
			$objeto->mensaje = "¡Vaya! No se pudo obtener el producto o no hay inventario disponible";
			return $objeto;
		}
		
		if(empty($_SESSION['carrito']) || count($_SESSION['carrito'])==0){
			$_SESSION['carrito']['cantidad'] = 1;
			$_SESSION['carrito']['precioTotal'] = $producto['precio'];

			$_SESSION['carrito']['productos'] = array();
			$_SESSION['carrito']['productos'][0]['id'] = $producto['id'];
			$_SESSION['carrito']['productos'][0]['nombre'] = $producto['nombre'];
			$_SESSION['carrito']['productos'][0]['descripcion'] = $producto['descripcion'];
			$_SESSION['carrito']['productos'][0]['precio'] = $producto['precio'];
			$_SESSION['carrito']['productos'][0]['categoria'] = $producto['categoria'];
			$_SESSION['carrito']['productos'][0]['urlImagen'] = $producto['urlImagen'];
			$_SESSION['carrito']['productos'][0]['nombreCategoria'] = $producto['nombreCategoria'];
			$_SESSION['carrito']['productos'][0]['cantidad'] = 1;


			$cantidadProducto = $_SESSION['carrito']['productos'][0]['cantidad'];
			$precioTotalProducto = $producto['precio'] * $cantidadProducto;
		}
		else{

			$_SESSION['carrito']['cantidad'] ++;
			$_SESSION['carrito']['precioTotal'] = $_SESSION['carrito']['precioTotal'] + $producto['precio'];

			// buscamos si ya existe el prodcuto en el carrito
			$posicion = -1;
			$productos = $_SESSION['carrito']['productos'];
			for ($i=0; $i < count($productos); $i++) { 
				$productoLeido = $productos[$i];
				if($producto['id'] == $productoLeido['id']){
					$posicion = $i;
					break;
				}
			}

			// Ya existe el producto
			if($posicion>=0){
				$_SESSION['carrito']['productos'][$posicion]['cantidad'] ++;

				$cantidadProducto = $_SESSION['carrito']['productos'][$posicion]['cantidad'];
				$precioTotalProducto = $producto['precio'] * $cantidadProducto;
			}
			else{
				// Es un nuevo producto y se inserta al carrito
				$posicionInsertar = count($productos);
				$_SESSION['carrito']['productos'][$posicionInsertar]['id'] = $producto['id'];
				$_SESSION['carrito']['productos'][$posicionInsertar]['nombre'] = $producto['nombre'];
				$_SESSION['carrito']['productos'][$posicionInsertar]['descripcion'] = $producto['descripcion'];
				$_SESSION['carrito']['productos'][$posicionInsertar]['precio'] = $producto['precio'];
				$_SESSION['carrito']['productos'][$posicionInsertar]['categoria'] = $producto['categoria'];
				$_SESSION['carrito']['productos'][$posicionInsertar]['urlImagen'] = $producto['urlImagen'];
				$_SESSION['carrito']['productos'][$posicionInsertar]['nombreCategoria'] = $producto['nombreCategoria'];
				$_SESSION['carrito']['productos'][$posicionInsertar]['cantidad'] = 1;

				$cantidadProducto = $_SESSION['carrito']['productos'][$posicionInsertar]['cantidad'];
				$precioTotalProducto = $producto['precio'] * $cantidadProducto;
			}
		}

		$objeto->resultado = true;
		$objeto->mensaje = "";
		$objeto->idProducto = $idProducto;
		$objeto->cantidadProducto = $cantidadProducto;
		$objeto->precioTotalProducto = $precioTotalProducto;
		$objeto->precioTotal = $_SESSION['carrito']['precioTotal'];
		$objeto->numeroProductos = $_SESSION['carrito']['cantidad'];
		return $objeto;
	}


	function disminuirProducto($idProducto=""){

		session_start();

		$objeto = new stdClass();
		$objeto->resultado = false;
		$objeto->mensaje = "Error";
		$objeto->idProducto = 0;
		$objeto->cantidadProducto = 0;
		$objeto->precioTotalProducto = 0;
		$objeto->precioTotal = 0;
		$objeto->numeroProductos = 0;

		$cantidadProducto = 0;
		$precioTotalProducto = 0;

		if(empty($idProducto) || $idProducto == ""){
			$objeto->mensaje = "El id del producto no puede ir vacío";
			return $objeto;
		}

		$producto = null;

		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	// Se crea un String con la instruccion a ejecutar

		  	$instruccion = 'SELECT *, (SELECT nombre FROM categoria WHERE idCategoria=categoria) as nombreCategoria FROM producto WHERE id=:idProducto';
		  	

		  	//die($instruccion);
		  	// Se crea un objeto para realizar el Query
			$consulta = $conexion->prepare($instruccion);

			$consulta->execute([
								'idProducto' => $idProducto
								]);
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$producto = $consulta->fetch();
			//print_r($productos);
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		$objeto->mensaje = "Falló la conexión: " . $e->getMessage();
	  		return $objeto;
		}

		if($producto == null){
			$objeto->mensaje = "No se pudo obtener el producto";
			return $objeto;
		}
		
		if(empty($_SESSION['carrito']) || count($_SESSION['carrito'])==0){
			$_SESSION['carrito']['cantidad'] = 0;
			$_SESSION['carrito']['precioTotal'] = 0;
			$_SESSION['carrito']['productos'] = array();
			
			$cantidadProducto = 0;
			$precioTotalProducto = 0;
		}
		else{
			
			// buscamos si ya existe el prodcuto en el carrito
			$posicion = -1;
			$productos = $_SESSION['carrito']['productos'];
			for ($i=0; $i < count($productos); $i++) { 
				$productoLeido = $productos[$i];
				if($producto['id'] == $productoLeido['id']){
					$posicion = $i;
					break;
				}
			}

			// Ya existe el producto
			if($posicion>=0 && $_SESSION['carrito']['productos'][$posicion]['cantidad']>0){

				$_SESSION['carrito']['cantidad'] --;
				$_SESSION['carrito']['precioTotal'] = $_SESSION['carrito']['precioTotal'] - $producto['precio'];
				$_SESSION['carrito']['productos'][$posicion]['cantidad'] --;

				$cantidadProducto = $_SESSION['carrito']['productos'][$posicion]['cantidad'];
				$precioTotalProducto = $producto['precio'] * $cantidadProducto;

				// Si ese producto ya no tiene elemento se quita del carrito
				if($cantidadProducto == 0){
					array_splice($_SESSION['carrito']['productos'],$posicion,1);
				}
			}
			
		}

		$objeto->resultado = true;
		$objeto->mensaje = "";
		$objeto->idProducto = $idProducto;
		$objeto->cantidadProducto = $cantidadProducto;
		$objeto->precioTotalProducto = $precioTotalProducto;
		$objeto->precioTotal = $_SESSION['carrito']['precioTotal'];
		$objeto->numeroProductos = $_SESSION['carrito']['cantidad'];

		// Si ya no tiene ningún producto el carrito, entonces se borra
		if($_SESSION['carrito']['cantidad'] == 0){
			$_SESSION['carrito'] = array();
		}
				
		return $objeto;
	}


	function vaciarCarrito(){
		if(!empty($_SESSION['carrito']))
			$_SESSION['carrito'] = array();
		return TRUE;;
	}

   /*function actualizaStock($cantidad="",$idProducto="",$precioVenta="",$idCliente=""){
		if(empty($cantidad) || $cantidad == ""){
			return "La cantidad del producto no puede ir vacío";
		}

		if(empty($idProducto) || $idProducto == ""){
			return "El id del producto no puede ir vacío";
		}
		
		if(empty($precioVenta) || $precioVenta == ""){
			return "El precio del producto no puede ir vacío";
		}
		
		if(empty($idCliente) || $idCliente == ""){
			return "debes iniciar sesion";
		}

		$Inventario="";
		$cveInventario=0;

		try {
			$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //CREACION DE LA VENTA
		  	$consulta = $conexion->prepare("INSERT INTO venta (fechaVenta,idCliente) VALUES (:fechaVenta,:idCliente)");
            $fechaVenta = date('Y-m-d H:i:s');
            $consulta->execute(['fechaVenta' => $fechaVenta,
            	                'idCliente' => $idCliente
                               ]);

            //SELECCION DEL NUMERO DE VENTA
		  	$consulta = $conexion->prepare("SELECT idVenta FROM venta WHERE fechaVenta = :fechaVenta");
            $consulta->execute(['fechaVenta' => $fechaVenta]);
            $noVenta = $consulta->fetch();
            $idVenta = $noVenta['idVenta'];

            //CONSULTA DEL ID DE INVENTARIO
            $consulta = $conexion->prepare("SELECT idInventario FROM inventario WHERE idProducto = :idProducto");
            $consulta->execute(['idProducto'=>$idProducto]);
            $Inventario = $consulta->fetch();
            $cveInventario = $Inventario['idInventario'];

            //LLENADO DEL DETALLE DE VENTA
		    $consulta = $conexion->prepare("INSERT INTO detalleVenta (cantidad,precioVenta,idVenta,idInventario) VALUES                                                (:cantidad,:precioVenta,:idVenta,:idInventario)");
		    $consulta->execute(['cantidad' => $cantidad,
		    	                'precioVenta' => $precioVenta,
								'idVenta' => $idVenta,
								'idInventario' => $cveInventario
							  ]);

		  /*  //FACTURA
           $consulta = $conexion->prepare("INSERT INTO factura fechaFactura,idCliente,idVenta) VALUES (:fechaVenta,:idCliente,:idVenta)");
            $consulta->execute([
            	                'fechaVenta' => $fechaVenta
            	                'idCliente' => $idCliente,
            	                'idVenta' => $idVenta,
                               ]); */
            
			/* $conexion = null;
			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}
		return TRUE;
	} */
	

?>