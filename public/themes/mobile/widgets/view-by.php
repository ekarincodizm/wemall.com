


<div class="row result-row">
    <div class="col-xs-4 search-result">
        <span style="color:#e83a27;" class="total-results"><?php echo number_format($totalItems); ?></span> <?php echo __("total-results"); ?>
    </div>
    <div class="col-xs-8 view-by text-right"><?php echo __("view-by"); ?>
        <a href="#" data-href="<?php echo URL::toLang('cate/search-view'); ?>" data-view-by="default" data-shref="<?php echo URL::toLang('search/view'); ?>" class="anchor-view-by active"><img src="<?php echo Theme::asset()->usePath()->url('img/icon_viewby_default_active.png'); ?>"></a>
        <a href="#" data-href="<?php echo URL::toLang('cate/search-view'); ?>" data-view-by="thumbnail" data-shref="<?php echo URL::toLang('search/view'); ?>" class="anchor-view-by"><img src="<?php echo Theme::asset()->usePath()->url('img/icon_viewby_thumbnail.png'); ?>"></a>
        <a href="#" data-href="<?php echo URL::toLang('cate/search-view'); ?>" data-view-by="list" data-shref="<?php echo URL::toLang('search/view'); ?>" class="anchor-view-by"><img src="<?php echo Theme::asset()->usePath()->url('img/icon_viewby_list.png'); ?>"></a>
    </div>
</div>

