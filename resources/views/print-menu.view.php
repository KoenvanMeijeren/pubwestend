<?php
require_once RESOURCES_PATH . '/partials/errors/header.view.php';
$usedCategories = [];
if (isset($menus) && !empty($menus)) :
    ?>
    <div class="container">
        <div class="heading">
            <h2>Menukaart</h2>
        </div>

        <!-- Menu items -->
        <?php
        foreach ($menus as $menu) :
            if (!in_array($menu['Menu_category'], $usedCategories)) {
                $usedCategories += [$menu['Menu_category'] => ['isUsed' => false]];
            }
            ?>
            <div class="container">
                <div class="heading">
                    <?php
                    if (array_key_exists($menu['Menu_category'],
                            $usedCategories) && $usedCategories[$menu['Menu_category']]['isUsed'] === false) : ?>
                        <h4><?= \App\models\admin\AdminMenu::convertCategory($menu['Menu_category']) ?></h4>
                        <?php
                        $usedCategories[$menu['Menu_category']]['isUsed'] = true;
                    endif;
                    ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="sided-90x mb-30 ">
                            <div class="s-right">
                                <h5 class="mb-10">
                                    <b><?= $menu['Menu_name'] ?></b>
                                    <b class="color-primary float-right">&euro;<?= number_format($menu['Menu_price'], 2,
                                            ',', '.') ?></b>
                                </h5>
                                <p class="pr-70">
                                    <?= $menu['Menu_description'] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        window.print();
    </script>
<?php
endif;
require_once RESOURCES_PATH . '/partials/errors/header.view.php';
?>