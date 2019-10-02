<?php
$days = [
    'sunday' => 'zondag',
    'monday' => 'maandag',
    'tuesday' => 'dinsdag',
    'wednesday' => 'woensdag',
    'thursday' => 'donderdag',
    'friday' => 'vrijdag',
    'saturday' => 'zaterdag'
];
?>

<form method="post" action="/admin/opening-hours/store">
    <?php
    // load the flash alerts
    require_once RESOURCES_PATH . '/partials/flash.view.php';

    foreach ($days as $key => $day) :
        $AfterNoonOpeningTimeKey = $key . 'AfternoonOpeningTime';
        $AfterNoonClosingTimeKey = $key . 'AfternoonClosingTime';
        $EveningOpeningTimeKey = $key . 'EveningOpeningTime';
        $EveningClosingTimeKey = $key . 'EveningClosingTime';
        ?>
        <div class="form-group">
            <h4><?= ucfirst($day) ?> (Leeg = Gesloten)</h4>

            <div class="row">
                <div class="col">
                    <label class="col-form-label" for="openingTime"><b>Openingstijd 's middags</b></label><br>
                    <input type="time" id="openingTime" class="form-control" name="<?= $key ?>AfternoonOpeningTime"
                           value="<?= isset($openingHours) && is_array($openingHours) ?
                               isset($openingHours[$AfterNoonOpeningTimeKey]) && !empty($openingHours[$AfterNoonOpeningTimeKey]) ?
                                   $openingHours[$AfterNoonOpeningTimeKey] : ''
                               : '' ?>">

                    <label class="col-form-label" for="openingTime"><b>Openingstijd 's avonds</b></label><br>
                    <input type="time" id="openingTime" class="form-control" name="<?= $key ?>EveningOpeningTime"
                           value="<?= isset($openingHours) && is_array($openingHours) ?
                               isset($openingHours[$EveningOpeningTimeKey]) && !empty($openingHours[$EveningOpeningTimeKey]) ?
                                   $openingHours[$EveningOpeningTimeKey] : ''
                               : '' ?>">
                </div>

                <div class="col">
                    <label class="col-form-label" for="openingTime"><b>Sluitingstijd 's middags</b></label><br>
                    <input type="time" id="openingTime" class="form-control" name="<?= $key ?>AfternoonClosingTime"
                           value="<?= isset($openingHours) && is_array($openingHours) ?
                               isset($openingHours[$AfterNoonClosingTimeKey]) && !empty($openingHours[$AfterNoonClosingTimeKey]) ?
                                   $openingHours[$AfterNoonClosingTimeKey] : ''
                               : '' ?>">

                    <label class="col-form-label" for="openingTime"><b>Sluitingstijd 's avonds</b></label><br>
                    <input type="time" id="openingTime" class="form-control" name="<?= $key ?>EveningClosingTime"
                           value="<?= isset($openingHours) && is_array($openingHours) ?
                               isset($openingHours[$EveningClosingTimeKey]) && !empty($openingHours[$EveningClosingTimeKey]) ?
                                   $openingHours[$EveningClosingTimeKey] : ''
                               : '' ?>">
                </div>
            </div>
        </div>
        <hr>
    <?php endforeach; ?>

    <div class="row">
        <div class="col-sm-2">
            <button class="btn btn-danger" type="button" onclick="window.location.href='/admin/opening-hours'">
                Reset
            </button>
        </div>

        <div class="col-sm-2">
            <button class="btn btn-primary" type="submit">Opslaan</button>
        </div>
    </div>
</form>