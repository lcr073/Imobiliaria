<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);


	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;

	require 'composer/vendor/autoload.php';

	$app = new \Slim\App;

	$app->any('/', function () {
		echo 'VASCODECALABRESA';
	});

	// Chegando utilizando o /login/
	$app->post('/login/',function(){
		include 'api/sistemaLogin.php';
	});

	// Rota para cadastrar usuario
	$app->post('/usuario/',function(){
		include 'api/cadastraUsuario.php';
	});	

	// Rota para cadastrar contrato
	$app->post('/contrato/',function(){
		include 'api/cadastraContrato.php';
	});	

	// Rota para listar os contratos de um certo usuario
	$app->get('/contrato/{idusuario}',function(Request $request, Response $response, array $args){
		include 'api/listaContratos.php';
	});		

	// Rota para criar imovel
	$app->post('/imovel/',function(){
		include 'api/cadastraImovel.php';
	});		


//dellianapptest.ddns.net:2525/imobiliaria/Imobiliaria_Backend/back-end/imovel/-1/-1/-1/-1/-1/-1/-1/-1/-1/-1/-1
	// Chegando utilizando parametros para obter imovel com todos os filtros possiveis
	$app->get('/imovel/{valor}/{endereco}/{area}/{bairro}/{nquartos}/{estado}/{nbanheiros}/{cidade}/{cep}/{contatotel}/{contatoemail}', function (Request $request, Response $response, array $args) {

		$resp = array();


		if(strcmp($args['valor'],"-1")){
			$resp['valor'] = $args['valor'];
		}

		if(strcmp($args['endereco'],"-1")){    
			$resp['endereco'] = $args['endereco'];			 
		}

		if(strcmp($args['area'],"-1")){     
			$resp['area'] = $args['area'];		   
		}

		if(strcmp($args['bairro'],"-1")){  
			$resp['bairro'] = $args['bairro'];			
		}

		if(strcmp($args['nquartos'],"-1")){ 
			$resp['nquartos'] = $args['nquartos'];		 	
		}

		if(strcmp($args['estado'],"-1")){  
			$resp['estado'] = $args['estado'];			
		}
		if(strcmp($args['nbanheiros'],"-1")){  
			$resp['nbanheiros'] = $args['nbanheiros'];			
		}

		if(strcmp($args['cidade'],"-1")){  
			$resp['cidade'] = $args['cidade'];			
		}						

		if(strcmp($args['cep'],"-1")){  
			$resp['cep'] = $args['cep'];			

		}

		if(strcmp($args['contatotel'],"-1")){     
			$resp['contatotel'] = $args['contatotel'];
		}

		if(strcmp($args['contatoemail'],"-1")){  
			$resp['contatoemail'] = $args['contatoemail'];		
		}
	
		$obj = json_encode($resp);

		include 'api/listaimoveisdisponiveis.php';

    return $response;
});
	$app->run();

?>
