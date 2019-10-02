<?php

use App\services\core\Request;

require_once RESOURCES_PATH . '/partials/admin/header.view.php';
require_once RESOURCES_PATH . '/partials/admin/menu.view.php';

$request = new Request();
?>

<body>
<div class="page-wrapper">
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop">
            <h1 class="ml-5 mt-3"><?= isset($title) && !empty($title) ? $title : '' ?></h1>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">

            <?php if (isset($orders) && !empty($orders)) : ?>
                <div class="last-view ml-5 mr-5">
                    <h3>
                        Tafel <?= isset($_SESSION['tafelID']) && !empty($_SESSION['tafelID']) ? $_SESSION['tafelID'] : '' ?></h3>
                    <?php
                    // load flash alerts
                    require_once RESOURCES_PATH . '/partials/flash.view.php';
                    ?>
                    <div class="mt-3 ">
                        <?php foreach ($orders as $id => $order) : ?>
                            <div class="">
                                <h4><?= $order['Menu_name'] ?></h4>
                                <p><?= $order['Menu_description'] ?></p>
                                <p>€<?= $order['Menu_price'] ?></p>
                                <div class="row">
                                    <div class="col-sm-1">
                                        <form method="post" action="/admin/ober/cart/delete">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Weet je zeker dat je deze bestelling wilt verwijderen?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <br>
                                    <div class="col-sm-auto">
                                        <form action="/admin/ober/cart/update" method="post" name="update">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <input class="number-type" type="number" id="menus"
                                                   name="quantity<?= $id ?>" min="1"
                                                   value="<?= $order['Quantity']; ?>"
                                                   step="1" max="100" placeholder="Aantal">
                                            <button type="submit" class="btn btn-success">
                                                <i class="far fa-save"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="ml-5 mr-5">
                    Er zijn geen bestellingen gevonden.
                </div>
            <?php endif; ?>
            <br>
            <div class="row mt-20 ml-3">
                <div class="col-sm-2">
                    <button class="btn btn-danger" type="submit" onclick="window.location.href='/admin/ober'">
                        Tafel kiezen
                    </button>
                </div>
                <div class="col-sm-2">
                    <form method="post" action="/admin/ober/menuchart">
                        <input type="hidden"
                               value="<?= isset($_SESSION['tafelID']) && !empty($_SESSION['tafelID']) ? $_SESSION['tafelID'] : '' ?>"
                               name="id">
                        <button class="btn btn-success" type="submit">
                            Toevoegen
                        </button>
                    </form>
                </div>
                <?php if (isset($orders) && !empty($orders)) : ?>
                    <div class="col-sm-2">
                        <form method="post" action="/admin/ober/cart/store">
                            <input type="hidden" name="tableid"
                                   value="<?= isset($_SESSION['tafelID']) && !empty($_SESSION['tafelID']) ? $_SESSION['tafelID'] : '' ?>">
                            <button class="btn btn-primary" type="submit">Opslaan</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <br>
    </div>
</div>
<?php
require_once RESOURCES_PATH . '/partials/admin/footer.view.php';
?>
