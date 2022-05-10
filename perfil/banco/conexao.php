<?php

session_start();


$servidor="localhost";
$usuario="root";
$senha="";
$banco="perfil";



try{
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco",$usuario,$senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Banco conectado com sucesso!";

}catch(PDOException $erro){
    echo "Falha ao se conectar com o banco!";

}

function limpaPost($dados){
    $dados = trim($dados);
    $dados = stripslashes($dados);
    $dados = htmlspecialchars($dados);
    return $dados;
}

function autentica($tokenSessao){
    global $pdo;
    //Verificar se tem autorização
$sql = $pdo->prepare("SELECT * FROM tabela_perfil WHERE token=? LIMIT 1");
$sql->execute(array($tokenSessao));
$usuario = $sql->fetch(PDO::FETCH_ASSOC);

//Se não encontrar usuário

if(!$usuario){
    return false;
}else{
    return $usuario;
    }
}

?>