<?php
	require_once("constantes.php");


	function obtenUsuarios($username="",$email="",$registroActual=0,$numeroRegistrosPorPagina=6,$contar=FALSE){

		$usuarios = array();

		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	//echo "Se conectó";
		  	// Se crea un String con la instruccion a ejecutar
		  	if($contar===TRUE)
		  		$instruccion = 'SELECT COUNT(*) FROM usuario';
		  	else
		  		$instruccion = 'SELECT * FROM usuario';

		  	if($username != "" || $email != ""){
		  		$instruccion .= " WHERE";

		  		$busqueda = "";
		  		
		  		if($username != "")
		  			$busqueda = " username LIKE :username";

		  		if($email != ""){
		  			if($busqueda != "")
		  				$busqueda .= " AND ";
		  			$busqueda .= " email LIKE :email";
		  		}

		  		$instruccion .= $busqueda;
		  	}

		  	if($contar!==TRUE){
		  		$instruccion .= " ORDER BY username LIMIT $numeroRegistrosPorPagina OFFSET $registroActual";
		  	}


		  	//die($instruccion);
		  	// Se crea un objeto para realizar el Query
			$consulta = $conexion->prepare($instruccion);

			if($username != ""){
				$texto = "%$username%";
				$consulta->bindParam('username',$texto);
			}
			if($email != ""){
				$texto = "%$email%";
				$consulta->bindParam('email',$texto);
			}

			$consulta->execute();
			// Se obtienen todos los renglones obtenidos de la ejecución del Query
			$usuarios = $consulta->fetchAll();
			
			// liberamos la conexión
		  	$conexion = null;
		  		
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}

		if($contar === TRUE){
			return $usuarios[0]['COUNT(*)'];
		}
		
		return $usuarios;
	}

	

	function obtenUsuario($username=""){

		if($username == "")
			return "El nombre de usuario no puede ir vacío";

		$usuario = null;

		try {
			// Se crea la conexión
		  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
		  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  	
			$consulta = $conexion->prepare("SELECT * FROM usuario WHERE username = :username");
			// Se ejecuta el query

			$consulta->execute(['username' => $username]);
			
			$usuario = $consulta->fetch();

		  	$conexion = null;
		} catch(PDOException $e) {
	  		return "Falló la conexión: " . $e->getMessage();
		}
		return $usuario;
	}

	function agregarUsuario($username="",$email="",$password1="",$password2=""){
		if(empty($username) || $username == ""){
			return "El nombre de usuario no puede ir vacío";
		}
		if(empty($email) || $email == ""){
			return "El correo electrónico no puede ir vacío";
		}
		if($password1 != $password2){
			return "Las contraseñas no coinciden";
		}
		if(empty($password1) || $password1 == ""){
			return "La contraseña no puede ir vacía";
		}
		if(strlen($password1)<8){
			return "La contraseña tiene que tener al menos 8 caracteres";
		}

		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	
				$consulta = $conexion->prepare("INSERT INTO usuario (username,email,password,fechaModificacion) VALUES (:username,:email,AES_ENCRYPT('$password1','".CLAVE_ENCRIPTAR."'),:fechaModificacion)");
				// Se ejecuta el query
				$fechaModificacion = date('Y-m-d H:i:s');

				$consulta->execute(['username' => $username,
									'email' => $email,
									'fechaModificacion' => $fechaModificacion,
								  ]);
				$instruccion = "SELECT modulo FROM modulo";

				$consulta = $conexion->prepare($instruccion);

				$consulta->execute();

				$modulos = $consulta->fetchAll();

				foreach ($modulos as $modulo) {
					$consulta = $conexion->prepare("INSERT INTO permisos (username,modulo,usernameModificacion,fechaModificacion) VALUES (:username,:modulo,'',:fechaModificacion)");
					// Se ejecuta el query
					$fechaModificacion = date('Y-m-d H:i:s');

					$consulta->execute(['username' => $username,
										'modulo' => $modulo['modulo'],
										'fechaModificacion' => $fechaModificacion,
									  ]);
				}

			  	$conexion = null;
			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}

		return TRUE;
	}

	function borrarUsuario($username=""){
		if($username == "")
			return "El nombre de usuario no puede ir vacío";

		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$consulta = $conexion->prepare("DELETE FROM usuario WHERE username = :username");
				// Se ejecuta el query
				$consulta->execute(['username' => $username]);
			  	$conexion = null;

			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}
		return TRUE;
	}

	function editarUsuario($usernameAnterior="",$username="",$email="",$password1="",$password2=""){

		if(empty($usernameAnterior) || $usernameAnterior == ""){
			return "El nombre de usuario anterior no puede ir vacío";
		}
		if(empty($username) || $username == ""){
			return "El nombre de usuario no puede ir vacío";
		}
		if(empty($email) || $email == ""){
			return "El correo electrónico no puede ir vacío";
		}
		if($password1 != $password2){
			return "Las contraseñas no coinciden";
		}
		if($password1 != "" && strlen($password1)<8){
			return "La contraseña tiene que tener al menos 8 caracteres";
		}

		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			  	$instruccion = "UPDATE usuario SET username = :username, email = :email";

			  	if(!empty($password1) && $password1 != ""){
			  		$instruccion .= ", password = AES_ENCRYPT('$password1','".CLAVE_ENCRIPTAR."')";
			  	}

			  	$instruccion .= ", fechaModificacion = :fechaModificacion WHERE username = :usernameAnterior";


			  	$consulta = $conexion->prepare($instruccion);
				
				$fechaModificacion = date('Y-m-d H:i:s');

				$consulta->execute(['username' => $username,
									'email' => $email,
									'fechaModificacion' => $fechaModificacion,
									'usernameAnterior' => $usernameAnterior
								  ]);
			  	$conexion = null;
			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}

		return TRUE;
	}

