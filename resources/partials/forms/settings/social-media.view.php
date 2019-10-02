<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="social-media-facebook"><b>Facebook account</b><span
                style="color: red">*</span></label>

    <div class="col-sm-10">
        <input class="form-control" type="url" id="social-media-facebook" name="facebook"
               value="<?= \App\services\Settings::get('facebook') ?>" required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="social-media-instagram"><b>Instagram account</b><span
                style="color: red">*</span></label>

    <div class="col-sm-10">
        <input class="form-control" type="url" id="social-media-instagram" name="instagram"
               value="<?= \App\services\Settings::get('instagram') ?>" required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="social-media-linkedin"><b>LinkedIn account</b><span
                style="color: red">*</span></label>

    <div class="col-sm-10">
        <input class="form-control" type="url" id="social-media-linkedin" name="linkedin"
               value="<?= \App\services\Settings::get('linkedin') ?>" required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="social-media-youtube"><b>Youtube account</b><span
                style="color: red">*</span></label>

    <div class="col-sm-10">
        <input class="form-control" type="url" id="social-media-youtube" name="youtube"
               value="<?= \App\services\Settings::get('youtube') ?>" required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="social-media-twitter"><b>Twitter account</b><span
                style="color: red">*</span></label>

    <div class="col-sm-10">
        <input class="form-control" type="url" id="social-media-twitter" name="twitter"
               value="<?= \App\services\Settings::get('twitter') ?>" required>
    </div>
</div>