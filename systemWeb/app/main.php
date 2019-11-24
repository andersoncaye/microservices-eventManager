<?php
    //Apresentacao da pagina
    if (!isset($_GET['page']) || $_GET['page'] == ''){ //Para receber a pagina inicial (home)

        include ("pages/home.php");

    } else if(isset($_GET['page']) && $_GET['page'] == 'findCheque') { //Para receber pagina ...

        include("pages/chequeFIND.php");

    } else if(isset($_GET['pros']) && $_GET['pros'] == 'CADclient') { //Para receber pagina ...

        include("pages/clientCAD.php");

    } else if(isset($_GET['page']) && $_GET['page'] == 'client') { //Para receber pagina ...

        include("pages/client.php");

    } else if(isset($_GET['pros']) && $_GET['pros'] == 'CADmalote') { //Para receber pagina ...

        include("pages/maloteCAD.php");

    } else if(isset($_GET['page']) && $_GET['page'] == 'malote') { //Para receber pagina ...

        include("pages/malote.php");

    } else if(isset($_GET['page']) && $_GET['page'] == 'report') { //Para receber pagina ...

        include("pages/report.php");

    } else if(isset($_GET['page']) && $_GET['page'] == 'email') { //Para receber pagina ...

        include("pages/email.php");

    } else if(isset($_GET['page']) && $_GET['page'] == 'info') { //Para receber pagina ...

        include("pages/info.php");

    } else if(isset($_GET['page']) && $_GET['page'] == 'sair') { //Para receber pagina ...

        $main->session->destroy();
        echo '<script>location.href="index.php";</script>';

    } else {

        include("pages/erro.php");

    }

?>