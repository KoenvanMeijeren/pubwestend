<form method="post" action="/admin/stock/update">
    <?php
    $request = new \App\services\core\Request();
    // load flash alerts
    require_once RESOURCES_PATH . '/partials/flash.view.php';
    ?>
    <input type="hidden" name="id"
           value="<?= isset($ingredient->ID) && !empty($ingredient->ID) ? $ingredient->ID : '' ?>">

    <div class="ml-5 mr-5">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="name"><b>Naam</b><span style="color: red">*</span></label>

            <div class="col-sm-10">
                <input class="form-control" type="text" id="name" name="name" minlength="2" maxlength="100"
                       value="<?= isset($ingredient->Ingredient_name) && !empty($ingredient->Ingredient_name) ? $ingredient->Ingredient_name : '' ?>"
                       required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="description"><b>Beschrijving</b></label>

            <div class="col-sm-10">
                <input class="form-control" type="text" id="description" name="description"
                       value="<?= isset($ingredient->Ingredient_description) && !empty($ingredient->Ingredient_description) ? $ingredient->Ingredient_description : '' ?>"
                       required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="quantity"><b>Aantal</b><span style="color: red">*</span></label>

            <div class="col">
                <input class="form-control" type="number" id="quantity" min="1" step="1" max="1000" name="quantity"
                       value="<?= isset($ingredient->Ingredient_quantity) && !empty($ingredient->Ingredient_quantity) ? $ingredient->Ingredient_quantity : '' ?>"
                       required>
            </div>

            <label class="col-sm-2 col-form-label" for="unity"><b>Eenheid</b><span style="color: red">*</span></label>

            <div class="col">
                <select class="form-control" name="unity" id="unity" required>
                    <option value="">Kies een eenheid</option>
                    <option value="ML" <?= isset($ingredient->ingredient_unit) && $ingredient->ingredient_unit == 'ML' ? 'selected' : '' ?>>
                        Mililiter
                    </option>
                    <option value="CL" <?= isset($ingredient->ingredient_unit) && $ingredient->ingredient_unit == 'CL' ? 'selected' : '' ?>>
                        Centiliter
                    </option>
                    <option value="DL" <?= isset($ingredient->ingredient_unit) && $ingredient->ingredient_unit == 'DL' ? 'selected' : '' ?>>
                        Deciliter
                    </option>
                    <option value="L" <?= isset($ingredient->ingredient_unit) && $ingredient->ingredient_unit == 'L' ? 'selected' : '' ?>>
                        Liter
                    </option>
                    <option value="MG" <?= isset($ingredient->ingredient_unit) && $ingredient->ingredient_unit == 'MG' ? 'selected' : '' ?>>
                        Miligram
                    </option>
                    <option value="G" <?= isset($ingredient->ingredient_unit) && $ingredient->ingredient_unit == 'G' ? 'selected' : '' ?>>
                        Gram
                    </option>
                    <option value="KG" <?= isset($ingredient->ingredient_unit) && $ingredient->ingredient_unit == 'KG' ? 'selected' : '' ?>>
                        Kilogram
                    </option>
                    <option value="Stuk" <?= isset($ingredient->ingredient_unit) && $ingredient->ingredient_unit == 'Stuk' ? 'selected' : '' ?>>
                        Stuk
                    </option>
                    <option value="Stuks" <?= isset($ingredient->ingredient_unit) && $ingredient->ingredient_unit == 'Stuks' ? 'selected' : '' ?>>
                        Stuks
                    </option>
                    <option value="Eetlepel" <?= isset($ingredient->ingredient_unit) && $ingredient->ingredient_unit == 'Eetlepel' ? 'selected' : '' ?>>
                        Eetlepel
                    </option>
                    <option value="Eetlepels" <?= isset($ingredient->ingredient_unit) && $ingredient->ingredient_unit == 'Eetlepels' ? 'selected' : '' ?>>
                        Eetlepels
                    </option>
                    <option value="Lepel" <?= isset($ingredient->ingredient_unit) && $ingredient->ingredient_unit == 'Lepel' ? 'selected' : '' ?>>
                        Lepel
                    </option>
                    <option value="Lepels" <?= isset($ingredient->ingredient_unit) && $ingredient->ingredient_unit == 'Lepels' ? 'selected' : '' ?>>
                        Lepels
                    </option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="price"><b>Prijs in €</b><span
                        style="color: red">*</span></label>

            <div class="col-sm-10">
                <input class="form-control" type="number" id="price" name="price" step='0.01' placeholder='0.00'
                       min="0.0l" max="1000.99"
                       value="<?= isset($ingredient->Ingredient_price_without_vat) && !empty($ingredient->Ingredient_price_without_vat) ?
                           $ingredient->Ingredient_price_without_vat : '' ?>"
                       required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="btw"><b>Btw in %</b><span style="color: red">*</span></label>

            <div class="col-sm-10">
                <input class="form-control" type="number" id="btw" name="btw" min="1" step="1" max="99"
                       value="<?= isset($ingredient->Ingredient_btw) && !empty($ingredient->Ingredient_btw) ? $ingredient->Ingredient_btw : '' ?>"
                       required>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                <button class="btn btn-danger" type="button" onclick="window.location.href='/admin/stock'">Terug
                </button>
            </div>

            <div class="col-sm-2">
                <button class="btn btn-primary" type="submit">Bijwerken</button>
            </div>

            <div class="col-sm-auto">
                <p style="color: red">Velden met een * zijn verplicht</p>
            </div>
        </div>
    </div>
</form>