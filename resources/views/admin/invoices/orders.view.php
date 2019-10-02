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
            <div class="ml-5 mr-5">
                <?php
                // load flash alerts
                require_once RESOURCES_PATH . '/partials/flash.view.php';
                ?>

                <ul class="list-group">
                    <?php if (isset($orders) && !empty($orders)) :
                        foreach ($orders as $order) :
                            ?>
                            <li class="list-group-item list-group-item-action">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <?= isset($order->Order_ammount) && !empty($order->Order_ammount) ? $order->Order_ammount : '' ?>
                                        x <?= isset($order->Order_menu_item) && !empty($order->Order_menu_item) ? $order->Order_menu_item : '' ?>
                                    </div>
                                    <div class="col-sm-3">
                                        €<?= isset($order->Menu_price) && !empty($order->Menu_price) ?
                                            number_format($order->Menu_price, 2, ',', '.') : '0,00' ?> per stuk
                                    </div>
                                    <div class="col-sm-3">
                                        <?= isset($order->Menu_btw) && !empty($order->Menu_btw) ? $order->Menu_btw : 0
                                        ?>% BTW
                                    </div>
                                    <div class="col-sm-3">
                                        <?= isset($order->Order_created_at) && !empty($order->Order_created_at) ? $order->Order_created_at : '' ?>
                                    </div>
                                </div>
                            </li>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </ul>

                <div class="row">
                    <button class="btn btn-danger" type="button"
                            onclick="window.location.href='/admin/invoices'">
                        Terug
                    </button>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>

</div>
<?php
require_once RESOURCES_PATH . '/partials/admin/footer.view.php';
?>