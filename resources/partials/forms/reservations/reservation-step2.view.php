<section class="story-area left-text center-sm-text pos-relative">
    <div class="abs-tbl bg-2 w-20 z--1 dplay-md-none"></div>
    <div class="abs-tbr bg-3 w-20 z--1 dplay-md-none"></div>
    <div class="container">
        <div class="heading">
            <h2>Reserveren - stap 2</h2>
        </div>
        <div class="row">
            <div class="mx-auto w-50 p-3 text-white text-left">
                <form action="/reserveren/store" id="reservationForm" method="post">
                    <?php
                    $request = new \App\services\core\Request();
                    // load the flash alerts
                    require_once RESOURCES_PATH . '/partials/flash.view.php';
                    ?>
                    <input type="hidden" name="name" value="<?= $request->post('name') ?>">
                    <input type="hidden" name="email" value="<?= $request->post('email') ?>">
                    <input type="hidden" name="phone" value="<?= $request->post('phone') ?>">
                    <input type="hidden" name="date" value="<?= $request->post('date') ?>">
                    <?= \App\services\core\CSRF::formToken('/reserveren/store') ?>

                    <div class="form-group">
                        <p>Tijd</p>
                        <select class="form-control" id="time" name="time" required>
                            <option value="">Kies een tijdstip</option>
                            <?php if (isset($openingHours['afternoon']) && !empty($openingHours['afternoon'])) :
                                foreach ($openingHours['afternoon'] as $openingHour) :
                                    ?>
                                    <option value="<?= $openingHour ?>"
                                        <?= $request->post('time') == $openingHour ? 'selected' : '' ?>>
                                        <?= $openingHour ?></option>
                                <?php
                                endforeach;
                                if (isset($openingHours['evening']) && !empty($openingHours['evening'])) :
                                    foreach ($openingHours['evening'] as $openingHour) :
                                        ?>
                                        <option value="<?= $openingHour ?>"><?= $openingHour ?></option>
                                    <?php
                                    endforeach;
                                endif;
                            else : ?>
                                <option value="11:00" <?= $request->post('time') == '11:00' ? 'selected' : '' ?>>11:00
                                </option>
                                <option value="11:30" <?= $request->post('time') == '11:30' ? 'selected' : '' ?>>11:30
                                </option>
                                <option value="12:00" <?= $request->post('time') == '12:00' ? 'selected' : '' ?>>12:00
                                </option>
                                <option value="12:30" <?= $request->post('time') == '12:30' ? 'selected' : '' ?>>12:30
                                </option>
                                <option value="13:00" <?= $request->post('time') == '13:00' ? 'selected' : '' ?>>13:00
                                </option>
                                <option value="13:30" <?= $request->post('time') == '13:30' ? 'selected' : '' ?>>13:30
                                </option>
                                <option value="14:00" <?= $request->post('time') == '14:00' ? 'selected' : '' ?>>14:00
                                </option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <p>Personen</p>
                        <input type="number" id="persons" class="form-control" name="quantityPersons" min="1" step="1"
                               max="<?= isset($retrievingCapacityRestaurant) && !empty($retrievingCapacityRestaurant) ?
                                   $retrievingCapacityRestaurant : \App\services\Settings::get('capacityRestaurant') ?>"
                               value="<?= !empty($request->post('quantityPersons')) ? $request->post('quantityPersons') : 1 ?>"
                               required>
                    </div>
                    <div class="form-group">
                        <p>Opmerking</p>
                        <textarea class="form-control" id="message" maxlength="1000"
                                  name="note"><?= $request->post('note') ?></textarea>
                    </div>

                    <input type="submit" class="btn btn-danger g-recaptcha" value="Reserveren"
                           data-sitekey="6LeNC5YUAAAAAFnTMZ0jsov-0eYFa_9khig5djvo"
                           data-callback="onSubmit"
                           data-size="invisible">
                </form>
            </div>

        </div><!-- row -->
    </div><!-- container -->
</section>