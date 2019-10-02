<!DOCTYPE HTML>
<html lang="en">
<head>
    <title><?= (isset($title) && !empty($title)) ? $title : '' ?> - Pub Westend</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <link href="/resources/assets/fonts/beyond_the_mountains_webfont.css" rel="stylesheet">
    <link href="/resources/assets/fonts/TaleofHawks.ttf" rel="stylesheet">

    <!-- Favicon -->
    <link rel='icon' href='/resources/assets/images/favicon.png' type='image/x-icon'>

    <!-- Stylesheets -->
    <link href="/resources/assets/plugin-frameworks/bootstrap.min.css" rel="stylesheet">
    <link href="/resources/assets/plugin-frameworks/swiper.css" rel="stylesheet">
    <link href="/resources/assets/fonts/ionicons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/resources/assets/css/styles.css" rel="stylesheet">
    <link href="/resources/assets/css/reservation.css" rel="stylesheet">
    <link href="/resources/assets/css/404-page.css" rel="stylesheet">
    <link href="/resources/assets/css/500-page.css" rel="stylesheet">

    <!-- Recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function onSubmit(token) {
            document.getElementById("reservationForm").submit();
        }
    </script>

</head>
<body>

<?php
require_once RESOURCES_PATH . '/partials/menu.view.php';
?>

<section class="bg-10 h-900x  pos-relative section1">
    <div class="bg-11">
        <div class="triangle-up pos-bottom bg-1"></div>
        <div class="container h-100">
            <div class="dplay-tbl">
                <div class="dplay-tbl-cell center-text color-white">
                    <h2>Welkom bij</h2>
                    <a class="logoHome"><img src="/resources/assets/images/westend-logo.png"
                                             alt="Restaurant Pub Westend"></a>
                </div><!-- dplay-tbl-cell -->
            </div><!-- dplay-tbl -->
        </div>
    </div><!-- container -->
</section>