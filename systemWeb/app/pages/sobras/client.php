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
        $idClientDelete = (int) $_GET['delete'];

        $table = "client";
        $where = "idClient = ".$idClientDelete;
        $retry = $main->database->delete($table, $where);

        if ($retry){
            echo '<script>alert("Excluido com sucesso!");</script>';
        } else {
            echo '<script>alert("Erro ao excluir!");</script>';
        }

        echo '<script>location.href="'.PATH.'/index.php?page=client";</script>';
    }

?>

    <section class="page-title" style="background: url(assets/img/bg-page-title-email.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h1>Clientes</h1>
                </div>
                <div class="col-lg-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><span>Inicio</span></li>
                            <!--<li class="breadcrumb-item"><span>Home</span></li>-->
                            <li class="breadcrumb-item active" aria-current="page">Clientes</li>
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

                <a style="    margin-top: 15px;" href="<?php echo $_SERVER["REQUEST_URI"]; ?>&pros=CADclient"> <button type="button" class="btn btn-primary"> Cadastrar </button> </a></p>

<?php
    //Buscar dados dos clientes -- para popular a tabela

    $reply = $main->database->select("SELECT * FROM client ORDER BY name, idClient");



?>
                <!-- Inicio - Tabela de Clientes -->
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
                        <th scope="col">Código</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Email</th>
                        <th scope="col">Ações</th>
                    </tr>
                    </thead>
                    <?php if (!empty($reply)) { ?>
                        <tbody>
                        <?php foreach ($reply as $row){ ?>
                        <tr data-url="<?php echo $_SERVER["REQUEST_URI"]; ?>&pros=CADclient&edit=<?php echo $row->idClient; ?>" style="cursor: pointer; ">
                            <th scope="row"><?php echo $row->idClient; ?></th>
                            <td><?php echo $row->code; ?> </td>
                            <td><?php echo $row->name; ?> </td>
                            <td><?php echo $row->email; ?> </td>
                            <td>
                                <!--<a href="<?php echo $_SERVER["REQUEST_URI"]; ?>&pros=CADclient&edit=<?php echo $row->idClient; ?>" style="font-size: 1.2em; color: Tomato;" title="Editar"><i class="fas fa-edit"></i></i></a>
                                &nbsp;&nbsp;-->
                                <a href="<?php echo $_SERVER["REQUEST_URI"]; ?>&delete=<?php echo $row->idClient; ?>" style="font-size: 1.2em; color: Tomato;" title="Excluir"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    <?php } else { ?>
                        <h4>Nenhum dado encontrado!</h4>
                    <?php } ?>
                </table>
                <!-- Fim - Tabela de Clientes -->


            </div>
        </div>
    </div>