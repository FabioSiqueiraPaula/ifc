<?php
require_once("./functions/init.php");


// Exclusão de partidas Cadastradas
if (isset($_GET['acao']) && $_GET['acao'] == 'apagar_partida') {
    $partidaId = $_GET['partidaId'];


    $verificaPartida =  $PDO->query("SELECT partidaId FROM timepartida WHERE partidaId = '$partidaId'");

    if ($verificaPartida->rowCount() > 0) {
        echo '<script type="text/javascript">';
        echo ' alert("A Partida já Contem Escalação Associada")';  //not showing an alert box.
        echo '</script>';
    } else {

        try {
            $sqlDelete = $PDO->prepare("DELETE FROM partida WHERE partidaId = :partidaId");
            $sqlDelete->bindParam(":partidaId", $partidaId, PDO::PARAM_INT);
            $sqlDelete->execute();

            if ($sqlDelete->rowCount() == 1) {

                $result = print "<p style='color:green;'>Deletado com Sucesso</p>";
                header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&ok=2");
            }
        } catch (PDOException $e) {
            $result = print "<p style='color:red;'>Erro no Delete: " . $e->getMessage() . "</p>";
            header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&ok=2");

            exit;
        }
    }
}


//Atualização de partidas cadastradas
if (isset($_POST['acao']) && $_POST['acao'] == 'atualiza_partida') {
    $partidaId = $_POST['partidaId'];
    $data = $_POST['data'];
    $juiz = $_POST['juiz'];
    $golAzul = $_POST['golAzul'];
    $golBranco = $_POST['golBranco'];
    $nPartida = $_POST['nPartida'];

    $t = explode("/", $data);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];


    try {

        $sqlUpdate = "UPDATE partida SET dia=:dia, mes=:mes, ano=:ano, juiz=:juiz, golAzul=:golAzul, golBranco=:golBranco, nPartida=:nPartida WHERE partidaid = $partidaId";

        $statement = $PDO->prepare($sqlUpdate);
        $statement->execute(array(':dia' => $dia, ':mes' => $mes, ':ano' => $ano, ':juiz' => $juiz, ':golAzul' => $golAzul, 'golBranco' => $golBranco, 'nPartida' => $nPartida));

        if ($statement->rowCount() == 1) {

            $result = print "<p style='color:green;'>Cadastrado Atualizado com Sucesso</p>";
        }
    } catch (PDOException $e) {
        $result = print "<p style='color:red;'>Erro na Atualização: " . $e->getMessage() . "</p>";

        exit;
    }
}


