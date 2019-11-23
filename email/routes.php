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
	
		$app->post('/send', function() use ($app, $database, $space) {
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

						$header = "Content-Type: text/html; charset= utf-8\n";
                        $header .= "From: syscoffe@syscoffe.com.br Reply-to: {$array->destino}";
                        $to = "syscoffe@syscoffe.com.br, {$array->destino}";

                        if( mail($to, $array->assunto, $array->conteudo, $header) ){
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