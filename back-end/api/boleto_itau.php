<?php

/*(INSTAVEL AINDA)
 * API DE CADASTRAMENTO DE Gera��o de Boleto
 * Parametros esperados de entrada:
 *		* id_contrato
 *		* valor
 *		* valido
 *      * data_pgmt
 *      * id_proprietario
 *      * id_inquilino

 *
 *  exemplo json esperado
 *
 *
{
	"id_contrato":"1",
	"valor" : "2000",
	"valido" : "true",
	"data_pgmt" : "02/2018",
	"id_proprietario" : "2",
	"id_inquilino" : "23"
}
 *
 Saidas:
(200) Valores condizem,boleto gerado
(403) + Contrato n�o existe,usuario n�o cadastrado,pagamento errado
(403) + Houve algum erro (Se algum campo nao veio preenchido)
 */

// IMPORTANTE
 ////Testar o if Else amanha////////

header("Content-type: text/html; charset=utf-8");
// ------------------------- DADOS DIN�MICOS DO SEU CLIENTE PARA A GERA��O DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formul�rio c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// Recebe variaveis por Json (Retorna array indexado na variavel $obj)
include "include/json/json_rec.php";

// Verifica se veio algum campo em branco
if(!(isset($obj['id_contrato']) AND isset($obj['valor']) AND isset($obj['valido']) AND isset($obj['data_pgmt']) AND isset($obj['id_proprietario']) AND isset($obj['id_inquilino']))) {
	// Faltou algum campo ent�o nao � aprovada a movimentacao
	http_response_code(403);
	exit("Houve algum erro");
}

//Verifica se o usuario esta logado
session_start();

if(isset($_SESSION['user'])){
	http_response_code(403);
	exit("Houve algum erro");
}

//Verifica se o contrato esta valido
$stmt = $dbh->prepare("SELECT valido FROM contratos WHERE id= :ID");

// Vinculando parametros
$stmt->bindParam(":ID",$obj["id_contrato"]);
// Realmente realiza a execucao da query
$stmt -> execute();
	
//Pega os itens encontrados na query
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(count($result) == 0){
		
	//Retorna o codigo 204 (Vazio)
	http_response_code(200);
	exit($result);
}
else{
	http_response_code(200);
	exit("nao existe resultado");
}

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 2.95;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = "2950,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = '12345678';  // Nosso numero - REGRA: M�ximo de 8 caracteres!
$dadosboleto["numero_documento"] = '0123';	// Num do pedido ou nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] =  utf8_encode("Nome do seu Cliente");
$dadosboleto["endereco1"] = utf8_encode("Endere�o do seu Cliente");
$dadosboleto["endereco2"] = utf8_encode("Cidade - Estado -  CEP: 00000-000");

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = utf8_encode("Pagamento de Compra na Loja Nonononono");
$dadosboleto["demonstrativo2"] = utf8_encode("Mensalidade referente a nonon nonooon nononon<br>Taxa banc�ria - R$ ".number_format($taxa_boleto, 2, ',', ''));
$dadosboleto["demonstrativo3"] = utf8_encode("BoletoPhp - http://www.boletophp.com.br");
$dadosboleto["instrucoes1"] = utf8_encode("- Sr. Caixa, cobrar multa de 2% ap�s o vencimento");
$dadosboleto["instrucoes2"] = utf8_encode("- Receber at� 10 dias ap�s o vencimento");
$dadosboleto["instrucoes3"] = utf8_encode("- Em caso de d�vidas entre em contato conosco: xxxx@xxxx.com.br");
$dadosboleto["instrucoes4"] = utf8_encode("&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br");

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - ITA�
$dadosboleto["agencia"] = "1565"; // Num da agencia, sem digito
$dadosboleto["conta"] = "13877";	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "4"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - ITA�
$dadosboleto["carteira"] = "175";  // C�digo da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

// SEUS DADOS
$dadosboleto["identificacao"] = utf8_encode("BoletoPhp - C�digo Aberto de Sistema de Boletos");
$dadosboleto["cpf_cnpj"] = "";
$dadosboleto["endereco"] = utf8_encode("Coloque o endere�o da sua empresa aqui");
$dadosboleto["cidade_uf"] = utf8_encode("Cidade / Estado");
$dadosboleto["cedente"] = utf8_encode("Coloque a Raz�o Social da sua empresa aqui");

// N�O ALTERAR!
include("../include/boleto/funcoes_itau.php"); 
include("../include/boleto/layout_itau.php");
?>
