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
            <h1 class="ml-5 mt-3"><?= isset($title) && !empty($title) ? $title : '' ?></h1>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5">
                <?php
                // load the flash alerts
                require_once RESOURCES_PATH . '/partials/flash.view.php';

                if (isset($kitchenList) && !empty($kitchenList)) :
                    foreach ($kitchenList as $table => $list) :
                        if (!empty($list)) :
                            ?>
                            <form method="post" action="/admin/kitchen/list/update">
                                <div class="kitchen-list table-responsive-sm">
                                    <div class="kitchen-list-item">
                                        <table>
                                            <tr>
                                                <th>Gerecht</th>
                                                <th>Ingredienten</th>
                                                <th>Tijd</th>
                                            </tr>
                                            <h2>Tafel <?= isset($table) && !empty($table) ? $table : 0 ?></h2>
                                            <?php foreach ($list as $orderId => $item) : ?>
                                                <tr>
                                                    <input type="hidden" name="orders[]"
                                                           value="<?= isset($orderId) && !empty($orderId) ? $orderId : 0 ?>">
                                                    <td>
                                                        <b><?= isset($item['Menu_amount']) && !empty($item['Menu_amount']) ?
                                                                $item['Menu_amount'] : '' ?></b>
                                                        x
                                                        <?= isset($item['Menu_item']) && !empty($item['Menu_item']) ?
                                                            $item['Menu_item'] : '' ?>
                                                    </td>
                                                    <td>
                                                        <?=
                                                        \App\models\admin\AdminMenu::getStoredIngredientsByName($item['Menu_id'])
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?= isset($item['Created_at']) && !empty($item['Created_at']) ?
                                                            $item['Created_at'] : '' ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <br>
                                            <h4>Status</h4>
                                            <button type="submit" class="btn btn-primary"
                                                <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '2') ?
                                                    '' : 'disabled' ?>>
                                                Klaar
                                            </button>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        <?php
                        endif;
                    endforeach;
                else : ?>
                    Er zijn geen tickets om weer te geven
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
</div>

<?php
// load the footer
require_once RESOURCES_PATH . '/partials/admin/footer.view.php';
?>