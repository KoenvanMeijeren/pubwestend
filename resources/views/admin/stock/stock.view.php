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
                <?php if (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '2') : ?>
                    <button class="btn btn-primary" onclick="window.location.href='/admin/stock/create'">
                        Ingrediënt toevoegen
                    </button>
                <?php endif; ?>
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

                // load the stock table
                if (isset($ingredients) && !empty($ingredients)) {
                    loadTable('stock-table',
                        ['ID', 'Naam', 'Beschrijving', 'Aantal', 'Eenheid', 'Prijs in €', 'BTW in %', 'Bewerken'],
                        $ingredients);
                } else {
                    echo "Er is geen voorraad gevonden.";
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