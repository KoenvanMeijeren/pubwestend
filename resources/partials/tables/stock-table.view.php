<?php if (isset($keys) && !empty($keys) && isset($rows) && !empty($rows)) : ?>
    <div class="table-responsive-xl">
        <table id="stockTable" class="table table-striped table-bordered table-hover table-sm" cellspacing="0"
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
                    <td><?= isset($row['Ingredient_name']) && !empty($row['Ingredient_name']) ?
                            $row['Ingredient_name'] : '-' ?></td>
                    <td><?= isset($row['Ingredient_description']) && !empty($row['Ingredient_description']) ?
                            $row['Ingredient_description'] : '-' ?></td>
                    <td><?= isset($row['Ingredient_quantity']) && !empty($row['Ingredient_quantity']) ?
                            $row['Ingredient_quantity'] : 'Niet op voorraad' ?></td>
                    <td><?= isset($row['ingredient_unit']) && !empty($row['ingredient_unit']) ?
                            $row['ingredient_unit'] : '-' ?></td>
                    <td>
                        €<?= isset($row['Ingredient_price']) && !empty($row['Ingredient_price']) ?
                            number_format($row['Ingredient_price'], 2, ',', '.') : '-' ?></td>
                    <td><?= isset($row['Ingredient_btw']) && !empty($row['Ingredient_btw']) ?
                            $row['Ingredient_btw'] : '-' ?></td>
                    <td class="text-center">
                        <form method="post" action="/admin/stock/edit" class="pull-left">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <button type="submit" class="btn btn-success"
                                <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '3') ?
                                '' : 'disabled' ?>>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        </form>

                        <form method="post" action="/admin/stock/delete" class="pull-right">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Weet je zeker dat je dit ingredient wilt verwijderen?')"
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