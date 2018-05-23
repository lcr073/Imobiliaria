<?php
/**
 * Created by PhpStorm.
 * User: lcr07
 * Date: 04/05/2018
 * Time: 15:44
 */

/*
 * API DE CADASTRAMENTO DE USUARIO
 * Parametros esperados de entrada:
 *      * Nome completo
 *      * email
 *      * senha
 *      * cpf
 *      * rg
 *      * tel_contato
 *
 *  exemplo json esperado
 *
 *
 {
	"nome_completo":"nome_Completo_usuario5",
	"email" : "email5",
	"senha" : "12345678",
	"cpf" : "222222222",
	"rg" : "22323232323",
	"tel_contato" : 29292929
}
 *
 Saidas:
(201) Se inseriu com sucesso
(403) + Nome de usuario ou CPF ou RG ja existentes
(403) + Houve algum erro (Se algum campo nao veio preenchido)
 */

// Recebe variaveis por Json (Retorna array indexado na variavel $obj)
    include "../include/json/json_rec.php";

// Valida no banco as informações recebidas
   include "../include/db/connect.php";

    // Verifica no banco se ja tem algum usuario com aquele nome ou email escolhido
    //Prepara para a query
    $stmt = $dbh->prepare("SELECT  id FROM tab_user WHERE email= :EMAIL OR cpf= :CPF OR rg= :RG;");

    // bindParam ajuda evitar SQLinjection
    // Vinculando parametros de entrada nas variaveis
    $email = $obj['email'];
    $cpf = $obj['cpf'];
    $rg = $obj['rg'];

    // Vinculando parametros
    $stmt->bindParam(":EMAIL",$email);
    $stmt->bindParam(":CPF",$cpf);
    $stmt->bindParam(":RG",$rg);

    // Realmente realiza a execucao da query
    $stmt -> execute();

   // Exibe a quantidade de itens encontrados na query
   $qtd_result = $stmt->rowCount();

  // Validando se tem usuario com aquela senha
  if($qtd_result  > 0){
     // Sai e da erro
      // Ver o retorno de codigo
      http_response_code(403);
      exit("Nome de usuario, CPF ou RG ja existente");
  }

  else{
      // Validar dados e se estiver tudo correto cadastrar no DB
      // Verifica se tudo veio preenchido

        // Tudo veio preenchido
        if(isset($obj['nome_completo']) AND isset($obj['email']) AND isset($obj['senha']) AND isset($obj['cpf']) AND isset($obj['rg']) AND isset($obj['tel_contato'])){
            // Realiza operação de hash na senha para armazena-la no DB

            $senha = password_hash($obj['senha'], PASSWORD_DEFAULT);

            try{
            // Realiza insercao User
            $stmt = $dbh->prepare("INSERT INTO tab_user (email, senha) VALUES (:EMAIL, :SENHA)");

            // Vinculando parametros

            $stmt->bindParam(":EMAIL",$email);
            $stmt->bindParam(":SENHA", $senha);

            // Realmente executa a query
            $stmt -> execute();

            echo $stmt->debugDumpParams();
            } catch (Exception $e){
                echo 'Exceção capturada: ', $e->getMessage(), "\n";
                http_response_code(403);
                exit("Erro DB")
            }

            // Realiza insercao usuarios
          //  $stmt = $dbh->prepare("INSERT INTO usuarios (nome_completo, cpf, rg, tel_contato) VALUES (:NOME_COMPLETO, :CPF, :RG, :TEL_CONTATO)");
            $stmt = $dbh->prepare("INSERT INTO usuarios (id_user, nome_completo, cpf, rg, tel_contato) VALUES (1,:NOME_COMPLETO, :CPF, :RG, :TEL_CONTATO)");

            // Vinculando parametros de entrada nas variaveis
            $nome_completo = $obj['nome_completo'];
            $tel_contato = $obj['tel_contato'];

            // Vinculando parametros/
            $stmt->bindParam(":NOME_COMPLETO",$nome_completo);
            $stmt->bindParam(":TEL_CONTATO", $tel_contato);
            $stmt->bindParam(":CPF",$cpf);
            $stmt->bindParam(":RG",$rg);

            // Realmente executa a query
            $stmt -> execute();

            // Vai para nova pagina e retorna o codigo 201 (Criado)
            http_response_code(201);
            // header('Location: novoUsuarioCadastrado.php',true,201);

        }
        // Algum campo não veio preenchido
        else{
            // Faltou algum campo então nao é aprovada a movimentacao
            http_response_code(403);
            exit("Houve algum erro");
        }
      // Sofisticação .... REGEX

     // header('Location: index.php');
      exit;
  }
?>