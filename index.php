<?php

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
  <script src="./js/bootstrap.min.js"></script>   

    <title>SIS IFC</title>

    <script language="JavaScript">    
        function MM_openBrWindow(theUrl, winName, features) {
        window.open(theUrl, winName, features);
        }
    </script>

</head>
<body>
    <?php
        require 'header.php';
    ?>
 <table cellpadding="1" cellspacing="10"  width="100%" align="center" style="background-color:#033" class="table">
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
                                    <option value="<?php echo $i ?>" <?php if ($i == $ano_hoje) echo "selected=selected" ?> ><?php echo $i ?></option>
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
                
                <table class="table table-success table-striped" style="text-transform: uppercase; border: #005B5B; font-size:16px; font-weight:bold;" border="1">
                    <thead>
                        <tr style="text-align: center;">
                            <td colspan="2"></td>                            
                            <td colspan="2" style="background-color: #033; color: #FFF;">placar</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr style="text-align: center;">
                            <th scope="col" style="text-align: center;">Dia</th>
                            <th scope="col">Juiz</th>
                            <th scope="col" style="background-color: blue; color: #FFF;">Gols Time azul</th>
                            <th scope="col" style="background-color: white;"> Gols Time Branco</th>
                            <th scope="col">escalar Jogadores</th>  
                            <th>detalhe da partida</th>                          
                        </tr>
                    </thead>
                    <?php
                    $consulta =  $PDO->query("SELECT * FROM partida WHERE mes='$mes_hoje' && ano='$ano_hoje' ORDER By dia");
                    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

                    foreach($resultado as $item){                                            
                    ?>
                    <tr style="text-align: center;">
                        <th scope="row"><?= $item['dia']; ?></th>
                        <td><?= $item['juiz']; ?></td>                        
                        <td>
                        <?= $item['golAzul']; echo '<br />';
                            if($item['golAzul'] > $item['golBranco'])
                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-award-fill" viewBox="0 0 16 16">
                                <path d="m8 0 1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864 8 0z"/>
                                <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
                              </svg>' 
                        ?>
                        </td>
                        <td>
                        <?= $item['golBranco']; echo '<br />';
                            if($item['golAzul'] < $item['golBranco'])
                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-award-fill" viewBox="0 0 16 16">
                            <path d="m8 0 1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864 8 0z"/>
                            <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
                          </svg>' 
                        ?>
                        </td>
                        <td>
                            <a href="javascript:void(0)" onClick="MM_openBrWindow('escala_jogador.php?id=<?= $item['partidaId']; ?>','','scrollbars=no, width=auto, height=500, left=0, top=0')"> escalar</a></td>
                        <td><a href="javascript:void(0)" onClick="MM_openBrWindow('detalhe_escalacao.php?id=<?= $item['partidaId']; ?>','','scrollbars=no, width=auto, height=500, left=0, top=0')">SUMULA</a></td>
                    </tr>
                    <?php } ?>
                </table>
</body>
</html>