<?php

    function requestGet($url){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        return json_decode( $response->getBody() );
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
	
		$app->get('/show/:token', function ($token) use ($database, $space, $app) {
			$curl_response = requestGet($space.'login/api/access/'.$token);
			if ( array_key_exists('token', $curl_response) ) {

				$query = "SELECT * FROM usuarios WHERE deletado = 0";
				$return = $database->select($query);

			} else {
				$return = json_encode($curl_response);
			}

            $app->response->write( json_encode($return) );
            return $app->response()->header('Content-Type', 'application/json');
		});
	
		/*
			Método GET
		*/
	
		$app->get('/show/:dados/:token', function($dados, $token) use ($database, $space, $app) {
			
			$curl_response = requestGet($space.'login/api/access/'.$token);
			if ( array_key_exists('token', $curl_response) ) {

				$dados = (int) $dados;
				$query = "SELECT * FROM usuarios WHERE id=".$dados;
				$return = $database->select($query);

				if (!empty($return)) {
				    $return = $return[0];
                }

			} else {
				$return = json_encode($curl_response);
			}

            $app->response->write( json_encode($return) );
            return $app->response()->header('Content-Type', 'application/json');
		});
	
		/*
			Método POST
			Tipo STORE = INSERT
		*/
	
		$app->post('/store', function() use ($app, $database, $space) {
            $temp = $app->request()->params();
            $data = json_encode($temp);
            $nome = json_decode($data);
	
			$return = array('ERRO' => 'ERRO' );
			if (isset($nome->token)) {

				$curl_response = requestGet($space.'login/api/access/'.$nome->token);

				if ( array_key_exists('token', $curl_response) ) {
					
					if(
						isset($nome->documento) &&
						isset($nome->email)	&&
						isset($nome->tipo)
					) {
						$array = array(
							'documento' => $nome->documento,
							'email' => $nome->email,
							'tipo' => $nome->tipo
						);
			
						if ( isset($nome->nome) ) {
							$array['nome'] = $nome->nome;
						}
			
						if ( isset($nome->senha) ) {
							$array['senha'] = $nome->senha;
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

            $app->response->write( json_encode($array) );
            return $app->response()->header('Content-Type', 'application/json');
		});
	
		/*
			Método POST
			Tipo UPDATE = UPDATE
		*/
	
		$app->post('/update', function() use ($app, $database, $space){
		     $temp = $app->request()->params();
             $data = json_encode($temp);
             $data = json_decode($data);

			 $array = array ('ERRO' => 'ERRO');
			 if (isset($data->token)) {

			 	$curl_response = requestGet($space.'login/api/access/'.$data->token);

			 	if ( array_key_exists('token', $curl_response) ) {

			 		if (isset($data->id)){
			 			$array = array();
			 			$id = $data->id;
						
			 			if(isset($data->nome))		{ $array['nome'] = $data->nome; }
			 			if(isset($data->documento))	{ $array['documento'] = $data->documento; }
			 			if(isset($data->email))		{ $array['email'] = $data->email; }
			 			if(isset($data->senha))		{ $array['senha'] = $data->senha; }
			 			if(isset($data->tipo))		{ $array['tipo'] = $data->tipo; }
						
			 			$database->update('usuarios', $array, "id = {$id} AND deletado = 0");
			 			$array['id'] = $id;
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

            $app->response->write( json_encode($array) );
            return $app->response()->header('Content-Type', 'application/json');
		});
	
		/*
			Método POST
			Tipo DELETE = UPDATE
		*/
	
		$app->post('/delete', function() use ($app, $database, $space){
			$temp = $app->request()->params();
            $data = json_encode($temp);
            $nome = json_decode($data);

			$array = array ( 'erro' => 'Cadastro não desativado' );
			if (isset($nome->Token)) {

				$curl_response = requestGet($space.'login/api/access/'.$nome->token);

				if ( array_key_exists('token', $curl_response) ) {

					if (isset($nome->id)){

						$array = array ( 'deletado' => '1');
						$return = $database->update('usuarios', $array, 'id = '.$nome->id);
						
						$array = array ( 'id_destaivado' => $nome->id);
				
						if (!$return) {
							$array = array ( 'erro' => 'Cadastro não desativado', 'id' => $nome->id);
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

            $app->response->write( json_encode($array) );
            return $app->response()->header('Content-Type', 'application/json');
		});
		
	});

?>