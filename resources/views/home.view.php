<?php
// load the footer of the website
require_once RESOURCES_PATH . '/partials/header.view.php';

// load our story
require_once RESOURCES_PATH . '/partials/homepage/our-story.view.php';

// load opening hours
require_once RESOURCES_PATH . '/partials/homepage/opening-hours.view.php';

if (isset($menus) && !empty($menus)) {
    // load our menu
    require_once RESOURCES_PATH . '/partials/homepage/our-menu.view.php';
}

// load the footer of the website
require_once RESOURCES_PATH . '/partials/footer.view.php';