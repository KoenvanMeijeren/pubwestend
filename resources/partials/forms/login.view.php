<form method="post" action="/admin/login">
    <div class="login-container mx-auto">
        <?php
        // load the flash alerts
        require_once RESOURCES_PATH . '/partials/flash.view.php';
        ?>

        <h1>Inloggen</h1>

        <?= \App\services\core\CSRF::formToken('/admin/login') ?>

        <label for="email"><b>Email</b></label>
        <input class="login-input" type="email" id="email" placeholder="Typ email" name="email" required>

        <label for="password"><b>Wachtwoord</b></label>
        <input class="login-input" type="password" id="password" placeholder="Typ wachtwoord" name="password" required>

        <button class="login-button" type="submit">Inloggen</button>
    </div>
</form>