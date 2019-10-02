<a name="reservations" id="reserveren-stap1"></a>
<section class="story-area left-text center-sm-text pos-relative">
    <div class="abs-tbl bg-2 w-20 z--1 dplay-md-none"></div>
    <div class="abs-tbr bg-3 w-20 z--1 dplay-md-none"></div>
    <div class="container">
        <div class="heading">
            <h2>Reserveren - stap 1</h2>
        </div>
        <div class="row">
            <div class="mx-auto w-50 p-3 text-white text-left">
                <?php
                $date = date('Y-m-d');
                $request = new \App\services\core\Request();
                // load the flash alerts
                require_once RESOURCES_PATH . '/partials/flash.view.php';
                ?>

                <form action="/reserveren/stap2" method="post">
                    <div class="form-group">
                        <p>Reserveren op de naam van</p>
                        <input type="text" id="name" class="form-control" name="name" minlength="2" maxlength="50"
                               value="<?= $request->post('name') ?>" required>
                    </div>
                    <div class="form-group">
                        <p>Emailadres</p>
                        <input type="email" id="email" class="form-control" name="email" minlength="2" maxlength="100"
                               value="<?= $request->post('email') ?>" required>
                    </div>
                    <div class="form-group">
                        <p>Telefoonnummer</p>
                        <input type="tel" id="phone" class="form-control" name="phone" minlength="10"
                               value="<?= $request->post('phone') ?>" maxlength="14" required>
                    </div>
                    <div class="form-group">
                        <p>Datum</p>
                        <input type="date" id="date" class="form-control" name="date" min="<?= $date ?>"
                               value="<?= $date ?>" required>
                    </div>

                    <input type="submit" class="btn btn-danger" value="Volgende">
                </form>
            </div>

        </div><!-- row -->
    </div><!-- container -->
</section>