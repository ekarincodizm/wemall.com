<div class="home__top_banner">
    <?php if(isset($showHighLight) && $showHighLight === true): ?>
        <?php echo Theme::widget("highlightBannerV2", array())->render(); ?>
    <?php endif; ?>
</div>