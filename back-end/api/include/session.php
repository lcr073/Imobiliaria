<?php
	session_start();
	echo $_SESSION["id_user"];

	echo session_id();
	if(!(isset($_SESSION['id_user']))){
		http_response_code(403);
		exit("Usuario não logado");
	}
?>
