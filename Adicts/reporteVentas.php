<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Usuario","consultas");

$error = obtenDatos('error');

require_once("modelos/vistasModelo.php");
$ventas = reporteVentas();


require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuAdministracion("reporteVentas.php");

?>
		
		<div class="container">
			<div class="login-form">
				<div class="row">
					<div class="col-lg-12">
                     	 <br>
				         <h2>Reporte de ventas</h2>
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
								<th>ID de venta</th>
								<th>Fecha de venta</th>
								<th>Total de venta</th>
								<th>ID de cliente</th>
							</tr>
						</thead>
						<tbody>
				<?php
				foreach ($ventas as $venta) {
					echo "
							<tr>
								<td>{$venta['idVenta']}</td>
								<td>{$venta['fechaVenta']}</td>
								<td>{$venta['totalVenta']}</td>
								<td>{$venta['idCliente']}</td>
								
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