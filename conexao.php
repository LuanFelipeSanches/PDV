<?php
require_once('config.php');

date_default_timezone_set('America/Campo_Grande');

try{
$pdo = new PDO("mysql:dbname=$banco;host=$servidor;charset=utf8","$usuario","$senha");
}catch(Exception $e){
    echo "Error ao conectar com o banco de dados!"."<br />".$e->getMessage;
}
?>