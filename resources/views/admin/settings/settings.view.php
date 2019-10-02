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
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-company-settings-tab" data-toggle="tab"
                           href="#nav-company-settings" role="tab" aria-controls="nav-home" aria-selected="true">
                            Bedrijfs instellingen
                        </a>
                        <a class="nav-item nav-link" id="nav-social-media-tab" data-toggle="tab"
                           href="#nav-social-media" role="tab" aria-controls="nav-profile" aria-selected="false">
                            Sociale media instellingen
                        </a>
                        <a class="nav-item nav-link" id="nav-restaurant-media-tab" data-toggle="tab"
                           href="#nav-restaurant-media" role="tab" aria-controls="nav-restaurant" aria-selected="false">
                            Restaurant instellingen
                        </a>
                    </div>
                </nav>
                <form method="post" action="/admin/settings/store">
                    <?php
                    // load the flash alerts
                    require_once RESOURCES_PATH . '/partials/flash.view.php';
                    ?>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-company-settings" role="tabpanel"
                             aria-labelledby="nav-company-settings-tab">
                            <div class="mt-3 ">
                                <?php
                                // load the settings view
                                require_once RESOURCES_PATH . '/partials/forms/settings/company-settings.view.php';
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-social-media" role="tabpanel"
                             aria-labelledby="nav-social-media-tab">
                            <div class="mt-3 ">
                                <?php
                                // load the settings view
                                require_once RESOURCES_PATH . '/partials/forms/settings/social-media.view.php';
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-restaurant-media" role="tabpanel"
                             aria-labelledby="nav-restaurant-media-tab">
                            <div class="mt-3">
                                <?php
                                // load the settings view
                                require_once RESOURCES_PATH . '/partials/forms/settings/restaurant-settings.view.php';
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <button class="btn btn-danger" type="button"
                                    onclick="window.location.href='/admin/settings'">Reset
                            </button>
                        </div>

                        <div class="col-sm-2">
                            <button class="btn btn-primary" type="submit">Opslaan</button>
                        </div>

                        <div class="col-sm-auto">
                            <p style="color: red">Velden met een * zijn verplicht</p>
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