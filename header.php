<?php
require_once("./functions/init.php");
require_once("./functions/function.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>SIS IFC</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/style.css">
  <script src="./js/bootstrap.min.js"></script>

</head>

<body>

  <div class="slider">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" 
    style="background-image: -ms-linear-gradient(top, #00510F 0%, #17882C 100%);
           background-image: -moz-linear-gradient(top, #00510F 0%, #17882C 100%);
           background-image: -o-linear-gradient(top, #00510F 0%, #17882C 100%);
           background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #00510F), color-stop(100, #17882C));
           background-image: -webkit-linear-gradient(top, #00510F 0%, #17882C 100%);
           background-image: linear-gradient(to bottom, #00510F 0%, #17882C 100%);
           color: #fff;">
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="./img/brasao_f.png" id="img">
        </div>
      </div>

      <!-- Controls -->
      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="fa fa-angle-right" aria-hidden="true"></span>
        <span>sis controle de sumula</span>
      </a>
    </div>
  </div>
  <!--slider-->
  <hr />

  <?php

  session_start();

  require_once "login.php";

  if (isset($_GET['logout'])) :
    if ($_GET['logout'] == 'ok') :
      Login::deslogar();
    endif;
  endif;

  if (isset($_SESSION['logado'])) :

  ?>

    <div style="max-height: 30px;
                color: #fff;
                background-color: #00420c;
                margin-bottom: 30px;">

      <!--informo o campo que utilizarei para mostra quem se encontra logado-->
      BEM VINDO <?php echo $_SESSION['usuario']; ?>

      <br />
      <a href="index.php?logout=ok">Sair do Sistema</a>

    <?php

  else :
    echo "Você não esta logado ou Não tem acesso tente novamente"; ?>

      <a href="http://localhost:82/sisifc/">Inicio</a>
    <?php
  endif;
    ?>
</div>

    <?php require_once("./menu.php"); ?>
    
</body>

</html>