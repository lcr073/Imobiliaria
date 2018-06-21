<?php

/*
 * API DE LISTAGEM DE IMOVEIS COM BASE EM UM FILTRO
 * Parametros esperados de entrada:
 *      Dinamico
 *  
 exemplo json esperado
 *
 *
 {
	"tipo":"1",
	"n_quartos":"2",
	"n_banheiros":"1",
	"valor_aluguel":"1500",
	"rua":"Antonio Marino Morelatto",
	"area":"200",
	"bairro":"Olimpico",
	"estado":"Sao Paulo",
	"cidade":"SCS"
}
 *
 Saidas:
(204) Caso a pesquisa retorne vazia
(200) Caso a pesquisa retorne resultados
(403) Houve algum erro
 */

// --- JSON vindo pelo PhpSlim
// Recebe variaveis por Json (Retorna array indexado na variavel $obj)
//    include "include/json/json_rec.php";

// Valida no banco as informações recebidas
   include "include/db/connect.php";

//Clausula Where
$where ='';

//Contador para determinar o uqe escrever entre os parametros do where
$variables = array();

  
	//Definição da clausura where,e montagem do array que irá dar Bind nos parametros
	foreach($obj as $key => $val)
	{	
		$variable_length = count($variables);
		
		if($variable_length > 0)
		{
			$where=$where." AND ";
		}
		//Verificar filtros de buscas parciais
		switch($key){
			case "rua":
			case "area":
			case "bairro":
			case "estado":
			case "cidade":
				$where=$where . $key ." LIKE :" .$key. " ";
				$val="%".$val."%";
				$key=":".$key;
				break;
			default:
				$where=$where . $key ." = :" .$key." " ;
				break;
		}
		array_push($variables,array($key,$val));
	}
	
	try{
		//Prepara para a query
		if(strlen($where) > 0)
		{
			$query="SELECT * FROM imoveis WHERE ".$where;
			$stmt = $dbh->prepare($query);
		}
		else
		{
			$stmt = $dbh->prepare("SELECT * FROM imoveis");
		}
		
			
		//Supostamente atribuir o count do array em uma variavel é melhor que colocar diretamente no loop For
		$variable_length = count($variables); 
		
		// bindParam ajuda evitar SQLinjection
		for( $i = 0 ;$i<$variable_length;$i++)
		{	
			//Vinculando parametros
			$stmt->bindParam($variables[$i][0],$variables[$i][1]);
		}
			
		// Realmente realiza a execucao da query
		$stmt -> execute();
		
		//DEBUG
		//$stmt->debugDumpParams();
		
		//Pega os itens encontrados na query
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		/*(rowCount())If the last SQL statement executed by the associated PDOStatement was a SELECT statement, 
		some databases may return the number of rows returned by that statement. However, 
		this behaviour is not guaranteed for all databases and should not be relied on for 
		portable applications. */
		
		//Checa se não existe resultados
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
	}catch (Exception $e) {
		echo 'Exceção capturada: ', $e->getMessage(), "\n";
		http_response_code(403);
		exit("Erro DB");
    }
	
?>