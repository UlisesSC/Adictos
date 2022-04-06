<?php
	define("SERVIDOR","localhost");
	define("BASE_DATOS","adictos");
	define("USUARIO","root");
	define("PASSWORD","");
	define("CLAVE_ENCRIPTAR","Esta es la frase para encriptar");


	function obtenDatos($entrada=""){
		$resultado = "";
		if(!empty($_GET[$entrada]))
			$resultado = $_GET[$entrada];

		else if(!empty($_POST[$entrada]))
			$resultado = $_POST[$entrada];

		// Le quita los espacios al inicio y al final
		$resultado = trim($resultado);
		// Le quita los caracteres de html
		$resultado = htmlspecialchars($resultado);

		return $resultado;
	}

	function subirArchivo($archivoSubido="",$directorio="",$tiposValidos="jpg|png|jpeg|gif",$tamanio=2000000){
		$resultado = new stdClass();
		$resultado->error = true;
		$resultado->ruta = "";
		$resultado->mensaje = "";

		if(empty($_FILES[$archivoSubido])){
			$resultado->mensaje = "El nombre del archivo subido no puede ir vacío";
			return $resultado;
		}

		$archivo = $_FILES[$archivoSubido];	

		if($archivo['size'] > $tamanio){
			$resultado->mensaje = "No se pueden subir archivos mayores a $tamanio, su archivo tiene {$archivo['size']}";
			return $resultado;
		}

		$arregloTiposValidos = explode("|", $tiposValidos);
		$esValido = false;
		foreach ($arregloTiposValidos as $tipo) {
			if(strpos($archivo['type'], $tipo))
				$esValido = true;
		}			

		if(!$esValido){
			$resultado->mensaje = "No se puede subir archivos diferentes a $tiposValidos su tipo de archivo es {$archivo['type']}";
			return $resultado;
		}

		$fecha = new DateTime('NOW');
		$parteUnica = $fecha->format('mdYHisu');

		$nombreActual = $archivo['name'];
		$nombreActual = str_replace(" ", "-", $nombreActual);
		$nuevoNombre = $directorio.$parteUnica."-".$nombreActual;


		if(!move_uploaded_file($archivo['tmp_name'], $nuevoNombre)){
			$resultado->mensaje = "No se pudo subir el archivo {$archivo['name']}";
			return $resultado;
		}

		$resultado->error = false;
		$resultado->ruta = $nuevoNombre;
		$resultado->mensaje = "Archivo subido satisfactoriamente";
		return $resultado;
	}

?>