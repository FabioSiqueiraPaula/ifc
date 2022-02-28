<?php

session_start();
require_once "./functions/init.php";
require_once "login.php";

if (isset($_POST['ok'])) :

    $login = filter_input(INPUT_POST, "login");
    $senha = filter_input(INPUT_POST, "senha");

    /**/
    $_1 = new Login;
    $_1->setLogin($login);
    $_1->SetSenha($senha);

    if ($_1->logar()) :
        header("Location: index_logado.php");
    else :
        $erro = "Erro ao Logar";
    endif;

endif;

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!--Utilizei o boostrap para deixar com uma aparencia melhor ao projeto-->
    <meta charset="UTF-8">
    <title>Login Sistema</title>
    <!--se preferir add um css para caso queira utiliza-lo em vez do boostrap-->
    <link rel="stylesheet" type="text/css" href="css/tela_login.css" />

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>

<body style="background-image: url(./img/soccerbg3.jpg); 
  background-color: #cccccc;
  height: 500px; 
  background-position: center; 
  background-repeat: no-repeat; 
  background-size: cover; ">
    <div class="container" style="margin-top:30px">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Acesso ao Sistema </strong></h3>
                    <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#"></a></div>
                </div>

                <div class="panel-body" id="login">
                    <form action="" method="POST" id="form-login" role="form">
                        <div style="margin-bottom: 12px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-username" type="text" class="input" name="login" value="" placeholder="E-mail">
                        </div>

                        <div style="margin-bottom: 12px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="senha" placeholder="password">
                        </div>

                        <button type="submit" name="ok" id="btn_logar" value="logar" class="input_button"">Logar</button>

                        <hr style=" margin-top:10px;margin-bottom:10px;">

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>