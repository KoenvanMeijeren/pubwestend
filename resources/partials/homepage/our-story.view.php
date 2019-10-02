<a name="verhaal" id="onsverhaal"></a>
<section class="story-area left-text center-sm-text pos-relative">
    <div class="abs-tbl bg-2 w-20 z--1 dplay-md-none"></div>
    <div class="abs-tbr bg-3 w-20 z--1 dplay-md-none"></div>
    <div class="container">
        <div class="heading">
            <h2><?= isset($ourStory['title']) && !empty($ourStory['title']) ? $ourStory['title'] : 'Content kan niet worden weergegeven' ?></h2>
            <hr>
        </div>

        <div class="row">
            <div class="col-md-6">
                <p class="mb-30">
                    <?= isset($ourStory['descriptionLeft']) && !empty($ourStory['descriptionLeft']) ? $ourStory['descriptionLeft'] : '' ?>
                </p>
            </div><!-- col-md-6 -->

            <div class="col-md-6">
                <p class="mb-30">
                    <?= isset($ourStory['descriptionRight']) && !empty($ourStory['descriptionRight']) ? $ourStory['descriptionRight'] : '' ?>
                </p>
            </div><!-- col-md-6 -->
        </div><!-- row -->
    </div><!-- container -->
</section>