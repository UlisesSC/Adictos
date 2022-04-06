<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Usuario","consultas");


$username = obtenDatos('username');
$email = obtenDatos('email');
$error = obtenDatos('error');
$registroActual = obtenDatos('registroActual');
$numeroRegistrosPorPagina = obtenDatos('numeroRegistrosPorPagina');

if(!is_numeric($registroActual))
      $registroActual=0;
if(!is_numeric($numeroRegistrosPorPagina))
      $numeroRegistrosPorPagina = 10;

require_once("modelos/usuarioModelo.php");
$usuarios = obtenUsuarios($username,$email,$registroActual,$numeroRegistrosPorPagina);
$total = obtenUsuarios($username,$email,$registroActual,$numeroRegistrosPorPagina,TRUE);
$consulta = "&username=$username&email=$email&error=$error";
$linksPaginas = paginacion("./usuario.php",$registroActual,$numeroRegistrosPorPagina,$consulta,$total);

if(!is_array($usuarios)){
  require_once("vistas/encabezado.php");
  require_once("vistas/menu.php");
  echo menuAdministracion("usuarios.php");
  echo muestraError($usuarios);
  require_once("vistas/piePagina.php");
  return;
}

require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuAdministracion("usuario.php");

?>
		<div class="container">
			<h1>Usuarios</h1>
			<?php
				if(isset($error) && $error!=""){
					echo "
					<div class='row'>
						<div class='col-md-12 form-group'>	
							<div class='alert alert-danger' role='alert'>
					          $error
					        </div>
						</div>
					</div>";

				}
			?>
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
								<th>tipo de empleado</th>
								<th>Fecha de modificación</th>
								<th colspan="3">Acciones</th>
							</tr>
						</thead>
						<tbody>
				<?php
				foreach ($usuarios as $usuario) {
					echo "
							<tr>
								<td>{$usuario['username']}</td>
								<td>{$usuario['email']}</td>
								<td>{$usuario['tipoEmpleado']}</td>
								<td>{$usuario['fechaModificacion']}</td>
								<td><button class='btn btn-light form-control' onclick=\"location.href='./formaEditarPermisos.php?username={$usuario['username']}'\" >Permisos</button></td>
								<td><button class='btn btn-light form-control' onclick=\"location.href='./formaEditarUsuario.php?username={$usuario['username']}'\" >Editar</button></td>
								<td><button class='btn btn-dark form-control' onclick=\"borrarUsuario('{$usuario['username']}')\">Borrar</button></td>
							</tr>";
				}
				?>
					</tbody>
				</table>
				<div class="col-md-2 form-group">
				<button type="button" class="btn btn-outline-dark form-control" onclick="location.href='./RespaldarUsuarios.php'">RESPALDAR</button>
			</div>
			</div>

			<!-- Pagination -->
  			<?php echo $linksPaginas; ?>

		</div>
		<!-- container -->

		<script type="text/javascript">
			function borrarUsuario(username=""){
				if (confirm('¿Esta seguro que quiere borrar el usuario '+ username + '?')) {
				  	location.href = "./borrarUsuario.php?username=" + username;
				} 
			}
		</script>

<?php
require_once("vistas/piePagina.php");
?>
