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
            <div class="mr-5 mt-2 pull-right">
                <button class="btn btn-danger" onclick="window.location.href='/admin/account'">Terug</button>
                <button class="btn btn-primary" onclick="window.location.href='/admin/account/create'">Account
                    toevoegen
                </button>
            </div>
            <div class="ml-5 mt-3 pull-left">
                <h1><?= isset($title) && !empty($title) ? $title : '' ?></h1>
            </div>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5">
                <?php
                // load the flash alerts
                require_once RESOURCES_PATH . '/partials/flash.view.php';

                if (isset($accounts)) {
                    loadTable('account', ['ID', 'Naam', 'Email', 'Rechten', 'Bewerken'],
                        $accounts);
                } else {
                    echo "Er zijn geen accounts gevonden.";
                }
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