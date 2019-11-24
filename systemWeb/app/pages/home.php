<?php
    //valida a sessão
    if (isset($main)){
        if (!$main->session->issetSession($keySession)) {
            echo '<script>location.href="index.php";</script>';
        } 
    } else {
        echo '<script>location.href="../../index.php";</script>';
    }
?>

<section class="">
    <div class="container">
        <div class="row">
            <div class="col bg-white">

                <br><br>

                <h2 class="bg-white text-center" >SofEventos</h2>

                <br>

                <p class="text-center">Inscrição e Gerenciamento de Eventos</p>


                <p class="text-center">
                    <img src="assets/img/hero.jpg" style="width: 100%;">
                </p>

            </div>
        </div>
    </div>
</section>

