<?php
/*
 * API DE LISTAGEM DE RECLAMAÇÕES DE UM CONTRATO
 * Parametros esperados de entrada:
 *      * id contrato
 *  exemplo json esperado
 *
 *
 {
	"id_contrato":"3",
 }
 *
 Saidas:
(200) Retorno das informaçoes da(s) reclamacoes
(204) Contrato nao existe
(403) Não esta logado,id de usuario nao veio,id de usuario nao existe.

*/

// Recebe variaveis por Json (Retorna array indexado na variavel $obj)
    include "include/json/json_rec.php";

// Valida no banco as informações recebidas
   include "include/db/connect.php";

	//Verifica se existe uma sessão estabelecida
/*	if(!(isset($_SESSION['id_user']))){
		http_response_code(403);
		exit("Usuario não logado");
	}
*/	
	$obj['id_contrato'] = $args['id_contrato'];

    // Verifica se veio algum campo em branco
    if(!isset($obj['id_contrato'])) {
        // Faltou algum campo então nao é aprovada a movimentacao
        http_response_code(403);
        exit("Falta de parametros");
    }
    // Todos os campos vieram preenchidos
    else{
		try{
	        // Verifica no banco se existe algum contrato com aquele id
			$stmt = $dbh->prepare("SELECT id FROM contratos WHERE id = :ID_CONTRATO");
			
	        // bindParam ajuda evitar SQLinjection
	        // Vinculando parametros
	        $stmt->bindParam(":ID_CONTRATO",$obj['id_contrato']);

	        // Realmente realiza a execucao da query
	        $stmt -> execute();
			
			//Pega os itens encontrados na query
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		}catch (Exception $e) {
			echo 'Exceção capturada: ', $e->getMessage(), "\n";
			http_response_code(403);
			exit("Erro DB");
        }
        // Verifica se existem o dono
        if(count($result) == 0){
            // Sai e da erro
            http_response_code(403);
            exit("Esse contrato não existe");
        }
        else {
			try{
				//Prepara para a query
				// $stmt = $dbh->prepare("SELECT * FROM contratos WHERE id_inquilino=:ID_USUARIO ");
				//$stmt = $dbh->prepare("SELECT valor,periodo,valido,id_imovel,id_proprietario,id_inquilino FROM contratos WHERE id_inquilino=:ID_USUARIO OR id_proprietario=:ID_USUARIO ");
				
				$stmt = $dbh->prepare("SELECT * FROM reclamacoes WHERE id_contrato=:ID_CONTRATO");

				// bindParam ajuda evitar SQLinjection
				// Vinculando parametros
				$stmt->bindParam(":ID_CONTRATO",$obj["id_contrato"]);

				// Realmente realiza a execucao da query
				$stmt -> execute();
				
				//Pega os itens encontrados na query
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			}catch (Exception $e) {
				echo 'Exceção capturada: ', $e->getMessage(), "\n";
				http_response_code(403);
				exit("Erro DB");
			}			
			// Verifica se existem reclamacoes
			if(count($result) == 0){
				//Retorna o codigo 204 (Vazio)
				http_response_code(204);
				exit("Esse contrato nao possui reclamacoes");
			}
			else {
				//Retorna o codigo 200 (OK)
				http_response_code(200);
				echo json_encode($result);				
			}
			
        }
    }
?>