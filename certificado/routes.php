<?php

    function requestGet($url){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        return json_decode( $response->getBody() );
    }

    function requestPost($url, $data){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $headers = array('Accept: application/json', 'Content-type: application/json' );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
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

		$app->get('/show/:number/:token', function ($number, $token) use ($database, $space, $app) {
			$curl_response = requestGet($space.'login/api/access/'.$token);
			if ( array_key_exists('token', $curl_response) ) {

			    $number = (int) $number;

				$query = "SELECT * FROM certificado WHERE id = {$number}";
				$return = $database->select($query);

//                if ( !empty($return) ){
//                    $array = array();
//
//                    $v = $return[0];
//
//                    $id             = $v->id;
//                    $id_inscricao   = $v->id_inscricao;
//                    $url = "https://sofftest.azurewebsites.net/api/inscricoes/{$id_inscricao}?token={$token}";
//                    $inscricao = requestGet($url);
//                    $id_registro    = $v->id_registro;
////                            $registro = requestGet("https://sofftest.azurewebsites.net/api/registros/{$id_registro}?token={$token}");
//                    $id_usuario     = $v->id_usuario;
//                    $usuario = requestGet($space."usuario/api/show/{$id_usuario}/{$token}");
//                    $id_evento      = $v->id_evento;
//                    $evento = requestGet("https://sofftest.azurewebsites.net/api/eventos/{$id_evento}?token={$token}");
//
//                    $array[$id] = array(
//
//                        'inscricao' => $inscricao,
//                        'registro'  => array('id' => $id_registro),
//                        'usuario'   => $usuario,
//                        'evento'    => $evento
//
//                    );
//                }
//                $return = $array;

			} else {
				$return = json_encode($curl_response);
			}

            $app->response->write( json_encode($return[0]) );
            return $app->response()->header('Content-Type', 'application/json');
		});
	
		$app->get('/certificados/inscricao/:inscricao/:token', function ($inscricao, $token) use ($database, $space, $app) {
			$curl_response = requestGet($space.'login/api/access/'.$token);
			if ( array_key_exists('token', $curl_response) ) {

			    $inscricao = (int) $inscricao;

				$query = "SELECT * FROM certificado WHERE id_inscricao = {$inscricao}";
				$return = $database->select($query);

//                if ( !empty($return) ){
//                    $array = array();
//
//                    $v = $return[0];
//
//                    $id             = $v->id;
//                    $id_inscricao   = $v->id_inscricao;
//                    $url = "https://sofftest.azurewebsites.net/api/inscricoes/{$id_inscricao}?token={$token}";
//                    $inscricao = requestGet($url);
//                    $id_registro    = $v->id_registro;
////                            $registro = requestGet("https://sofftest.azurewebsites.net/api/registros/{$id_registro}?token={$token}");
//                    $id_usuario     = $v->id_usuario;
//                    $usuario = requestGet($space."usuario/api/show/{$id_usuario}/{$token}");
//                    $id_evento      = $v->id_evento;
//                    $evento = requestGet("https://sofftest.azurewebsites.net/api/eventos/{$id_evento}?token={$token}");
//
//                    $array[$id] = array(
//
//                        'inscricao' => $inscricao,
//                        'registro'  => array('id' => $id_registro),
//                        'usuario'   => $usuario,
//                        'evento'    => $evento
//
//                    );
//                }
//                $return = $array;

			} else {
				$return = json_encode($curl_response);
			}

            $app->response->write( json_encode($return[0]) );
            return $app->response()->header('Content-Type', 'application/json');
		});


		/*
			Método GET
		*/
	
		$app->get('/certificados/usuario/:user/:token', function($user, $token) use ($database, $space, $app) {
			
			$curl_response = requestGet($space.'login/api/access/'.$token);
            $array = array('erro' => 'campo obrigatorio');
			if ( array_key_exists('token', $curl_response) ) {

				$user = (int) $user;
				$query = "SELECT * FROM certificado WHERE id_usuario = {$user}";
				$return = $database->select($query);

//				if ( !empty($return) ){
//                    $array = array();
//                    foreach ( $return as $k => $v ){
//
//                        $id             = $v->id;
//
//                        $id_inscricao   = $v->id_inscricao;
//                        $inscricao = requestGet("https://sofftest.azurewebsites.net/api/inscricoes/{$id_inscricao}?token={$token}");
//
//                        $id_registro    = $v->id_registro;
////                            $registro = requestGet("https://sofftest.azurewebsites.net/api/registros/{$id_registro}?token={$token}");
//
//                        $id_usuario     = $v->id_usuario;
//                        $usuario = requestGet($space."usuario/api/show/{$id_usuario}/{$token}");
//
//                        $id_evento      = $v->id_evento;
//                        $evento = requestGet("https://sofftest.azurewebsites.net/api/eventos/{$id_evento}?token={$token}");
//
//                        $array[$id] = array(
//
//                            'inscricao' => $inscricao,
//                            'registro'  => array('id' => $id_registro),
//                            'usuario'   => $usuario,
//                            'evento'    => $evento
//
//                        );
//                    }
//                    $return = $array;
                }

//			} else {
//				$return = json_encode($array);
//			}

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
            $data = json_decode($data);
	
			$array = array('ERRO' => 'ERRO' );
			if ( isset($data->token) ) {
				$curl_response = requestGet($space.'login/api/access/'.$data->token);
				if ( array_key_exists('token', $curl_response) ) {
					
					if (
						isset( $data->id_inscricao  ) &&
						isset( $data->id_registro   ) &&
						isset( $data->id_usuario    ) &&
                        isset( $data->id_evento     )
					) {
						$array = array(
							'id_inscricao'  => $data->id_inscricao,
							'id_registro'   => $data->id_registro,
							'id_usuario'    => $data->id_usuario,
                            'id_evento'     => $data->id_evento
						);
			
						$return = $database->insert("certificado", $array);
						$array['id'] = $return;
					} else {
						$array = array( 'erro' => 'campo obrigatorio.');
						$array['campos'] = array(
							'id_inscricao'  =>'obrigatorio',
							'id_registro'   =>'obrigatorio',
							'id_usuario'    =>'obrigatorio',
							'id_evento'     =>'obrigatorio',
							'token'         =>'obrigatorio'
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