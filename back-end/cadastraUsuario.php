<?php
/**
 * Created by PhpStorm.
 * User: lcr07
 * Date: 04/05/2018
 * Time: 15:44
 */

// Recebe variaveis por Json (Retorna array indexado na variavel $obj)
    include "include/json/json_rec.php";

// Valida no banco as informações recebidas
   include "include/db/connect.php";

    // Verifica no banco se ja tem algum usuario com aquele nome ou email escolhido
    //Prepara para a query
    $stmt = $dbh->prepare("SELECT  id FROM tbl_user WHERE usuario= :USUARIO OR email= :EMAIL;");

     // bindParam ajuda evitar SQLinjection
    $usuario = $obj['usuario'];
    $email = $obj['email'];
    $stmt->bindParam(":USUARIO",$usuario);
    $stmt->bindParam(":EMAIL",$email);

   $stmt -> execute();
   // Exibe a quantidade de itens encontrados na query
   $qtd_result = $stmt->rowCount();

  // Validando se tem usuario com aquela senha
  if($qtd_result  > 0){
     // Sai e da erro
      // Ver o retorno de codigo
      http_response_code(403);
      exit("Nome de usuario ou email ja existente");
  }

  else{
      // Validar dados e se estiver tudo correto cadastrar no DB
      // Verifica se tudo veio preenchido

        // Tudo veio preenchido
        if(isset($obj['nome']) AND isset($obj['usuario']) AND isset($obj['email']) AND isset($obj['senha'])){
            // Realiza operação de hash na senha para armazena-la no DB

            $senha = password_hash($obj['senha'], PASSWORD_DEFAULT);

            // Realiza insercao DB
            $stmt = $dbh->prepare("INSERT INTO tbl_user (nome, usuario, email, senha) VALUES (:NOME, :USUARIO, :EMAIL, :SENHA)");
            $stmt->bindParam(":NOME", $obj['nome']);
            $stmt->bindParam(":USUARIO", $obj['usuario']);
            $stmt->bindParam(":EMAIL", $obj['email']);
            $stmt->bindParam(":SENHA", $senha);
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