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

<?php

$idMalote = "";
$date = "";
$references = "";
$codeClient = "";
$nameClient = "";

$idMaloteEdit = "";

if (isset($_GET['edit']) && !empty($_GET['edit'])){
    $idMaloteEdit = (int) $_GET['edit'];
    $query = "SELECT pc.*, c.name, c.code FROM pouch_check pc, client c WHERE idPouch = ".$idMaloteEdit." AND idClient_Pousch = idClient ORDER BY date_e, idPouch";
//        echo '<script>alert("'.$query.'");</script>';
    $reply = $main->database->select($query);

    foreach ($reply as $row){
        $idMalote = $row->idPouch;
        $date = $row->date_e;
        $references = $row->reference;
        $codeClient = $row->code;
        $nameClient = $row->name;
    }

}

?>

<?php

$dateCheck = '';
$valueCheck = '';
$bank = '';
$agency = '';
$account = '';
$numCheck = '';
$holder = '';
$doc = '';

if ( isset($_POST['add']) && $_POST['add'] == 'check' ) {
    $dateCheck = $_POST['date'];
    $valueCheck = str_replace(',','.',$_POST['value']);
//    $valueCheck = (double) $_POST['value'];
    $bank = $_POST['bank'];
    $agency = $_POST['agency'];
    $account = $_POST['account'];
    $numCheck = $_POST['numCheck'];
    $holder = $_POST['holder'];
    $doc = $_POST['docs'];

    $array = array (
        'idPouch_Check' => $idMaloteEdit,
        'date_e' => $dateCheck,
        'value' => $valueCheck,
        'docCpfOrCnpj' => $doc,
        'nameHolder' => $holder,
        'numberCheck' => $numCheck,
        'numberAccount' => $account,
        'numberAgency' => $agency,
        'numberBank' => $bank
    );

}

if ( isset($_GET['delete']) && !empty($_GET['delete']) ){
    $idCheckDelete = (int) $_GET['delete'];

    $table = "check_doc";
    $where = "idCheck = ".$idCheckDelete;
    $retry = $main->database->delete($table, $where);

    if ($retry){
        echo '<script>alert("Excluido com sucesso!");</script>';
    } else {
        echo '<script>alert("Erro ao excluir!");</script>';
    }

    echo '<script>location.href="'.PATH.'/index.php?page=malote&pros=CADmalote&edit='.$idMaloteEdit.'";</script>';
}

?>
<section class="page-title" style="background: url(assets/img/bg-page-title-email.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1>Cadastrar Malote</h1>
            </div>
            <div class="col-lg-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><span>Inicio</span></li>
                        <!--<li class="breadcrumb-item"><span>Home</span></li>-->
                        <li class="breadcrumb-item"><span>Malotes</span></li>
                        <li class="breadcrumb-item active" aria-current="page">Cadastrar Malote</li>
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

            <!-- Cabeçalho do Malote-->


            <h2 class="text-center">MALOTE Nº <?php echo $idMaloteEdit; ?></h2>
            <form method="POST" enctype="multipart/form-data">

                 <button type="submit" class="btn btn-success" name="save" value="malote" > Salvar </button>
                <a href="<?php echo PATH; ?>index.php?page=malote" class="btn btn-secondary ml-2"> Cancelar </a>
                <div class="mt-3" id="cabecalhoMalote" style=" border: black solid 1px ; border-radius: 5px; padding: 10px;">
                    <div class="row" style="">
                        <div class="col-md-3">
                            <label for="recipient-name" class="control-label">Código cliente:</label>
                            <input name="codeClient" type="text" class="form-control-plaintext font-weight-bold" placeholder="Ex.: 0123456" value="<?php echo $codeClient; ?>" required>
                        </div>
                        <div class="col-md-9">
                            <label for="recipient-name" class="control-label">Nome cliente:</label>
                            <input name="codeClient" type="text" class="form-control-plaintext font-weight-bold" value="<?php echo $nameClient; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="message-text" class="control-label">Data:</label>
                            <input id="date" name="dateMalote" type="text" class="form-control" placeholder="Ex.: dd/mm/aaaa" data-mask="00/00/0000" maxlength="10" value="<?php echo $date; ?>" required>
                        </div>
                        <div class="col-md-9">
                            <label for="message-text" class="control-label">Referência:</label>
                            <textarea name="references" class="form-control" required><?php echo $references; ?></textarea>
                        </div>
                    </div>
                </div>
