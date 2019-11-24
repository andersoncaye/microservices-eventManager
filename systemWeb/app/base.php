<?php

    include ("./system/config.php");
//    include ('./system/db.php');

    require ('./system/Database.php');
    require ('./system/Session.php');

class Main
{
    public $session;
    public $database;

    public function __construct()
    {
        //Session
        $this->session = new \system\Session();
        $this->session->init();

        //Database
        $this->database = new \system\Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

    public function getLogin($email, $password)
    {
        $table = "user";
        $fields = "*";
        $limit = "1";
        $obj = TRUE;
        //$password = md5($password);
        $where = "email = '{$email}' AND password = '{$password}'" ;

        $content = $this->database->select("SELECT {$fields} FROM {$table} WHERE {$where} LIMIT {$limit}", NULL, $obj);

        return $content;
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