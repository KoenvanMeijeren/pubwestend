<?php
require_once RESOURCES_PATH . '/partials/errors/header.view.php';
?>

    <div class="not-found">
        <h1><span><?= isset($error) && !empty($error) ? $error : '403' ?></span>
            - <?= isset($title) && !empty($title) ? $title : ' - Verboden toegang' ?></h1>
        <p><?= isset($description) && !empty($description) ? $description : '' ?></p>
    </div>

<?php
require_once RESOURCES_PATH . '/partials/errors/footer.view.php';
?>