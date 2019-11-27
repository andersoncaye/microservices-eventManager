<?php
    require ('./app/base.php');
    $keySession = "login";
    $idUser = 'user';
    $main = new Main();

    if ($main->session->issetSession($keySession)){

        include("admin.php");

    } else {

        include("login.php");

    }

?>