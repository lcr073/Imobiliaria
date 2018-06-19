<?php

/*
 * API DE RETORNO DE IMOVEIS
 * Parametros esperados de entrada:
 *      * Nome completo
 *  
 exemplo json esperado
 *
 *
 {
	"nome_completo":"nome_Completo_usuario5",
}
 *
 Saidas:
(201) Se inseriu com sucesso
(403) + Nome de usuario ou CPF ou RG ja existentes
(403) + Houve algum erro (Se algum campo nao veio preenchido)
 */

// Recebe variaveis por Json (Retorna array indexado na variavel $obj)
    include "include/json/json_rec.php";

// Valida no banco as informações recebidas
   include "include/db/connect.php";


   // Variavel geral de ID
    $id=0;

    // Verifica se veio algum campo em branco
    if(!(isset($obj['nome_completo']) AND isset($obj['email']) AND isset($obj['senha']) AND isset($obj['cpf']) AND isset($obj['rg']) AND isset($obj['tel_contato']))) {
        // Faltou algum campo então nao é aprovada a movimentacao
        http_response_code(403);
        exit("Houve algum erro");

    }
    // Todos os campos vieram preenchidos
    else{
        // Verifica no banco se ja tem algum usuario com aquele nome ou email escolhido
        //Prepara para a query
        $stmt = $dbh->prepare("SELECT  id FROM tab_user INNER JOIN usuarios ON tab_user.id = usuarios.id_user WHERE email= :EMAIL OR cpf= :CPF OR rg= :RG;");

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
            http_response_code(403);
            exit("Email, CPF ou RG ja existente");
        }
        else {
            // Validar dados e se estiver tudo correto cadastrar no DB

            // Realiza operação de hash na senha para armazena-la no DB
            $senha = password_hash($obj['senha'], PASSWORD_DEFAULT);

            try {
                // Realiza insercao User
                $stmt = $dbh->prepare("INSERT INTO tab_user (email, senha) VALUES (:EMAIL, :SENHA)");

                // Vinculando parametros

                $stmt->bindParam(":EMAIL", $email);
                $stmt->bindParam(":SENHA", $senha);

                // Realmente executa a query
                $stmt->execute();

            } catch (Exception $e) {
                echo 'Exceção capturada: ', $e->getMessage(), "\n";
                http_response_code(403);
                exit("Erro DB");
            }

            // Busca no DB o ID gerado na insercao

            try {
                //Prepara para a query
                $stmt = $dbh->prepare("SELECT  id FROM tab_user WHERE email= :EMAIL;");

                // Vinculando parametros
                $stmt->bindParam(":EMAIL", $email);

                // Realmente realiza a execucao da query
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Para cada elemento de result
                foreach ($result as $row) {
                    // vincula o id encontrado para realizar validaçao
                    $id = $row['id'];
                }

                // Vinculando parametros de entrada nas variaveis
                $nome_completo = $obj['nome_completo'];
                $tel_contato = $obj['tel_contato'];

            } catch (Exception $e) {
                echo 'Exceção capturada: ', $e->getMessage(), "\n";
                http_response_code(403);
                exit("Erro DB");
            }

            try {
                // Realiza insercao usuarios
                $stmt = $dbh->prepare("INSERT INTO usuarios (id_user, nome_completo, cpf, rg, tel_contato) VALUES (:ID,:NOME_COMPLETO, :CPF, :RG, :TEL_CONTATO)");

                // Vinculando parametros/
                $stmt->bindParam(":ID", $id);
                $stmt->bindParam(":NOME_COMPLETO", $nome_completo);
                $stmt->bindParam(":TEL_CONTATO", $tel_contato);
                $stmt->bindParam(":CPF", $cpf);
                $stmt->bindParam(":RG", $rg);

                // Realmente executa a query
                $stmt->execute();
            } catch (Exception $e) {
                echo 'Exceção capturada: ', $e->getMessage(), "\n";
                http_response_code(403);
                exit("Erro DB");
            }

            // Retorna o codigo 201 (Criado)
            http_response_code(201);
        }
    }
?>