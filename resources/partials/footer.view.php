</body>
<footer class="pb-50  pt-70 pos-relative" id="contact">
    <div class="pos-top triangle-bottom"></div>
    <div class="container-fluid">
        <a href="/"><img src="/resources/assets/images/westend-logo.png" class="footerLogo"
                         alt="Restuarant Pub Westend Logo"></a>
        <hr>

        <div class="pt-30">
            <p class="underline-secondary"><b>Adres:</b></p>
            <p>
                <?= \App\services\Settings::get('companyAddress') ?> <br>
                <?= \App\services\Settings::get('companyPostcode') ?>
                <?= \App\services\Settings::get('companyCity') ?>
            </p>
        </div>

        <div class="pt-30">
            <p class="underline-secondary mb-10"><b>Email:</b></p>
            <a href="mailto:<?= \App\services\Settings::get('companyEmail') ?>" style="color: white">
                <?= \App\services\Settings::get('companyEmail') ?>
            </a>
        </div>

        <ul class="icon mt-30">
            <li><a href="<?= \App\services\Settings::get('facebook') ?>" target="_blank" rel="noopener noreferrer"><i
                            class="ion-social-facebook" style="color: white"></i></a></li>
            <li><a href="<?= \App\services\Settings::get('linkedin') ?>" target="_blank" rel="noopener noreferrer"><i
                            class="ion-social-linkedin" style="color: white"></i></a></li>
            <li><a href="<?= \App\services\Settings::get('instagram') ?>" target="_blank" rel="noopener noreferrer"><i
                            class="ion-social-instagram" style="color: white"></i></a></li>
            <li><a href="<?= \App\services\Settings::get('youtube') ?>" target="_blank" rel="noopener noreferrer"><i
                            class="ion-social-youtube" style="color: white"></i></a></li>
            <li><a href="<?= \App\services\Settings::get('twitter') ?>" target="_blank" rel="noopener noreferrer"><i
                            class="ion-social-twitter" style="color: white"></i></a></li>
        </ul>

        <p class="color-light font-9 mt-50 mt-sm-30">
            Copyright &copy;<script>document.write(new Date().getFullYear());</script>
            Alle rechten voorbehouden | <?= \App\services\Settings::get('companyName') ?> |
            <a href="/privacy-verklaring" target="_blank" rel="noopener noreferrer">Privacy verklaring</a>
        </p>
    </div><!-- container -->
</footer>

<!-- SCIPTS -->
<script src="/resources/assets/plugin-frameworks/jquery-3.2.1.min.js"></script>
<script src="/resources/assets/plugin-frameworks/bootstrap.min.js"></script>
<script src="/resources/assets/plugin-frameworks/swiper.js"></script>
<script src="/resources/assets/js/scripts.js"></script>

</html>