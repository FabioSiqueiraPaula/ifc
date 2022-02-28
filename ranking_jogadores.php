<html>

<body>

<?php
require_once("header.php");
?>

<div class="row">
    <div class="left card bg-info text-white col-sm-12" style="border-radius: 25px; text-align: center;
                    color: #FFF;
                    background-image: -ms-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: -moz-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: -o-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #00510F), color-stop(100, #17882C));
                    background-image: -webkit-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: linear-gradient(to bottom, #00510F 0%, #17882C 100%);">
        <h1>classificação dos jogadores</h1>
    </div>
</div>

<div class="row" style="padding-right: 25px; padding-left: 25px; padding-top: 15px;">

    <?php

    // Soma de Total de Gols
    $consultaGol = $PDO->query("    
            SELECT j.jogadorId, j.jogadorNome, SUM(jp.gol) as TotalGol FROM jogadorpartida jp
                INNER JOIN jogador j
                ON (jp.jogadorId = j.jogadorId)
            GROUP BY j.jogadorId
            ORDER BY TotalGol DESC");
    $resultadoGol = $consultaGol->fetchAll(PDO::FETCH_ASSOC);

    // Soma de Total de Cartoes
    $consultaCart = $PDO->query("    
        SELECT j.jogadorNome, SUM(jp.ca) as TotalCA, SUM(jp.cv) as TotalCV  FROM jogadorpartida jp
            INNER JOIN jogador j
            ON (jp.jogadorId = j.jogadorId)
        GROUP BY j.jogadorId
        ORDER BY TotalCV, TotalCA ASC");
    $resultadoCart = $consultaCart->fetchAll(PDO::FETCH_ASSOC);


    //Consulta Jogadores Vitoria, Derrotas, Empates e pontos
    $consultaPontos = $PDO->query("
        SELECT j.jogadorNome, 
            SUM(jp.vitoria) as TotalV, 
            SUM(jp.derrota) as TotalD, 
            SUM(jp.empate) as TotalE,
            SUM(jp.ponto) as TotalP
        FROM jogadorpartida jp
            INNER JOIN jogador j
            ON (jp.jogadorId = j.jogadorId)
        GROUP BY j.jogadorId
        ORDER BY TotalP DESC");
    $resultadoPontos = $consultaPontos->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="left card bg-info text-white col-sm-4" style="border-radius: 25px; text-align: center;
                    color: #FFF;
                    background-image: -ms-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: -moz-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: -o-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #00510F), color-stop(100, #17882C));
                    background-image: -webkit-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: linear-gradient(to bottom, #00510F 0%, #17882C 100%);">
        <table class="table" style="color: #FFF;">
            <thead>
            <tr>
                <th colspan="3">Classificação Artileiro <img src="./img/soccer-ball.png" width="40px"
                                                             style="background-color: #FFF; border-radius: 50%;"></th>
            </tr>
            <tr style="background-color: #17882C;">
                <th>#</th>
                <th>Jogador</th>
                <th>Gols<img src="./img/soccer-ball.png" width="40px"></th>
            </tr>
            </thead>
            <?php
            $count = 1;
            foreach ($resultadoGol as $itemGol) {
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?= $itemGol['jogadorNome']; ?></td>
                    <td><?= $itemGol['TotalGol']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="left card bg-info text-white col-sm-4" style="border-radius: 25px; text-align: center;
                    color: #FFF;
                    background-image: -ms-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: -moz-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: -o-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #00510F), color-stop(100, #17882C));
                    background-image: -webkit-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: linear-gradient(to bottom, #00510F 0%, #17882C 100%);">
        <table class="table" style="color: #FFF;">
            <thead>
            <tr>
                <th colspan="6">Vitorias / Empates / Derrotas <img src="./img/vitoria.png" width="40px"></th>
            </tr>
            <tr style="background-color: #17882C">
                <th>#</th>
                <th>Jogador</th>
                <th>V</th>
                <th>E</th>
                <th>D</th>
                <th>Pontuação <img src="./img/pontuacao.png" width="20px"></th>
            </tr>
            </thead>
            <?php

            $count = 1;

            foreach ($resultadoPontos as $itemP) {
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?= $itemP['jogadorNome']; ?></td>
                    <td><?= $itemP['TotalV']; ?></td>
                    <td><?= $itemP['TotalE']; ?></td>
                    <td><?= $itemP['TotalD']; ?></td>
                    <td style="text-align: center;"><?= $itemP['TotalP']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="left card bg-info text-white col-sm-4" style="border-radius: 25px; text-align: center;
                    color: #FFF;
                    background-image: -ms-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: -moz-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: -o-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #00510F), color-stop(100, #17882C));
                    background-image: -webkit-linear-gradient(top, #00510F 0%, #17882C 100%);
                    background-image: linear-gradient(to bottom, #00510F 0%, #17882C 100%);">
        <table class="table" style="color: #FFF;">
            <thead>
            <tr>
                <th colspan="4">Classificação Disciplinado<img src="./img/cartoes.png" width="40px"></th>
            </tr>
            <tr style="background-color: #17882C">
                <th>#</th>
                <th>Jogador</th>
                <th>T. CA <img src="./img/cartao_a.png" width="40px"></th>
                <th>T. CV <img src="./img/cartao_v.png" width="40px"></th>
            </tr>
            </thead>
            <?php
            $count = 1;
            foreach ($resultadoCart as $itemCart) {
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?= $itemCart['jogadorNome']; ?></td>
                    <td><?= $itemCart['TotalCA']; ?></td>
                    <td><?= $itemCart['TotalCV']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

</div>
</body>

</html>