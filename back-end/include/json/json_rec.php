<?php
/**
 * Created by PhpStorm.
 * User: lcr07
 * Date: 04/05/2018
 * Time: 17:34
 */


// Recebendo informaçoes da entrada default do php
$body = file_get_contents('php://input');
// Retira espaços em branco
$body = trim($body);
// Gera um array indexado atraves do json recebido
$obj  = json_decode($body,true);

 // echo var_dump($obj);
// echo $obj['nome'] " " $obj['pass'];

/*
$host = '127.0.0.1:3306';
$db = 'imobiliaria';
$user = 'teste';
$pass = '12345678';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass);
$stmt = $pdo->prepare("INSERT INTO tbl_user (nome, email, senha) VALUES (:NOME, :EMAIL, :SENHA)");
//$nome = "user5";
//$email = "email5";
//$senha = "senha5";
$stmt->bindParam(":NOME", $obj['nome']);
$stmt->bindParam(":EMAIL", $obj['email']);
$stmt->bindParam(":SENHA", $obj['senha']);
$stmt->execute();
echo "Se bau foi!"
*/

?>
