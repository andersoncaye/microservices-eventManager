<?php
    //valida a sessão
    if (isset($main)){
        if (!$main->session->issetSession($keySession)) {
            echo '<script>location.href="../../index.php";</script>';
        } 
    } else {
        echo '<script>location.href="../../index.php";</script>';
    }
?>
<div class="container erro">
    <div class="row">
        <div class="col bg-white">
            <!-- <h2 class="bg-white" >Título Aqui</h2> -->

            <div class="row">
                <div class="col bg-white">

                    <div class="error-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="error-text">
                                        <h1 class="error">404 Error</h1>
                                        <div class="im-sheep">
                                            <div class="top">
                                                <div class="body"></div>
                                                <div class="head">
                                                    <div class="im-eye one"></div>
                                                    <div class="im-eye two"></div>
                                                    <div class="im-ear one"></div>
                                                    <div class="im-ear two"></div>
                                                </div>
                                            </div>
                                            <div class="im-legs">
                                                <div class="im-leg"></div>
                                                <div class="im-leg"></div>
                                                <div class="im-leg"></div>
                                                <div class="im-leg"></div>
                                            </div>
                                        </div>
                                        <h4>Oops! Parece que essa página evaporou!</h4>
                                        <p>Temos um problema, mas nosso técnico tá trabalhando nisso...</p>
                                        <a href="<?php echo PATH; ?>index.php?page" class="btn btn-primary btn-round">Página Inicial</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <p class="bg-white">Conteúdo Aqui</p> -->

                </div>
            </div>

        </div>
    </div>
</div>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