function respaldarUsuarios(){
		try {
				// Se crea la conexión
			  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
			  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			  	$backup = "backup_Usuario";

			  	$tabla = array("usuario");

			  	$mysqli = new mysqli(SERVIDOR,USUARIO,PASSWORD,BASE_DATOS);
		        $mysqli->select_db(BASE_DATOS);
		        $mysqli->query("SET NAMES 'utf8'");

		        $consultaTablas    = $mysqli->query('SHOW TABLES');
		        while($row = $consultaTablas->fetch_row())
		        {
		            $tablas[] = $row[0];
		        }
		        if($tabla !== false)
		        {
		            $tablas = array_intersect( $tablas, $tabla);
		        }
		        foreach($tablas as $t)
		        {
		            $result         =   $mysqli->query('SELECT * FROM '.$t);
		            $fields_amount  =   $result->field_count;
		            $rows_num=$mysqli->affected_rows;
		            $res            =   $mysqli->query('SHOW CREATE TABLE '.$t);
		            $TableMLine     =   $res->fetch_row();
		            $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

		            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0)
		            {
		                while($row = $result->fetch_row())
		                { //when started (and every after 100 command cycle):
		                    if ($st_counter%100 == 0 || $st_counter == 0 )
		                    {
		                            $content .= "\nINSERT INTO ".$table." VALUES";
		                    }
		                    $content .= "\n(";
		                    for($j=0; $j<$fields_amount; $j++)
		                    {
		                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) );
		                        if (isset($row[$j]))
		                        {
		                            $content .= '"'.$row[$j].'"' ;
		                        }
		                        else
		                        {
		                            $content .= '""';
		                        }
		                        if ($j<($fields_amount-1))
		                        {
		                                $content.= ',';
		                        }
		                    }
		                    $content .=")";
		                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
		                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num)
		                    {
		                        $content .= ";";
		                    }
		                    else
		                    {
		                        $content .= ",";
		                    }
		                    $st_counter=$st_counter+1;
		                }
		            } $content .="\n\n\n";
		        }
		        $fecha = date("Ymd-Hsi");
		        $backup = $backup ? $backup : BASE_DATOS."_".$fecha.".sql";
		        header('Content-Type: application/octet-stream');
		        header("Content-Transfer-Encoding: Binary");
		        header("Content-disposition: attachment; filename=\"".$backup."\"");
		        echo $content; exit;

			  	

			  	//die(print_r($resultado));

			} catch(PDOException $e) {
		  		return "Falló la conexión: " . $e->getMessage();
			}
		return TRUE;
	}

?>


?>











