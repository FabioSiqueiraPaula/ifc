<?php

define( 'MYSQL_HOST', 'localhost' );
define( 'MYSQL_USER', 'root' );
define( 'MYSQL_PASSWORD', '' );
define( 'MYSQL_DB_NAME', 'bd_ifc' );

try
{
    $PDO = new PDO( 'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB_NAME, MYSQL_USER, MYSQL_PASSWORD );
}
catch ( PDOException $e )
{
    echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
}

$PDO->exec("set names utf8");

abstract class Conexao{

    /*nesta classe só utilizo o meu user e a senha do do DB*/
    const USER = "root";
    const PASS = "";

    private static $instance = null;

    private static function conectar(){

        try{
            if(self::$instance == null):
                /*Abaixo mostro a instancia de qual DB estou utilizando e o nome do database*/
                $dsn = "mysql:host=localhost;dbname=bd_ifc";
                self::$instance = new PDO($dsn, self::USER, self::PASS);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            endif;
        }catch (PDOException $e){
            echo "Erro: ".$e->getMessage();
        }
        return self::$instance;
    }

    protected static function getDB(){
        return self::conectar();
    }

}
