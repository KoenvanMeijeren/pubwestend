<?php if (isset($keys) && !empty($keys) && isset($rows) && !empty($rows)) : ?>
    <div class="table-responsive-sm">
        <table id="menuTable" class="table table-striped table-bordered table-hover table-sm" cellspacing="0"
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
                    <td><?= isset($row['Menu_name']) && !empty($row['Menu_name']) ? $row['Menu_name'] : '-' ?></td>
                    <td><?= isset($row['Menu_category']) && !empty($row['Menu_category']) ?
                            \App\models\admin\AdminMenu::convertCategory($row['Menu_category']) : '-' ?></td>
                    <td><?= isset($row['Menu_description']) && !empty($row['Menu_description']) ? $row['Menu_description'] : '-' ?></td>
                    <td><?= \App\models\admin\AdminMenu::getStoredIngredientsByName(isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0); ?></td>
                    <td>
                        €<?= isset($row['Menu_price']) && !empty($row['Menu_price']) ?
                            number_format($row['Menu_price'], 2, ',', '.') : '0,00' ?></td>
                    <td><?= isset($row['Menu_btw']) && !empty($row['Menu_btw']) ? $row['Menu_btw'] : '0' ?></td>
                    <td class="text-center">
                        <form method="post" action="/admin/menu/edit" class="pull-left">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <button type="submit" class="btn btn-success"
                                <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '3') ?
                                    '' : 'disabled' ?>>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        </form>

                        <form method="post" action="/admin/menu/delete" class="pull-right">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <button type="submit" class="btn btn-danger"
                                <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '4') ?
                                    '' : 'disabled' ?>
                                    onclick="return confirm('Weet je zeker dat je dit menu wilt verwijderen?')">
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