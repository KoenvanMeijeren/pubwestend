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
                <a href="/admin/menu/print" class="btn btn-danger" target="_blank" rel="nofollow">Menu
                    afdrukken</a>

                <?php if (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '2') : ?>
                    <button class="btn btn-primary" type="button"
                            onclick="window.location.href='/admin/menu/create'">
                        Menu item toevoegen
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
            <div class="mr-5 ml-5">
                <?php
                // load the flash alerts
                require_once RESOURCES_PATH . '/partials/flash.view.php';

                // load the menu table
                if (isset($menus)) {
                    loadTable('menu-table',
                        [
                            'ID',
                            'Naam',
                            'Categorie',
                            'Beschrijving',
                            'Ingrediënten',
                            'Prijs in €',
                            'BTW in %',
                            'Bewerken'
                        ], $menus);
                } else {
                    echo "Er zijn geen menu items gevonden.";
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