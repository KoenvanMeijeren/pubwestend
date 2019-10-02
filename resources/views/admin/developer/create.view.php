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
            <div class="ml-5 mt-3">
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
                ?>

                <form enctype="multipart/form-data" method="post" action="/admin/developer/store">
                    <div class="row">
                        <label class="col-sm-2 col-form-label" for="file"><b>Bestand uploaden</b></label>

                        <div class="col-sm-10">
                            <input type="file" id="file" name="file" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <button class="btn btn-danger" type="button"
                                    onclick="window.location.href='/admin/developer'">Terug
                            </button>
                        </div>

                        <div class="col-sm-2">
                            <button class="btn btn-primary" type="submit">Uploaden</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>

</div>
<?php
require_once RESOURCES_PATH . '/partials/admin/footer.view.php';
?>