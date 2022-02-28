<?php
include_once("./functions/init.php");
include_once("./functions/function.php");

$id = $_GET['id'];
$np = $_GET['np'];
$timeId = $_GET['timeId'];


if (isset($_POST['acao']) && $_POST['acao'] == 'cad_partida_jogador') {
    $partidaId = $_POST['partidaId'];
    $timeId = $_POST['timeId'];
    $jogadorId = $_POST['jogadorId'];
    $gol = $_POST['gol'];
    $vitoria = $_POST['vitoria'];
    $derrota = $_POST['derrota'];
    $empate = $_POST['empate'];
    $ponto = $_POST['ponto'];
    $ca = $_POST['ca'];
    $cv = $_POST['cv'];

    $verificaJogador =  $PDO->query("SELECT jogadorid, partidaId FROM jogadorpartida WHERE jogadorId = '$jogadorId' AND partidaId = '$partidaId'");

    if ($verificaJogador->rowCount() > 0) {
        echo '<script type="text/javascript">';
        echo ' alert("Jogador Já escalado para esta partida")';  //not showing an alert box.
        echo '</script>';
    } else {
        try {
            $sqlInsert = "INSERT INTO jogadorpartida (partidaId,timeId,jogadorId,gol,vitoria,derrota,empate,ponto,ca,cv)
                                              VALUES (?,?,?,?,?,?,?,?,?,?)";

            $statement = $PDO->prepare($sqlInsert);
            $statement->execute([$partidaId, $timeId, $jogadorId, $gol, $vitoria, $derrota, $empate, $ponto, $ca, $cv]);

            if ($statement->rowCount() == 1) {

                $result = print "<p style='color:green;'>Cadastrado com Sucesso</p>";
            }
        } catch (PDOException $e) {
            $result = print "<p style='color:red;'>Erro no Cadastro: " . $e->getMessage() . "</p>";

            exit;
        }
    }
}



//Atualização de partidas cadastradas
if (isset($_POST['acao']) && $_POST['acao'] == 'atualiza_jogador') {
    $jogadorId = $_POST['jogadorId'];
    $gol = $_POST['gol'];    
    $ca = $_POST['ca'];
    $cv = $_POST['cv'];


    try {

        $sqlUpdate = "UPDATE jogadorpartida SET gol=:gol, ca=:ca, cv=:cv WHERE jogadorId = $jogadorId";

        $statement = $PDO->prepare($sqlUpdate);
        $statement->execute(array(':gol' => $gol, ':ca' => $ca, ':cv' => $cv));

        if ($statement->rowCount() == 1) {

            $result = print "<p style='color:green;'>Cadastrado Atualizado com Sucesso</p>";
        }
    } catch (PDOException $e) {
        $result = print "<p style='color:red;'>Erro na Atualização: " . $e->getMessage() . "</p>";

        exit;
    }
}

if (isset($_GET['acao']) && $_GET['acao'] == 'apagar_jogador') {
    $jogadorId = $_GET['jogadorId'];
    $id = $_GET['id'];
    $np = $_GET['np'];
    $timeId = $_GET['timeId'];    

        try {
            $sqlDelete = $PDO->prepare("DELETE FROM jogadorpartida WHERE jogadorId = :jogadorId");
            $sqlDelete->bindParam(":jogadorId", $jogadorId, PDO::PARAM_INT);
            $sqlDelete->execute();

            if ($sqlDelete->rowCount() == 1) {

                $result = print "<p style='color:green;'>Deletado com Sucesso</p>";
                header("Location: ?id=" . $_GET['id'] . "&np=" . $_GET['np'] . "&timeId=" . $_GET['timeId'] . "&ok=2");
            }
        } catch (PDOException $e) {
            $result = print "<p style='color:red;'>Erro no Delete: " . $e->getMessage() . "</p>";
           header("Location: ?id=" . $_GET['id'] . "&np=" . $_GET['np'] . "&timeId=" . $_GET['timeId'] . "&ok=2");

            exit;
        }
}


?>

<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#termo_busca').keyup(function() {
                $.ajax({
                    type: 'POST',
                    url: 'busca_jogador_ajax.php',
                    data: {
                        nome: $("#termo_busca").val()
                    },
                    success: function(data) {
                        $('#jogadorId').html(data);
                    }
                });
            });

        });
    </script>

    <style type="text/css">
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
  
            cursor: pointer;
            -webkit-transition-duration: 0.4s; /* Safari */
            transition-duration: 0.4s;
            border-radius: 12px;
        }

        .button1 {
            box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
        }
    </style>    
