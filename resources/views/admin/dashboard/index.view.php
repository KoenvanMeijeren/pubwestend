<?php
require_once RESOURCES_PATH . '/partials/admin/header.view.php';
require_once RESOURCES_PATH . '/partials/admin/menu.view.php';
?>

    <body>
<div class="page-wrapper">
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <header class="header-desktop">
            <h1 class="ml-5 mt-3"><?= isset($title) && !empty($title) ? $title : '' ?></h1>
        </header>

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5">
                <?php
                // load the flash alerts
                require_once RESOURCES_PATH . '/partials/flash.view.php';
                ?>
            </div>

            <div class="ml-5 mr-5">
                <h1>Overzicht - Bestellingen</h1>

                <?php
                // load the table
                if (isset($orders) && !empty($orders)) {
                    loadTable('orders-table',
                        [
                            'ID',
                            'Tafel',
                            'Aangemaakt op',
                            'Menu item',
                            'Prijs',
                            'Aantal',
                            ' Status',
                            'Betaald',
                            'Verwijderen'
                        ], $orders);
                } else {
                    echo "Er zijn geen bestellingen gevonden.";
                }
                ?>
            </div>

            <div class="ml-5 mr-5">
                <h1>Overzicht - Reserveringen</h1>

                <?php
                if (isset($reservations) && !empty($reservations)) {
                    // load the reservations table
                    loadTable('reservations-table',
                        ['ID', 'Tafel', 'Aangemaakt op', 'Naam', 'Personen', 'Opmerkingen', 'Status', 'Bewerken'],
                        $reservations);
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