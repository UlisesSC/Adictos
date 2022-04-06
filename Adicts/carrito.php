<?php

require_once("seguridadCliente.php");
require_once("librerias/utilerias.php");
require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuGeneral("carrito.php");


$cantidad = 0;
$precioTotal = 0;
$productos = array();

if(!empty($_SESSION['carrito'])){
  $cantidad = $_SESSION['carrito']['cantidad'];
  $precioTotal = $_SESSION['carrito']['precioTotal'];
  $productos = $_SESSION['carrito']['productos'];
}


?>
    
    <!-- Breadcrumb Section Begin -->
    
    <!-- Breadcrumb Section Begin -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                  <h2>Carrito de compra</h2>
                    <br>

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Imagen</th>
                                    <th class="p-name">Nombre del producto</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                    <th colspan="2">Acciones</th>
                                </tr>
                              </thead>
                            <tbody id="productosCarrito">
                                <?php
                                     for($i=0; $i<count($productos); $i++){
                                     $producto = $productos[$i];
                                      echo "
                                <tr>
                                    <tr id='{$producto['id']}-renglon'>
                                    <td>{$producto['id']}</td>
                                    <td class='cart-pic first-row'><img src='{$producto['urlImagen']}' alt='{$producto['nombre']}' width='150'></td>
                                        <td>{$producto['nombre']}</td>
                                    <td>{$producto['nombreCategoria']}</td>
                                    <td class='p-price first-row'>$".number_format($producto['precio'],2)."</td>
                                    <td id='{$producto['id']}-cantidad'>{$producto['cantidad']}</td>
                                    <td class='p-price first-row' id='{$producto['id']}-precioTotal'>$".number_format($producto['precio']*$producto['cantidad'],2)."</td>
                                    <td><button class='btn btn-light form-control' onclick=\"agregarCarrito({$producto['id']})\">+</button></td>
                                    <td><button class='btn btn-dark form-control' onclick=\"disminuirCarrito({$producto['id']})\">-</button></td>
                                </tr>";

                            }
                            ?>
                <tr>
                <th colspan="5">&nbsp</th>
                <th id='cantidad'><?php echo $cantidad; ?></th>
                <th id='precioTotal'>$<?php echo number_format($precioTotal,2); ?></th>
                <th colspan="2">&nbsp</th>
              </tr>
          </tbody>
        </table>
     </div>
 
      <div class="row">
          <div class="col-md-1">&nbsp;</div>
          <div class="col-md-4 form-group">
            <label>&nbsp;</label>
          </div>
          <div class="col-md-2">&nbsp;</div>
          <!-- boton de paypal -->
          <div class="col-md-4 form-group">
              <input type="hidden" name="precioTotalPaypal" id="precioTotalPaypal" value="<?php echo $precioTotal; ?>">
              <!-- Set up a container element for the button -->
              <div id="boton-paypal"></div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> 
