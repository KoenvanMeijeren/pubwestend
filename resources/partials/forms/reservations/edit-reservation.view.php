<?php
// load the flash alerts
require_once RESOURCES_PATH . '/partials/flash.view.php';
?>

<form action="/admin/reservation/update" method="post">
    <input type="hidden" name="id"
           value="<?= isset($reservation->ID) && !empty($reservation->ID) ? $reservation->ID : '' ?>">

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="name"><b>Reservering op naam van</b>
            <span style="color: red">*</span></label>

        <div class="col-sm-10">
            <input class="form-control" type="text" id="name" name="name" minlength="2" maxlength="50"
                   value="<?= isset($reservation->Reservation_customer_name) &&
                   !empty($reservation->Reservation_customer_name) ? $reservation->Reservation_customer_name : '' ?>"
                   required>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="email"><b>Email</b><span style="color: red">*</span></label>

        <div class="col-sm-10">
            <input class="form-control" type="email" id="email" name="email" minlength="2" maxlength="100"
                   value="<?= isset($reservation->Reservation_customer_email) &&
                   !empty($reservation->Reservation_customer_email) ? $reservation->Reservation_customer_email : '' ?>"
                   required>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="phone"><b>Telefoon nummer</b><span
                    style="color: red">*</span></label>

        <div class="col-sm-10">
            <input class="form-control" type="tel" id="phone" name="phone" minlength="10" maxlength="14"
                   value="<?= isset($reservation->Reservation_customer_phone) &&
                   !empty($reservation->Reservation_customer_phone) ? $reservation->Reservation_customer_phone : '' ?>"
                   required>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="date"><b>Datum</b><span style="color: red">*</span></label>

        <div class="col-sm-10">
            <input class="form-control" type="date" id="date" name="date"
                   value="<?= isset($reservation->Reservation_date) &&
                   !empty($reservation->Reservation_date) ? $reservation->Reservation_date : '' ?>" required>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="time"><b>Tijd</b><span style="color: red">*</span></label>

        <div class="col-sm-10">
            <input type="time" class="form-control" id="time" name="time"
                   value="<?= isset($reservation->Reservation_time) && !empty($reservation->Reservation_time) ?
                       $reservation->Reservation_time : '00:00' ?>">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="persons"><b>Personen</b><span style="color: red">*</span></label>

        <div class="col-sm-10">
            <input class="form-control" type="number" id="persons" name="quantityPersons" min="1" step="1"
                   max="<?= isset($retrievingCapacityRestaurant) && !empty($retrievingCapacityRestaurant) ?
                       $retrievingCapacityRestaurant : \App\services\Settings::get('capacityRestaurant') ?>"
                   value="<?= isset($reservation->Reservation_quantity_persons) &&
                   !empty($reservation->Reservation_quantity_persons) ? $reservation->Reservation_quantity_persons : '' ?>"
                   required>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="message"><b>Opmerking</b></label>

        <div class="col-sm-10">
            <textarea class="form-control" id="message" maxlength="1000"
                      name="note"><?= isset($reservation->Reservation_customer_notes) && !empty($reservation->Reservation_customer_notes) ? $reservation->Reservation_customer_notes : '' ?></textarea>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="state"><b>Status</b></label>

        <div class="col-sm-10">
            <select id="state" name="state" class="form-control" disabled>
                <option value="0" <?= isset($reservation->Reservation_state) && $reservation->Reservation_state == '0' ? 'selected' : '' ?>>
                    Onbevestigd
                </option>
                <option value="1" <?= isset($reservation->Reservation_state) && $reservation->Reservation_state == '1' ? 'selected' : '' ?>>
                    In behandeling
                </option>
                <option value="2" <?= isset($reservation->Reservation_state) && $reservation->Reservation_state == '2' ? 'selected' : '' ?>>
                    Afgerond
                </option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="table"><b>Tafel</b></label>

        <div class="col-sm-10">
            <select id="table" name="table" class="form-control">
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

    <?php if (isset($reservation->Table_id) && !empty($reservation->Table_id)) : ?>
        <input type="hidden" name="previousTable" value="<?= $reservation->Table_id ?>">
    <?php endif; ?>

    <div class="row">
        <div class="col-sm-2">
            <button class="btn btn-danger" type="button" onclick="window.location.href='/admin/reservations'">
                Terug
            </button>
        </div>

        <div class="col-sm-2">
            <button class="btn btn-primary" type="submit">
                Opslaan
            </button>
        </div>

        <div class="col-sm-auto">
            <p style="color: red">Velden met een * zijn verplicht</p>
        </div>
    </div>
</form>