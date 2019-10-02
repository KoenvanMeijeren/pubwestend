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

            <?php
            // only accessible if your an admin with rights level 4
            if (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '2') : ?>
                <div class="mr-5 mt-2 pull-right">
                    <form method="post" action="/admin/table/store">
                        <div class="row">
                            <div class="col mt-2">
                                <input type="number" class="form-control" min="1" step="1" value="1" max="10"
                                       name="amountTables" required>
                            </div>

                            <div class="col">
                                <button class="btn btn-primary">Tafel toevoegen</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5">
                <?php
                // load flash alerts
                require_once RESOURCES_PATH . '/partials/flash.view.php';

                // load table
                if (isset($tables) && !empty($tables)) {
                    loadTable('tables-table', ['Tafel nummer', 'Tafel actief', 'Tafel Bezet', 'Afrekenen', 'Verwijderen'], $tables);
                } else {
                    echo 'Er zijn geen tafels gevonden.';
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