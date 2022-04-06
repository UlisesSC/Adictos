<?php
require_once("librerias/utilerias.php");
$resultado = revisaSesion();
if($resultado === TRUE){
  header("Location: ./usuario.php");
  exit();
}


require_once("vistas/encabezado.php");
require_once("vistas/menu.php");
echo menuGeneral("formaPedirPassword.php");

//die(print_r($_POST)." ".print_r($_FILES));

$username = obtenDatos('username');
$error = obtenDatos('error');

?>


  <title>Iniciar Sesión</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/util.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
   
  <div class="container-contact100">
    <div class="wrap-contact100">
        <span class="contact100-form-title">
          <div class="col-lg-6 offset-lg-3">
            <br><br><br>
          Iniciar Sesión
        </span>
        <br>
        <br>
        <div class="wrap-input100">
          <form action="./revisaPassword.php" method="post" class="needs-validation" novalidate>
          <label class="label-input100" for="username">¿Cúal es tu nombre de usuario?</label>
          <input id="username" class="input100" type="text" name="username" placeholder="Ingresa tu usuario..." maxlength="30" value="<?php echo (isset($username) ? $username : ""); ?>" required="required">
          <span class="focus-input100"></span>
          <div class="invalid-feedback">
            El campo es requerido.
          </div>
        </div>

        <div class="wrap-input100" >
          <label class="label-input100" for="password1">Contraseña</label>
            <input id="password1" class="input100" type="password" name="password1" placeholder="Ingresa tu Contraseña..." required="required">
              <span class="focus-input100"></span>
            <div class="invalid-feedback">
              El campo es requerido.
            </div>
        </div>
            <div class="wrap-input100">
          <div class="label-input100"></div>
          <div>
            <div class="dropDownSelect2"></div>
          </div>
          <span class="focus-input100"></span>
        </div>

        <div class="container-contact100-form-btn">
          <button type="submit" value="Entrar" class="contact100-form-btn">
            Iniciar
          </button>
        </div>

      </form>
        <?php
          if(isset($error) && $error!=""){
            echo "
            <div class='row'>
              <div class='col-md-4'></div>
              <div class='col-md-12 form-group'>  
                <div class='alert alert-danger' role='alert'>
                      $error
                    </div>
              </div>
              <div class='col-md-4'></div>
            </div>";

          }
      ?>

    </div>



        <div class="contact100-form-social flex-c-m">
          <a href="#" class="contact100-form-social-item flex-c-m bg1 m-r-5">
            <i class="fa fa-facebook-f" aria-hidden="true"></i>
          </a>

          <a href="#" class="contact100-form-social-item flex-c-m bg2 m-r-5">
            <i class="fa fa-twitter" aria-hidden="true"></i>
          </a>

          <a href="#" class="contact100-form-social-item flex-c-m bg3">
            <i class="fa fa-youtube-play" aria-hidden="true"></i>
          </a>
        </div>  
      </div>
      </form>  
    </div>
  </div>
</form>
<script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                /*
                password1 = document.getElementById('password1').value;
                password2 = document.getElementById('password2').value;
                
                if(password1 !== password2){
                    event.preventDefault();
                    event.stopPropagation();
                    alert("Las contraseñas no coinciden");
                }
                else 
                    */
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
        </script>

<!--===============================================================================================-->
  <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
  <script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
  <script src="vendor/bootstrap/js/popper.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
  <script src="vendor/select2/select2.min.js"></script>
  <script>
    $(".js-select2").each(function(){
      $(this).select2({
        minimumResultsForSearch: 20,
        dropdownParent: $(this).next('.dropDownSelect2')
      });
    })
    $(".js-select2").each(function(){
      $(this).on('select2:open', function (e){
        $(this).parent().next().addClass('eff-focus-selection');
      });
    });
    $(".js-select2").each(function(){
      $(this).on('select2:close', function (e){
        $(this).parent().next().removeClass('eff-focus-selection');
      });
    });

  </script>
<!--===============================================================================================-->
  <script src="vendor/daterangepicker/moment.min.js"></script>
  <script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
  <script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
  <script src="js/main.js"></script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
  </script>
</body>

<?php
require_once("vistas/piePagina.php");
?>
