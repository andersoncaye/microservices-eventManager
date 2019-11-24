<nav class="navbar navbar-expand-sm   navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse bg-light" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item bg-light">
                <a class="nav-link" href="<?php echo PATH; ?>index.php?page">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item bg-light">
                <a class="nav-link" href="<?php echo PATH; ?>index.php?page=findCheque">Pesquisar Cheque</a>
            </li>
            <li class="nav-item dropdown dmenu bg-light">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    Cadastros
                </a>
                <div class="dropdown-menu sm-menu">
                    <a class="dropdown-item" href="<?php echo PATH; ?>index.php?page=client">Cliente</a>
                    <a class="dropdown-item" href="<?php echo PATH; ?>index.php?page=malote">Malote</a>
                </div>
            </li>
            <li class="nav-item bg-light">
                <a class="nav-link" href="<?php echo PATH; ?>index.php?page=report">Relatórios</a>
            </li>
            <li class="nav-item bg-light">
                <a class="nav-link" href="<?php echo PATH; ?>index.php?page=email">Email</a>
            </li>
<!--            <li class="nav-item bg-light">-->
<!--                <a class="nav-link" href="--><?php //echo PATH; ?><!--index.php?page=info">Info</a>-->
<!--            </li>-->
        </ul>
        <div class="social-part bg-light">
            <span class="bg-light">Olá <?php echo $main->session->get($keySession); ?> !</span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="index.php?page=sair">SAIR</a>
            <!--
            <i class="fa fa-facebook" aria-hidden="true"></i>
            <i class="fa fa-twitter" aria-hidden="true"></i>
            <i class="fa fa-instagram" aria-hidden="true"></i>
            -->
        </div>
    </div>
</nav>