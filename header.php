<?php
include_once("./functions/init.php");
include_once("./functions/function.php");


if (isset($_POST['acao']) && $_POST['acao'] == 'cad_jogador') {
    $jogadorNome = $_POST['jogadorNome'];
 	
    try {
        $sqlInsert = "INSERT INTO jogador (jogadorNome)
                       VALUES (:jogadorNome)";
    
         $statement = $PDO->prepare($sqlInsert);
         $statement->execute(array(':jogadorNome' => $jogadorNome  ));
    
         if ($statement ->rowCount() == 1){
    
             $result = "<p style='color:green;'>Cadastrado com Sucesso</p>";
    
         }
       
        }
        catch(PDOException $e)
        {
            $result = "<p style='color:green;'>Erro no Cadastro: " . $e->getMessage() . "</p>";

    exit;
    }
}

if (isset($_POST['acao']) && $_POST['acao'] == 'cad_partida') {
    $data = $_POST['data'];
    $juiz = $_POST['juiz'];
    $golAzul = $_POST['golAzul'];
    $golBranco = $_POST['golBranco'];

    $t = explode("/", $data);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];

    
 	
    try {
        $sqlInsert = "INSERT INTO partida (dia,mes,ano,juiz,golAzul,golBranco)
                       VALUES (:dia,:mes,:ano,:juiz,:golAzul,:golBranco)";
    
         $statement = $PDO->prepare($sqlInsert);
         $statement->execute(array(':dia' => $dia, ':mes' => $mes, ':ano' => $ano, ':juiz' => $juiz, ':golAzul' => $golAzul, 'golBranco' => $golBranco  ));
    
         if ($statement ->rowCount() == 1){
    
             $result = "<p style='color:green;'>Cadastrado com Sucesso</p>";
    
         }
       
        }
        catch(PDOException $e)
        {
            $result = "<p style='color:green;'>Erro no Cadastro: " . $e->getMessage() . "</p>";

    exit;
    }
}

if (isset($_GET['mes']))
    $mes_hoje = $_GET['mes'];
else
    $mes_hoje = date('m');

if (isset($_GET['ano']))
    $ano_hoje = $_GET['ano'];
else
    $ano_hoje = date('Y');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light" style="text-transform: uppercase;">
  <a class="navbar-brand" href="#">Menu</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" data-toggle="modal" data-target="#partidaModal" href="#">cadastro de Partida <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link active" data-toggle="modal" data-target="#jogadorModal" href="#">Cadastro Jogadores</a>      
      <a class="nav-item nav-link active" href="#">Ranking de Jogadores</a>
    </div>
  </div>
</nav>

<div class="modal fade" id="jogadorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="text-transform: uppercase;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro Jogador</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
        <input type="hidden" name="acao" value="cad_jogador" />
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nome:</label>
            <input type="text" class="form-control" id="jogadorNome" name="jogadorNome">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" value="Cadastrar" name="submit" class="btn btn-primary">Cadastrar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="partidaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="text-transform: uppercase;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro de Partida</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
        <input type="hidden" name="acao" value="cad_partida" />
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Data:</label>            
            <input type="text" class="form-control" id="data" name="data" value="<?php echo date('d') ?>/<?php echo $mes_hoje ?>/<?php echo $ano_hoje ?>">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Juiz:</label>
            <input type="text" class="form-control" id="juiz" name="juiz">
          </div>
          <div class="form-group">            
            <label for="recipient-name" class="col-form-label">Gols Time Azul:</label>
            <input type="text" class="form-control" id="golAzul" name="golAzul">
            <label for="recipient-name" class="col-form-label">Gols Time Branco:</label>
            <input type="text" class="form-control" id="golBranco" name="golBranco">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" value="Cadastrar" name="submit" class="btn btn-primary">Cadastrar</button>
      </div>
      </form>
    </div>
  </div>
</div>

 </body>
</html>