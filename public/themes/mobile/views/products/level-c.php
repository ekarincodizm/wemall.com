<?php echo Theme::widget('mobileSearchBox')->render(); ?>

<?php echo Theme::widget('mobileCategoryLink')->render(); ?>
<h1 class="seo_search_mobile"><?php echo __('seo_h1_home');?></h1>
<h3 class="seo_search_mobile"><?php echo __('seo_keyword_home');?></h3>
<?php if ( ! empty($data['total_item'])) : ?>
<?php $total_item = $data['total_item']; ?>
<?php else : ?>
<?php $total_item = 0; ?>
<?php endif; ?>
<?php echo Theme::widget('viewBy', array('totalItems' => $total_item))->render(); ?>
<?php
$sortBy = array(
    'orderBy' => $orderBy,
    'order' => $order
);
?>
<?php echo Theme::widget('sortBy', $sortBy)->render(); ?>
<div id="load-more" data-pe="<?php echo $expired_at;?>"  data-page="1" style="display:none;" data-href="<?php echo URL::toLang('cate/search-view'); ?>"></div>

<div class="row"
     data-total-page="<?php echo ( ! empty($data['total_page'])) ? $data['total_page'] : 0; ?>"
     data-total-item="<?php echo $total_item; ?>"
     id="pkey-content"
     data-collection-pkey="<?php echo $currentPkey; ?>"></div>
