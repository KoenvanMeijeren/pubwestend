<?php if (isset($keys) && !empty($keys) && isset($rows) && !empty($rows)) : ?>
    <div class="table-responsive-sm">
        <table id="ordersTable" class="table table-striped table-bordered table-hover table-sm" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <?php foreach ($keys as $key) : ?>
                    <th class="th-sm">
                        <?= isset($key) && !empty($key) ? $key : '' ?>
                    </th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : '-' ?></td>
                    <td><?= isset($row['ID']) && !empty($row['ID']) ?
                            \App\models\admin\AdminOrder::getTableId($row['ID']) : '-' ?></td>
                    <td><?= isset($row['Order_created_at']) && !empty($row['Order_created_at']) ? $row['Order_created_at'] : '-' ?></td>
                    <td><?= isset($row['Order_menu_item']) && !empty($row['Order_menu_item']) ? $row['Order_menu_item'] : '-' ?></td>
                    <td>&euro;<?= isset($row['menu_id']) && !empty($row['menu_id']) ?
                            \App\models\admin\AdminTable::getMenuPrice($row['menu_id']) : '-' ?></td>
                    <td>
                        <form method="post" class="form-inline" action="/admin/order/update">
                            <input type="hidden" name="id" value="<?= $row['ID'] ?>">

                            <div class="form-group">
                                <label for="amount" class="sr-only">Aantal</label>
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Aantal"
                                       value="<?= isset($row['Order_ammount']) ? $row['Order_ammount'] : '-' ?>"
                                       min="0" max="100"
                                    <?= (isset($row['order_state']) && $row['order_state'] == '2') ||
                                    (isset($row['Order_paid']) && $row['Order_paid'] == '1') ? 'disabled' : '' ?>
                                    <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '3') ?
                                    '' : 'disabled' ?>
                                >
                                <input type="hidden" name="previousAmount"
                                       value="<?= isset($row['Order_ammount']) ? $row['Order_ammount'] : '-' ?>">
                            </div>
                            <button type="submit" class="btn btn-success mb-2"
                                <?= (isset($row['order_state']) && $row['order_state'] == '2') ||
                                (isset($row['Order_paid']) && $row['Order_paid'] == '1') ? 'disabled' : '' ?>
                                <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '3') ?
                                    '' : 'disabled' ?>
                            >
                                <i class="far fa-save"></i></button>
                        </form>
                    </td>
                    <td><?= isset($row['order_state']) ? \App\models\admin\AdminOrder::convertOrderState($row['order_state']) : '-' ?></td>
                    <td><?= isset($row['Order_paid']) ? \App\models\admin\AdminOrder::convertOrderPaid($row['Order_paid']) : '-' ?></td>
                    <td class="text-center">
                        <form method="post" action="/admin/order/delete">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Weet je zeker dat je deze bestelling wilt verwijderen?')"
                                <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '4') ?
                                    '' : 'disabled' ?>
                            >
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <p>Er is geen data gevonden.</p>
<?php endif; ?>