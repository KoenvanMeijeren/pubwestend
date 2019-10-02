<form method="post" action="/admin/account/update">
    <div class="row pb-2">
        <label class="col-sm-2 col-form-label" for="name"><b>Naam</b><span style="color: red">*</span></label>

        <div class="col-sm-10">
            <input class="form-control" type="text" id="name" name="name" minlength="2" maxlength="50"
                   value="<?= isset($account->account_name) && !empty($account->account_name) ? $account->account_name : '' ?>"
                   required>
        </div>
    </div>

    <div class="row pb-2">
        <label class="col-sm-2 col-form-label" for="email"><b>Email</b><span style="color: red">*</span></label>

        <div class="col-sm-10">
            <input class="form-control" type="email" id="email" name="email" minlength="2" maxlength="100"
                   value="<?= isset($account->account_email) && !empty($account->account_email) ? $account->account_email : '' ?>"
                   required>
        </div>
    </div>

    <div class="row pb-2">
        <label class="col-sm-2 col-form-label" for="password"><b>Wachtwoord</b></label>

        <div class="col-sm-10">
            <input class="form-control" type="password" id="password" name="password"
                   minlength="4"
                   placeholder="Nieuw wachtwoord">
        </div>
    </div>

    <div class="row pb-2">
        <label class="col-sm-2 col-form-label" for="confirmPassword"><b>Bevestig wachtwoord</b></label>

        <div class="col-sm-10">
            <input class="form-control" type="password" id="confirmPassword" name="confirmPassword"
                   minlength="4"
                   placeholder="Bevestig nieuw wachtwoord">
        </div>
    </div>

    <div class="row pb-2">
        <label class="col-sm-2 col-form-label" for="rights"><b>Rechten</b></label>

        <div class="col-sm-10">
            <select id="rights" class="form-control" disabled>
                <option value="1" <?= isset($account->account_level) && !empty($account->account_level) ?
                    $account->account_level === '1' ? 'selected' : '' : '' ?>>
                    Niveau 1 - Lees rechten
                </option>
                <option value="2" <?= isset($account->account_level) && !empty($account->account_level) ?
                    $account->account_level === '2' ? 'selected' : '' : '' ?>>
                    Niveau 2 - Lees en schrijf rechten
                </option>
                <option value="3" <?= isset($account->account_level) && !empty($account->account_level) ?
                    $account->account_level === '3' ? 'selected' : '' : '' ?>>
                    Niveau 3 - Lees, schrijf en update rechten
                </option>
                <option value="4" <?= isset($account->account_level) && !empty($account->account_level) ?
                    $account->account_level === '4' ? 'selected' : '' : '' ?>>
                    Niveau 4 - Lees, schrijf, update en verwijder rechten
                </option>
                <option value="5" <?= isset($account->account_level) && !empty($account->account_level) ?
                    $account->account_level === '5' ? 'selected' : '' : '' ?>>
                    Niveau 5 - Lees, schrijf, update, verwijder en account beheer rechten
                </option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <button class="btn btn-primary" type="submit">Opslaan</button>
        </div>

        <div class="col-sm-auto">
            <p style="color: red">Velden met een * zijn verplicht</p>
        </div>
    </div>
</form>

