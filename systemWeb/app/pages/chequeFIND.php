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
                <h1>Pesquisar Cheque</h1>
            </div>
            <div class="col-lg-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><span>Inicio</span></li>
                        <!--<li class="breadcrumb-item"><span>Home</span></li>-->
                        <li class="breadcrumb-item active" aria-current="page">Pesquisar Cheque</li>
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


$ask = "";

if ( isset($_POST['ask']) && $_POST['ask'] == 'check' ){
    $ask = $_POST['search'];

//    //valida a sincronia
//    $whereLike = "pc.idPouch = cd.idPouch_Check AND ";
//    $whereLike .= "pc.idClient_Pousch = c.idClient OR ";

    //valida o termos no check_doc
    $whereLike = "cd.idCheck like '%".$ask."%' or ";
    $whereLike .= "cd.numberBank like '%".$ask."%' or ";
    $whereLike .= "cd.numberAgency like '%".$ask."%' or ";
    $whereLike .= "cd.numberAccount like '%".$ask."%' or ";
    $whereLike .= "cd.numberCheck like '%".$ask."%' or ";
    $whereLike .= "cd.nameHolder like '%".$ask."%' or ";
    $whereLike .= "cd.docCpfOrCnpj like '%".$ask."%' or ";
    $whereLike .= "cd.date like '%".$ask."%' or ";
    $whereLike .= "cd.value like '%".$ask."%' or ";
    $whereLike .= "cd.idPouch_Check like '%".$ask."%' ";

//    //valida o termos no pouch_check
//    $whereLike .= "pc.idPouch like '%".$ask."%' or ";
//    $whereLike .= "pc.date_e like '%".$ask."%' or ";
//    $whereLike .= "pc.reference like '%".$ask."%' or ";
//
//    //valida o termos no pouch_check
//    $whereLike .= "c.idClient like '%".$ask."%' or ";
//    $whereLike .= "c.code like '%".$ask."%' or ";
//    $whereLike .= "c.name like '%".$ask."%' or ";
//    $whereLike .= "c.email like '%".$ask."%' ";

//    $query = "SELECT * FROM check_doc cd, pouch_check pc, client c WHERE ".$whereLike." ORDER BY date DESC";
//    $query = "SELECT * FROM check_doc cd WHERE ".$whereLike." ORDER BY date DESC LIMIT {$inicioCheck},{$fimCheck}";

    $query = "SELECT * FROM check_doc cd WHERE ".$whereLike." ORDER BY date DESC";

//    echo $query;

    $replyChecks = $main->database->select($query);
} else {
    $replyChecks = $main->database->select("SELECT * FROM check_doc ORDER BY date DESC");
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
                                    <input class="form-control form-control-lg form-control-borderless" name="search" type="search" placeholder="Pesquisar cheque" value="<?php echo $ask; ?>">
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
                    <th scope="col">ID</th>
                    <th scope="col">Data</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Nr Cheque</th>
                    <th scope="col">Titular</th>
                    <th scope="col">Info Bancárias</th>
<!--                    <th scope="col">Ações</th>-->

                </tr>
                </thead>
                <?php if (!empty($replyChecks)) { $i = 1?>
                <tbody>
                <?php foreach ($replyChecks as $row){ ?>
                    <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td><?php echo $row->idCheck; ?></td>
                        <td><?php echo $row->date; ?></td>
                        <td><?php echo 'R$ '.$row->value; ?></td>
                        <td><?php echo $row->numberCheck; ?></td>
                        <td>
                            Nome: <?php echo $row->nameHolder; ?><br>
                            Doc.: <?php echo $row->docCpfOrCnpj; ?>

                        </td>
                        <td>
                            Banco: <?php echo $row->numberBank; ?> <br>
                            Agência: <?php echo $row->numberAgency; ?> <br>
                            Conta: <?php echo $row->numberAccount; ?>
                        </td>
<!--                        <td>-->
<!--                            <a href="--><?php //echo $_SERVER["REQUEST_URI"]; ?><!--&pros=CADclient&edit=--><?php //echo 'IDAQUI'; ?><!--" style="font-size: 1.2em; color: Tomato;" title="Editar"><i class="fas fa-edit"></i></i></a>-->
<!--                            <a href="--><?php //echo $_SERVER["REQUEST_URI"]; ?><!--&delete=--><?php //echo $row->idCheck; ?><!--" class="ml-2" style="font-size: 1.2em; color: Tomato;" title="Excluir"><i class="fas fa-trash-alt"></i></a>-->
<!--                        </td>-->
                    </tr>
                    <?php $i++;} ?>
                <?php } else { ?>
                    <h4>Nenhum dado encontrado!</h4>
                <?php } ?>
                </tbody>

            </table>
            <!-- Fim - Tabela de Cheques -->

<!--            Paginação -->
            <br><br>
<!--            <nav aria-label="...">-->
<!--                <ul class="pagination justify-content-center">-->
<!--                    <li class="page-item disabled">-->
<!--                        <a class="page-link" href="#" tabindex="-1">Anterior</a>-->
<!--                    </li>-->
<!--                    <li class="page-item"><a class="page-link" href="#">1</a></li>-->
<!--                    <li class="page-item active">-->
<!--                        <a class="page-link" href="#">2 <span class="sr-only">(atual)</span></a>-->
<!--                    </li>-->
<!--                    <li class="page-item"><a class="page-link" href="#">3</a></li>-->
<!--                    <li class="page-item">-->
<!--                        <a class="page-link" href="#">Próximo</a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </nav>-->

            <p></p>
        </div>
    </div>
</div>