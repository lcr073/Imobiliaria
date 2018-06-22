<?php
/*
 * API DE LISTAGEM DE CONTRATOS DE UM USUARIO
 * Parametros esperados de entrada:
 *      * id usuario
 *  exemplo json esperado
 *
 *
 {
	"id_usuario":"14",
	
 }
 *
 Saidas:
(200) Retorno das informaçoes do(s) contratos
(204) Usuario nao possui contratos
(403) Não esta logado,id de usuario nao veio,id de usuario nao existe.

*/

// Recebe variaveis por Json (Retorna array indexado na variavel $obj)
    include "include/json/json_rec.php";

// Valida no banco as informações recebidas
   include "include/db/connect.php";

//Verifica se existe uma sessão estabelecida
   include "include/session.php";
	
	$obj['id_usuario'] = $args['idusuario'];

    // Verifica se veio algum campo em branco
    if(!isset($obj['id_usuario'])) {
        // Faltou algum campo então nao é aprovada a movimentacao
        http_response_code(403);
        exit("Falta de parametros");
    }
    // Todos os campos vieram preenchidos
    else{
		try{
	        // Verifica no banco se existe algum usuario com aquele id
			$stmt = $dbh->prepare("SELECT id_user FROM usuarios WHERE id_user= :ID_USUARIO ");
			
	        // bindParam ajuda evitar SQLinjection
	        // Vinculando parametros
	        $stmt->bindParam(":ID_USUARIO",$obj['id_usuario']);

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
            exit("O usuario não existe");
        }
        else {
			try{
				//Prepara para a query
				// $stmt = $dbh->prepare("SELECT * FROM contratos WHERE id_inquilino=:ID_USUARIO ");
				//$stmt = $dbh->prepare("SELECT valor,periodo,valido,id_imovel,id_proprietario,id_inquilino FROM contratos WHERE id_inquilino=:ID_USUARIO OR id_proprietario=:ID_USUARIO ");
				
				$stmt = $dbh->prepare("SELECT * FROM contratos WHERE id_inquilino=:ID_USUARIO OR id_proprietario=:ID_USUARIO ");

				// bindParam ajuda evitar SQLinjection
				// Vinculando parametros
				$stmt->bindParam(":ID_USUARIO",$obj["id_usuario"]);

				// Realmente realiza a execucao da query
				$stmt -> execute();
				
				//Pega os itens encontrados na query
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			}catch (Exception $e) {
				echo 'Exceção capturada: ', $e->getMessage(), "\n";
				http_response_code(403);
				exit("Erro DB");
			}			
			// Verifica se existem contratos
			if(count($result) == 0){
				//Retorna o codigo 204 (Vazio)
				http_response_code(204);
				exit("Esse usuario nao possui contrato");
			}
			else {
				//Retorna o codigo 200 (OK)
				
				// Realiza a conversão para poder enviar a imagem pelo json
				$result[0]["img_contrato"] = base64_encode($result[0]["img_contrato"]);
				http_response_code(200);
				echo json_encode($result);				
			}
			
        }
    }
?>