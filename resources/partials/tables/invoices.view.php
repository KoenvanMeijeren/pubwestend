<?php if (isset($keys) && !empty($keys) && isset($rows) && !empty($rows)) : ?>
    <div class="table-responsive-xl">
        <table id="invoices" class="table table-striped table-bordered table-hover table-sm" cellspacing="0" width="100%">
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
                    <td><?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : '' ?></td>
                    <td><?= isset($row['Table_id']) && !empty($row['Table_id']) ? $row['Table_id'] : '-' ?></td>
                    <td><?= isset($row['Invoice_date']) && !empty($row['Invoice_date']) ? $row['Invoice_date'] : '-' ?></td>
                    <td>€<?= isset($row['Invoice_costs']) && !empty($row['Invoice_costs']) ?
                            number_format($row['Invoice_costs'], 2, ',', '.') : '-' ?></td>
                    <td class="text-center">
                        <form method="post" action="/admin/invoice/orders">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <button type="submit" class="btn btn-success">
                                Bestellingen
                            </button>
                        </form>
                    </td>
                    <td class="text-center">
                        <form method="post" action="/admin/invoice/print">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <button type="submit" class="btn btn-primary">
                                Factuur afdrukken
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