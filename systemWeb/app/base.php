<?php

    include ("./system/config.php");
//    include ('./system/db.php');

//    require ('./system/Database.php');
    require ('./system/Session.php');
    require ('./vendor/autoload.php');
    use GuzzleHttp\Client;

class Main
{
    public $session;
    //public $database;

    public function __construct()
    {
        //Session
        $this->session = new \system\Session();
        $this->session->init();

        //Database
        //$this->database = new \system\Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

    public function requestGET($url){
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        return json_decode( $response->getBody() );
    }

    public function requestPOST($url, $array){
        $client = new \GuzzleHttp\Client();
        $form_params['form_params'] = $array;
        $response = $client->post($url, $form_params);
        return json_decode( $response->getBody() );
    }

    public function getLogin($email, $password)
    {
        $url = "ms-api.syscoffe.com.br/login/api/access";
        $array = array( 'email' => $email, 'senha' => $password );
        return $this->requestPOST($url, $array);
    }
    public function clearInjectAllSQL($stringInput)
    {
        return preg_replace('/[^[:alnum:]_]/', '',$stringInput);
    }

    public function clearInjectEmailSQL($stringInput)
    {
        return preg_replace('/[^a-zA-Z0-9\/:@\.\+-s]/', '',$stringInput);
    }
}
?>