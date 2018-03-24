<div class="content-home sub">
    <div class="breadcrumbs">
        <div id="link_map">
            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                <?php
                    $url = URL::current();
                    $section = parse_url($url);
                ?>
                <?php echo HTML::link('', __('Shopping On-line'), array('class'=>'map','itemprop'=>'url','title'=>'Shopping Online')); ?>

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

                <?php
                    // First, We'll get all params
                    $qstrArr = Input::all();

                    // Set params for $urlPriceRange1
                    if (isset($qstrArr['priceMin']))
                    {
                        unset($qstrArr['priceMin']);
                    }
                    if (isset($qstrArr['page']))
                    {
                        unset($qstrArr['page']);
                    }
                    $qstrArr['priceMax'] = 200;
                    $urlPriceRange1 = URL::current() . '?' . http_build_query($qstrArr);

                    // Set params for $urlPriceRange2
                    $qstrArr['priceMin'] = 200;
                    $qstrArr['priceMax'] = 500;
                    $urlPriceRange2 = URL::current() . '?' . http_build_query($qstrArr);

                    // Set params for $urlPriceRange3
                    $qstrArr['priceMin'] = 500;
                    $qstrArr['priceMax'] = 1000;
                    $urlPriceRange3 = URL::current() . '?' . http_build_query($qstrArr);

                    // Set params for $urlPriceRange4
                    $qstrArr['priceMin'] = 1000;
                    $qstrArr['priceMax'] = 2000;
                    $urlPriceRange4 = URL::current() . '?' . http_build_query($qstrArr);

                    // Set params for $urlPriceRange5
                    $qstrArr['priceMin'] = 2000;
                    $qstrArr['priceMax'] = 3000;
                    $urlPriceRange5 = URL::current() . '?' . http_build_query($qstrArr);

                    // Set params for $urlPriceRange6
                    $qstrArr['priceMin'] = 3000;
                    if (isset($qstrArr['priceMax']))
                    {
                        unset($qstrArr['priceMax']);
                    }
                    $urlPriceRange6 = URL::current() . '?' . http_build_query($qstrArr);
                ?>

                <!-- Price -->
                <?php echo Theme::widget('priceFilter', array())->render(); ?>

                <!-- Brand -->
                <?php if (!empty($brandLists)) { ?>
                    <?php echo Theme::widget('brandFilter', array('brands' => $brandLists))->render(); ?>
                <?php } ?>

                <div class="space"></div>
                <div class="space"></div>
                <h3 style="clear:both;">โปรโมชั่น</h3>
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
                      <h2><?php if (!empty($bestSeller)) { echo __('สินค้าขายดี'); echo " : "; } ?><?php echo __('Flash Sale'); ?></h2>
                    </div>
                <?php } ?>

                <?php if (!empty($bestSeller)) { ?>
                    <?php echo Theme::widget('productsBestSeller', array('bestSeller' => $bestSeller,'collectionDetail' => $collectionDetail))->render(); ?>
                <?php } ?>

                <div class="brand_banner_img">
                    <!-- Flashsale Banner -->
                    <img src="<?php echo Theme::asset()->url('images/banner/flashsale-banner.jpg'); ?>" alt="BeyerDynamic" style="width:935px;" width="935" height="290">
                </div>

                <?php /* =============== Flashsale By Brand =============== */ ?>
                <?php if (!empty($brandLists)) { ?>
                    <div class="base_seller_head">
                        <h3><?php echo __('FLASH SALE BY BRAND') ?></h3>
                    </div>
                    <?php echo Theme::widget('discountByBrands', array('brands' => $brandLists))->render(); ?>
                <?php } ?>
                <?php /* =============== Flashsale By Brand =============== */ ?>

                <div class="base_seller_head">
                    <h2><?php echo __('Flash Sale'); ?></h2>
                </div>

            <?php endif; ?>

            <?php echo Theme::widget('productsList', array('data' => $data))->render(); ?>

        </div>
    </div>
</div>