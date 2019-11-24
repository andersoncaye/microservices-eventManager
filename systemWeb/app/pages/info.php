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

<section class="page-title" style="background: url(assets/img/bg-page-title-finance.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1>Teste</h1>
            </div>
            <div class="col-lg-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Biblioteca</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dados</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>


<div class="container rounded mb-4">
    <div class="row">
        <div class="col bg-white">
            <h2 class="bg-white" >Título Aqui</h2>


                <p class="bg-white">Conteúdo Aqui</p>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Porro aut, ea, voluptatum voluptas veritatis optio voluptatibus laboriosam repudiandae recusandae ipsa sequi totam neque libero eum rerum, incidunt officiis fuga atque.</p>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Porro aut, ea, voluptatum voluptas veritatis optio voluptatibus laboriosam repudiandae recusandae ipsa sequi totam neque libero eum rerum, incidunt officiis fuga atque.</p>
            
                <p></p>
        </div>
    </div>
</div>