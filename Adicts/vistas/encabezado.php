<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Sitio web ADICTS">
  <meta name="author" content="ADCICTS">

  <title>ADICTS</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/tienda.css" rel="stylesheet">

</head>

    <script type="text/javascript">
      function enviarAlerta(titulo="Error", mensaje="Error desconocido",error=true){
        var estiloTitulo = "bg-danger";
        if(error==false){
          estiloTitulo = "bg-secondary";
        }

        var contenidoAlerta = "<div class='modal-dialog modal-dialog-centered' role='document'>" +
                      "<div class='modal-content'>" +
                        "<div class='modal-header " + estiloTitulo + "'>" +
                          "<h5 class='modal-title' id='tituloAlerta'>"+ titulo + "</h5>" +
                          "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>" +
                            "<span aria-hidden='true'>&times;</span>" +
                          "</button>" +
                        "</div>" +
                        "<div class='modal-body'>" +
                         "<p>" + mensaje + "</p>" +
                        "</div>" +
                        "<div class='modal-footer'>" +
                          "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Ok</button>" +
                        "</div>" +
                      "</div>" +
                    "</div>";
        document.getElementById("alerta").innerHTML = contenidoAlerta;
        $('#alerta').modal('show');
      }
      
    </script>

<body>

  <!-- Se pone el siguiente div para mostrar una alerta modal con bootstrap -->
  <div id="alerta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tituloAlerta" aria-hidden="true" style="display: none;">
  </div>

