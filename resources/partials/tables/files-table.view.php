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
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <p>Er is geen data gevonden.</p>
<?php endif; ?>