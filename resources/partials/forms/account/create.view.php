<form method="post" action="/admin/account/store">
    <div class="row pb-2">
        <label class="col-sm-2 col-form-label" for="name"><b>Naam</b><span style="color: red">*</span></label>

        <div class="col-sm-10">
            <input class="form-control" type="text" id="name" name="name" minlength="2" maxlength="50" required>
        </div>
    </div>

    <div class="row pb-2">
        <label class="col-sm-2 col-form-label" for="email"><b>Email</b><span style="color: red">*</span></label>

        <div class="col-sm-10">
            <input class="form-control" type="email" id="email" name="email" minlength="2" maxlength="100" required>
        </div>
    </div>

    <div class="row pb-2">
        <label class="col-sm-2 col-form-label" for="password"><b>Wachtwoord</b><span style="color: red">*</span></label>

        <div class="col-sm-10">
            <input class="form-control" type="password" id="password" name="password" minlength="4" required>
        </div>
    </div>

    <div class="row pb-2">
        <label class="col-sm-2 col-form-label" for="repeatPassword">
            <b>Bevestig je wachtwoord</b><span style="color: red">*</span></label>

        <div class="col-sm-10">
            <input class="form-control" type="password" id="repeatPassword" name="confirmPassword" minlength="4"
                   required>
        </div>
    </div>

    <div class="row pb-2">
        <label class="col-sm-2 col-form-label" for="rights"><b>Rechten</b><span style="color: red">*</span></label>

        <div class="col-sm-10">
            <select id="rights" class="form-control" name="rights" required>
                <option value="">Kies het rechten niveau</option>
                <option value="1">Niveau 1 - Lees rechten</option>
                <option value="2">Niveau 2 - Lees en schrijf rechten</option>
                <option value="3">Niveau 3 - Lees, schrijf en update rechten</option>
                <option value="4">Niveau 4 - Lees, schrijf, update en verwijder rechten</option>
                <option value="5">Niveau 5 - Lees, schrijf, update, verwijder en account beheer rechten</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <button class="btn btn-danger" type="button" onclick="window.location.href='/admin/accounts/show'">
                Terug
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

