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
                <h1>Pesquisar Evento</h1>
            </div>
            <div class="col-lg-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><span>Inicio</span></li>
                        <!--<li class="breadcrumb-item"><span>Home</span></li>-->
                        <li class="breadcrumb-item active" aria-current="page">Pesquisar Evento</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<?php
//$maxCheck = 10;
//
//if(!isset($_GET['p'])) {
//    $page = 1;
//} else {
//    $page = (int) $_GET['p'];
//}
//
//$inicioCheck = $maxCheck * $page;
//$fimCheck = $inicioCheck + $maxCheck;

if (isset($_GET['inscrever'])) {
    $idInscricao = (int) $_GET['inscrever'];
    $token  = $main->session->get($keySession);
    $main->requestPUT("https://sofftest.azurewebsites.net/api/inscricoes/{$idInscricao}?token={$token}", array('token'=>$token,'id'=>$idInscricao));
}


$ask = "";

if ( isset($_POST['ask']) && $_POST['ask'] == 'check' ){
    $ask = $_POST['search'];
    $token = $main->session->get($keySession);
    $eventos = $main->requestGET("https://sofftest.azurewebsites.net/api/eventos?token={$token}");
} else {
    $token  = $main->session->get($keySession);
    $id     = $main->session->get($idUser);

    $eventos = $main->requestGET("https://sofftest.azurewebsites.net/api/eventos?token={$token}");
    $myIdEventos = array();
    $inscricoes = $main->requestGET("https://sofftest.azurewebsites.net/api/inscricoes?token={$token}");
    foreach ($inscricoes as $k => $v){
        if ($v->id_usuario == $id){
            $myIdEventos[$v->id_evento] = $v->id;
        }
    }
}

//Buscar dados dos clientes -- para popular a tabela



?>

<div class="container rounded mb-4">
    <div class="row">
        <div class="col bg-white">
            <h2 class="bg-white" ></h2>
            <p class="bg-white"></p>

            <div class="container">
                <br/>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8">
                        <form class="card card-sm" method="POST">
                            <div class="card-body row no-gutters align-items-center">
                                <div class="col-auto">
                                    <i class="fas fa-search h4 text-body"></i>
                                </div>
                                <!--end of col-->
                                <div class="col">
                                    <input class="form-control form-control-lg form-control-borderless" name="search" type="search" placeholder="Pesquisar evento" value="<?php echo $ask; ?>">
                                </div>
                                <!--end of col-->
                                <div class="col-auto">
                                    <button class="btn btn-lg btn-success" name="ask" value="check" type="submit">Pesquisar</button>
                                </div>
                                <!--end of col-->
                            </div>
                        </form>
                    </div>
                    <!--end of col-->
                </div>
            </div>

            <!-- Inicio da Tabela -->

            <table class="table table-striped table-dark mt-1" >
                <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Código</th>
                    <th scope="col">Data</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Inscrição</th>

                </tr>
                </thead>
                <?php if (!empty($eventos)) { $i = 1?>
                <tbody>
                <?php foreach ($eventos as $row){ ?>
                    <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td><?php echo $row->id; ?></td>
                        <?php
                            $date_array = str_split($row->dataevento);
                            $date = '';
                            for ($j = 0; $j < 10; $j++ ){
                                @$date .= $date_array[$j];
                            }
                            $date = date ('d/m/Y', strtotime($date));
                        ?>
                        <td><?php echo $date; ?></td>
                        <td><?php echo $row->nome; ?></td>
                        <?php
                            if (array_key_exists($row->id,$myIdEventos)){
                            
                        ?>
                            <td> </td>
                        <?php } else { ?>
                            <td>
                                <a href="index.php?page=myEvento&inscrever=<?php echo $row->id; ?>" class="text-light">
                                    Inscreva-se! <i class="fas fa-sign-in-alt"></i> 
                                </a>
                            </td>
                        <?php }?>
                    </tr>
                    <?php $i++;} ?>
                <?php } else { ?>
                    <h4>Nenhum dado encontrado!</h4>
                <?php } ?>
                </tbody>

            </table>
            <!-- Fim - Tabela de Eventos -->
            <br><br>
            <p></p>
        </div>
    </div>
</div>