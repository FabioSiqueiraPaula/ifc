<?php
    include_once("./functions/init.php");
    include_once("./functions/function.php");

    $id = $_GET['id'];

    if (isset($_POST['acao']) && $_POST['acao'] == 'cad_partida_jogador') {
        $partidaId = $_POST['partidaId'];
        $timeId = $_POST['timeId'];
        $jogadorId = $_POST['jogadorId'];
        $gol = $_POST['gol'];        
        $ca = $_POST['ca'];
        $cv = $_POST['cv'];
        
         
        try {
            $sqlInsert = "INSERT INTO jogadorpartida (partidaId,timeId,jogadorId,gol,ca,cv)
                                              VALUES (?,?,?,?,?,?)";
        
        $statement = $PDO->prepare($sqlInsert);
        $statement->execute([$partidaId, $timeId, $jogadorId, $gol, $ca, $cv]);
        
             if ($statement ->rowCount() == 1){
        
                 $result = print "<p style='color:green;'>Cadastrado com Sucesso</p>";
        
             }
           
            }
            catch(PDOException $e)
            {
                $result = print "<p style='color:red;'>Erro no Cadastro: " . $e->getMessage() . "</p>";               
    
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
  <script src="./js/bootstrap.min.js"></script>  
    <script>
    $(document).ready(function()
    {
        $('#termo_busca').keyup(function()
        {
            $.ajax({
              type: 'POST',
              url:  'busca_jogador_ajax.php',
              data: {
                  nome: $("#termo_busca").val()
              },
              success: function(data) 
              {
                $('#jogadorId').html(data);
              }
            });
        });

    });
    </script>
    <style>
        body { font-size:14pt; padding:5%; }
        #jogadorId { width:500px; }
    </style>
</head>
<body>

<div class="row">
    <div class="col-md-12 offset-md-12" style="font-size:16px; font-weight:bold;">
        <?php
            $busca = $PDO->prepare("SELECT * FROM partida WHERE partidaid = $id");
            $busca -> execute();
            $linha = $busca->fetchAll(PDO::FETCH_OBJ);

            foreach($linha as $listar){
        ?>
        ESCALA DO JOGO DO DIA:  <?= $listar->dia; ?> / <?= $listar->mes; ?> / <?= $listar->ano; ?>
        <?php } ?>
    </div>
</div>
<hr>    
<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="input-group shadow-lg p-3 mb-5 bg-white rounded">
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
<div class="row">
    <div class="col-12 col-md-12">
        <form method="post"  style="text-transform: uppercase;">

            <input type="hidden" name="acao" value="cad_partida_jogador" />
            <input type="hidden" id="partidaId" name="partidaId" value="<?php echo $id; ?>"  />

    <div class="form-row">
        <div class="form-group col-md-8">
            <label>Nome:</label>
                <select class="form-control mb-2" id="jogadorId" name="jogadorId" onclick="if( $('#jogadorId').html() == '' ){ alert('Sem resultados carregados.\n Faça uma busca digitando o nome de um Jogador.');}"></select>
        </div>
    
        <div class="form-group col-md-4">            
            <label>Time:</label>
                <select class="form-control" id="timeId" name="timeId">
                    <option value="">Selecione um Time</option>
                    <?php
                    $consultaTime =  $PDO->query("SELECT timeId, timeNome FROM time  ORDER By timeNome");
                    $resultadoConsulta = $consultaTime->fetchAll(PDO::FETCH_ASSOC);

                    foreach($resultadoConsulta as $itemTime){ 
                    ?>
                    <option value="<?= $itemTime['timeId']; ?>"><?= $itemTime['timeNome']; ?></option>
                    <?php } ?>
                </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label>CA:</label>
                <input class="form-control" type="text" id="ca" name="ca" value="0" />
        </div>

        <div class="form-group col-md-4">
            <label>CV:</label>
                <input class="form-control" type="text" id="cv" name="cv" value="0"/>
        </div>

        <div class="form-group col-md-4">
            <label>Gols:</label>
                <input class="form-control" type="text" id="gol" name="gol" value="0"/>
        </div>
    </div>

    <br>
    <button type="submit" value="Cadastrar" name="submit" class="btn btn-primary">Cadastrar</button>
    </form>
    </div>
</div>
    <br>
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

                    foreach($resultado as $item){
                        if($item['timeNome'] == 'BRANCO'){                                         
                    ?>
        <tr style="text-align: center; background-color: white;">
            <td><?= $item['dia']; ?> / <?= $item['mes']; ?> / <?= $item['ano']; ?></td>
            <td><?= $item['jogadorNome']; ?></td>
            <td><?= $item['timeNome']; ?></td>

            <?php if($item['ca'] > 0){ ?>
            <td style="background-color: yellow; color: black;"><?= $item['ca']; ?></td>
            <?php }else{ ?>
            <td><?= $item['ca']; ?></td>
            <?php } ?>

            <?php if($item['cv'] > 0){ ?>
            <td style="background-color: red;"><?= $item['cv']; ?></td>
            <?php }else{ ?>
            <td><?= $item['cv']; ?></td>
            <?php } ?>

            <td><?= $item['gol']; ?></td>
        </tr>
    <?php }else{  ?>
        <tr style="text-align: center; background-color: blue; color: white;">
            <td><?= $item['dia']; ?> / <?= $item['mes']; ?> / <?= $item['ano']; ?></td>
            <td><?= $item['jogadorNome']; ?></td>
            <td><?= $item['timeNome']; ?></td>

            <?php if($item['ca'] > 0){ ?>
            <td style="background-color: yellow; color: black;"><?= $item['ca']; ?></td>
            <?php }else{ ?>
            <td><?= $item['ca']; ?></td>
            <?php } ?>

            <?php if($item['cv'] > 0){ ?>
            <td style="background-color: red;"><?= $item['cv']; ?></td>
            <?php }else{ ?>
            <td><?= $item['cv']; ?></td>
            <?php } ?>

            <td><?= $item['gol']; ?></td>
        </tr>

        <?php } } ?>
    </table>

</body>
<html>