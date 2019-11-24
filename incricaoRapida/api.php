<?php
	
	require 'lib/Slim/Slim.php';
	\Slim\Slim::registerAutoloader();
	require 'lib/Database.php';
	require 'vendor/autoload.php';
	use GuzzleHttp\Client;

	define('DB_TYPE', 'mysql');

	 define('DB_HOST', 'mysql04-farm76.kinghost.net'); //local
	 define('DB_NAME', 'syscoffe03'); //banco
	 define('DB_USER', 'syscoffe03'); //usuario
	 define('DB_PASS', 'olamundo2019'); //senha

//	define('DB_HOST', '127.0.0.1'); //local
//	define('DB_NAME', 'microservice_sofevent'); //banco
//	define('DB_USER', 'root'); //usuario
//	define('DB_PASS', ''); //senha

	 $space = 'http://ms-api.syscoffe.com.br/';
//	$space = 'http://127.0.0.1/SYSCoffe/microservices-eventManager/';

	$database = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
	
	$app = new \Slim\Slim();

	require 'routes.php';

	$app->run();
?>