<!--                <div class="modal-footer">-->
<!--                    <button type="submit" class="btn btn-success" name="save" value="malote">Cadastrar</button>-->
<!--                </div>-->
            </form>

            <?php

            if (isset($_POST['save']) && $_POST['save'] == 'malote'){

                $newDate = $_POST['dateMalote'];
                $newReferences = $_POST['references'];

                $array = array(
                    'date_e' => $newDate,
                    'reference' => $newReferences
                );

                $reply = $main->database->update("pouch_check", $array, " idPouch = ".$idMaloteEdit);

                if(!$reply){
                    echo '<script>alert("Erro ao adicionar cheque!");</script>';
                } else {
                    echo '<script>location.href="'.PATH.'/index.php?page=malote&pros=CADmalote&edit='.$idMaloteEdit.'";</script>';
                }

            }

            ?>

            <!-- Tabela de Cheques-->

            <a data-toggle="modal" data-target="#myModalcad" class="btn btn-primary mt-5"> Adicionar Cheque </a>

            <!-- Inicio Modal -->
            <div class="modal fade" id="myModalcad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-left" id="myModalLabel">Incluir Cheque</h4>
                        </div>
                        <div class="modal-body">

                            <form method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="message-text" class="control-label">Data vencimento:</label>
                                        <input id="date" name="date" type="text" class="form-control date placeholder" maxlength="10" value="<?php echo $dateCheck; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="control-label">Valor</label>
                                        <input name="value" type="text" class="form-control money" placeholder="R$"  value="<?php echo $valueCheck; ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="message-text" class="control-label">Banco:</label>
                                        <input id="date" name="bank" type="text" class="form-control" value="<?php echo $bank; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="control-label">Agência</label>
                                        <input name="agency" type="text" class="form-control" value="<?php echo $agency; ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="message-text" class="control-label">Conta:</label>
                                        <input id="date" name="account" type="text" class="form-control" value="<?php echo $account; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="control-label">Cheque Nº:</label>
                                        <input name="numCheck" type="text" class="form-control" value="<?php echo $numCheck; ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="message-text" class="control-label">Nome titular principal:</label>
                                        <input id="date" name="holder" type="text" class="form-control" value="<?php echo $holder; ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="recipient-name" class="control-label">Documento (CPF/CNPJ):</label>
                                        <input name="docs" type="text" class="form-control cpfOuCnpj" value="<?php echo $doc; ?>" required>
                                    </div>
                                </div>
                                <!--								<div class="modal-footer">-->
                                <button type="submit" class="btn btn-success" name="add" value="check">Incluir</button>
                                <a data-dismiss="modal" class="btn btn-secondary ml-2"> Cancelar </a>
                                <!--								</div>-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php

                if ( isset($_POST['add']) && $_POST['add'] == 'check' ){

                    $reply = $main->database->insert("check_doc", $array, 0);

                    if(!$reply){
                        echo '<script>alert("Erro ao adicionar cheque!");</script>';
                    } else {
                        echo '<script>location.href="'.$_SERVER["REQUEST_URI"].'";</script>';
                    }

                }

            ?>


<!--            Documentação https://igorescobar.github.io/jQuery-Mask-Plugin/docs.html#field-options -->
            <script>
                $(document).ready(function(){
                    $('.date').mask('00/00/0000');
                    // $('.time').mask('00:00:00');
                    // $('.date_time').mask('00/00/0000 00:00:00');
                    // $('.cep').mask('00000-000');
                    // $('.phone').mask('0000-0000');
                    // $('.phone_with_ddd').mask('(00) 0000-0000');
                    // $('.phone_us').mask('(000) 000-0000');
                    // $('.mixed').mask('AAA 000-S0S');
                    $('.cpf').mask('000.000.000-00', {reverse: true});
                    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
                    $('.money').mask('000.000.000.000.000,00', {reverse: true});
                    $('.money2').mask("#.##0,00", {reverse: true});
                    // $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
                    //     translation: {
                    //         'Z': {
                    //             pattern: /[0-9]/, optional: true
                    //         }
                    //     }
                    // });
                    // $('.ip_address').mask('099.099.099.099');
                    // $('.percent').mask('##0,00%', {reverse: true});
                    // $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
                    $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
                    // $('.fallback').mask("00r00r0000", {
                    //     translation: {
                    //         'r': {
                    //             pattern: /[\/]/,
                    //             fallback: '/'
                    //         },
                    //         placeholder: "__/__/____"
                    //     }
                    // });
                    // $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});



                    var options = {
                        onKeyPress: function (cpf, ev, el, op) {
                            var masks = ['000.000.000-000', '00.000.000/0000-00'];
                            $('.cpfOuCnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
                        }
                    }

                    $('.cpfOuCnpj').length > 11 ? $('.cpfOuCnpj').mask('00.000.000/0000-00', options) : $('.cpfOuCnpj').mask('000.000.000-00#', options);
                });

            </script>

            <!-- Fim Modal -->

            <!-- Inicio da Tabela -->

            <?php

                //Buscar dados dos clientes -- para popular a tabela

                $replyChecks = $main->database->select("SELECT * FROM check_doc WHERE idPouch_Check = ".$idMaloteEdit." ORDER BY idCheck");

            ?>

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
                        <th scope="col">Ações</th>

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
                        <td>
<!--                            <a href="--><?php //echo $_SERVER["REQUEST_URI"]; ?><!--&pros=CADclient&edit=--><?php //echo 'IDAQUI'; ?><!--" style="font-size: 1.2em; color: Tomato;" title="Editar"><i class="fas fa-edit"></i></i></a>-->
                            <a href="<?php echo $_SERVER["REQUEST_URI"]; ?>&delete=<?php echo $row->idCheck; ?>" class="ml-2" style="font-size: 1.2em; color: Tomato;" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php $i++;} ?>
                    <?php } else { ?>
                        <h4>Nenhum dado encontrado!</h4>
                    <?php } ?>
                </tbody>

            </table>
            <!-- Fim - Tabela de Cheques -->

            <p></p>
        </div>
    </div>
</div>
