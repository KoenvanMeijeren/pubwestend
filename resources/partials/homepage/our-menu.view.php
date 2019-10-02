<a name="menu" id="ons-menu"></a>
<section>
    <?php if (isset($menus['categories']) && !empty($menus['categories']) && isset($menus['items']) && !empty($menus['items'])) : ?>
        <div class="container">
            <div class="heading">
                <h2>Ons Menu</h2>
            </div>

            <!-- Navbar menu -->
            <div class="row">
                <div class="col-sm-12">
                    <ul class="selecton brdr-b-primary mb-70">
                        <li><a class="active" href="#" data-select="*"><b>Alle gerechten</b></a></li>
                        <?php foreach ($menus['categories'] as $category) : ?>
                            <li>
                                <a href="" data-select="<?= \App\models\Home::convertCategory($category) ?>">
                                    <b><?= \App\models\admin\AdminMenu::convertCategory($category) ?></b>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Menu items -->
            <div class="container">
                <div class="row">
                    <?php
                    foreach ($menus['items'] as $items) :
                        foreach ($items as $item) :
                            ?>
                            <div class="col-md-6 food-menu <?= \App\models\Home::convertCategory($item['Menu_category']) ?>">
                                <div class="sided-90x mb-30 ">
                                    <div class="s-right">
                                        <h5 class="mb-10">
                                            <b><?= $item['Menu_name'] ?></b>
                                            <b class="color-primary float-right">
                                                &euro;<?= number_format($item['Menu_price'], 2, ',', '.') ?></b>
                                        </h5>
                                        <p class="pr-70">
                                            <?= $item['Menu_description'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endforeach;
                    endforeach;
                    ?>
                </div>
            </div>

            <h6 class="center-text mt-40 mt-sm-20 mb-30">
                <a href="/menu/print" class="btn-primaryc plr-25" target="_blank" rel="nofollow"><b>Print het
                        menu</b></a>
            </h6>
        </div>
    <?php else : ?>
        <div class="container">
            <div class="heading">
                <h2>Menu kan niet worden weergegeven</h2>
            </div>
        </div>
    <?php endif; ?>
</section>