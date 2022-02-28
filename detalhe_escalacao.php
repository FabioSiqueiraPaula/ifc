<?php
include_once("./functions/init.php");
include_once("./functions/function.php");

$id = $_GET['id'];
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
</head>

<body>

    <div class="row">
        <div class="col-md-12 offset-md-12">
            <?php
            $busca = $PDO->prepare("SELECT * FROM partida WHERE partidaid = $id");
            $busca->execute();
            $linha = $busca->fetchAll(PDO::FETCH_OBJ);

            foreach ($linha as $listar) {
            ?>
                SUMULA DO JOGO DO DIA: <?= $listar->dia; ?> / <?= $listar->mes; ?> / <?= $listar->ano; ?>
            <?php } ?>
        </div>
    </div>
    <hr>

    <table class="table table-success table-striped" style="text-transform: uppercase; border: #005B5B; font-size:16px; font-weight:bold;" border="1">
        <thead style="text-align: center;">
            <tr>
                <th scope="col">DT Jogo</th>
                <th scope="col">Jogador</th>
                <th scope="col">Time</th>
                <th scope="col">CA</th>
                <th scope="col"> CV</th>
                <th scope="col">Gols</th>
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
                </tr>

        <?php }
        } ?>
    </table>


</body>

</html>