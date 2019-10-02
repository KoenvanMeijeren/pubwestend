<?php if (isset($keys) && !empty($keys) && isset($rows) && !empty($rows)) : ?>
    <div class="table-responsive-xl">
        <table id="reservationTable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
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
                    <td><?= isset($row['Table_id']) && !empty($row['Table_id']) ? $row['Table_id'] : '-' ?></td>
                    <td><?= isset($row['Reservation_date']) && !empty($row['Reservation_date']) ?
                            date_format(date_create($row['Reservation_date']), 'd-m-Y') : '-' ?>
                        <?= isset($row['Reservation_time']) && !empty($row['Reservation_time']) ?
                            $row['Reservation_time'] : '-' ?></td>
                    <td><?= isset($row['Reservation_customer_name']) && !empty($row['Reservation_customer_name']) ?
                            $row['Reservation_customer_name'] : '-' ?></td>
                    <td><?= isset($row['Reservation_quantity_persons']) && !empty($row['Reservation_quantity_persons']) ?
                            $row['Reservation_quantity_persons'] : '-' ?></td>
                    <td><?= isset($row['Reservation_customer_notes']) && !empty($row['Reservation_customer_notes']) ?
                            $row['Reservation_customer_notes'] : '-' ?></td>
                    <td><?= isset($row['Reservation_state']) ?
                            \App\models\admin\AdminTableReservation::convertState($row['Reservation_state']) : '-' ?></td>
                    <td class="text-center">
                        <form method="post" action="/admin/reservation/edit" class="pull-left">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <button type="submit" class="btn btn-success"
                                <?= isset($row['Reservation_state']) && $row['Reservation_state'] == '2' ? 'disabled' : '' ?>
                                <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '3') ?
                                    '' : 'disabled' ?>
                            >
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        </form>

                        <form method="post" action="/admin/reservation/delete" class="pull-right">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Weet je zeker dat je deze reservering wilt verwijderen?')"
                                <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '4') ?
                                    '' : 'disabled' ?>>
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