<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Usuario","consultas");

$error = obtenDatos('error');

require_once("modelos/clienteModelo.php");
$clientes = obtenClientes();

$registroActual = obtenDatos('registroActual');
$numeroRegistrosPorPagina = obtenDatos('numeroRegistrosPorPagina');

if(!is_numeric($registroActual))
      $registroActual=0;
if(!is_numeric($numeroRegistrosPorPagina))
      $numeroRegistrosPorPagina = 6;


if(!is_array($clientes)){
  require_once("vistas/Encabezado.php");
  require_once("vistas/menu.php");
  echo menuAdministracion("usuarioCliente.php");
  echo muestraError($clientes);
  require_once("vistas/piePagina.php");
  return;
}

require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuAdministracion("usuario.php");

?>
		
		<div class="container">
			<div class="login-form">
				<div class="row">
					<div class="col-lg-12">
                     	 <br>
				         <h2>Clientes</h2>
			        </div>
			    </div>
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


			<div class="table-responsive">
				<table class="table">
						<thead class="thead-dark">
							<tr>
								<th>Nombre de cliente</th>
								<th>Primer apellido</th>
								<th>Segundo apellido</th>
								<th>Telefono</th>
								<th>Usuario</th>
							</tr>
						</thead>
						<tbody>
				<?php
				foreach ($clientes as $cliente) {
					echo "
							<tr>
								<td>{$cliente['nombre']}</td>
								<td>{$cliente['apellidoPaterno']}</td>
								<td>{$cliente['apellidoMaterno']}</td>
								<td>{$cliente['telCliente']}</td>
								<td>{$cliente['username']}</td>
								
							</tr>";
				}
				?>
					</tbody>
				</table>
			</div>
		</div>

		<!-- container -->
	</div>

<?php
require_once("vistas/piePagina.php");
?>