<!-- Search -->
<?php echo Theme::widget('WidgetMobileSearchBox')->render(); ?>

<!-- Category List -->
<div class="row margin-top-20">
    <div class="cate-list">
        <h1><?php echo $category['name']; ?></h1>
        <ul>
            <?php foreach ($category['children'] as $child): ?>
            <li><a href="#"><?php echo $child['name']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>