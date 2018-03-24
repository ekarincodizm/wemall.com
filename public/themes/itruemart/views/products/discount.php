<div class="content-home sub">
    <div class="breadcrumbs">
        <div id="link_map">

            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                <?php echo HTML::link('', __('Shopping On-line'), array('class'=>'map', 'itemprop'=>'url', 'title'=>__('Shopping On-line'))); ?>
            </span> <!-- &gt; <a class="map">แฟชั่นผู้ชาย</a> -->

            <?php echo Theme::breadcrumb()->render(); ?>
        </div>
    </div>
    <div id="wrapper_content">
        <div class="content">
            <div class="left_menu_lvb">

                <!-- Brand Menu List -->
                <?php if (!empty($collections)) { ?>
                    <div id="menu">
                        <?php echo Theme::widget('categoryMenu', array('collections' => $collections, 'currentPkey' => $currentPkey))->render(); ?>
                    </div>
                <?php } ?>

                <!-- [S] FILTER SHOP BY -->
                <h3><?php echo __('shop-by-title'); ?></h3>
                <div class="line_lvb"></div>
                <div class="space"></div>
                <h4><?php echo __('shopping-option-title'); ?></h4>
                <div class="space"></div>

                <!-- Price -->
                <?php echo Theme::widget('priceFilter', array())->render(); ?>

                <!-- Brand -->
                <?php if (!empty($brandLists)) { ?>
                    <?php echo Theme::widget('brandFilter', array('brands' => $brandLists))->render(); ?>
                <?php } ?>

                <div class="space"></div>
                <div class="space"></div>
                <h3 style="clear:both;"><?php echo __('Promotion'); ?></h3>
                <div class="line_lvb"></div>
                <?php echo Theme::widget('bannerPromotion', array('position' => 8, 'width' => '246', 'height' => '246'))->render(); ?>
<!--                <a href="http://www.itruemart.com/brand/fcuk-watch-988.html" title="FCUK-121213" target="_blank">
                    <img src="http://cdn.itruemart.com/files/banner/11/583.jpg" width="246" height="246" alt="FCUK-121213">
                </a>-->
                <?php if (! empty($collectionDetail['essay'])): ?>
                <div class="seo-box-left">
                     <?php if ($type != 'search'): ?>
                     <p><?php echo $collectionDetail['essay'] ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <?php if ($type != 'search'): ?>
                <?php // echo Theme::widget('productsBanner', array('metas' => $collectionDetail['metas']))->render(); ?>

                <?php if (!empty($bestSeller)) { ?>
                    <div class="base_seller_head">
                      <h2><?php if (!empty($bestSeller)) { echo __('สินค้าขายดี'); echo " : "; } ?><?php echo __('สินค้าลดราคา'); ?></h2>
                    </div>
                <?php } ?>

                <?php if (!empty($bestSeller)) { ?>
                    <?php echo Theme::widget('productsBestSeller', array('bestSeller' => $bestSeller,'collectionDetail' => $collectionDetail))->render(); ?>
                <?php } ?>

                <?php /* =============== Discount By Brand =============== */ ?>
                <?php if (!empty($brandLists)) { ?>
                    <div class="base_seller_head">
                        <h3><?php echo __('DISCOUNT BY BRAND') ?></h3>
                    </div>
                    <?php echo Theme::widget('discountByBrands', array('brands' => $brandLists))->render(); ?>
                <?php } ?>
                <?php /* =============== Discount By Brand =============== */ ?>

                <div class="base_seller_head">
                    <h2><?php echo __('discount_products'); ?></h2>
                </div>

            <?php endif; ?>
            <!-- typeidea script -->
            <?php $data['collection_name'] = 'discount-products'; echo Theme::widget('productsList', array('data' => $data))->render(); ?>
            <!-- /typeidea script -->
        </div>
    </div>
</div>
