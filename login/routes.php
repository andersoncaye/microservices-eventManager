<?php

	$app->get('/', function (){

		//include 'index.php';
		include 'view.php';

	});

	$app->group('/api', function() use ($app, $database) {

		$app->get('/', function () {
			include 'view.php';
		});

		$app->get('/access/:dados', function ($dados) use ($app, $database) {
			$return = $database->select("SELECT * FROM login WHERE token = '{$dados}' LIMIT 1");
			$array = array();

			if (!empty($return)) {
				$array = $return[0];
			} else {
				$array = array(
					'erro' => 'Nao autorizado'
				);
			}

			echo json_encode($array);
		});

		$app->post('/access', function() use ($app, $database) {
			$temp = $app->request()->params();
            $data = json_encode($temp);
            $data = json_decode($data);
	
			$array = array('ERRO' => 'ERRO' );
			$array['status'] = FALSE;
	
			$token = NULL;

			if(isset($data->email) && isset($data->senha)) {
				
				$post_email = $data->email;
				$post_senha = $data->senha;

				$qry = 'SELECT email, id FROM usuarios WHERE email = "'.$post_email.'" AND senha = "'.$post_senha.'" LIMIT 1';
				$return = $database->select($qry);

				if (!empty($return)) {
					$result = $return[0];
					if ($result->email == $post_email) {
						
						date_default_timezone_set('America/Sao_Paulo');
						$date = date('Y-m-d\TH:i:s');

						$token = md5($result->email.$date);

						$creat_token = array(
							'date' => $date,
							'token' => $token,
							'id_usuario' => $result->id
						);

						$return = $database->insert('login', $creat_token, '');

						if ($return) {
							$array = array (
								'email' => $result->email,
								'token' => $token
							);
						} else {
							$array = array( 'erro' => 'erro ao gerar o token');
							$array['campos'] = array(
								'token' => NULL
							);
						}
						
					}
				} else {
					$array = array( 'erro' => 'dados incorretos');
					$array['campos'] = array(
						'email' => 'incorreto', 
						'senha'=>'incorreto'
					);
				}
	
			} else {
				$array = array( 'erro' => 'campo obrigatorio.');
				$array['campos'] = array(
					'email' => 'obrigatorio', 
					'senha'=>'obrigatorio'
				);
			}

            $app->response->write( json_encode($array) );
            return $app->response()->header('Content-Type', 'application/json');
		});
		
	});

?>