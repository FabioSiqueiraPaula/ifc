<?php
include_once("./functions/init.php");
include_once("./functions/function.php");

$id = $_GET['id'];
$np = $_GET['np'];

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
</head>

<body>
<?php
$busca = $PDO->prepare("SELECT * FROM partida WHERE partidaid = $id");
$busca->execute();
$linha = $busca->fetchAll(PDO::FETCH_OBJ);

foreach ($linha

as $listar) {
?>
<div class="row text-white">
    <div class="left card bg-info col-sm-4" style="border-radius: 25px;">
        ESCALA DO PARTIDA N° <?= $listar->nPartida ?> DO DIA: <?= $listar->dia; ?> / <?= $listar->mes; ?>
        / <?= $listar->ano; ?>
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

<hr/>

<div class="row">
    <div class="col-12 col-md-12">
        <form method="GET" action="escala_jogador.php">

            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"/>
            <input type="hidden" id="np" name="np" value="<?php echo $np; ?>"/>

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

</body>
</html>