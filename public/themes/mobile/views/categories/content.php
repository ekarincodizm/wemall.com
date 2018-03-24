<!-- Search -->
<?php echo Theme::widget('WidgetMobileSearchBox')->render(); ?>

<!-- Category List -->
<div class="row margin-top-20">
    <div class="cate-list">
        <ul>
            <?php /*<li><a href="#">All category </a></li> */ ?>
            <?php if(!empty($categories['collections'])):?>
                <?php foreach($categories['collections'] as $collection): ?>
                    <li><a href="<?php echo get_permalink('category', $collection); ?>">
                        <?php
                            if (App::getLocale() == 'th') {
                                echo '<h2 class="seo_category">'.array_get($collection, 'name').'</h2>';
                            } else {
                                if (array_get($collection, 'translates') != null) {
                                    echo '<h2 class="seo_category">'.array_get($collection['translates'], Config::get('locale.' . App::getLocale()) . '.name').'</h2>';
                                } else {
                                    echo '<h2 class="seo_category">'.array_get($collection, 'name').'</h2>';
                                }
                            }
                        ?>
                    </a></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>