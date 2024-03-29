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
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array());
        $curl_response = curl_exec($curl);
        curl_close($curl);
        return json_decode( $curl_response );
    }

	$app->get('/', function (){

		//include 'index.php';
		include 'view.php';

	});

	$app->group('/api', function() use ($app, $space) {

		$app->get('/', function (){

			//include 'index.php';
			include 'view.php';
	
		});
	
		$app->post('/send', function() use ($app, $space) {
            $temp = $app->request()->params();
            $data = json_encode($temp);
            $data = json_decode($data);

			$return = array('ERRO' => 'ERRO' );
			if (isset($data->token)) {
				$curl_response = requestGet($space.'login/api/access/'.$data->token);
				if ( array_key_exists('token', $curl_response) ) {
					if( isset($data->destino) && isset($data->assunto) && isset($data->conteudo) ) {
						$array = array(
							'destino' => $data->destino,
							'assunto' => $data->assunto,
							'conteudo' => $data->conteudo
						);

						$mail = $data->destino;
	                    $mailheader = 'From: syscoffe@syscoffe.com.br'."\r\n";
                        $mailheader .= 'Reply-to: '.$mail."\r\n";
                        $to = 'syscoffe@syscoffe.com.br,'.$mail;
                        $subject = $data->assunto;
                        $message = $data->conteudo;

                        if( mail($to, $subject, $message, $mailheader) ){
                            $array['envio'] = TRUE;
                        } else {
                            $array['envio'] = FALSE;
                        }

					} else {
						$array = array( 'erro' => 'campo obrigatorio.');
						$array['campos'] = array(
							'destino'=>'obrigatorio',
							'assunto'=>'obrigatorio',
							'conteudo' => 'obrigatorio',
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

	});

?>