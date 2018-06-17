<?php

	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;

	require 'composer/vendor/autoload.php';

	$app = new \Slim\App;

	$app->any('/', function () {
		echo VASCODECALABRESA;
	});

	// Chegando utilizando o /login/
	$app->any('/login/',function(){
		include 'api/sistemaLogin.php';
		//$json = $req->getBody();
		//echo "$json";

	});

	// Rota para cadastrar usuario
	$app->any('/cadastraUsuario/',function(){
		include 'api/cadastraUsuario.php';
		//$json = $req->getBody();
		//echo "$json";

	});	

	// Chegando utilizando parametros
	$app->get('/logon/{name}', function (Request $request, Response $response, array $args) {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
	//echo '$args[\'name\']';
    return $response;
});
	$app->run();

?>