// Validação das partidas com Vitoria ou Empate
if (isset($_POST['acao']) && $_POST['acao'] == 'valida_partida') {
    $partidaId = $_POST['partidaId'];
    $timeId = $_POST['timeId'];
    $vitoria = $_POST['vitoria'];
    $derrota = $_POST['derrota'];
    $empate = $_POST['empate'];
    $ponto = $_POST['ponto'];

// Variavel para o insert de derrota
    $partidaIdD = $_POST['partidaIdD'];
    $timeIdD = $_POST['timeIdD'];
    $vitoriaD = $_POST['vitoriaD'];
    $derrotaD = $_POST['derrotaD'];
    $empateD = $_POST['empateD'];
    $pontoD = $_POST['pontoD'];


    $verificaPartida =  $PDO->query("SELECT partidaId FROM timepartida WHERE partidaId='$partidaId'");

    if ($verificaPartida->rowCount() > 0) {
        echo '<script type="text/javascript">';
        echo ' alert("Partida já validada")';  //not showing an alert box.
        echo '</script>';
    } else {

        try {
            $sqlInsert = "INSERT INTO timepartida (partidaId,timeId,vitoria,derrota,empate,ponto)
            VALUES (?,?,?,?,?,?), (?,?,?,?,?,?) ";

            $statement = $PDO->prepare($sqlInsert);
            $statement->execute([$partidaId, $timeId, $vitoria, $derrota, $empate, $ponto, $partidaIdD, $timeIdD, $vitoriaD, $derrotaD, $empateD, $pontoD]);

            if ($statement->rowCount() == 1) {

                $result = print "<p style='color:green;'>Cadastrado com Sucesso</p>";
            }
        } catch (PDOException $e) {
            $result = print "<p style='color:red;'>Erro no Cadastro: " . $e->getMessage() . "</p>";

            exit;
        }
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/bootstrap.min.js"></script>

    <title>SIS IFC</title>

    <script language="JavaScript">
        function MM_openBrWindow(theUrl, winName, features) {
            window.open(theUrl, winName, features);
        }
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
    ?>
    <table cellpadding="1" cellspacing="10" width="100%" align="center" style="background-color:#033" class="table">
        <thead>
            <tr>
                <th colspan="11" style="background-color:#005B5B;">
                    <h2 style="color:#FFF; margin:5px">Jogos do Mês</h2>
                </th>
                <th colspan="2" align="right" style="background-color:#005B5B;">
                    <a style="color:#FFF" href="?mes=<?php echo date('m') ?>&ano=<?php echo date('Y') ?>">Hoje:<strong> <?php echo date('d') ?> de <?php echo mostraMes(date('m')) ?> de <?php echo date('Y') ?></strong></a>&nbsp;
                </th>
            </tr>

            <tr>
                <th width="70">
                    <select onchange="location.replace('?mes=<?php echo $mes_hoje ?>&ano=' + this.value)">
                        <?php
                        for ($i = 2022; $i <= 2032; $i++) {
                            ?>
                            <option value="<?php echo $i ?>" <?php if ($i == $ano_hoje) echo "selected=selected" ?>><?php echo $i ?></option>
                        <?php } ?>
                    </select>
                </th>

                <?php
                for ($i = 1; $i <= 12; $i++) {
                    ?>
                    <th align="center" style="<?php if ($i != 12) echo "border-right:1px solid #FFF;" ?> padding-right:5px">
                        <a href="?mes=<?php echo $i ?>&ano=<?php echo $ano_hoje ?>" style="
                        <?php if ($mes_hoje == $i) { ?>    
                           color:#033; font-size:16px; font-weight:bold; background-color:#FFF; padding:5px
                       <?php } else { ?>
                           color:#FFF; font-size:16px;
                       <?php } ?>
                       ">
                       <?php echo mostraMes($i); ?>
                   </a>
               </th>
               <?php
           }
           ?>
       </tr>
   </thead>
</table>

<table class="table table-success table-striped" width="100%"
style="text-transform: uppercase; 
border: #005B5B; 
font-size:16px; 
font-weight:bold;
border-radius: 25px; text-align: center;
color: #FFF;
background-image: -ms-linear-gradient(top, #00510F 0%, #17882C 100%);
background-image: -moz-linear-gradient(top, #00510F 0%, #17882C 100%);
background-image: -o-linear-gradient(top, #00510F 0%, #17882C 100%);
background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #00510F), color-stop(100, #17882C));
background-image: -webkit-linear-gradient(top, #00510F 0%, #17882C 100%);
background-image: linear-gradient(to bottom, #00510F 0%, #17882C 100%);">
<thead>
    <tr style="text-align: center;">
        <td colspan="3"></td>
        <td colspan="2" style="background-color: #033; color: #FFF;">placar <img src="./img/soccer-ball.png" width="40px" style="background-color: #FFF; border-radius: 50%;"></td>
        <td colspan="2"></td>
    </tr>
    <tr style="text-align: center; background-color: black; color: #FFF;">
        <th scope="col" style="text-align: center;">Dia</th>
        <th>N Partida</th>
        <th scope="col">Juiz <img src="./img/juiz.png" width="40px"></th>
        <th scope="col" style="background-color: blue; color: #FFF;">Gols Time azul</th>
        <th scope="col" style="background-color: white; color: black;"> Gols Time Branco</th>
        <th scope="col">escalar Jogadores <img src="./img/jogador.png" width="40px"></th>
        <th>detalhe da partida</th>
        <th>validar partida <img src="./img/vitoria.png" width="40px"></th>
        <th>Ação</th>
    </tr>
</thead>
<?php
$consulta =  $PDO->query("SELECT * FROM partida WHERE mes='$mes_hoje' && ano='$ano_hoje' ORDER By dia");
$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

foreach ($resultado as $item) {
    ?>
    <tr style="text-align: center;">
        <td><?= $item['dia']; ?></td>
        <td><?= $item['nPartida']; ?></td>
        <td><?= $item['juiz']; ?></td>
        <td><?= $item['golAzul'];  ?></td>
        <td><?= $item['golBranco']; ?></td>

        <td>
            <a class="button button1" data-toggle="modal" data-target="#escala_pat_<?= $item['partidaId']; ?>" href="javascript:;" onclick="document.getElementById('escala_pat_<?= $item['partidaId']; ?>').style.display = '';" title="Editar">escalar
            </a>
        </td>
        <td>
            <a class="button button1" href="javascript:void(0)" onClick="MM_openBrWindow('detalhe_escalacao.php?id=<?= $item['partidaId']; ?>&np=<?= $item['nPartida']; ?>','','scrollbars=no, width=auto, height=500, left=0, top=0')">SUMULA
            </a>            
        </td>

        <form method="POST">
            <input type="hidden" name="acao" value="valida_partida" />
            <?php
            if ($item['golAzul'] > $item['golBranco']) { ?>
                <td>
                    <label style="color: #FFD700; background-color: #033;">
                        <img src="./img/vitoria.png" width="40px">
                    Time vitorioso Azul</label>
                    <hr />
                    <input type="hidden" value="<?= $item['partidaId']; ?>" name="partidaId" id="partidaId">
                    <input type="hidden" value="1" name="timeId" id="timeId">
                    <input type="hidden" value="1" name="vitoria" id="vitoria">
                    <input type="hidden" value="0" name="derrota" id="derrota">
                    <input type="hidden" value="0" name="empate" id="empate">
                    <input type="hidden" value="3" name="ponto" id="ponto"><br /> 

                    <input type="hidden" value="<?= $item['partidaId']; ?>" name="partidaIdD" id="partidaIdD">
                    <input type="hidden" value="2" name="timeIdD" id="timeIdD">
                    <input type="hidden" value="0" name="vitoriaD" id="vitoriaD">
                    <input type="hidden" value="1" name="derrotaD" id="derrotaD">
                    <input type="hidden" value="0" name="empateD" id="empateD">
                    <input type="hidden" value="0" name="pontoD" id="pontoD"><br />                            

                    <?php
                    $idA = $item['partidaId'];
                    $consultaA =  $PDO->query("SELECT DISTINCT(partidaId) FROM timepartida WHERE partidaId = $idA  ");
                    $resultadoA = $consultaA->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($resultadoA as $itemA) {
                        if ($itemA['partidaId'] = $item['partidaId'])
                            ?>
                        <Label>Validado</Label>
                    <?php  } ?>
                    <button type="submit" value="Cadastrar" name="submit" class="button button1">Validar</button>
                </td>

            <?php } elseif ($item['golAzul'] < $item['golBranco']) { ?>
                <td>
                    <label style="color: #FFD700; background-color: #033;">
                        <img src="./img/vitoria.png" width="40px">
                    Time vitorioso Branco</label>
                    <hr />
                    <input type="hidden" value="<?= $item['partidaId']; ?>" name="partidaId" id="partidaId">
                    <input type="hidden" value="2" name="timeId" id="timeId">
                    <input type="hidden" value="1" name="vitoria" id="vitoria">
                    <input type="hidden" value="0" name="derrota" id="derrota">
                    <input type="hidden" value="0" name="empate" id="empate">
                    <input type="hidden" value="3" name="ponto" id="ponto"><br /> 

                    <input type="hidden" value="<?= $item['partidaId']; ?>" name="partidaIdD" id="partidaIdD">
                    <input type="hidden" value="1" name="timeIdD" id="timeIdD">
                    <input type="hidden" value="0" name="vitoriaD" id="vitoriaD">
                    <input type="hidden" value="1" name="derrotaD" id="derrotaD">
                    <input type="hidden" value="0" name="empateD" id="empateD">
                    <input type="hidden" value="0" name="pontoD" id="pontoD"><br />  

                    <?php
                    $idB = $item['partidaId'];
                    $consultaB =  $PDO->query("SELECT DISTINCT(partidaId) FROM timepartida WHERE partidaId = $idB");
                    $resultadoB = $consultaB->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($resultadoB as $itemB) {
                        if ($itemB['partidaId'] = $item['partidaId']) {
                            ?>
                            <Label style="color: red;">Validado</Label>
                        <?php }
                        if ($itemB['partidaId'] != $item['partidaId']) { ?>
                            <Label style="font-size: 16; color: red;">Invalidado</Label>
                        <?php }
                    } ?>
                    <button type="submit" value="Cadastrar" name="submit" class="button button1">Validar</button>
                </td>

            <?php } else { ?>
                <td>
                    <label style="color: #FFD700; background-color: #033;">empate</label>
                    <hr />
                    <input type="hidden" value="<?= $item['partidaId']; ?>" name="partidaId" id="partidaId">
                    <input type="hidden" value="1" name="timeId" id="timeId">
                    <input type="hidden" value="0" name="vitoria" id="vitoria">
                    <input type="hidden" value="0" name="derrota" id="derrota">
                    <input type="hidden" value="1" name="empate" id="empate">
                    <input type="hidden" value="1" name="ponto" id="ponto"><br /> 

                    <input type="hidden" value="<?= $item['partidaId']; ?>" name="partidaIdD" id="partidaIdD">
                    <input type="hidden" value="2" name="timeIdD" id="timeIdD">
                    <input type="hidden" value="0" name="vitoriaD" id="vitoriaD">
                    <input type="hidden" value="0" name="derrotaD" id="derrotaD">
                    <input type="hidden" value="1" name="empateD" id="empateD">
                    <input type="hidden" value="1" name="pontoD" id="pontoD"><br />  


                    <?php
                    $idE = $item['partidaId'];
                    $consultaE =  $PDO->query("SELECT DISTINCT(partidaId) FROM timepartida WHERE partidaId = $idE ");
                    $resultadoE = $consultaE->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($resultadoE as $itemE) {
                        if ($itemE['partidaId'] = $item['partidaId']) {
                            ?>
                            <Label style="color: green;">Validado</Label>
                        <?php }
                        if ($itemE['partidaId'] != $item['partidaId']) { ?>
                            <Label style="font-size: 16; color: red;">Invalidado</Label>
                        <?php }
                    } ?>
                    <button type="submit" value="Cadastrar" name="submit" class="button button1">Validar</button>
                </td>

            <?php } ?>
        </form>

        <td>
            <a class="button button1" data-toggle="modal" data-target="#editar_pat_<?= $item['partidaId']; ?>" href="javascript:;" onclick="document.getElementById('editar_pat_<?= $item['partidaId']; ?>').style.display = '';" title="Editar">editar
            </a>

            <a class="button button1" onclick="return confirm('Tem certeza que deseja remover esta partida?\nAtenção: Apenas Partidas sem movimentos associados poderao ser removidas.')" href="?mes=<?php echo $mes_hoje ?>&ano=<?php echo $ano_hoje ?>&acao=apagar_partida&partidaId=<?= $item['partidaId']; ?>" title="Remover">remover
            </a>
        </td>
    </tr>

    <!-- Modal de Atualização de Partida -->
    <div class="modal fade table-responsive" id="editar_pat_<?= $item['partidaId']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <input type="hidden" name="acao" value="atualiza_partida" />
                    <input type="hidden" name="partidaId" id="partidaid" value="<?= $item['partidaId']; ?>" />
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Data:</label>
                        <input type="text" class="form-control" id="data" name="data" value="<?= $item['dia']; ?>/<?= $item['mes']; ?>/<?= $item['ano']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Juiz:</label>
                        <input type="text" class="form-control" id="juiz" name="juiz" value="<?= $item['juiz']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">N Partida:</label>
                        <input type="text" class="form-control" id="nPartida" name="nPartida" value="<?= $item['nPartida']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Gols Time Azul:</label>
                        <input type="text" class="form-control" id="golAzul" name="golAzul" value="<?= $item['golAzul']; ?>">
                        <label for="recipient-name" class="col-form-label">Gols Time Branco:</label>
                        <input type="text" class="form-control" id="golBranco" name="golBranco" value="<?= $item['golBranco']; ?>">
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


<!-- Modal escala jogador -->
<div class="modal fade" id="escala_pat_<?= $item['partidaId']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <div class="row">
                <div class="col-12 col-md-12">
                    <form method="GET" action="escala_jogador.php">

                        <input type="hidden" id="id" name="id" value="<?= $item['partidaId']; ?>"/>
                        <input type="hidden" id="np" name="np" value="<?= $item['nPartida']; ?>"/>

                        <select class="form-control" id="timeId" name="timeId" onclick="Idtime()">
                            <option value=" ">Selecione o Time .....</option>
                            <?php
                            $consultaTime = $PDO->query("SELECT timeId, timeNome FROM time  ORDER By timeNome");
                            $resultadoConsulta = $consultaTime->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($resultadoConsulta as $itemTime) { ?>
                                <option value="<?= $itemTime['timeId']; ?>"><?= $itemTime['timeNome']; ?></option>
                            <?php } ?>
                        </select>
                        <hr/>
                        <button type="submit" value="Selecionar" name="submit" class="btn btn-primary">Selecionar</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<?php } ?>

</table>
</body>

</html>