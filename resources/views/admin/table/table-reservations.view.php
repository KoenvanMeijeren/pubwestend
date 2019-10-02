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
            <h1 class="ml-5 mt-3 mr-5"><?= isset($title) && !empty($title) ? $title : '' ?></h1>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5">
                <?php
                // load the flash alerts
                require_once RESOURCES_PATH . '/partials/flash.view.php';

                if (isset($reservations) && !empty($reservations)) {
                    // load the reservations table
                    loadTable('reservations-table',
                        [
                            'ID',
                            'Tafel',
                            'Aangemaakt op',
                            'Naam',
                            'Personen',
                            'Opmerkingen',
                            'Status',
                            'Bewerken'
                        ],
                        $reservations
                    );
                } else {
                    echo "Er zijn geen reserveringen gevonden.";
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