</section>

   <!-- Include the PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=AeYdbfHFV1Sj2U8-bmEmIE6BdDKsL81kkE1KlqiuTcm36LRJLsYr8p_LJkgByIpa9DYr6x9C7HRTncW5&currency=MXN"></script>

    <script type="text/javascript">
      function vaciarCarrito(){
        if (confirm('¿Esta seguro que quiere vaciar el carrito?')) {
            eliminarProductosCarrito();
        } 
      }

       function eliminarProductosCarrito(tituloRecibido="",mensajeRecibido=""){
        
        var peticion = new XMLHttpRequest();
        peticion.onreadystatechange = function() {
          // Cuando finalice la petición y la respuesta se OK
        if (this.readyState == 4 && this.status == 200) {
            var objeto = JSON.parse(this.responseText);
            var resultado = objeto.resultado;
            var mensaje = objeto.mensaje;

            if(tituloRecibido == "")
              tituloRecibido = "OK";

            if(mensajeRecibido == "")
              mensajeRecibido = mensaje;

            if(resultado == false){
              enviarAlerta(tituloRecibido,mensajeRecibido,true);
            }
            else{
              document.getElementById('productosCarrito').innerHTML = "";
              document.getElementById('precioTotalPaypal').value = 0;
              enviarAlerta(tituloRecibido,mensajeRecibido,false);
            }
          }
        };
        peticion.open("GET", "vaciarCarrito.php", true);
        peticion.send();
      }

       function agregarCarrito(idProducto=""){
        
        var peticion = new XMLHttpRequest();
        peticion.onreadystatechange = function() {
          // Cuando finalice la petición y la respuesta se OK
        if (this.readyState == 4 && this.status == 200) {
            var objeto = JSON.parse(this.responseText);
            var resultado = objeto.resultado;
            var mensaje = objeto.mensaje;
            idProducto = objeto.idProducto;
            var cantidadProducto = objeto.cantidadProducto;
            var precioTotalProducto = objeto.precioTotalProducto;
            var precioTotalObtenido = objeto.precioTotal;
            var numeroProductos = objeto.numeroProductos;
            var precioTotalPayPal = objeto.precioTotalPayPal;
            
            if(resultado == false){
              enviarAlerta("Error",mensaje,true);
            }
            else{
              document.getElementById('precioTotal').innerHTML = precioTotalObtenido;
              document.getElementById('cantidad').innerHTML = numeroProductos;
              document.getElementById(idProducto+'-cantidad').innerHTML = cantidadProducto;
              document.getElementById(idProducto+'-precioTotal').innerHTML = precioTotalProducto;
              document.getElementById('precioTotalPaypal').value = precioTotalPayPal;
              enviarAlerta("OK",mensaje,false);
            }
          }
        };
        peticion.open("GET", "actualizaCarrito.php?idProducto="+idProducto, true);
        peticion.send();
      }


     function disminuirCarrito(idProducto=""){
        
        var peticion = new XMLHttpRequest();
        peticion.onreadystatechange = function() {
          // Cuando finalice la petición y la respuesta se OK
        if (this.readyState == 4 && this.status == 200) {
            var objeto = JSON.parse(this.responseText);
            var resultado = objeto.resultado;
            var mensaje = objeto.mensaje;
            idProducto = objeto.idProducto;
            var cantidadProducto = objeto.cantidadProducto;
            var precioTotalProducto = objeto.precioTotalProducto;
            var precioTotalObtenido = objeto.precioTotal;
            var numeroProductos = objeto.numeroProductos;
            var precioTotalPayPal = objeto.precioTotalPayPal;
            
            if(resultado == false){
              enviarAlerta("Error",mensaje,true);
            }
            else{
              document.getElementById('precioTotal').innerHTML = precioTotalObtenido;
              document.getElementById('cantidad').innerHTML = numeroProductos;
              document.getElementById(idProducto+'-cantidad').innerHTML = cantidadProducto;
              document.getElementById(idProducto+'-precioTotal').innerHTML = precioTotalProducto;
              document.getElementById('precioTotalPaypal').value = precioTotalPayPal;
              if(cantidadProducto<1){
                document.getElementById(idProducto+'-renglon').style.display = "none";
              }


              enviarAlerta("OK",mensaje,false);
            }
          }
        };
        peticion.open("GET", "disminuirCarrito.php?idProducto="+idProducto, true);
        peticion.send();
      }

      // Dibuja el botón de Paypal en el div que tiene el id paypal-button-container
        paypal.Buttons({

            // Set up the transaction
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: document.getElementById('precioTotalPaypal').value
                        }
                    }]
                });
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                  // Registrar la compra
                    $.get('agregarDetalleVenta.php');

                    // Vaciar el carrito
                    eliminarProductosCarrito("PayPal",'La transacción se completó con éxito ' + details.payer.name.given_name + '!');
                    
                    // Actualizar inventario
                });
            }

        }).render('#boton-paypal');

    </script>



<?php
require_once("vistas/piePagina.php");
?>
