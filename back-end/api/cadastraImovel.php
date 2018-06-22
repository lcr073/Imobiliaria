<?php
/*
 * API DE CADASTRAMENTO DE IMOVEL
 * Parametros esperados de entrada:
 *      *Id Dono
 *      *tipo
 *      *n quartos
 *      *n banheiros
 *      *valor aluguel
 *      *rua
 *      *area
 *      *bairro
 *      *estado
 *      *cidade
 *      *contato tel
 *      *contato email
 *      *cep
 *  exemplo json esperado
 *
 *
 {
	"id_dono":"14",
	"tipo":"2",
	"n_quartos":"3",
	"n_banheiros":"2",
	"valor_aluguel":"2000",
	"rua":"Rua das Palmeiras",
	"area":"300",
	"bairro":"Bairro das Lagostas",
	"estado":"São Paulo",
	"cidade":"São Joaquin",
	"contato_tel":"934523453",
	"contato_email":"douglas_berg@vascostore.com",
	"cep":"52098200"

 }
 *
 Saidas:
(201) Se inseriu com sucesso
(403) Não esta logado,parametros faltando,id de dono nao existe.

*/

// Recebe variaveis por Json (Retorna array indexado na variavel $obj)
    include "include/json/json_rec.php";

// Valida no banco as informações recebidas
   include "include/db/connect.php";

//Verifica se existe uma sessão estabelecida
   include "include/session.php";

    // Verifica se veio algum campo em branco
    if(!(isset($obj['id_dono']) AND isset($obj['tipo']) AND isset($obj['n_quartos']) AND isset($obj['n_banheiros']) AND isset($obj['valor_aluguel']) AND isset($obj['rua']) AND isset($obj['area']) AND isset($obj['bairro']) AND isset($obj['estado']) AND isset($obj['cidade']) AND isset($obj['contato_tel']) AND isset($obj['contato_email']) AND isset($obj['cep']) )) {
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
        // Verifica se existem o dono
        if(count($result) == 0){
            // Sai e da erro
            http_response_code(403);
            exit("O dono não existe");
        }
        else {
			try{
				//Prepara para a query
				$stmt = $dbh->prepare("INSERT INTO imoveis (tipo, n_quartos, n_banheiros, valor_aluguel, rua, area, bairro, estado, cidade, contato_tel, contato_email, cep, id_responsavel) VALUES (:TIPO,:N_QUARTOS, :N_BANHEIROS, :VALOR_ALUGUEL, :RUA, :AREA, :BAIRRO, :ESTADO, :CIDADE, :CONTATO_TEL, :CONTATO_EMAIL, :CEP, :ID_DONO)");
				
				// bindParam ajuda evitar SQLinjection
				// Vinculando parametros
				$stmt->bindParam(":TIPO",$obj["tipo"]);
				$stmt->bindParam(":N_QUARTOS",$obj["n_quartos"]);
				$stmt->bindParam(":N_BANHEIROS",$obj["n_banheiros"]);
				$stmt->bindParam(":VALOR_ALUGUEL",$obj["valor_aluguel"]);
				$stmt->bindParam(":RUA",$obj["rua"]);
				$stmt->bindParam(":AREA",$obj["area"]);
				$stmt->bindParam(":BAIRRO",$obj["bairro"]);
				$stmt->bindParam(":ESTADO",$obj["estado"]);
				$stmt->bindParam(":CIDADE",$obj["cidade"]);
				$stmt->bindParam(":CONTATO_TEL",$obj["contato_tel"]);
				$stmt->bindParam(":CONTATO_EMAIL",$obj["contato_email"]);
				$stmt->bindParam(":CEP",$obj["cep"]);
				$stmt->bindParam(":ID_DONO",$obj["id_dono"]);

				// Realmente realiza a execucao da query
				$stmt -> execute();
			}catch (Exception $e) {
				echo 'Exceção capturada: ', $e->getMessage(), "\n";
				http_response_code(403);
				exit("Erro DB");
			}			
			// Retorna o codigo 201 (Criado)
			http_response_code(201);
			exit("Imovel cadastrado");
			
        }
    }
?>