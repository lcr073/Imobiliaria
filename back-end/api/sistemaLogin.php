<?php
/**
 * Created by PhpStorm.
 * User: lcr07
 * Date: 21/05/2018
 * Time: 20:19
 */

/*
 * API DE VALIDACAO DE USUARIO
 * Parametros esperados de entrada:
 *      * email
 *      * senha

 *  exemplo json esperado
 *
 *
{
	"email" : "email5",
	"senha" : "12345678"
}
 *
 Saidas:
(204) Email e senha validos
(403) Email e ou senha invalidos
 */

// Recebe variaveis por Json (Retorna array indexado na variavel $obj)
include "include/json/json_rec.php";

// Valida no banco as informações recebidas
include "include/db/connect.php";

// bindParam ajuda evitar SQLinjection
// Vinculando parametros de entrada nas variaveis
$email = $obj['email'];
// Cost é a qtd de vezes que sera executado o algoritmo para gerar o hash
$options = array("cost"=>4);

try {
    // Verifica no banco se ja tem algum usuario com aquele nome ou email escolhido
    //Prepara para a query
    $stmt = $dbh->prepare("SELECT  id,senha FROM tab_user WHERE email= :EMAIL;");

    // Vinculando parametros
    $stmt->bindParam(":EMAIL", $email);

    // Realmente realiza a execucao da query
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Para cada elemento de result
    foreach ($result as $row) {
        // Senha correta
        if (password_verify($obj['senha'], $row['senha'])) {
            // Inicia uma sessao para esse usuario
            session_start();
            // Vincula seu id nessa sessao criada
            $_SESSION["id_user"] = $row['id'];
            // Responde ao usuario
            http_response_code(202);
            echo $_SESSION["id_user"];
            echo session_id();
            // Sai da execucao
            exit("Usuario logado");
        }
    }
}catch (Exception $e) {
    echo 'Exceção capturada: ', $e->getMessage(), "\n";
    http_response_code(403);
    exit("Erro DB");
}

// Saiu do foreach é porque nada foi igual
http_response_code(403);
exit("Email e ou senha invalidos");
?>
