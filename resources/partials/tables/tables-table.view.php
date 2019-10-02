<?php if (isset($keys) && !empty($keys) && isset($rows) && !empty($rows)) : ?>
    <div class="table-responsive-sm">
        <table id="tablesTable" class="table table-striped table-bordered table-hover table-sm" cellspacing="0"
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
                    <td class="text-center"><?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : '' ?></td>
                    <td class="text-center">
                        <form method="post" action="/admin/table/updateEnabled">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <?php if (isset($row['Table_enabled']) && $row['Table_enabled'] === '1') : ?>
                                <button type="submit"
                                        class="btn btn-success"
                                    <?= isset($row['Table_occupied']) && $row['Table_occupied'] === '1' ? 'disabled' : '' ?>
                                    <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '3') ?
                                        '' : 'disabled' ?>>
                                    <?= isset($row['Table_enabled']) ? \App\models\admin\AdminTable::convertActiveState($row['Table_enabled']) : '' ?>
                                </button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-warning"
                                    <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '3') ?
                                        '' : 'disabled' ?>>
                                    <?= isset($row['Table_enabled']) ? \App\models\admin\AdminTable::convertActiveState($row['Table_enabled']) : '' ?>
                                </button>
                            <?php endif; ?>
                        </form>
                    </td>
                    <td class="text-center">
                        <form method="post" action="/admin/table/updateOccupied">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <?php if (isset($row['Table_occupied']) && $row['Table_occupied'] === '1') : ?>
                                <button type="submit" class="btn btn-success"
                                        onclick="return confirm('Weet je zeker dat je deze tafel op onbezet wilt zetten?')"
                                    <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '3') ?
                                        '' : 'disabled' ?>>
                                    <?= isset($row['Table_occupied']) ? \App\models\admin\AdminTable::convertOccupiedState($row['Table_occupied']) : '' ?>
                                </button>
                            <?php else: ?>
                                <button type="submit"
                                        class="btn btn-warning"
                                    <?= isset($row['Table_enabled']) && $row['Table_enabled'] === '0' ? 'disabled' : '' ?>
                                    <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '3') ?
                                        '' : 'disabled' ?>
                                        onclick="return confirm('Weet je zeker dat je deze tafel op bezet wilt zetten?')">
                                    <?= isset($row['Table_occupied']) ? \App\models\admin\AdminTable::convertOccupiedState($row['Table_occupied']) : '' ?>
                                </button>
                            <?php endif; ?>
                        </form>
                    </td>
                    <td class="text-center">
                        <form method="post" action="/admin/table/pay">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <?php if (isset($row['Table_occupied']) && $row['Table_occupied'] === '1') : ?>
                                <button type="submit" class="btn btn-primary"
                                    <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '3') ?
                                        '' : 'disabled' ?>>
                                    Afrekenen
                                </button>
                            <?php else : ?>
                                <button type="submit" class="btn btn-primary" disabled>
                                    Afrekenen
                                </button>
                            <?php endif; ?>
                        </form>
                    </td>
                    <td class="text-center">
                        <form method="post" action="/admin/table/delete">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <?php if (isset($row['Table_occupied']) && $row['Table_occupied'] === '1') : ?>
                                <button class="btn btn-danger" disabled>
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            <?php else: ?>
                                <button class="btn btn-danger"
                                    <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '4') ?
                                        '' : 'disabled' ?>
                                        onclick="return confirm('Weet je zeker dat je deze tafel wilt verwijderen?')">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            <?php endif; ?>
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