<?php
require_once RESOURCES_PATH . '/partials/admin/header.view.php';
if (isset($invoice) && !empty($invoice) && isset($orders) && !empty($orders)) :
    ?>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Factuur <?= isset($invoice->ID) && !empty($invoice->ID) ? $invoice->ID : '0' ?>
                <strong><?= isset($invoice->Invoice_date) && !empty($invoice->Invoice_date) ?
                        date('d-m-Y H:i:s', strtotime($invoice->Invoice_date)) : '' ?></strong>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div>
                            <strong><?= \App\services\Settings::get('companyName') ?></strong><br>
                            Adres: <?= \App\services\Settings::get('companyAddress') ?> <br>
                            Plaats: <?= \App\services\Settings::get('companyPostcode') ?>
                            <?= \App\services\Settings::get('companyCity') ?> <br>
                            E-mail: <?= \App\services\Settings::get('companyEmail') ?> <br>
                            Telefoon: <?= \App\services\Settings::get('companyTel') ?> <br>
                        </div>
                    </div>
                </div>

                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="center">ID</th>
                            <th>Menu item</th>
                            <th class="right">Kosten</th>
                            <th class="right">BTW</th>
                            <th class="center">Aantal</th>
                            <th class="right">Totaal</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orders as $order) : ?>
                            <tr>
                                <td class="center">
                                    <?= isset($order->ID) && !empty($order->ID) ? $order->ID : '' ?>
                                </td>
                                <td class="left strong">
                                    <?= isset($order->Order_menu_item) && !empty($order->Order_menu_item) ?
                                        $order->Order_menu_item : '' ?>
                                </td>
                                <td class="right">
                                    €<?= isset($order->Menu_price) && !empty($order->Menu_price) ?
                                        number_format($order->Menu_price, 2, ',', '.') : '0,00' ?>
                                </td>
                                <td class="right">
                                    <?= isset($order->Menu_btw) && !empty($order->Menu_btw) ? $order->Menu_btw : 0 ?>%
                                </td>
                                <td class="center">
                                    <?= isset($order->Order_ammount) && !empty($order->Order_ammount) ?
                                        $order->Order_ammount : '' ?>
                                </td>
                                <td class="right">
                                    €
                                    <?=
                                    isset($order->Menu_price) && !empty($order->Menu_price) &&
                                    isset($order->Order_ammount) && !empty($order->Order_ammount) &&
                                    isset($order->Menu_btw) && !empty($order->Menu_btw)
                                        ?
                                        \App\model\admin\AdminInvoice::calculatePrice(
                                            $order->Menu_price, $order->Order_ammount, $order->Menu_btw
                                        ) : '0,00'
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5"></div>

                    <div class="col-lg-4 col-sm-5 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                            <tr>
                                <td class="left">
                                    <strong>BTW</strong>
                                </td>
                                <td class="right">
                                    €<?= isset($btwCosts) && !empty($btwCosts) ?
                                        number_format($btwCosts, 2, ',', '.') : 0 ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="left">
                                    <strong>Totaal</strong>
                                </td>
                                <td class="right">
                                    <strong>€<?= isset($totalCosts) && !empty($totalCosts) ?
                                            number_format($totalCosts, 2, ',', '.') : 0 ?></strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.print();
    </script>
<?php else : ?>
    Factuur kan niet worden weergegeven.
<?php
endif;
require_once RESOURCES_PATH . '/partials/admin/footer.view.php';
?>