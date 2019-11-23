<?php
// phpinfo();
$curl = curl_init("http://127.0.0.1/SYSCoffe/microservices-eventManager/usuario/api/update");

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

curl_setopt($curl, CURLOPT_POST, 'POST');
$dados = array('token' => 'd690caea5ae5641c9cceec11628c6aef', 'id' => '3', 'documento' => '00000000333');
curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);
//curl_setopt($curl, CURLOPT_HTTPHEADER, array('name' => 'anderson@amderson.com', 'senha' => 'anderson'));
$curl_response = curl_exec($curl);
curl_close($curl);
var_dump( $curl_response );
echo $curl_response;