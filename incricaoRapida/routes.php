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

    function requestPost($url, $data){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array());
        $curl_response = curl_exec($curl);
        curl_close($curl);
        return json_decode( $curl_response );
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
	
//		/*
//			Método GET
//		*/
//
//		$app->get('/show/:token', function ($token) use ($database, $space, $app) {
//			$curl_response = requestGet($space.'login/api/access/'.$token);
//			if ( array_key_exists('token', $curl_response) ) {
//
//				$query = "SELECT * FROM usuarios WHERE deletado = 0";
//				$return = $database->select($query);
//
//			} else {
//				$return = json_encode($curl_response);
//			}
//
//            $app->response->write( json_encode($return) );
//            return $app->response()->header('Content-Type', 'application/json');
//		});
//
//		/*
//			Método GET
//		*/
//
//		$app->get('/show/:dados/:token', function($dados, $token) use ($database, $space, $app) {
//
//			$curl_response = requestGet($space.'login/api/access/'.$token);
//			if ( array_key_exists('token', $curl_response) ) {
//
//				$dados = (int) $dados;
//				$query = "SELECT * FROM usuarios WHERE id=".$dados;
//				$return = $database->select($query);
//
//			} else {
//				$return = json_encode($curl_response);
//			}
//
//            $app->response->write( json_encode($return) );
//            return $app->response()->header('Content-Type', 'application/json');
//		});
	
		/*
			Método POST
			Tipo STORE = INSERT
		*/
	
		$app->post('/store', function() use ($app, $database, $space) {
            $temp = $app->request()->params();
            $data = json_encode($temp);
            $data = json_decode($data);
	
			$return = array('ERRO' => 'ERRO' );
			if (isset($data->token)) {

				$curl_response = requestGet($space.'login/api/access/'.$data->token);

				if ( array_key_exists('token', $curl_response) ) {
					
					if(
						isset($data->documento) &&
						isset($data->email)	&&
						isset($data->tipo)
					) {
						$array = array(
							'documento' => $data->documento,
							'email' => $data->email,
							'tipo' => $data->tipo,
                            'token' => $data->token
						);

                        $array = requestPost($space.'usuario/api/store', $array);

					} else {
						$array = array( 'erro' => 'campo obrigatorio.');
						$array['campos'] = array(
							'documento'=>'obrigatorio', 
							'email'=>'obrigatorio',
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
	
//		/*
//			Método POST
//			Tipo UPDATE = UPDATE
//		*/
//
//		$app->post('/update', function() use ($app, $database, $space){
//		     $temp = $app->request()->params();
//             $data = json_encode($temp);
//             $data = json_decode($data);
//
//			 $array = array ('ERRO' => 'ERRO');
//			 if (isset($data->token)) {
//
//			 	$curl_response = requestGet($space.'login/api/access/'.$data->token);
//
//			 	if ( array_key_exists('token', $curl_response) ) {
//
//			 		if (isset($data->id)){
//			 			$array = array();
//			 			$id = $data->id;
//
//			 			if(isset($data->nome))		{ $array['nome'] = $data->nome; }
//			 			if(isset($data->documento))	{ $array['documento'] = $data->documento; }
//			 			if(isset($data->email))		{ $array['email'] = $data->email; }
//			 			if(isset($data->senha))		{ $array['senha'] = $data->senha; }
//			 			if(isset($data->tipo))		{ $array['tipo'] = $data->tipo; }
//
//			 			$database->update('usuarios', $array, "id = {$id} AND deletado = 0");
//			 			$array['id'] = $id;
//			 		} else {
//			 			$array = array( 'erro' => 'campo obrigatorio.');
//			 			$array['campos'] = array('id' => 'obrigatorio');
//			 		}
//			 	} else {
//			 		$array = $curl_response;
//			 	}
//			 } else {
//			 	$array = array( 'erro' => 'campo obrigatorio.');
//			 	$array['campos'] = array('token' => 'obrigatorio');
//			 }
//
//            $app->response->write( json_encode($array) );
//            return $app->response()->header('Content-Type', 'application/json');
//		});
//
//		/*
//			Método POST
//			Tipo DELETE = UPDATE
//		*/
//
//		$app->post('/delete', function() use ($app, $database, $space){
//			$temp = $app->request()->params();
//            $data = json_encode($temp);
//            $nome = json_decode($data);
//
//			$array = array ( 'erro' => 'Cadastro não desativado' );
//			if (isset($nome->Token)) {
//
//				$curl_response = requestGet($space.'login/api/access/'.$nome->token);
//
//				if ( array_key_exists('token', $curl_response) ) {
//
//					if (isset($nome->id)){
//
//						$array = array ( 'deletado' => '1');
//						$return = $database->update('usuarios', $array, 'id = '.$nome->id);
//
//						$array = array ( 'id_destaivado' => $nome->id);
//
//						if (!$return) {
//							$array = array ( 'erro' => 'Cadastro não desativado', 'id' => $nome->id);
//						}
//
//					} else {
//						$array = array( 'erro' => 'campo obrigatorio.');
//						$array['campos'] = array('id' => 'obrigatorio');
//					}
//
//				} else {
//					$array = $curl_response;
//				}
//			} else {
//				$array = array( 'erro' => 'campo obrigatorio.');
//				$array['campos'] = array('token' => 'obrigatorio');
//			}
//
//            $app->response->write( json_encode($array) );
//            return $app->response()->header('Content-Type', 'application/json');
//		});
		
	});

?>