<?php
    //valida a sessão
    if (isset($main)){
        if (!$main->session->issetSession($keySession)) {
            echo '<script>location.href="index.php";</script>';
        } 
    } else {
        echo '<script>location.href="index.php";</script>';
    }
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <?php require 'app/scripts/head.php'; ?>
    </head>
    <body>
        
        <div class="wrapper">
            <?php require 'app/partials/header.php'; ?>
            <main>
                <?php require 'app/main.php'; ?>
            </main>
            <div class="push"></div>
        </div>

       <?php require 'app/partials/footer.php'; ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/css/edge//javascripts/locastyle.js"></script>
        <script src="assets/js/script.js"></script>

<!--        Máscara de campos -->
        <script src="assets/js//jQuery-Mask-Plugin-master/src/jquery.mask.js"></script>
<!--            Documentação https://igorescobar.github.io/jQuery-Mask-Plugin/docs.html#field-options -->

        <script type="text/javascript">
            $(document).ready(function () {
                $('.navbar-light .dmenu').hover(function () {
                    $(this).find('.sm-menu').first().stop(true, true).slideDown(150);
                }, function () {
                    $(this).find('.sm-menu').first().stop(true, true).slideUp(105)
                });
            });
        </script>
        
    </body>
</html>