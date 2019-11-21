<?php

	function requestGet($url){
		//START - REQUEST GET
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$headers = array(
			'Accept: application/json',
			'Content-type: application/json'
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$curl_response_json = curl_exec($curl);
		curl_close($curl);
		//END - REQUEST GET

		return json_decode($curl_response_json);
	}

	$app->get('/', function (){

		//include 'index.php';
		include 'view.php';

	});

	$app->group('/api', function() use ($app, $database, $space) {

		$app->get('/', function (){

			//include 'index.php';
			include 'view.php';
	
		});
	
		/*
			Método GET
		*/
	
		$app->get('/show/:token', function ($token) use ($database, $space) {
			$curl_response = requestGet($space.'login/api/access/'.$token);
			if ( array_key_exists('token', $curl_response) ) {

				$query = "SELECT * FROM usuarios WHERE deletado = 0";
				$return = $database->select($query);

			} else {
				$return = json_encode($curl_response);
			}
			echo json_encode($return);
		});
	
		/*
			Método GET
		*/
	
		$app->get('/show/:dados/:token', function($dados, $token) use ($database, $space) {
			
			$curl_response = requestGet($space.'login/api/access/'.$token);
			if ( array_key_exists('token', $curl_response) ) {

				$dados = (int) $dados;
				$query = "SELECT * FROM usuarios WHERE id=".$dados;
				$return = $database->select($query);

			} else {
				$return = json_encode($curl_response);
			}

			echo json_encode($return);
		});
	
		/*
			Método POST
			Tipo STORE = INSERT
		*/
	
		$app->post('/store', function() use ($app, $database, $space) {
			$temp = $app->request()->headers->all();
			$nome = json_encode($temp);
			$nome = json_decode($nome);
	
			$return = array('ERRO' => 'ERRO' );
			if (isset($nome->Token)) {

				$curl_response = requestGet($space.'login/api/access/'.$nome->Token);

				if ( array_key_exists('token', $curl_response) ) {
					
					if(
						isset($nome->Documento) && 
						isset($nome->Email)	&& 
						isset($nome->Tipo)
					) {
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
							'tipo' => 'obrigatorio',
							'token' => 'obrigatorio'
						);
					}

				} else {
					$array = $curl_response;
				}

			} else {
				$array = array( 'erro' => 'campo obrigatorio.');
				$array['campos'] = array('token' => 'obrigatorio');
			}

			echo json_encode($array);

		});
	
		/*
			Método POST
			Tipo UPDATE = UPDATE
		*/
	
		$app->post('/update', function() use ($app, $database, $space){
			$temp = $app->request()->headers->all();
			$nome = json_encode($temp);
			$nome = json_decode($nome);
			
			$array = array ('ERRO' => 'ERRO');
			if (isset($nome->Token)) {

				$curl_response = requestGet($space.'login/api/access/'.$nome->Token);

				if ( array_key_exists('token', $curl_response) ) {

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
				} else {
					$array = $curl_response;
				}
			} else {
				$array = array( 'erro' => 'campo obrigatorio.');
				$array['campos'] = array('token' => 'obrigatorio');
			}

			echo json_encode($array);
		});
	
		/*
			Método POST
			Tipo DELETE = UPDATE
		*/
	
		$app->post('/delete', function() use ($app, $database, $space){
			$temp = $app->request()->headers->all();
			$nome = json_encode($temp);
			$nome = json_decode($nome);

			$array = array ( 'erro' => 'Cadastro não desativado' );
			if (isset($nome->Token)) {

				$curl_response = requestGet($space.'login/api/access/'.$nome->Token);

				if ( array_key_exists('token', $curl_response) ) {

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
			
				} else {
					$array = $curl_response;
				}
			} else {
				$array = array( 'erro' => 'campo obrigatorio.');
				$array['campos'] = array('token' => 'obrigatorio');
			}

			echo json_encode($array);
		});
		
	});

?>