<?php
/*
 * API DE LISTAGEM DE IMOVEIS DE UM USUARIO
 * Parametros esperados de entrada:
 *      * Id Dono
 *      
 *  exemplo json esperado
 *
 *
 {
	"id_dono":"2"
 }
 *
 Saidas:
(200) Retorno das informaçoes do(s) imoveis
(204) Dono não possui imoveis
(403) Não esta logado,id de dono nao veio,id de dono nao existe.

*/

// Recebe variaveis por Json (Retorna array indexado na variavel $obj)
    include "include/json/json_rec.php";

// Valida no banco as informações recebidas
   include "include/db/connect.php";

	//Verifica se existe uma sessão estabelecida
	if(!(isset($_SESSION['id_user']))){
		http_response_code(403);
		exit("Usuario não logado");
	}
	
    // Verifica se veio algum campo em branco
    if(!isset($obj['id_dono'])) {
        // Faltou algum campo então nao é aprovada a movimentacao
        http_response_code(403);
        exit("Falta de parametros");
    }
	
    // Todos os campos vieram preenchidos
    else{
		try{
			// Verifica no banco se existe usuario com aquele id
			$stmt = $dbh->prepare("SELECT id_user FROM usuarios WHERE id_user= :ID_DONO ");
			
			// bindParam ajuda evitar SQLinjection
			// Vinculando parametros
			$stmt->bindParam(":ID_DONO",$obj['id_dono']);

			// Realmente realiza a execucao da query
			$stmt -> execute();
			
			//Pega os itens encontrados na query
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}catch (Exception $e) {
			echo 'Exceção capturada: ', $e->getMessage(), "\n";
			http_response_code(403);
			exit("Erro DB");
		}
		// Verifica se existe o dono
		if(count($result) == 0){
			// Sai e da erro
			http_response_code(403);
			exit("O dono não existe");
		}
		else{
		
			try{		
				//Prepara para a query
				$stmt = $dbh->prepare("SELECT * FROM imoveis WHERE id_responsavel= :ID_DONO");
				
				// bindParam ajuda evitar SQLinjection
				// Vinculando parametros
				$stmt->bindParam(":ID_DONO",$obj["id_dono"]);

				// Realmente realiza a execucao da query
				$stmt -> execute();
				
				//Pega os itens encontrados na query
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}catch (Exception $e) {
				echo 'Exceção capturada: ', $e->getMessage(), "\n";
				http_response_code(403);
				exit("Erro DB");
			}
			// Verifica se existem imoveis
			if(count($result) == 0){
				//Retorna o codigo 204 (Vazio)
				http_response_code(204);
				exit();
			}
			else {
				//Retorna o codigo 200 (OK)
				http_response_code(200);
				echo json_encode($result);
			}
		}
		
	}
?>