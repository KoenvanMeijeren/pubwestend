<?php
require_once RESOURCES_PATH . '/partials/admin/header.view.php';
require_once RESOURCES_PATH . '/partials/admin/menu.view.php';
?>

    <body>
<div class="page-wrapper">
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop">
            <div class="ml-5 mt-3 pull-left">
                <h1><?= isset($title) && !empty($title) ? $title : '' ?></h1>
            </div>

            <div class="mr-5 mt-3 pull-right">
                <a href="/admin/developer/create" class="btn btn-success">Bestand uploaden</a>
            </div>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="mr-5 ml-5">
                <?php
                // load the flash alerts
                require_once RESOURCES_PATH . '/partials/flash.view.php';

                dd($files);
                ?>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>

</div>
<?php
require_once RESOURCES_PATH . '/partials/admin/footer.view.php';
?>