<?php 
require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuGeneral("quienessomos.php");

?>

  <!-- Page Content -->
  <div class="container text-center">

    <!-- Jumbotron Header -->
    <header class="jumbotron my-4">
      <h1 class="display-3">¿Quiénes somos?</h1>
      <p class="lead">Somos una empresa que desde 2010 se dedica a al reacondicionamiento de equipos de impresión láser de bajo, mediano y alto volumen, así como a la venta de refacciones de los mismos.
      
    </header>

    <!-- Page Features -->
    <div class="row text-center">

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="./imagenes/quienessomos/mision.jpg" alt="">
          <div class="card-body">
            <h4 class="card-title">Misión</h4>
            <p class="card-text">Crear valor y generar crecimiento mediante Soluciones y Servicios innovadores en el campo de las soluciones informáticas, contribuyendo a la evolución, eficacia y productividad de nuestros clientes, promoviendo el talento, la integridad y el trabajo e equipo, para ser un referente en nuestra industria y en nuestra comunidad.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="./imagenes/quienessomos/vision.jpg" alt="">
          <div class="card-body">
            <h4 class="card-title">Visión</h4>
            <p class="card-text">Ser reconocidos dentro de los próximos 2 años en el ámbito del desarrollo web como una empresa profesional, ejemplar en la calidad e innovación de sus productos, el trato a los clientes y el desarrollo de las personas.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="./imagenes/quienessomos/valores.jpg" alt="">
          <div class="card-body">
            <h4 class="card-title">Valores</h4>
            <p class="card-text">*Excelencia</p>
            <p class="card-text">*Honestidad</p>
            <p class="card-text">*Cumplimiento</p>
            <p class="card-text">*Calidad</p>
            <p class="card-text">*Transparencia</p>
            <p class="card-text">*Trabajo en equipo</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card h-100">
          <img class="card-img-top" src="./imagenes/quienessomos/objetivos.jpg" alt="">
          <div class="card-body">
            <h4 class="card-title">Objetivos</h4>
            <p class="card-text">*Convertirse en una de las marcas líderes en el mercado nacional del ramo en los próximos 2 años.</p>
            <p class="card-text">*Incrementar en por lo menos un 20% el margen anual de ingresos de manera responsable y proactiva.</p>
            <p class="card-text">*Ofrecer alternativas de mejor calidad apartir de este momento.</p>
          </div>
        </div>
      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

<?php
require_once("vistas/piePagina.php");
?>