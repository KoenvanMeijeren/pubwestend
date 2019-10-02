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
        <div class="main-content container-fluid">
            <div class="table">
                <div class="col-md-12">
                    <h2>Kies de tafel</h2>
                    <hr>
                </div>
            </div>
            <?php
            // load the flash alerts
            require_once RESOURCES_PATH . '/partials/flash.view.php';

            if (isset($table) && !empty($table)) : ?>
                <div class="table-choose col-md-12">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <?php foreach ($table as $tables) : ?>
                            <form method="post" action="/public/admin/ober/menuchart">
                                <input type="hidden" name="id" value="<?= $tables['ID'] ?>">

                                <button type="submit" class="btn btn-primary">
                                    Tafel - <?= $tables['ID'] ?>
                                </button>
                            </form>
                        <?php
                        endforeach; ?>
                    </div>
                </div>
            <?php else : ?>
                Er zijn geen bezette tafels gevonden.
            <?php endif; ?>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>
</div>
<?php
require_once RESOURCES_PATH . '/partials/admin/footer.view.php';
?>
