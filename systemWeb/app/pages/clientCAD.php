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

    $code = "";
    $name = "";
    $email = "";

    if (isset($_GET['edit']) && !empty($_GET['edit'])){
        $idClientEdit = (int) $_GET['edit'];
        $query = "SELECT * FROM client WHERE idClient = ".$idClientEdit;
//        echo '<script>alert("'.$query.'");</script>';
        $reply = $main->database->select($query);

        foreach ($reply as $row){
            $code = $row->code;
            $name = $row->name;
            $email = $row->email;
        }

    }

?>

<section class="page-title" style="background: url(assets/img/bg-page-title-email.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1>Cadastro de Cliente</h1>
            </div>
            <div class="col-lg-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><span>Inicio</span></li>
                        <!--<li class="breadcrumb-item"><span>Home</span></li>-->
                        <li class="breadcrumb-item"><span>Clientes</span></li>
                        <li class="breadcrumb-item active" aria-current="page">Cadastro de Cliente</li>
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


            <form method="POST">
                <div class="form-group">
                    <label for="codeClient">Código do cliente <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="codeClient" name="code" placeholder="Codigo do cliente" value="<?php echo $code;?>" required>
                </div>
                <div class="form-group">
                    <label for="nameClient">Nome do cliente <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nameClient" name="name" placeholder="Nome do cliente" value="<?php echo $name;?>" required>
                </div>
                <div class="form-group">
                    <label for="emailClient">Endereço de email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="emailClient" name="email" aria-describedby="emailHelp" placeholder="Email do cliente" value="<?php echo $email;?>" required>
                </div>
                <small id="emailHelp" class="form-text text-muted"><span class="text-danger">* Campos obrigatórios</span></small><br/>
                <button type="submit" class="btn btn-success" name="save" value="client">Salvar Cliente</button>
                <a href="<?php echo PATH; ?>index.php?page=client" class="btn btn-secondary ml-2"> Cancelar </a>

            </form>

           <p></p>
        </div>
    </div>
</div>

<?php
    if (isset($_POST['save']) && $_POST['save'] == 'client'){
        
        $code = $main->clearInjectAllSQL($_POST['code']);
        $name = $main->clearInjectAllSQL($_POST['name']);
        $email = $main->clearInjectEmailSQL($_POST['email']);

        if (empty($code) || empty($name) || empty($email)){
            echo '<script>alert("Preencha todos os campos!");</script>';
        } else {

            $array = array(
                'code' => $code,
                'name' => $name,
                'email' => $email
            );

            if (isset($_GET['edit']) && !empty($_GET['edit'])){
                $reply = $main->database->update("client", $array, "idClient = ".$idClientEdit);
            } else {
                $reply = $main->database->insert('client', $array, 0);
            }

//            print_r($array);

            if ($reply){
                echo '<script>alert("Salvo com sucesso!");</script>';
                echo '<script>location.href="'.PATH.'/index.php?page=client";</script>';

            } else {
                echo '<script>alert("Erro ao salvar!");</script>';
            }
        }

    }
?>