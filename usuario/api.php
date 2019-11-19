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

	/*
		Método GET
	*/

	$app->get('/usuario/show/', function () use ($database) {

		$query = "SELECT * FROM usuarios WHERE deletado = 0";
		$return = $database->select($query);
		
        echo json_encode($return);

	});

	/*
		Método GET
	*/

	$app->get('/usuario/:dados', function($dados) use ($database) {

		$dados = (int) $dados;
        $query = "SELECT * FROM usuarios WHERE id=".$dados;
        $return = $database->select($query);

        echo json_encode($return);

	});

	/*
		Método POST
		Tipo STORE = INSERT
	*/

	$app->post('/usuario/store', function() use ($app, $database) {
		//$nome = $app->request()->getBody();
        $temp = $app->request()->headers->all();
        $nome = json_encode($temp);
        //echo $nome;
        $nome = json_decode($nome);

		$return = array('ERRO' => 'ERRO' );

		if(
			isset($nome->Documento) && 
			isset($nome->Email)	&& 
			isset($nome->Tipo)
		)
		{
			$array = array(
				'documento' => $nome->Documento,
				'email' => $nome->Email,
				'tipo' => $nome->Tipo
			);

			if ( isset($nome->Nome) ) {
				$array['nome'] = $nome->Nome;
			}

			if ( isset($nome->Senha) ) {
				$array['senha'] = $nome->Senha;
			}

			$return = $database->insert("usuarios", $array);
			$array['id'] = $return;
		} else {
            $array = array( 'erro' => 'campo obrigatorio.');
            $array['campos'] = array(
				'nome'=>'opcional', 
				'documento'=>'obrigatorio', 
				'email'=>'obrigatorio', 
				'senha'=>'opcional',
				'tipo' => 'obrigatorio'
			);
		}

		echo json_encode($array);

	});

	/*
		Método POST
		Tipo UPDATE = UPDATE
	*/

	$app->post('/usuario/update', function() use ($app, $database){
        $temp = $app->request()->headers->all();
        $nome = json_encode($temp);
        $nome = json_decode($nome);
        $array = array ('ERRO' => 'ERRO');
        if (isset($nome->Id)){
        	$array = array();
			$id = $nome->Id;
			
			if(isset($nome->Nome))		{ $array['nome'] = $nome->Nome; }
            if(isset($nome->Documento))	{ $array['documento'] = $nome->Documento; }
            if(isset($nome->Email))		{ $array['email'] = $nome->Email; }
			if(isset($nome->Senha))		{ $array['senha'] = $nome->Senha; }
			if(isset($nome->Tipo))		{ $array['tipo'] = $nome->Tipo; }
			
            $database->update('usuarios', $array, "id=$id");
            $array['id'] = $id;
		} else {
			$array = array( 'erro' => 'campo obrigatorio.');
			$array['campos'] = array('id' => 'obrigatorio');
		}
		$nome = json_encode($array);
		echo $nome;

	});

	/*
		Método GET
		Tipo DELETE = UPDATE
	*/

	$app->get('/usuario/destroy/:dados', function($dados) use ($database){

		$dados = (int) $dados;
		$array = array ( 'deletado' => '1');
		$return = $database->update('usuarios', $array, 'id = '.$dados);
		
		$array = array ( 'id_destaivado' => $dados);

		if (!$return) {
			$array = array ( 'Erro' => 'Cadastro não desativado', 'id' => $dados);
		}

        echo json_encode($array);

	});


	$app->run();

?>
