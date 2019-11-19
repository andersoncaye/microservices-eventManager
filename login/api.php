<?php

	require 'lib/Slim/Slim.php';
	\Slim\Slim::registerAutoloader();
	require 'lib/Database.php';

	define('DB_TYPE', 'mysql');
	define('DB_HOST', 'mysql04-farm76.kinghost.net'); //local
	define('DB_NAME', 'syscoffe03'); //banco
	define('DB_USER', 'syscoffe03'); //usuario
	define('DB_PASS', 'olamundo2019'); //senha
	$database = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

	$app = new \Slim\Slim();

	$app->get('/', function (){

		include 'index.php';

	});

	$app->get('/login', function (){

		include 'index.php';

	});

	$app->post('/login', function() use ($app, $database) {
		//$nome = $app->request()->getBody();
        $temp = $app->request()->headers->all();
        $nome = json_encode($temp);
        //echo $nome;
        $nome = json_decode($nome);

		$return = array('ERRO' => 'ERRO' );

		if(isset($nome->Email) && isset($nome->Senha))
		{

			$post_email = $nome->Email;
			$post_senha = $nome->Senha;

			$array = array(
				'email' => $post_email,
				'senha' => $post_senha
			);

			$return = $database->select("SELECT email FROM usuarios WHERE email = {$post_email} AND senha = {$post_senha} LIMIT 1");

			if ($return->email == $post_email) {
				$array['email'] = $return->email;
				$array['status'] = TRUE;
			} else {
				$array['email'] = $return->email;
				$array['status'] = FALSE;
			}

		} else {
            $array = array( 'erro' => 'campo obrigatorio.');
			$array['campos'] = array(
				'email' => 'obrigatorio', 
				'senha'=>'obrigatorio'
			);
		}

		echo json_encode($array);
	});

	$app->run();

?>
