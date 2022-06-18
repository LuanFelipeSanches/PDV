<?php
require_once("../../conexao.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$senha = $_POST['senha'];
$nivel = $_POST['nivel'];
$id = $_POST['id'];

$cpf_antigo = $_POST['cpf_antigo'];
$email_antigo = $_POST['email_antigo'];

//EVITAR DUPLICIDADE NO EMAIL
if($email_antigo != $email){
$query_con = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
$query_con->bindValue(":email", $email);
$query_con->execute();
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
if (@count($res_con) > 0) {
    echo 'O email do usuário já está cadastrado!';
    exit();
}
}

//EVITAR DUPLICIDADE NO CPF
if($cpf_antigo != $cpf){
$query_con = $pdo->prepare("SELECT * FROM usuarios WHERE cpf = :cpf");
$query_con->bindValue(":cpf", $cpf);
$query_con->execute();
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
if (@count($res_con) > 0) {
    echo 'O CPF do usuário já está cadastrado!';
    exit();
}}


//INSERT
if ($id == "") {
    $res = $pdo->prepare("INSERT INTO usuarios 
SET nome = :nome, email = :email, cpf = :cpf, senha = :senha, nivel = :nivel");

    $res->bindValue(':nome', $nome);
    $res->bindValue(':email', $email);
    $res->bindValue(':cpf', $cpf);
    $res->bindValue(':senha', $senha);
    $res->bindValue(':nivel', $nivel);
    $res->execute();
} else {
    //UPDATE
    $res = $pdo->prepare("UPDATE  usuarios SET
     nome = :nome, email = :email, cpf = :cpf, senha = :senha, nivel = :nivel WHERE id = :id");
    $res->bindValue(':nome', $nome);
    $res->bindValue(':email', $email);
    $res->bindValue(':cpf', $cpf);
    $res->bindValue(':senha', $senha);
    $res->bindValue(':nivel', $nivel);
    $res ->bindValue(':id', $id);
    $res->execute();
}
echo 'Salvo com Sucesso!';
