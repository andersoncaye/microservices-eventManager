<?php
    require 'vendor/autoload.php';
    use GuzzleHttp\Client;

    $client = new \GuzzleHttp\Client();

    $response = $client->request(
        'GET',
        'https://sofftest.azurewebsites.net/api/inscricoes/1?token=d690caea5ae5641c9cceec11628c6aef'
    );

//$response = $client->request(
//    'GET',
//    'https://viacep.com.br/ws/01001000/json/'
//);

//    $response = $client->request(
//        'GET',
//        'http://ms-api.syscoffe.com.br/login/api/access/d690caea5ae5641c9cceec11628c6aef'
//    );

    echo $response->getBody();
