<?php if (isset($keys) && !empty($keys) && isset($rows) && !empty($rows)) : ?>
    <div class="table-responsive-xl">
        <table id="accountTable" class="table table-striped table-bordered table-hover table-sm" cellspacing="0"
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
                    <td><?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?></td>
                    <td><?= isset($row['account_name']) && !empty($row['account_name']) ? $row['account_name'] : '-' ?></td>
                    <td><?= isset($row['account_email']) && !empty($row['account_email']) ? $row['account_email'] : '-' ?></td>
                    <td><?= isset($row['account_level']) && !empty($row['account_level']) ?
                            \App\models\admin\AdminAccount::convertRights($row['account_level']) : '-' ?></td>
                    <td class="text-center">
                        <form method="post" action="/admin/account/edit" class="pull-left">
                            <input type="hidden" name="id"
                                   value="<?= isset($row['ID']) && !empty($row['ID']) ? $row['ID'] : 0 ?>">

                            <button type="submit" class="btn btn-success"
                                <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '3') ?
                                    '' : 'disabled' ?>>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        </form>

                        <form method="post" action="/admin/accounts/show/delete" class="pull-right">
                            <input type="hidden" name="id" value="<?= $row['ID'] ?>">

                            <button type="submit" class="btn btn-danger"
                                <?= (\App\models\admin\AdminAccount::getRights(\App\services\core\Session::get('id')) >= '4') ?
                                    '' : 'disabled' ?>
                                    onclick="return confirm('Weet je zeker dat account wilt verwijderen?')">
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