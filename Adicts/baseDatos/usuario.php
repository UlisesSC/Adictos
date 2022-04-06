<?php
require_once("utilerias.php");

$username = obtenDatos('username');
$email = obtenDatos('email');

try {
		// Se crea la conexión
	  	$conexion = new PDO("mysql:host=".SERVIDOR.";dbname=".BASE_DATOS, USUARIO, PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	  	// A la conexión se le ponen atributos diciendole que si no se puede conectar mande una excepción
	  	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  	//echo "Se conectó";
	  	// Se crea un String con la instruccion a ejecutar
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
  		die("Falló la conexión: " . $e->getMessage());
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Usuarios</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
		<script type="text/javascript">
			function borrarUsuario(username=""){
				if (confirm('¿Esta seguro que quiere borrar el usuario '+ username + '?')) {
				  	location.href = "./borrarUsuario.php?username=" + username;
				} 
			}
		</script>
	</head>
	<body>
		<div class="container">
			<div class="jumbotron">
				<h1>Usuarios</h1>
			</div>
			<form method="get">
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="username">Nombre de usuario</label>
						<input type="text" name="username" id="username" placeholder="Escribe el nombre del usuario" class="form-control" maxlength="30" value="<?php if(!empty($username)) echo $username; ?>" >
					</div>

					<div class="col-md-6 form-group">
						<label for="email">Correo electrónico</label>
						<input type="text" name="email" id="email" placeholder="Escribe el correo" class="form-control" maxlength="255" value="<?php if(!empty($email)) echo $email; ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4 form-group">
						<label>&nbsp;</label>
						<input type="submit" value="Buscar" class="btn btn-primary form-control">
					</div>
					<div class="col-md-4"></div>
				</div>
			</form>

			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4 form-group">
					<button class="btn btn-success form-control" onclick="location.href='./formaUsuario.php'">Agregar</button>
				</div>
				<div class="col-md-4"></div>
			</div>

			<div class="table-responsive">
				<table class="table">
						<thead class="thead-dark">
							<tr>
								<th>Nombre de usuario</th>
								<th>Correo electrónico</th>
								<th>Fecha de modificación</th>
								<th colspan="2">Acciones</th>
							</tr>
						</thead>
						<tbody>
				<?php
				foreach ($usuarios as $usuario) {
					echo "
							<tr>
								<td>{$usuario['username']}</td>
								<td>{$usuario['email']}</td>
								<td>{$usuario['fechaModificacion']}</td>
								<td><button class='btn btn-light form-control' onclick=\"location.href='./formaEditarUsuario.php?username={$usuario['username']}'\" >Editar</button></td>
								<td><button class='btn btn-dark form-control' onclick=\"borrarUsuario({$usuario['username']})\">Borrar</button></td>
							</tr>";
				}
				?>
					</tbody>
				</table>
			</div>
	</body>
</html>
