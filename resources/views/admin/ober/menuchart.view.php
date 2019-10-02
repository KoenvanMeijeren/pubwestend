<?php

use App\services\core\Request;

require_once RESOURCES_PATH . '/partials/admin/header.view.php';
require_once RESOURCES_PATH . '/partials/admin/menu.view.php';

$request = new Request();
?>

<body>
<div class="page-wrapper">
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <form method="post" action="/public/admin/ober/store">
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <?php if (isset($menus['categories']) && !empty($menus['categories']) && isset($menus['items']) && !empty($menus['items'])) : ?>
                    <div class="ml-5 mr-5">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <?php foreach ($menus['categories'] as $category) : ?>
                                    <a class="nav-item nav-link"
                                       id="nav-social-tab"
                                       data-toggle="tab"
                                       href="#nav-<?= \App\models\Home::convertCategory($category) ?>"
                                       role="tab"
                                       aria-controls="nav-<?= \App\models\Home::convertCategory($category) ?>"
                                       aria-selected="false">
                                        <?= \App\models\admin\AdminMenu::convertCategory($category) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <?php
                            foreach ($menus['items'] as $items) :
                                ?>
                                <div class="tab-pane fade"
                                     id="nav-<?= isset($items[0]['Menu_category']) && !empty($items[0]['Menu_category']) ?
                                         \App\models\Home::convertCategory($items[0]['Menu_category']) : '' ?>"
                                     role="tabpanel"
                                     aria-labelledby="nav-<?= isset($items[0]['Menu_category']) && !empty($items[0]['Menu_category']) ?
                                         \App\models\Home::convertCategory($items[0]['Menu_category']) : '' ?>-tab">
                                    <div class="mt-3 ">
                                        <?php foreach ($items as $menu) : ?>
                                            <div class="menu-item">
                                                <h3>
                                                    <?= isset($menu['Menu_name']) && !empty($menu['Menu_name']) ?
                                                        $menu['Menu_name'] : '' ?>
                                                    <?php if (isset($menu['isOnStock']) && $menu['isOnStock'] === false) : ?>
                                                        <span style="color: red">(niet op voorraad)</span>
                                                    <?php endif; ?>
                                                </h3>
                                                <p><?= isset($menu['Menu_description']) && !empty($menu['Menu_description']) ?
                                                        $menu['Menu_description'] : '' ?></p>
                                                <p>€<?= isset($menu['Menu_price']) && !empty($menu['Menu_price']) ?
                                                        $menu['Menu_price'] : '' ?></p>
                                                <div class="row">
                                                    <div class="col-md-1 col-xs-3">
                                                        <input type="checkbox" id="cart" name="cart[]"
                                                               value="<?= isset($menu['ID']) &&
                                                               !empty($menu['ID']) ? $menu['ID'] : '' ?>"
                                                            <?= isset($menu['isOnStock']) && $menu['isOnStock'] === false ? 'disabled' : '' ?>
                                                        >
                                                    </div>
                                                    <div class="col-md-1 col-xs-3">
                                                        <div class="input-group">
                                                            <input class="form-control" type="number" id="menus"
                                                                   name="quantity<?= isset($menu['ID']) &&
                                                                   !empty($menu['ID']) ? $menu['ID'] : '' ?>"
                                                                   min="1" value="1" step='1' max="100"
                                                                   placeholder="Aantal"
                                                                <?= isset($menu['isOnStock']) && $menu['isOnStock'] === false ? 'disabled' : '' ?>
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        <?php
                                        endforeach; ?>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                            ?>
                        </div>
                        <input type="hidden" name="tafelid" value="<?= $request->post('id'); ?>">
                        <div class="row">
                            <div class="col-sm-2">
                                <button class="btn btn-danger" type="button"
                                        onclick="window.location.href='/admin/ober'">
                                    Tafel kiezen
                                </button>
                            </div>

                            <div class="col-sm-2">
                                <button class="btn btn-primary" type="submit">Toevoegen</button>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    Er zijn geen menu items gevonden
                <?php endif; ?>
            </div>
        </form>
    </div>
    <hr>
</div>
<?php
require_once RESOURCES_PATH . '/partials/admin/footer.view.php';
?>
