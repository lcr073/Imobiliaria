<?php
/**
 * Created by PhpStorm.
 * User: lcr07
 * Date: 04/05/2018
 * Time: 15:44
 */

/*
 * API DE CADASTRAMENTO DE RECLAMACAO
 * Parametros esperados de entrada:
 *      * Id do contrato
 *      * Descricao da reclamacao
 *
 *  exemplo json esperado
 *
 *
 {
	"id_contrato":"1",
	"descr_reclamacao" : "O apartamento era muito bom porem tinha ...."
 }
 *
 Saidas:
(201) Se inseriu com sucesso
(403) + Houve algum erro (Se algum campo nao veio preenchido)
 */

// Recebe variaveis por Json (Retorna array indexado na variavel $obj)
    include "include/json/json_rec.php";

// Valida no banco as informações recebidas
   include "include/db/connect.php";

//Verifica se existe uma sessão estabelecida
   include "include/session.php";
   
    // Verifica se veio algum campo em branco
    if(!(isset($obj['id_contrato']) AND isset($obj['descr_reclamacao']))) {
        // Faltou algum campo então nao é aprovada a movimentacao
        http_response_code(403);
        exit("Houve algum erro");
    }
    // Todos os campos vieram preenchidos
    else{
        // Verifica no banco se ja tem algum contrato com aquele id escolhido
        //Prepara para a query
        $stmt = $dbh->prepare("SELECT id FROM reclamacoes WHERE id_contrato= :IDCONTRATO;");
		
        // bindParam ajuda evitar SQLinjection
        // Vinculando parametros de entrada nas variaveis
        $id_contrato = $obj['id_contrato'];
        $descr_reclamacao = $obj['descr_reclamacao'];

        // Vinculando parametros
        $stmt->bindParam(":IDCONTRATO",$id_contrato);

        // Realmente realiza a execucao da query
        $stmt -> execute();
		
        // Exibe a quantidade de itens encontrados na query
        $qtd_result = $stmt->rowCount();

        // Validando se tem um contrato com aquele ID
        if($qtd_result  == 0){
            // Sai e da erro
            http_response_code(403);
            exit("Nenhum contrato com esse ID encontrado");
        }
        else {
            // Validar dados e se estiver tudo correto cadastrar no DB

            try {
                // Realiza insercao de reclamacao
                $stmt = $dbh->prepare("INSERT INTO reclamacoes (id_contrato, descr_reclamacao) VALUES (:IDCONTRATO, :DESCRRECLAMACAO)");

                // Vinculando parametros
                $stmt->bindParam(":IDCONTRATO",$id_contrato);
                $stmt->bindParam(":DESCRRECLAMACAO", $descr_reclamacao);

                // Realmente executa a query
                $stmt->execute();

            } catch (Exception $e) {
                echo 'Exceção capturada: ', $e->getMessage(), "\n";
                http_response_code(403);
                exit("Erro DB");
            }

            // Busca no DB o ID gerado na insercao

            // Retorna o codigo 201 (Criado)
            http_response_code(201);
            exit("Reclamacao cadastrada");
        }
    }
?>