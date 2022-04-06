<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Modulo","consultas");


$modulo = obtenDatos('modulo');
$habilitado = obtenDatos('habilitado');
$error = obtenDatos('error');
$registroActual = obtenDatos('registroActual');
$numeroRegistrosPorPagina = obtenDatos('numeroRegistrosPorPagina');

if(!is_numeric($registroActual))
      $registroActual=0;
if(!is_numeric($numeroRegistrosPorPagina))
      $numeroRegistrosPorPagina = 10;

require_once("modelos/moduloModelo.php");
$modulos = obtenModulos($modulo,$habilitado,$registroActual,$numeroRegistrosPorPagina);
$total = obtenModulos($modulo,$habilitado,$registroActual,$numeroRegistrosPorPagina,TRUE);
$consulta = "&modulo=$modulo&habilitado=$habilitado&error=$error";
$linksPaginas = paginacion("./modulo.php",$registroActual,$numeroRegistrosPorPagina,$consulta,$total);

if(!is_array($modulos)){
  require_once("vistas/encabezado.php");
  require_once("vistas/menu.php");
  echo menuAdministracion("modulo.php");
  echo muestraError($modulos);
  require_once("vistas/piePagina.php");
  return;
}

require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuAdministracion("modulo.php");

?>
		<div class="container">
			<h1>Módulos</h1>
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
						<label for="modulo">Nombre del módulo</label>
						<input type="text" name="modulo" id="modulo" placeholder="Escribe el nombre del módulo" class="form-control" maxlength="45" value="<?php if(!empty($modulo)) echo $modulo; ?>" >
					</div>

					<div class="col-md-6 form-group">
						<label for="habilitado">habilitado</label>
						<select name="habilitado" class="form-control">
							<option value="">Seleccione una opción</option>
							<option value="0" <?php echo (($habilitado == "0") ? "selected" : ""); ?>>Deshabilitado</option>
							<option value="1" <?php echo (($habilitado == "1") ? "selected" : ""); ?>>Habilitado</option>
						</select>
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
					<button class="btn btn-success form-control" onclick="location.href='./formaModulo.php'">Agregar</button>
				</div>
				<div class="col-md-4"></div>
			</div>

			<div class="table-responsive">
				<table class="table">
						<thead class="thead-dark">
							<tr>
								<th>Nombre del módulo</th>
								<th>Habilitado</th>
								<th>Fecha de creación</th>
								<th colspan="2">Acciones</th>
							</tr>
						</thead>
						<tbody>
				<?php
				foreach ($modulos as $modulo) {
					echo "
							<tr>
								<td>{$modulo['modulo']}</td>
								<td>{$modulo['habilitado']}</td>
								<td>{$modulo['fechaCreacion']}</td>
								<td><button class='btn btn-light form-control' onclick=\"location.href='./formaEditarModulo.php?modulo={$modulo['modulo']}'\" >Editar</button></td>
								<td><button class='btn btn-dark form-control' onclick=\"borrarModulo('{$modulo['modulo']}')\">Borrar</button></td>
							</tr>";
				}
				?>
					</tbody>
				</table>
			</div>

			<!-- Pagination -->
  			<?php echo $linksPaginas; ?>

		</div>
		<!-- container -->

		<script type="text/javascript">
			function borrarModulo(modulo=""){
				if (confirm('¿Esta seguro que quiere borrar el módulo '+ modulo + '?')) {
				  	location.href = "./borrarModulo.php?modulo=" + modulo;
				} 
			}
		</script>

<?php
require_once("vistas/piePagina.php");
?>




















