<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Usuario","consultas");

$error = obtenDatos('error');

require_once("modelos/subconsultasModelo.php");
$porTerminar = productoPorTerminar();

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
				         <h2>Produtos</h2>
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
								<th>Descripción del producto</th>
								<th>Stock</th>
							</tr>
						</thead>
						<tbody>
				<?php
				foreach ($porTerminar as $product) {
					echo "
							<tr>
							    <td>{$product['id']}</td>
								<td>{$product['descripcion']}</td>
								<td>{$product['stock']}</td>
								
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