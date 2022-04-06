<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Usuario","consultas");

$error = obtenDatos('error');

require_once("modelos/subconsultasModelo.php");
$noVendidos = productoNoVendidos();

$registroActual = obtenDatos('registroActual');
$numeroRegistrosPorPagina = obtenDatos('numeroRegistrosPorPagina');

require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuAdministracion("usuario.php");

?>
		
		<div class="container">
			<div class="login-form">
				<div class="row">
					<div class="col-lg-12">
                     	 <br>
				         <h2>Produtos no vendidos</h2>
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
								<th>Id del producto</th>
								<th>Nombre del producto</th>
								<th>Descripcion</th>
							</tr>
						</thead>
						<tbody>
				<?php
				foreach ($noVendidos as $producto) {
					echo "
							<tr>
							    <td>{$producto['id']}</td>
								<td>{$producto['nombre']}</td>
								<td>{$producto['descripcion']}</td>
								
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