<form method="post" action="/admin/our-story/store">
    <?php
    // load the flash alerts
    require_once RESOURCES_PATH . '/partials/flash.view.php';
    ?>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="title"><b>Titel</b><span style="color: red">*</span></label>

        <div class="col-sm-10">
            <input class="form-control" type="text" id="title" name="title" minlength="2" maxlength="100"
                   value="<?= isset($ourStory['title']) && !empty($ourStory['title']) ? $ourStory['title'] : '' ?>"
                   required>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="content-left"><b>Content linkerkant</b><span
                    style="color: red">*</span></label>

        <div class="col-sm-10">
            <textarea class="form-control" id="content-left" name="contentLeft" rows="5" minlength="2" maxlength="1000"
                      required><?= isset($ourStory['descriptionLeft']) && !empty($ourStory['descriptionLeft']) ?
                    $ourStory['descriptionLeft'] : '' ?></textarea>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="content-right"><b>Content rechterkant</b><span
                    style="color: red">*</span></label>

        <div class="col-sm-10">
            <textarea class="form-control" id="content-right" name="contentRight" rows="5" minlength="2"
                      maxlength="1000"
                      required><?= isset($ourStory['descriptionRight']) && !empty($ourStory['descriptionRight']) ?
                    $ourStory['descriptionRight'] : '' ?></textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <button class="btn btn-danger" type="button" onclick="window.location.href='/admin/our-story'">Reset
            </button>
        </div>

        <div class="col-sm-2">
            <button class="btn btn-primary" type="submit">Opslaan</button>
        </div>

        <div class="col-sm-auto">
            <p style="color: red">Velden met een * zijn verplicht</p>
        </div>
    </div>
</form>