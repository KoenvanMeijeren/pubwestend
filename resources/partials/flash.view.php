<?php
$error = \App\services\core\Session::get('error', true);
if (!empty($error)) :
    ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>

<?php
$message = \App\services\core\Session::get('success', true);
if (!empty($message)) :
    ?>
    <div class="alert alert-success" role="alert">
        <?= $message ?>
    </div>
<?php endif; ?>