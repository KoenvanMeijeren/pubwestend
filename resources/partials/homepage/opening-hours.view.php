<a name="open" id="openingstijden"></a>
<section class="story-area bg-1 color-white pos-relative">
    <div class="pos-bottom triangle-up"></div>
    <div class="pos-top triangle-bottom"></div>
    <div class="container">
        <div class="heading">
            <h2>Openingstijden</h2>
            <hr>
        </div>
        <?php
        if (isset($openingHours) && !empty($openingHours) && is_array($openingHours)) :
            foreach ($openingHours as $day => $openingHour) :
                ?>
                <div class="open">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td scope="row">
                                <h5 class="mt-20">
                                    <?= $day . ': ' . $openingHour ?>
                                </h5></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?php
            endforeach;
        else : ?>
            Openingstijden kunnen niet worden weergegeven.
        <?php endif; ?>
    </div><!-- container -->
</section>