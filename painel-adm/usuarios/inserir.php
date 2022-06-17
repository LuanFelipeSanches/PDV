<?php
require_once("../../conexao.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$nivel = $_POST['nivel'];

$res = $pdo->prepare("INSERT INTO usuarios 
SET nome = :nome, email = :email, cpf = :cpf,senha = :senha,  nivel = :nivel");

$res->bindValue(':nome', $nome);
$res->bindValue(':email', $email);
$res->bindValue(':cpf', $cpf);
$res->bindValue(':senha', $senha);
$res->bindValue(':nivel', $nivel);
?>