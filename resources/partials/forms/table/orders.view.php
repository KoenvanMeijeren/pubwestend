<div class="row mb-2">
    <div class="col-sm">
        <h3>Bestelde gerechten en dranken</h3>
    </div>
</div>

<div class="row">
    <div class="col-sm">
        <?php if (isset($orders) && !empty($orders)) : ?>
            <ul class="list-group">
                <?php foreach ($orders as $order) : ?>
                    <li class="list-group-item list-group-item-action">
                        <form method="post" action="/admin/table/deleteOrder">
                            <span class="badge badge-primary badge-pill"><?= $order->Order_ammount ?> x
                            &euro;<?= \App\models\admin\AdminTable::getMenuPrice($order->menu_id) ?></span>
                            <?= $order->Order_menu_item ?>

                            <input type="hidden" name="orderID" value="<?= $order->ID ?>">
                            <input type="hidden" name="id" value="<?= isset($tableID) && !empty($tableID) ? $tableID : '' ?>">

                            <button type="submit" class="btn btn-danger pull-right"
                                    onclick="return confirm('Weet je zeker dat je deze bestelling wilt verwijderen?')">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <h4>Er zijn geen bestellingen gevonden voor deze tafel</h4>
        <?php endif; ?>
    </div>
</div>

<div class="alert alert-info" role="alert">
    Het totale bedrag is
    &euro;<?= isset($totalOrdersPrice) && !empty($totalOrdersPrice) ? $totalOrdersPrice : 0 ?>
</div>

<div class="row">
    <div class="col-sm-2">
        <button class="btn btn-danger" type="button" onclick="window.location.href='/admin/table'">Terug</button>
    </div>

    <div class="col-sm-2">
        <form method="post" action="/admin/table/pay/store">
            <input type="hidden" name="table" value="<?= isset($tableID) && !empty($tableID) ? $tableID : '' ?>">
            <input type="hidden" name="totalCosts" value="<?= isset($totalOrdersPrice) && !empty($totalOrdersPrice) ? $totalOrdersPrice : 0 ?>">

            <button class="btn btn-primary" type="submit">Afrekenen</button>
        </form>
    </div>
</div>