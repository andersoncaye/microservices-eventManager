<?php

	require 'Slim/Slim.php';
	\Slim\Slim::registerAutoloader();

	require 'Database.php';
	$database = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);



	$app = new \Slim\Slim();

	$app->get('/', function (){

		include 'index.php';

	});

	$app->get('/usuario/:dados', function($dados) use ($database) {

        $query = "SELECT * FROM usuarios WHERE id=".$dados;
        $return = $database->select($query);

        echo json_encode($return);

		//echo "Voce procurou sobre o usuario com id = $dados";

	});

	$app->post('/usuario', function() use ($app, $database) {
		//$nome = $app->request()->getBody();
        $temp = $app->request()->headers->all();
        $nome = json_encode($temp);
        //echo $nome;
        $nome = json_decode($nome);

		$return = array('ERRO' => 'ERRO' );

		if(isset($nome->Nome) && isset($nome->Sobrenome) && isset($nome->Email) && isset($nome->Senha))
		{
			$array = array(
				'nome' => $nome->Nome,
				'sobrenome' => $nome->Sobrenome,
				'email' => $nome->Email,
				'senha' => $nome->Senha
			);
			$return = $database->insert("usuarios", $array);
			$array['id'] = $return;
		} else {
            $array = array( 'erro' => 'campo obrigatorio.');
            $array['campos'] = array('nome'=>'obrigatorio', 'sobrenome'=>'obrigatorio', 'email'=>'obrigatorio', 'senha'=>'obrigatorio');
		}

		echo json_encode($array);

	});


	$app->put('/usuario', function() use ($app, $database){
        $temp = $app->request()->headers->all();
        $nome = json_encode($temp);
        $nome = json_decode($nome);
        $array = array ('ERRO' => 'ERRO');
        if (isset($nome->Id)){
        	$array = array();
            $id = $nome->Id;
			if(isset($nome->Nome)){ $array['nome'] = $nome->Nome; }
            if(isset($nome->Sobrenome)){ $array['sobrenome'] = $nome->Sobrenome; }
            if(isset($nome->Email)){ $array['email'] = $nome->Email; }
            if(isset($nome->Senha)){ $array['senha'] = $nome->Senha; }
            $database->update('usuarios', $array, "id=$id");
            $array['id'] = $id;
		} else {
			$array = array( 'erro' => 'campo obrigatorio.');
			$array['campos'] = array('id' => 'obrigatorio','nome'=>'opcional', 'sobrenome'=>'opcional', 'email'=>'opcional', 'senha'=>'opcional');
		}
		$nome = json_encode($array);
		echo $nome;

	});


	$app->delete('/usuario', function() use ($app, $database){

        $temp = $app->request()->headers->all();
        $nome = json_encode($temp);
        $nome = json_decode($nome);

        $array = array ('ERRO' => 'ERRO');
        if (isset($nome->Id)){
            $array = array();
            $id = $nome->Id;
            $database->delete('usuarios', "id=$id");
            $array['id'] = $id;
        } else {
            $array = array( 'erro' => 'campo obrigatorio.');
            $array['campos'] = array('id' => 'obrigatorio');
        }
        $nome = json_encode($array);
        echo $nome;

	});


	$app->run();

?>
