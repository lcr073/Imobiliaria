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
		echo FOI;
	});

	// Chegando utilizando parametros
	$app->get('/logon/',function(Request $request){
		var_dump($request);
	});

	$app->run();

?>
