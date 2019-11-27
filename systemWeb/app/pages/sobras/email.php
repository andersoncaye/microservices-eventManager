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

<section class="page-title" style="background: url(assets/img/bg-page-title-email.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1>E-mail</h1>
            </div>
            <div class="col-lg-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><span>Inicio</span></li>
                        <!--<li class="breadcrumb-item"><span>Home</span></li>-->
                        <li class="breadcrumb-item active" aria-current="page">E-mail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>


<div class="container rounded mb-4">
    <div class="row">
        <div class="col bg-white">
            <h2 class="bg-white" ></h2>
            <p class="bg-white"></p>

            <form name="contactform" method="POST">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nome <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="name" placeholder="Seu nome" require>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Assunto <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="subject" placeholder="Qual o assunto?" require>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">E-mail <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" name="email" placeholder="nome@exemplo.com" require>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Mensagem <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" name="message" placeholder="Sua mensagem..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary" name="send" value="email">Enviar</button>

            </form>

            <p></p>
        </div>
    </div>
</div>

<?php
    if (isset($_POST['send']) && $_POST['send'] == 'email' ) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        //$to = "bruno.bencke@universo.univates.br";
        $to = "anderson.caye@universo.univates.br, bruno.bencke@universo.univates.br";
        $subject = "$subject";
        $message = "<strong>Nome:</strong> $name<br /><br/><strong>E-mail:</strong> $email<br /><br /><strong>Assunto:</strong> $subject<br/><br/><strong>Mensagem:</strong> $message";
        $header = "MIME-Version: 1.1\n";
        $header .= "Content-type: text/html; charset=iso-8859-1\n";
        //$header .= "From: $email\n";
        $header .= "From: syscoffe@syscoffe.com.br\n";
        $header .= "Return-Path:: $email\n";
        $reply = mail($to, $subject, $message, $header);
        if ($reply){
            echo '<script>alert("Mensagem Enviada com Sucesso!");</script>';
        } else {
            echo '<script>alert("ERRO ao enviar a mensagem");</script>';
        }

    }
?>