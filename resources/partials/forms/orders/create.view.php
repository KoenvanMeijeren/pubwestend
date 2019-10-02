<form method="post" action="/admin/order/store">
    <div class="ml-5 mr-5">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="table"><b>Bestelling tafel</b><span style="color: red">*</span></label>

            <div class="col-sm-10">
                <select id="table" name="table" class="form-control" required>
                    <option value="">Niet toegewezen aan een tafel</option>
                    <?php if (isset($reservation->Table_id) && !empty($reservation->Table_id)) : ?>
                        <option value="<?= $reservation->Table_id ?>" selected><?= $reservation->Table_id ?></option>
                    <?php endif;
                    if (isset($tables) && !empty($tables)) :
                        foreach ($tables as $table) : ?>
                            <option value="<?= $table['ID'] ?>"><?= $table['ID'] ?></option>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="menus"><b>Menu</b><span style="color: red">*</span></label>

            <div class="col-sm-10">
                <?php if (isset($menus) && !empty($menus)) : ?>
                    <div class="col" style="height: 50vh; overflow-y: scroll">
                        <?php foreach ($menus as $menu) : ?>
                            <div class="row">
                                <div class="col">
                                    <input type="checkbox" class="bigCheckbox" id="menus" name="menus[]"
                                           value="<?= $menu['ID'] ?>"
                                        <?= isset($menu['isOnStock']) && $menu['isOnStock'] === false ? 'disabled' : '' ?>
                                    >
                                    <label>
                                        <?= $menu['Menu_name'] ?>
                                        <?php if (isset($menu['isOnStock']) && $menu['isOnStock'] === false) : ?>
                                            <span style="color: red">(niet op voorraad)</span>
                                        <?php endif; ?>
                                    </label>
                                </div>

                                <div class="col">
                                    <input class="form-control" type="number" id="menus"
                                           name="quantity<?= $menu['ID'] ?>" min="1" value="1" step='1'
                                           max="100" placeholder="Aantal"
                                        <?= isset($menu['isOnStock']) && $menu['isOnStock'] === false ? 'disabled' : '' ?>
                                    >
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    Er zijn geen menu items gevonden.
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                <button class="btn btn-danger" type="button" onclick="window.location.href='/admin/order'">Terug
                </button>
            </div>

            <div class="col-sm-2">
                <button class="btn btn-primary" type="submit">Toevoegen</button>
            </div>

            <div class="col-sm-auto">
                <p style="color: red">Velden met een * zijn verplicht</p>
            </div>
        </div>
    </div>
</form>