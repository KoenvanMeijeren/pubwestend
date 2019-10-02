<form method="post" action="/admin/stock/store">
    <div class="ml-5 mr-5">
        <?php
        $request = new \App\services\core\Request();
        // load flash alerts
        require_once RESOURCES_PATH . '/partials/flash.view.php';
        ?>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="name"><b>Naam</b><span style="color: red">*</span></label>

            <div class="col-sm-10">
                <input class="form-control" type="text" id="name" name="name" minlength="2" maxlength="100"
                       value="<?= $request->post('name') ?>"
                       required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="description"><b>Beschrijving</b></label>

            <div class="col-sm-10">
                <input class="form-control" type="text" id="description" name="description"
                       value="<?= $request->post('description') ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="quantity"><b>Aantal</b><span style="color: red">*</span></label>

            <div class="col">
                <input class="form-control" type="number" id="quantity" min="1" step="1" value="1" max="1000"
                       name="quantity"
                       required>
            </div>

            <label class="col-sm-1 col-form-label" for="unity"><b>Eenheid</b><span style="color: red">*</span></label>

            <div class="col">
                <select class="form-control" name="unity" id="unity" required>
                    <option value="">Kies een eenheid</option>
                    <option value="ML">Mililiter</option>
                    <option value="CL">Centiliter</option>
                    <option value="DL">Deciliter</option>
                    <option value="L">Liter</option>
                    <option value="MG">Miligram</option>
                    <option value="G">Gram</option>
                    <option value="KG">Kilogram</option>
                    <option value="Stuk">Stuk</option>
                    <option value="Stuks">Stuks</option>
                    <option value="Eetlepel">Eetlepel</option>
                    <option value="Eetlepels">Eetlepels</option>
                    <option value="Lepel">Lepel</option>
                    <option value="Lepels">Lepels</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="price"><b>Prijs in €</b>
                <span style="color: red">*</span></label>

            <div class="col-sm-10">
                <input class="form-control" type="number" id="price" name="price" min="0.01" step='0.01' max="1000.99"
                       placeholder='0.00' required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="btw"><b>Btw in %</b><span style="color: red">*</span></label>

            <div class="col-sm-10">
                <input class="form-control" type="number" id="btw" name="btw" min="1" value="9" step="1" max="99"
                       required>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                <button class="btn btn-danger" type="button" onclick="window.location.href='/admin/stock'">
                    Terug
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