</head>

<body>

    <?php
    require 'header.php';   


    $busca = $PDO->prepare("SELECT * FROM partida WHERE partidaid = $id");
    $busca->execute();
    $linha = $busca->fetchAll(PDO::FETCH_OBJ);

    foreach ($linha as $listar) {
    ?>
        <div class="row text-white">

            <div class="left card bg-info col-sm-4" style="border-radius: 25px;">
                ESCALA DO PARTIDA N° <?= $listar->nPartida ?> DO DIA: <?= $listar->dia; ?> / <?= $listar->mes; ?> / <?= $listar->ano; ?>
            </div>
            <?php if ($listar->golBranco > $listar->golAzul) { ?>
                <div class="left card bg-info col-sm-4" style="border-radius: 25px;">
                    TIME VITORIOSO: BRANCO <img src="./img/vitoria.png" width="40px">               
                </div>
                <div class="left card bg-info col-sm-4" style="border-radius: 25px;">
                    com Placar de Branco [ <?= $listar->golBranco ?> X <?= $listar->golAzul ?> ] Azul
                </div>


            <?php } elseif ($listar->golBranco < $listar->golAzul) { ?>
                <div class="left card bg-info col-sm-4" style="border-radius: 25px;">
                    TIME VITORIOSO: Azul <img src="./img/vitoria.png" width="40px">
                </div>
                <div class="left card bg-info col-sm-4" style="border-radius: 25px;">
                    com Placar de Branco [ <?= $listar->golBranco ?> X <?= $listar->golAzul ?> ] Azul
                </div>
            <?php } else {
                ($listar->golBranco == $listar->golAzul) ?>
                <div class="left card bg-info col-sm-4" style="border-radius: 25px;">
                    Empate <img src="./img/vitoria.png" width="40px">
                </div>
                <div class="left card bg-info col-sm-4" style="border-radius: 25px;">
                    com Placar de Branco [ <?= $listar->golBranco ?> X <?= $listar->golAzul ?> ] Azul
                </div>
        <?php }
        } ?>

        </div>


        <hr>
        <div class="row">
            <div class="col-md-12 offset-md-12">
                <label>Digite o nome do Jogador para localiza-lo</label>
                               <br />
                <div class="input-group shadow-lg p-3 mb-5 bg-white rounded" style="background-image: -ms-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: -moz-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: -o-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #00510F), color-stop(100, #17882C));
                                background-image: -webkit-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: linear-gradient(to bottom, #00510F 0%, #17882C 100%);
                                border-radius: 25px;
                                color: white;
                                font-size: 16px;">

                    <input type="text" id="termo_busca" name="termo_busca" class="form-control" placeholder="Digite o Nome Jogador">
                    <div class="input-group-btn" id="btn_busca">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <hr>        

        <div class="row" style="background-image: -ms-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: -moz-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: -o-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #00510F), color-stop(100, #17882C));
                                background-image: -webkit-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: linear-gradient(to bottom, #00510F 0%, #17882C 100%);
                                border-radius: 25px;
                                color: white;">
            <div class="col-12 col-md-12">
                <form method="post" style="text-transform: uppercase;">

                    <input type="hidden" name="acao" value="cad_partida_jogador" />                   

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Nome:</label>
                            <select class="form-control mb-2" id="jogadorId" name="jogadorId" onclick="if( $('#jogadorId').html() == '' ){ alert('Sem resultados carregados.\n Faça uma busca digitando o nome de um Jogador.');}" checked></select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Time:</label>
                            <?php
                            $buscaTime = $PDO->prepare("SELECT * FROM timepartida tp
                                                            INNER JOIN partida p
                                                            ON tp.partidaId = p.partidaId
                                                                INNER JOIN time t
                                                                ON tp.timeId = t.timeId    
                                                        WHERE tp.partidaId = $id
                                                        AND tp.timeId = $timeId
                                                        AND p.nPartida = $np");
                            $buscaTime->execute();
                            $linhaTime = $buscaTime->fetchAll(PDO::FETCH_OBJ);

                            foreach ($linhaTime as $listarTime) { ?>
                            
                            <label><?= $listarTime->timeNome ?></label>

                            <?php } ?>
                            <input type="hidden" name="timeId"    id="timeId"     value="<?= $listarTime->timeId ?>"> 
                            <input type="hidden" name="vitoria"   id="vitoria"    value="<?= $listarTime->vitoria ?>">  
                            <input type="hidden" name="derrota"   id="derrota"    value="<?= $listarTime->derrota ?>">  
                            <input type="hidden" name="empate"    id="empate"     value="<?= $listarTime->empate ?>"> 
                            <input type="hidden" name="ponto"     id="ponto"      value="<?= $listarTime->ponto ?>">
                            <input type="hidden" name="partidaId" id="partidaid"  value="<?= $listarTime->partidaId ?>">                      
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>CA:</label>
                            <input class="form-control" type="text" id="ca" name="ca" value="0" />
                        </div>

                        <div class="form-group col-md-4">
                            <label>CV:</label>
                            <input class="form-control" type="text" id="cv" name="cv" value="0" />
                        </div>
                        <div class="form-group col-md-4">

                            <label>Gols:</label>
                            <?php $verificaGol =  $PDO->query("SELECT * FROM partida
                                                WHERE partidaId = $id
                                                AND ( golAzul != 0  OR golBranco != 0 )");

                            if ($verificaGol->rowCount() > 0) {
                                echo '<input class="form-control" type="text" id="gol" name="gol" value="0"/>';
                            } else {
                                echo '<input class="form-control" type="text" id="gol" name="gol" value="0" readonly/>';
                            }
                            ?>

                        </div>
                    </div>

                    <br>
                    <button type="submit" value="Cadastrar" name="submit" class="button button1">Cadastrar</button>
                </form>
            </div>
        </div>
        <br>
        

            <table class="table table-success table-hover" width="100%" style="text-transform: uppercase; border: #005B5B; font-size:16px; font-weight:bold;  border-radius: 25px;">
                
                <thead style="text-align: center; background-image: -ms-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: -moz-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: -o-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #00510F), color-stop(100, #17882C));
                                background-image: -webkit-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: linear-gradient(to bottom, #00510F 0%, #17882C 100%);
                                border-radius: 25px;
                                color: white;">
                    <tr>
                        <th scope="col">DT Jogo</th>
                        <th scope="col">Jogador<img src="./img/jogador.png" width="40px"></th>
                        <th scope="col">Time</th>
                        <th scope="col">CA<img src="./img/cartao_a.png" width="40px"></th>
                        <th scope="col">CV<img src="./img/cartao_v.png" width="40px"></th>
                        <th scope="col">Gols <img src="./img/soccer-ball.png" width="40px" style="background-color: #FFF; border-radius: 50%;"></th>
                        <th scope="col">Ação</th>
                    </tr>
                </thead>

                <?php
                $consulta =  $PDO->query("
                    SELECT * FROM jogadorpartida jp
                        INNER JOIN partida p 
                        ON(jp.partidaId = p.partidaId)
                        INNER JOIN time t
                        ON(jp.timeId = t.timeId)
                        INNER JOIN jogador j
                        ON(jp.jogadorId = j.jogadorId)
                    WHERE jp.partidaId='$id' ORDER By timeNome");
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

                foreach ($resultado as $item) {
                    if ($item['timeNome'] == 'BRANCO') {
                ?>
                        <tr style="text-align: center; background-color: white;">
                            <td><?= $item['dia']; ?> / <?= $item['mes']; ?> / <?= $item['ano']; ?></td>
                            <td><?= $item['jogadorNome']; ?></td>
                            <td><?= $item['timeNome']; ?></td>

                            <?php if ($item['ca'] > 0) { ?>
                                <td style="background-color: yellow; color: black;"><?= $item['ca']; ?></td>
                            <?php } else { ?>
                                <td><?= $item['ca']; ?></td>
                            <?php } ?>

                            <?php if ($item['cv'] > 0) { ?>
                                <td style="background-color: red;"><?= $item['cv']; ?></td>
                            <?php } else { ?>
                                <td><?= $item['cv']; ?></td>
                            <?php } ?>
                            <td><?= $item['gol']; ?></td>
                            <td>                                
                                <a class="button button1" data-toggle="modal" data-target="#editar_pat_<?= $item['jogadorId']; ?>" href="javascript:;" onclick="document.getElementById('editar_pat_<?= $item['jogadorId']; ?>').style.display = '';" title="Editar">editar
                                </a>
                                  
                                <a class="button button1" 
                                onclick="return confirm('Tem certeza que deseja remover o Jogador <?= $item['jogadorNome']; ?> ?')" 
                                href="?                       
                                id=<?= $item['partidaId']; ?>& 
                                np=<?= $item['nPartida']; ?>& 
                                timeId=<?= $item['timeId']; ?>&                           
                                acao=apagar_jogador&
                                jogadorId=<?= $item['jogadorId']; ?>"                    
                                title="Remover">remover
                                </a>

                            </td>
                        </tr>
                    <?php } else {  ?>
                        <tr style="text-align: center; background-color: blue; color: white;">
                            <td><?= $item['dia']; ?> / <?= $item['mes']; ?> / <?= $item['ano']; ?></td>
                            <td><?= $item['jogadorNome']; ?></td>
                            <td><?= $item['timeNome']; ?></td>

                            <?php if ($item['ca'] > 0) { ?>
                                <td style="background-color: yellow; color: black;"><?= $item['ca']; ?></td>
                            <?php } else { ?>
                                <td><?= $item['ca']; ?></td>
                            <?php } ?>

                            <?php if ($item['cv'] > 0) { ?>
                                <td style="background-color: red;"><?= $item['cv']; ?></td>
                            <?php } else { ?>
                                <td><?= $item['cv']; ?></td>
                            <?php } ?>

                            <td><?= $item['gol']; ?></td>

                            <td>
                                <a class="button button1" data-toggle="modal" data-target="#editar_pat_<?= $item['jogadorId']; ?>" href="javascript:;" onclick="document.getElementById('editar_pat_<?= $item['jogadorId']; ?>').style.display = '';" title="Editar">editar
                                </a>
                                  
                                <a class="button button1" onclick="return confirm('Tem certeza que deseja remover o Jogador <?= $item['jogadorNome']; ?> ?')" 
                                href="? 
                                id=<?= $item['partidaId']; ?>& 
                                np=<?= $item['nPartida']; ?>& 
                                timeId=<?= $item['timeId']; ?>&                           
                                acao=apagar_jogador&
                                jogadorId=<?= $item['jogadorId']; ?>" 
                                title="Remover">remover
                                </a>
                            </td>
                        </tr>
                        <?php } ?>


                        <!-- Modal de Atualização de Partida -->
            <div class="modal fade" id="editar_pat_<?= $item['jogadorId']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="text-transform: uppercase;">
                    <div class="modal-content" 
                         style="text-transform: uppercase; border: #005B5B; font-size:16px; font-weight:bold;
                                border-radius: 25px;
                                color: #FFF;
                                background-image: -ms-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: -moz-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: -o-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #00510F), color-stop(100, #17882C));
                                background-image: -webkit-linear-gradient(top, #00510F 0%, #17882C 100%);
                                background-image: linear-gradient(to bottom, #00510F 0%, #17882C 100%);">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Atualização de Partida</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <input type="hidden" name="acao" value="atualiza_jogador" />
                                <input type="hidden" name="jogadorId" id="jogadorId" value="<?= $item['jogadorId']; ?>" />
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Data:</label>
                                    <label for="recipient-name" class="col-form-label"><?= $item['dia']; ?>/<?= $item['mes']; ?>/<?= $item['ano']; ?></label>
                                </div>
                                 <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Time:</label>
                                    <label for="recipient-name" class="col-form-label"> <?= $item['timeNome']; ?></label>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"><img src="./img/jogador.png" width="40px"> Jogador: </label>
                                    <label for="recipient-name" class="col-form-label"><?= $item['jogadorNome']; ?></label>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Cartao Amarelo: <img src="./img/cartao_a.png" width="40px"></label>
                                    <input type="text" class="form-control" id="ca" name="ca" value="<?= $item['ca']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Cartão Vermelho: <img src="./img/cartao_v.png" width="40px"></label>
                                    <input type="text" class="form-control" id="cv" name="cv" value="<?= $item['cv']; ?>">
                                    <label for="recipient-name" class="col-form-label">Gols:<img src="./img/soccer-ball.png" width="40px" style="background-color: #FFF; border-radius: 50%;"></label>
                                    <input type="text" class="form-control" id="gol" name="gol" value="<?= $item['gol']; ?>">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" value="Cadastrar" name="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>

                <?php 
                } ?>
            </table>
             

</body>
<html>