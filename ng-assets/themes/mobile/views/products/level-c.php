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
<div id="load-more"  data-page="1" style="display:none;" data-href="<?php echo URL::toLang('cate/search-view'); ?>"></div>

<div class="row"
     data-total-page="<?php echo ( ! empty($data['total_page'])) ? $data['total_page'] : 0; ?>"
     data-total-item="<?php echo $total_item; ?>"
     id="pkey-content"
     data-collection-pkey="<?php echo $currentPkey; ?>"></div>

<?php /*
<div class="row"
     data-total-page="<?php echo ( ! empty($data['total_page'])) ? $data['total_page'] : 0; ?>"
     data-total-item="<?php echo $total_item; ?>"
     id="pkey-content"
     data-collection-pkey="<?php echo $currentPkey; ?>">
    <?php if ( ! empty($data['products'])) : ?>
    <?php $i = 0; ?>
    <?php foreach ($data['products'] as $key => $value) : ?>
    <?php $side = ($i % 2) ? "right" : "left"; ?>
    <?php #alert($value, 'green'); ?>
    <div class="col-xs-6 margin-top-20 col-<?php echo $side; ?>">
        <?php #alert($value, 'blue'); ?>
        <div class="view-default">
            <?php if ( ! empty($value['percent_discount']['max'])) : ?>
            <div class="price-tag">
                <span class="price-red"><?php echo floor($value['percent_discount']['max']); ?></span>

                <img src="<?php echo Theme::asset()->usePath()->url('img/dummy_sale_tag_03.png'); ?>">

            </div>
            <?php endif; ?>
            <div class="col-xs-12"><div class="product-image"><a href="<?php echo levelDUrl($value['slug'], $value['pkey']); ?>"><img src="<?php echo $value['image_cover']['normal']; ?>"></a></div></div>
            <div class="col-xs-12 product-name">
                <?php if (App::getLocale() == "th") : ?>
                <?php echo $value['title']; ?>
                <?php else : ?>
                    <?php if ( ! empty($value['translate']['title'])) : ?>
                    <?php echo $value['translate']['title']; ?>
                    <?php else : ?>
                    <?php echo $value['title']; ?>
                    <?php endif; ?>
                <?php endif; ?>
           </div>
            <?php if ( ! empty($value['caption'])) : ?>
            <div class="col-xs-12 caption">
                <img src="<?php echo Theme::asset()->usePath()->url('img/icon_caption.png'); ?>"><span><?php echo $value['caption']; ?></span>
            </div>
            <?php endif; ?>
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-6 price">
                        <?php if ( ! empty($value['special_price_range']['min']) && ! empty($value['special_price_range']['max'])) : ?>
                            <?php if ($value['net_price_range']['min'] == $value['net_price_range']['max']) : ?>
                                <h2><?php echo priceMobile($value['price_range']['min']); ?></h2>
                                <span><?php echo priceMobile($value['net_price_range']['min']); ?></span>

                            <?php else : ?>
                                <h2><?php echo priceMobile($value['price_range']['min'], $value['price_range']['max']); ?></h2>
                                <span><?php echo priceMobile($value['net_price_range']['min'], $value['net_price_range']['max']); ?></span>

                            <?php endif; ?>
                        <?php else : ?>
                            <?php if ($value['price_range']['min'] == $value['price_range']['max']) : ?>
                                <h2 class="normal-price-only"><?php echo priceMobile($value['price_range']['min']); ?></h2>
                            <?php else : ?>
                                <h2 class="normal-price-only"><?php echo priceMobile($value['price_range']['min'], $value['price_range']['max']); ?></h2>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                    <?php if ( ! empty($value['active_trueyou_discount'])) : ?>
                    <div class="col-xs-6 truecard">
                        <div class="row">
                            <div class="col-xs-6"><img src="<?php echo Theme::asset()->usePath()->url('img/true_card.png'); ?>"></div>
                            <div class="col-xs-6">
                                <p><?php echo __("discount-trueyou"); ?></p>
                                <?php if ( ! empty($value['active_trueyou_discount']['black']) && ! empty($value['active_trueyou_discount']['red'])) : ?>
                                <span><?php echo $value['active_trueyou_discount']['red']['discount']; ?> - <?php echo $value['active_trueyou_discount']['black']['discount']; ?>%</span>
                                <?php else : ?>
                                <span><?php echo $value['active_trueyou_discount']['red']['discount']; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <a href="<?php echo URL::toLang('cate/search-view'); ?>?collectionKey=<?php echo $currentKey; ?>&viewBy=<?php echo $viewBy; ?>&orderBy=<?php echo $orderBy; ?>&order=<?php echo $order; ?>&page=<?php echo $page + 1; ?>" class="anchor_href"></a>
    ?>
 <?php $i++; ?>
    <?php endforeach; ?>
    <?php else : ?>
    <div id="no-category" class="col-xs-12 margin-top-20 col-left">
        No Data
    </div>
    <?php endif; ?>
</div>
 */ ?>

