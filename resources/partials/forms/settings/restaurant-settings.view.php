<div class="form-group row">
    <label class="col-sm-3 col-form-label" for="capacity-restaurant"><b>Restaurant capaciteit</b><span
                style="color: red">*</span></label>

    <div class="col-sm-9">
        <input class="form-control" type="number" id="capacity-restaurant" name="capacityRestaurant" min="1" step="1"
               max="1000"
               placeholder="Maximaal aantal mensen"
               value="<?= \App\services\Settings::get('capacityRestaurant') ?>" required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label" for="spending-time-restaurant">
        <b>Restaurant gemiddelde bestedingstijd <br> (in uren)</b><span style="color: red">*</span></label>

    <div class="col-sm-9">
        <input class="form-control" type="number" id="spending-time-restaurant" name="spendingTimeRestaurant" min="1"
               step="1" max="10"
               placeholder="Gemiddelde tijd dat mensen in een restaurant zitten"
               value="<?= \App\services\Settings::get('spendingTimeRestaurant') ?>" required>
    </div>
</div>