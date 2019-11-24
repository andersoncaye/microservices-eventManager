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

if ( isset($_GET['delete']) && !empty($_GET['delete']) ){
    $idMaloteDelete = (int) $_GET['delete'];

    $table = "pouch_check";
    $where = "idPouch = ".$idMaloteDelete;
    $retryMalote = $main->database->delete($table, $where);

    $table = "check_doc";
    $where = "idPouch_Check = ".$idMaloteDelete;
    $retryCheck = $main->database->delete($table, $where);

    if ($retryMalote){
        echo '<script>alert("Excluido com sucesso!");</script>';
    } else {
        echo '<script>alert("Erro ao excluir!");</script>';
    }

    echo '<script>location.href="'.PATH.'/index.php?page=malote";</script>';
}

?>

<?php

    $codeClient = "";
    $date = date('d/m/Y');;
    $references = "";

    if (isset($_POST['save']) && $_POST['save'] == 'malote' ){
        $codeClient = $_POST['codeClient'];
        $date = $_POST['date'];
        $references = $_POST['references'];
    }

?>
<section class="page-title" style="background: url(assets/img/bg-page-title-email.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1>Malotes</h1>
            </div>
            <div class="col-lg-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><span>Inicio</span></li>
                        <!--<li class="breadcrumb-item"><span>Home</span></li>-->
                        <li class="breadcrumb-item active" aria-current="page">Malotes</li>
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

            <div class="pull-left">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalcad">Cadastrar</button>
			</div>
			<!-- Inicio Modal -->
			<div class="modal fade" id="myModalcad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
                            
                            <h4 class="modal-title text-left" id="myModalLabel">Cadastrar Malote</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							
						</div>
						<div class="modal-body">

							<form method="POST" enctype="multipart/form-data">
								<div class="form-group">
									<label for="recipient-name" class="control-label">Código Cliente:</label>
									<input name="codeClient" type="text" class="form-control" placeholder="Ex.: 0123456" value="<?php echo $codeClient; ?>" required>
								</div>
								<div class="form-group">
									<label for="message-text" class="control-label">Data:</label>
									<input id="date" name="date" type="text" class="form-control" placeholder="Ex.: dd/mm/aaaa" data-mask="00/00/0000" maxlength="10" value="<?php echo $date; ?>" required>
								</div>
                                <div class="form-group">
									<label for="message-text" class="control-label">Referência:</label>
									<textarea name="references" class="form-control" required><?php echo $references; ?></textarea>
								</div>
<!--								<div class="modal-footer">-->
									<button type="submit" class="btn btn-success" name="save" value="malote">Cadastrar</button>
                                    <a data-dismiss="modal" class="btn btn-secondary ml-2"> Cancelar </a>
<!--								</div>-->
							</form>

                            <?php

                                if (isset($_POST['save']) && $_POST['save'] == 'malote' ){
                                    $codeClient = $_POST['codeClient'];
                                    $date = $_POST['date'];
                                    $references = $_POST['references'];
                                    //$idClient;

                                    $query = "SELECT * FROM client WHERE code = '".$codeClient."'";
                                    $replyClient = $main->database->select($query);
                                    if( !empty($replyClient) ){
                                        foreach ($replyClient as $row) {
                                            $idClient = $row->idClient;
                                        }

                                        $array = array ('idClient_Pousch'=> $idClient,'date_e'=> $date,'reference'=> $references);

                                        $reply = $main->database->insert("pouch_check", $array);

                                        if ($reply != null){
                                            echo '<script>alert("Malote gerado com sucesso!");</script>';
                                            echo '<script>location.href="'.$_SERVER["REQUEST_URI"].'&pros=CADmalote&edit='.$reply.'";</script>';
                                        } else {
                                            echo '<script>alert("Erro ao gerar malote!");</script>';

                                        }

                                    } else {
                                        echo '<script>alert("Código do cliente inválido!");</script>';
                                    }

                                }

                            ?>

						</div>
					</div>
				</div>
			</div>
			<!-- Fim Modal -->

            <?php
            //Buscar dados dos malotes -- para popular a tabela

            $reply = $main->database->select("SELECT pc.*, c.name, c.code FROM pouch_check pc, client c WHERE idClient_Pousch = idClient ORDER BY date_e, idPouch");

            ?>
            <!-- Inicio - Tabela de Malotes -->
            <script type="text/javascript">

                $(document).ready(function(){
                    $('table tr').click(function(){
                        window.location = $(this).data('url');
                        returnfalse;
                    });
                });

            </script>
            <table class="table" style="margin-top: 60px;">

               <thead>
                    <tr data-url="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                        <th scope="col">#</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Data</th>
                        <th scope="col">Referência</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <?php if (!empty($reply)) { ?>
                <tbody>
                    <?php foreach ($reply as $row){ ?>
                    <tr data-url="<?php echo $_SERVER["REQUEST_URI"]; ?>&pros=CADmalote&edit=<?php echo $row->idPouch; ?>" style="cursor: pointer; ">
                        <th scope="row"><?php echo $row->idPouch; ?></th>
                        <td><?php echo '[ '.$row->code.' ] - '.$row->name; ?></td>
                        <td><?php echo $row->date_e; ?> </td>
                        <td><?php echo $row->reference; ?></td>
                        
                        <td>
                            <a href="<?php echo $_SERVER["REQUEST_URI"]; ?>&delete=<?php echo $row->idPouch; ?>" style="font-size: 1.2em; color: Tomato;" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            <?php } else { ?>
                <h4>Nenhum dado encontrado!</h4>
            <?php } ?>
            </table>
            <!-- Fim - Tabela de Malotes -->

            <p></p>
        </div>
    </div>
</div>
<!--
<script type="text/javascript">
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        var recipientnome = button.data('whatevernome')
        var recipientdetalhes = button.data('whateverdetalhes')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('ID do Curso: ' + recipient)
        modal.find('#id_curso').val(recipient)
        modal.find('#recipient-name').val(recipientnome)
        modal.find('#detalhes-text').val(recipientdetalhes)
    })
</script>
-->