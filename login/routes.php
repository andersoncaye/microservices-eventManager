<?php

	$app->group('/api', function() use ($app, $database) {

		$app->get('/', function () {
			include 'view.php';
		});
	
		$app->post('/', function() use ($app, $database) {
			//$nome = $app->request()->getBody();
			$temp = $app->request()->headers->all();
			$nome = json_encode($temp);
			$nome = json_decode($nome);
	
			$array = array('ERRO' => 'ERRO' );
			$array['status'] = FALSE;
	
			if(isset($nome->Email) && isset($nome->Senha)) {
				
				$post_email = $nome->Email;
				$post_senha = $nome->Senha;

				$qry = 'SELECT email FROM usuarios WHERE email = "'.$post_email.'" AND senha = "'.$post_senha.'" LIMIT 1';
				$return = $database->select($qry);

				if (!empty($return)) {
					$result = $return[0];
					if ($result->email == $post_email) {
						$array = array (
							'email' => $result->email,
							'status' => TRUE
						);
					}
				} else {
					$array = array( 'erro' => 'dados incorretos');
					$array['campos'] = array(
						'email' => 'incorreto', 
						'senha'=>'incorreto'
					);
					$array['status'] = FALSE;
				}
	
			} else {
				$array = array( 'erro' => 'campo obrigatorio.');
				$array['campos'] = array(
					'email' => 'obrigatorio', 
					'senha'=>'obrigatorio'
				);
				$array['status'] = FALSE;
			}
	
			echo json_encode($array);

		});
		
	});

?>