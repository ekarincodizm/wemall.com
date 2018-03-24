
<?php foreach ($showroom as $item): ?>
<div class="home__showroom_container layout_<?php echo $item['layout_id']; ?>"
     data-id="<?php echo $item['layout_id']; ?>"
     id="<?php echo $item['showroom_id']; ?>">

    <?php // render banner ?>
    <?php if ( ! empty($item['banner'])): ?>
        <a class="showroom_banner" href="<?php echo array_get($item, 'banner.link'); ?>"><img src="<?php echo array_get($item, 'banner.thumbnail.desktop'); ?>"/></a>
    <?php endif; ?>

    <?php // render brand ?>
    <?php if ( ! empty($item['brand'])): ?>
        <ul class="showroom_brand">
            <?php foreach ($item['brand'] as $brand): ?>
                <li class="brand_item">
                    <a class="brand_link"
                       href="<?php echo array_get($brand, 'link'); ?>"
                       id="<?php echo array_get($brand, 'id'); ?>">
                        <img src="<?php echo array_get($brand, 'thumbnail'); ?>" alt="<?php echo array_get($brand, 'name'); ?>" />
                    </a>
                </li>
            <?php endforeach; ?>
            <!-- li class="brand_item"><a href="<?php echo URL::toLang("shopbybrand"); ?>" class="brand_link"><span class="brand_more">...</span></a></li -->
        </ul>
    <?php endif; ?>

    <?php // render showroom ?>
    <div class="showroom_wrapper">
        <div class="showroom_header">
            <div class="showroom_name">
                <h2 class="page_main_h2_subject"><?php echo array_get($item, 'showroom_title'); ?></h2>
                <b><a href="<?php echo array_get($item, 'showroom_link'); ?>"><?php echo array_get($item, 'showroom_title'); ?></a></b>
            </div>
        </div>
        <div class="showroom_content">

            <?php // render product ?>
            <?php foreach ($item['product'] as $product): ?>
                <div class="box_<?php echo array_get($product, 'box'); ?> box_<?php echo array_get($product, 'type'); ?>"
                     data-position="<?php echo array_get($product, 'position'); ?>"
                     id="<?php echo array_get($product, 'id'); ?>">

                    <?php if ($product['type']=='banner'): ?>
                        <a href="<?php echo array_get($product, 'link'); ?>">
                            <img src="<?php echo array_get($product, 'thumbnail.desktop'); ?>"
                                 data-original="<?php echo array_get($product, 'thumbnail.desktop'); ?>" alt="" class="lazyload">
                        </a>

                    <?php elseif($product['type']=='product'): ?>
                        <a href="<?php echo array_get($product, 'link'); ?>">
                            <?php if (array_filter(array_get($product, 'price.discount'))): ?>
                                <span class="price_tag">
                                    <span class="price_no">
                                        <?php if ( array_get($product, 'price.discount.min') == array_get($product, 'price.discount.max') ): ?>
                                        <?php echo floor(array_get($product, 'price.discount.min')); ?>
                                        <?php else :?>
                                            <span class="price_text"><?php _e('up_to'); ?></span>
                                            <?php echo floor(array_get($product, 'price.discount.max')); ?>
                                        <?php endif; ?>
                                    </span>
                                    <sup>%</sup>
                                    <sub>OFF</sub>
                                </span>
                            <?php endif; ?>

                            <span class="product_thumbnail">
                                <img src="<?php echo array_get($product, 'thumbnail.desktop'); ?>"
                                     data-original="<?php echo array_get($product, 'thumbnail.desktop'); ?>"
                                     class="lazyload" alt="<?php echo array_get($product, 'title'); ?>">
                            </span>

                            <span class="product_name"><?php echo array_get($product, 'title'); ?></span>

                            <span class="product_price">
                                <?php if (array_filter(array_get($product, 'price.special'))): ?>
                                    <span class="price_discount">
                                        <?php echo price_format(array_get($product, 'price.special.min')); ?></span>
                                    <span class="price_normal discount">
                                        <?php echo price_format(array_get($product, 'price.net.min')); ?></span>
                                <?php else: ?>
                                    <span class="price_normal">
                                        <?php if ( array_get($product, 'price.normal.min') != array_get($product, 'price.normal.max') ): ?>
                                            <?php _e('start'); ?>
                                            <?php echo price_format(array_get($product, 'price.normal.min')); ?>
                                        <?php else: ?>
                                            <?php echo price_format(array_get($product, 'price.normal.min')); ?>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                            </span>
                        </a>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

        </div>
    </div>

</div>
<?php endforeach; ?>

<?php if ($display_next_page): ?>
<div class="next-showroom-container">
    <a href="<?php echo $next_page; ?>" id="next-showroom-btn"
       data-limit="<?php echo $limit; ?>"
       data-total-page="<?php echo $total_page; ?>"
       data-page="<?php echo $page; ?>"></a>
</div>
<?php endif; ?>
