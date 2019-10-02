<form method="post" action="/admin/menu/update">
    <input type="hidden" name="id" value="<?= isset($menu->ID) && !empty($menu->ID) ? $menu->ID : '' ?>">

    <div class="ml-5 mr-5">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="titel"><b>Titel</b><span style="color: red">*</span></label>

            <div class="col-sm-10">
                <input class="form-control" type="text" id="titel" name="titel" minlength="2" maxlength="100"
                       value="<?= isset($menu->Menu_name) && !empty($menu->Menu_name) ? $menu->Menu_name : '' ?>"
                       required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="category"><b>Categorie</b><span
                        style="color: red">*</span></label>

            <div class="col-sm-10">
                <select id="category" name="category" class="form-control" required>
                    <option value="1.1" <?= isset($menu->Menu_category) && $menu->Menu_category == '1.1' ? 'selected' : '' ?>>
                        Voorgerecht - Warm
                    </option>
                    <option value="1.2" <?= isset($menu->Menu_category) && $menu->Menu_category == '1.2' ? 'selected' : '' ?>>
                        Voorgerecht - Koud
                    </option>
                    <option value="2.1" <?= isset($menu->Menu_category) && $menu->Menu_category == '2.1' ? 'selected' : '' ?>>
                        Hoofdgerecht - Warm
                    </option>
                    <option value="2.2" <?= isset($menu->Menu_category) && $menu->Menu_category == '2.2' ? 'selected' : '' ?>>
                        Hoofdgerecht - Koud
                    </option>
                    <option value="3.1" <?= isset($menu->Menu_category) && $menu->Menu_category == '3.1' ? 'selected' : '' ?>>
                        Nagerecht - Warm
                    </option>
                    <option value="3.2" <?= isset($menu->Menu_category) && $menu->Menu_category == '3.2' ? 'selected' : '' ?>>
                        Nagerecht - Koud
                    </option>
                    <option value="4.1" <?= isset($menu->Menu_category) && $menu->Menu_category == '4.1' ? 'selected' : '' ?>>
                        Drinken - Warm
                    </option>
                    <option value="4.2" <?= isset($menu->Menu_category) && $menu->Menu_category == '4.2' ? 'selected' : '' ?>>
                        Drinken - Koud
                    </option>
                    <option value="4.3" <?= isset($menu->Menu_category) && $menu->Menu_category == '4.3' ? 'selected' : '' ?>>
                        Drinken - Alcohol
                    </option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="ingredients"><b>Ingrediënten</b><span
                        style="color: red">*</span></label>

            <?php if (isset($ingredients) && !empty($ingredients)) : ?>
                <div class="col-sm-10" style="height: 30vh; overflow-y: scroll">
                    <?php foreach ($ingredients as $ingredient) : ?>
                        <div class="form-group row">
                            <div class="col-sm-2 col-form-label">
                                <input type="checkbox" class="bigCheckbox" id="ingredients" name="ingredients[]"
                                       value="<?= $ingredient['ID'] ?>"
                                    <?= \App\models\admin\AdminMenu::getStoredIngredientByMenuId($menu->ID,
                                        $ingredient['ID']) !== false ? 'checked' : '' ?>>
                                <label><?= $ingredient['Ingredient_name'] ?></label>
                            </div>

                            <div class="col-sm-5 input-group mb-2">
                                <div class="input-group-prepend">
                                    <input class="form-control" type="number" id="ingredients"
                                           name="quantity<?= $ingredient['Ingredient_name'] ?>" min="0.01" step='0.01'
                                           max="1000.99" placeholder="Aantal"
                                           value="<?= !empty(\App\models\admin\AdminMenu::getStoredIngredientByMenuId($menu->ID,
                                               $ingredient['ID'])) ? \App\models\admin\AdminMenu::getStoredIngredientByMenuId($menu->ID,
                                               $ingredient['ID']) : '1' ?>">
                                    <div class="input-group-text"><?= $ingredient['ingredient_unit'] ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                Er zijn geen ingrediënten gevonden.
            <?php endif; ?>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="description"><b>Beschrijving</b></label>

            <div class="col-sm-10">
                <input class="form-control" type="text" id="description" name="description"
                       value="<?= isset($menu->Menu_description) && !empty($menu->Menu_description) ? $menu->Menu_description : '' ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="price"><b>Prijs</b><span style="color: red">*</span></label>

            <div class="col-sm-10">
                <input class="form-control" type="number" id="price" name="price" min="0.01" step='0.01' max="1000.99"
                       value="<?= isset($menu->Menu_price_without_vat) && !empty($menu->Menu_price_without_vat) ? $menu->Menu_price_without_vat : '' ?>"
                       required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="btw"><b>BTW in %</b><span style="color: red">*</span></label>

            <div class="col-sm-10">
                <input class="form-control" type="number" id="btw" name="btw" min="1" step='1' max="100"
                       value='<?= isset($menu->Menu_btw) && !empty($menu->Menu_btw) ? $menu->Menu_btw : '0' ?>'
                       required>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                <button class="btn btn-danger" type="button" onclick="window.location.href='/admin/menu'">Terug
                </button>
            </div>

            <div class="col-sm-2">
                <button class="btn btn-primary" type="submit">Opslaan</button>
            </div>

            <div class="col-sm-auto">
                <p style="color: red">Velden met een * zijn verplicht</p>
            </div>
        </div>
    </div>
</form>