<?php

use App\services\core\Session;
use App\models\admin\AdminAccount;

?>

<!-- HEADER MOBILE-->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a class="logo" href="/admin/dashboard">
                    <img src="/resources/assets/admin/images/westend-logo.png" alt="CoolAdmin"/>
                </a>
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                <?php if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <a href="/admin/dashboard">
                            <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    </li>
                <?php
                endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 2) : ?>
                    <li>
                        <div class="dropdown ml-3">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-home"></i>Home
                            </a>

                            <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/admin/our-story">Ons verhaal bewerken</a>
                                <a class="dropdown-item" href="/admin/opening-hours">Openingstijden bewerken</a>
                            </div>
                        </div>
                    </li>
                <?php
                endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <div class="dropdown ml-3">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-book"></i>Menu
                            </a>

                            <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton">
                                <a href="/admin/stock">Voorraadbeheer</a>
                                <a href="/admin/menu">Menukaart</a>
                            </div>
                        </div>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <div class="dropdown ml-3">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-clock-o"></i>Tafel beheer
                            </a>

                            <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/admin/table">Tafels beheren</a>
                                <a class="dropdown-item" href="/admin/reservations">Reserveringen beheren</a>
                            </div>
                        </div>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 2) : ?>
                    <li>
                        <a href="/admin/ober"><i class="fas fa-coffee"></i>Ober app</a>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <a href="/admin/order">
                            <i class="far fa-check-square"></i>Bestellingen
                        </a>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <a href="/admin/kitchen/list">
                            <i class="fas fa-utensils"></i>Keukenlijst</a>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <a href="/admin/invoices">
                            <i class="fas fa-file-invoice"></i>Facturen</a>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <a href="/admin/settings">
                            <i class="fas fa-cog"></i>Instellingen</a>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <div class="dropdown ml-3">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>Account
                            </a>

                            <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/admin/account">Account beheer</a>
                                <a class="dropdown-item" href="/admin/account/logout">Uitloggen</a>
                            </div>
                        </div>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 5) :
                    ?>
                    <li>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>Developer
                            </a>

                            <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/admin/developer">Developer</a>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
<!-- END HEADER MOBILE-->

<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo bg-black">
        <a href="/admin/dashboard">
            <img src="/resources/assets/admin/images/westend-logo.png" alt="Restaurant Pub Westend Logo"/>
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <?php if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <a href="/admin/dashboard">
                            <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    </li>
                <?php
                endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 2) : ?>
                    <li>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-home"></i>Home
                            </a>

                            <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/admin/our-story">Ons verhaal bewerken</a>
                                <a class="dropdown-item" href="/admin/opening-hours">Openingstijden bewerken</a>
                            </div>
                        </div>
                    </li>
                <?php
                endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-book"></i>Menu
                            </a>

                            <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton">
                                <a href="/admin/stock">Voorraadbeheer</a>
                                <a href="/admin/menu">Menukaart</a>
                            </div>
                        </div>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-clock-o"></i>Tafel beheer
                            </a>

                            <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/admin/table">Tafels beheren</a>
                                <a class="dropdown-item" href="/admin/reservations">Reserveringen beheren</a>
                            </div>
                        </div>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 2) : ?>
                    <li>
                        <a href="/admin/ober"><i class="fas fa-coffee"></i>Ober app</a>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <a href="/admin/order">
                            <i class="far fa-check-square"></i>Bestellingen
                        </a>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <a href="/admin/kitchen/list">
                            <i class="fas fa-utensils"></i>Keukenlijst</a>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <a href="/admin/invoices">
                            <i class="fas fa-file-invoice"></i>Facturen</a>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 3) : ?>
                    <li>
                        <a href="/admin/settings">
                            <i class="fas fa-cog"></i>Instellingen</a>
                    </li>
                <?php endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 1) : ?>
                    <li>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>Account
                            </a>

                            <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/admin/account">Account beheer</a>
                                <a class="dropdown-item" href="/admin/account/logout">Uitloggen</a>
                            </div>
                        </div>
                    </li>
                <?php
                endif;
                if (AdminAccount::getRights(intval(Session::get('id'))) >= 5) :
                    ?>
                    <li>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>Developer
                            </a>

                            <div class="dropdown-menu p-1" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/admin/developer">Developer</a>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->