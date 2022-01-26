<?php
//MySQLi DESENVOLVIMENTO
$db_host="localhost";
$db_port="5432";
$db_name="bd_ifc";
$db_user="root";
$db_password="";

$dbcon = mysqli_connect( $db_host, $db_user, $db_password );
mysqli_select_db($dbcon,$db_name);
mysqli_query($dbcon,"SET NAMES 'utf8'");

$nome = mysqli_real_escape_string($dbcon,$_POST["nome"]);

// se enviar nome vazio, não carregar nada
if(trim($nome)==''){ die(); }

$query = "SELECT * FROM jogador WHERE jogadorNome like '$nome%'";

$result = mysqli_query($dbcon,$query);

$options='';

while($linha = mysqli_fetch_assoc($result))
{
     $options.='<option value="'.$linha["jogadorId"].'">'.$linha["jogadorNome"].'</option>';
}

echo $options;  // isto voltará na variável data do ajax