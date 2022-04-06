<?php
require_once("librerias/utilerias.php");
require_once("seguridad.php");
verificaPermiso("Permisos","consultas");

//die(print_r($_POST)." ".print_r($_FILES));

$username = obtenDatos('username');
$error = obtenDatos('error');

require_once("modelos/permisosModelo.php");
$registros = obtenPermisos($username);

if(!is_array($registros)){
	require_once("vistas/encabezado.php");
	require_once("vistas/menu.php");
	echo menuAdministracion("usuario.php");
	echo muestraError($registros);
	require_once("vistas/piePagina.php");
	return;
}

require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuAdministracion("usuario.php");



?>


		<!-- Page Content -->
		<div class="container">

		  <!-- Page Heading -->
		  <h1>Permisos de <?php echo $username ?></h1>


		  <div class="row">
		    <div class="col-md-12">
		      <div class="table-responsive">
		        <table class="table">
		          <thead class="thead-dark">
		            <tr>
		              	<th> Nombre de usuario </th>
						<th> Módulo </th>
					  	<th> Altas </th>
						<th> Bajas </th>
						<th> Consultas</th>
					  	<th> Cambios </th>
		            </tr>
		          </thead>
		          <tbody>
		          <?php
		            if(isset($registros)){
		                foreach ($registros as $registro){
		                    $altas = ($registro['altas'] == 1)?"checked":"";
							$bajas = ($registro['bajas'] == 1)?"checked":"";
							$consultas = ($registro['consultas'] == 1)?"checked":"";
							$cambios = ($registro['cambios'] == 1)?"checked":"";

							echo "	
		                             <tr class='info'>
		                                <td>{$registro['username']}</td> 
		                                <td>{$registro['modulo']}</td>
										<td><div class='form-group'><input type='checkbox' onclick='actualizar(this.id)' id='altas-{$registro['username']}-{$registro['modulo']}' $altas></div></td>
										<td><div class='form-group'><input type='checkbox' onclick='actualizar(this.id)' id='bajas-{$registro['username']}-{$registro['modulo']}' $bajas></div></td>
										<td><div class='form-group'><input type='checkbox' onclick='actualizar(this.id)' id='consultas-{$registro['username']}-{$registro['modulo']}' $consultas></div></td>
										<td><div class='form-group'><input type='checkbox' onclick='actualizar(this.id)' id='cambios-{$registro['username']}-{$registro['modulo']}' $cambios></div></td>
									<tr>";
		                }
		            }

		          ?>
		          </tbody>
		        </table>
		      </div>
		      <!-- table-responsive -->
		    </div>
		    <!-- col-md-12 -->
		  </div>
		  <!-- /.row -->

		</div>
		<!-- /.container -->

		<script type="text/javascript">
			function actualizar(idPermiso=""){
				var estatus = document.getElementById(idPermiso).checked;
				var datos = idPermiso.split("-");
				var accion = datos[0]
				var username = datos[1];
				var modulo = datos[2];


				//alert("Accion: " + accion + " Usuario: " + username + " Módulo: " + modulo);
				//enviarAlerta("Prueba","Accion: " + accion + " Usuario: " + username + " Módulo: " + modulo + " Estatus: " + estatus);
				var peticion = new XMLHttpRequest();
				peticion.onreadystatechange = function() {
					// Cuando finalice la petición y la respuesta se OK
				if (this.readyState == 4 && this.status == 200) {
						var objeto = JSON.parse(this.responseText);
						var resultado = objeto.resultado;
						var mensaje = objeto.mensaje;
						username = objeto.username;
						if(resultado == false){
							enviarAlerta("Error",mensaje,true);
							if(estatus)
								$("#"+idPermiso).prop("checked",false);
							else
								$("#"+idPermiso).prop("checked",true);
						}
						else{
							enviarAlerta("Permisos",mensaje,false);
						}
					}
				};
				peticion.open("GET", "editarPermiso.php?accion="+accion+"&estatus="+estatus+"&username="+username+"&modulo="+modulo, true);
				peticion.send();
			}
			
		</script>


<?php
require_once("vistas/piePagina.php");
?>





















