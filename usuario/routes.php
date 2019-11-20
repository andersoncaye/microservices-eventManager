<?php

	$app->group('/api', function() use ($app, $database) {

		$app->get('/', function (){

			//include 'index.php';
			include 'view.php';
	
		});
	
		/*
			Método GET
		*/
	
		$app->get('/show', function () use ($database) {
			$query = "SELECT * FROM usuarios WHERE deletado = 0";
			$return = $database->select($query);
			
			echo json_encode($return);
		});
	
		/*
			Método GET
		*/
	
		$app->get('/show/:dados', function($dados) use ($database) {
			$dados = (int) $dados;
			$query = "SELECT * FROM usuarios WHERE id=".$dados;
			$return = $database->select($query);
	
			echo json_encode($return);
		});
	
		/*
			Método POST
			Tipo STORE = INSERT
		*/
	
		$app->post('/store', function() use ($app, $database) {
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
	
		$app->post('/update', function() use ($app, $database){
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
			Método POST
			Tipo DELETE = UPDATE
		*/
	
		$app->post('/delete', function() use ($app, $database){
			$temp = $app->request()->headers->all();
			$nome = json_encode($temp);
			$nome = json_decode($nome);
			$array = array ( 'erro' => 'Cadastro não desativado' );

			if (isset($nome->Id)){

				$array = array ( 'deletado' => '1');
				$return = $database->update('usuarios', $array, 'id = '.$nome->Id);
				
				$array = array ( 'id_destaivado' => $nome->Id);
		
				if (!$return) {
					$array = array ( 'erro' => 'Cadastro não desativado', 'id' => $nome->Id);
				}

			} else {
				$array = array( 'erro' => 'campo obrigatorio.');
				$array['campos'] = array('id' => 'obrigatorio');
			}
	
			echo json_encode($array);
		});
		
	});

?>