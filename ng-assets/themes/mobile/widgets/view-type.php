<!-- Slider : Use bootstrap framework-->


<?php /*
<div class="row result-row">
    <div class="col-xs-4 search-result"><span style="color:#e83a27;">12,503</span> results</div>
    <div class="col-xs-8 view-by text-right">View by <a href="#"><img src="img/icon_viewby_default_active.png"></a> <a href="search-thumbnail.html"><img src="img/icon_viewby_thumbnail.png"></a> <a href="search-list.html"><img src="img/icon_viewby_list.png"></a></div>
</div>
 */ ?>


<div class="row result-row">
    <div class="col-xs-4 search-result">
        <span style="color:#e83a27;">12,503</span> results
    </div>
    <div class="col-xs-8 view-by text-right"><?php echo __("view_by"); ?>
        <a href="#" data-href="<?php echo URL::toLang('category/search-view'); ?>" data-view-by="default" class="view-by"><img src="<?php echo Theme::asset()->usePath()->url('img/icon_viewby_default_active.png'); ?>"></a>
        <a href="#" data-href="<?php echo URL::toLang('category/search-view'); ?>" data-view-by="thumbnail" class="view-by"><img src="<?php echo Theme::asset()->usePath()->url('img/icon_viewby_thumbnail.png'); ?>"></a>
        <a href="#" data-href="<?php echo URL::toLang('category/search-view'); ?>" data-view-by="list" class="view-by"><img src="<?php echo Theme::asset()->usePath()->url('img/icon_viewby_list.png'); ?>"></a>
    </div>
</div>

