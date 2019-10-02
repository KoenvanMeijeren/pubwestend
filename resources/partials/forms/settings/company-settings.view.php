<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="company-name"><b>Naam</b><span style="color: red">*</span></label>

    <div class="col-sm-10">
        <input class="form-control" type="text" id="company-name" name="companyName" minlength="2" maxlength="100"
               value="<?= \App\services\Settings::get('companyName') ?>" required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="company-tel"><b>Telefoonnummer</b><span
                style="color: red">*</span></label>

    <div class="col-sm-10">
        <input class="form-control" type="tel" id="company-tel" name="companyTel" minlength="10" maxlength="14"
               value="<?= \App\services\Settings::get('companyTel') ?>" required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="company-email"><b>Email</b><span style="color: red">*</span></label>

    <div class="col-sm-10">
        <input class="form-control" type="text" id="company-email" name="companyEmail" minlength="2" maxlength="100"
               value="<?= \App\services\Settings::get('companyEmail') ?>" required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="company-address"><b>Adres</b><span style="color: red">*</span></label>

    <div class="col-sm-10">
        <input class="form-control" type="text" id="company-address" name="companyAddress" minlength="2" maxlength="100"
               value="<?= \App\services\Settings::get('companyAddress') ?>" required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="company-postcode"><b>Postcode</b><span
                style="color: red">*</span></label>

    <div class="col-sm-10">
        <input class="form-control" type="text" id="company-postcode" name="companyPostcode" minlength="5" maxlength="6"
               value="<?= \App\services\Settings::get('companyPostcode') ?>" required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="company-city"><b>Plaats</b><span style="color: red">*</span></label>

    <div class="col-sm-10">
        <input class="form-control" type="text" id="company-city" name="companyCity" minlength="2" maxlength="100"
               value="<?= \App\services\Settings::get('companyCity') ?>" required>
    </div>
</div>
