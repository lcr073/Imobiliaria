<?php
/*
 * API DE CRIAÇÃO DE CONTRATO
 * Parametros esperados de entrada:
 *      * id dono
 *      * id cliente
 *      * valor
 *      * banco(nao usado)
 *      * id imovel
 *      * img_contrato
 *      * periodo
 *  exemplo json esperado
 *
 *
 {
	"id_dono":"11",
	"id_cliente":"14",
	"valor":"14000",
	"id_imovel":"4",
	"img_contrato":"fudeo meu parceiro",
	"periodo":"20"
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
	if(isset($_SESSION['user'])){
		http_response_code(403);
		exit("Usuario não logado");
	}
	
    // Verifica se veio algum campo em branco
   if(!(isset($obj['id_dono']) AND isset($obj['id_cliente']) AND isset($obj['valor']) AND isset($obj['id_imovel']) AND isset($obj['img_contrato']) AND isset($obj['periodo']))) {
        // Faltou algum campo então nao é aprovada a movimentacao
        http_response_code(403);
        exit("Falta de parametros");
    }
    // Todos os campos vieram preenchidos
    else{
		try{
        // Verifica no banco se existe algum dono com aquele id
		$stmt = $dbh->prepare("SELECT id_user FROM usuarios WHERE id_user= :ID_DONO ");
		
        // bindParam ajuda evitar SQLinjection
        // Vinculando parametros
        $stmt->bindParam(":ID_DONO",$obj['id_dono']);

        // Realmente realiza a execucao da query
        $stmt -> execute();
		
		//Pega os itens encontrados na query
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
        // Verifica no banco se existe algum cliente com aquele id
		$stmt = $dbh->prepare("SELECT id_user FROM usuarios WHERE id_user= :ID_CLIENTE ");
		
        // bindParam ajuda evitar SQLinjection
        // Vinculando parametros
        $stmt->bindParam(":ID_CLIENTE",$obj['id_cliente']);

        // Realmente realiza a execucao da query
        $stmt -> execute();
		
		//Pega os itens encontrados na query
		$result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		}catch (Exception $e) {
			echo 'Exceção capturada: ', $e->getMessage(), "\n";
			http_response_code(403);
			exit("Erro DB");
        }
        // Verifica se existem o dono
        if(count($result) == 0 OR count($result2) == 0){
            // Sai e da erro
            http_response_code(403);
            exit("Cliente e/ou dono não existem");
        }
        else {
			try{
				//Checa se o imovel ja esta relacionado em algum contrato
				$stmt = $dbh->prepare("SELECT id FROM contratos WHERE id_imovel=:ID_IMOVEL");
				
				// bindParam ajuda evitar SQLinjection
				// Vinculando parametros
				$stmt->bindParam(":ID_IMOVEL",$obj["id_imovel"]);

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
			if(count($result) != 0){
				//Retorna o codigo 403 (Erro)
				http_response_code(403);
				exit("Este imovel ja esta cadastrado em outro contrato");
			}
			else {
				try{
					// Realiza insercao de contrato
					$stmt = $dbh->prepare("INSERT INTO contratos (valor, img_contrato, periodo, valido, id_imovel, id_proprietario, id_inquilino) VALUES (:VALOR, :IMG_CONTRATO, :PERIODO, '1', :ID_IMOVEL, :ID_PROPRIETARIO, :ID_INQUILINO)");
					// Vinculando parametros/
					$stmt->bindParam(":VALOR", $obj["valor"]);
					$stmt->bindParam(":IMG_CONTRATO", $obj["img_contrato"]);
					$stmt->bindParam(":PERIODO", $obj["periodo"]);
					$stmt->bindParam(":ID_IMOVEL", $obj["id_imovel"]);
					$stmt->bindParam(":ID_PROPRIETARIO", $obj["id_dono"]);
					$stmt->bindParam(":ID_INQUILINO", $obj["id_cliente"]);

					// Realmente executa a query
					$stmt->execute();
					
				}catch (Exception $e) {
					echo 'Exceção capturada: ', $e->getMessage(), "\n";
					http_response_code(403);
					exit("Erro DB");
				}
				// Retorna o codigo 201 (Criado)
				http_response_code(201);
			}
        }
    }
?>