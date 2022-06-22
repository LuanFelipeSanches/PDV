<?php 
require_once("../../conexao.php");

$id = $_POST['id'];
//Buscar a imagem para excluir da pasta
$query_con = $pdo->query("SELECT * FROM categorias WHERE id = '$id'");
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
$imagem = $res_con[0]['foto'];
unlink('../../img/categorias',$imagem)
$query_con = $pdo->query("DELETE FROM categorias WHERE id = '$id'");
echo 'Excluído com Sucesso!';

 ?>