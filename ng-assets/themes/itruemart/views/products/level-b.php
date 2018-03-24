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
        <div class="content"><?php /*

        */?><div class="brand_banner">

                <!-- Previous -->
                <div class="prev_lvb" style="display: none;">
                    <a href="<?php echo $pkeyPrev; ?>.html">
                        <img src="http://www.itruemart.com/assets/itruemart_new/global/images/level_b/levelB_container_01.jpg" width="20" height="290" alt="">
                    </a>
                </div>

                <?php 
                    if(Lang::getLocale() != 'th' && isset($brandDetail['translate']['description'])){
                        $productsBrandStoryDesc = $brandDetail['translate']['description'];
                    }else{
                        $productsBrandStoryDesc = $brandDetail['description'];
                    }
                ?>
                <?php echo Theme::widget('productsBrandStory', array('description' => $productsBrandStoryDesc, 'metas'=>$brandDetail['metas']))->render(); ?>


                <!-- Next -->
                <div class="next_lvb" style="display: none;">
                    <a href="<?php echo $pkeyNext; ?>.html">
                        <img src="http://www.itruemart.com/assets/itruemart_new/global/images/level_b/levelB_container_01_2.jpg" width="20" height="290" alt="">
                    </a>
                </div>

            </div>

        </div>
        <div class="left_menu_lvb">
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
            <div class="by_price"><?php echo __('Price'); ?></div>
            <div class="by_price_list"><a href="<?php echo $urlPriceRange1 ?>" title="under - ₱200"><?php echo __('under'); ?> - ₱200 <span class="font8"></span></a></div>
            <div class="by_price_list"><a href="<?php echo $urlPriceRange2 ?>" title="₱200 - ₱500">₱200 - ₱500 <span class="font8"></span></a></div>
            <div class="by_price_list"><a href="<?php echo $urlPriceRange3 ?>" title="₱500 - ₱1,000">₱500 - ₱1,000  <span class="font8"></span></a></div>
            <div class="by_price_list"><a href="<?php echo $urlPriceRange4 ?>" title="₱1,000 - ₱2,000">₱1,000 - ₱2,000 <span class="font8"></span></a></div>
            <div class="by_price_list"><a href="<?php echo $urlPriceRange5 ?>" title="₱2,000 - ₱3,000">₱2,000 - ₱3,000  <span class="font8"></span></a></div>
            <div class="by_price_list"><a href="<?php echo $urlPriceRange6 ?>" title="₱3,000 and Over">₱3,000 <?php echo __('over'); ?> <span class="font8"></span></a></div>
            <div class="line_lvb2"></div>

            <!-- Brand -->
            <?php if (!empty($brandLists)) { ?>
                <div class="by_brand"><?php echo __("brands");?></div>
                <div class="search_input_box"><input id="key_brand" name="key_brand" class="search_input"></div><div class="search_button_box"><img class="btn_key_brand" src="http://www.itruemart.com/assets/itruemart_new/global/images/level_b/search_button.jpg" alt="search"></div>
                <div class="space"></div>
                <div class="brandlist">
                    <div>
                        <div class="brandlist_options">
                            <ul class="list">
                                <?php foreach ($brandLists as $brand) : ?>
                                <li>
                                    <a href="<?php echo route('brands.products', $brand['pkey']) ?>" title="<?php echo $brand['name'] ?>" class="name"><?php echo $brand['name'] ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>


            <div class="space"></div>
            <div class="space"></div>
            <h3 style="clear:both;"><?php echo __('Promotion'); ?></h3>
            <div class="line_lvb"></div>
            <!-- <a href="http://www.itruemart.com/brand/fcuk-watch-988.html" title="FCUK-121213" target="_blank">
                <img src="http://cdn.itruemart.com/files/banner/11/583.jpg" width="246" height="246" alt="FCUK-121213">
            </a> -->

            <?php /* Banner promotion */ ?>
            <?php echo Theme::widget('bannerPromotion', array('position' => 6, 'width' => '246', 'height' => '246'))->render(); ?>

            <?php if (! empty($collectionDetail['essay'])): ?>
            <div class="seo-box-left">
                 <?php if ($type != 'search'): ?>
                 <p><?php echo $collectionDetail['essay'] ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div>

        <?php if (!empty($bestSeller)) { ?>
            <div class="base_seller_head">
              <h2><?php echo __('สินค้าขายดี'); echo " : "; echo __($brandDetail['name']); ?></h2>
            </div>
        <?php } ?>

        <?php if (!empty($bestSeller)) { ?>
            <?php echo Theme::widget('productsBestSeller', array('bestSeller' => $bestSeller))->render(); ?>
        <?php } ?>

        <div class="base_seller_head">
             <h2>
                <?php
                    if(App::getLocale()=="th")
                    {
                        echo $brandDetail['name'];
                    }
                    else
                    {
                        if(!empty($brandDetail['translate']))
                        {
                            echo $brandDetail['translate']['name'];
                        }
                        else
                        {
                        echo $brandDetail['name'];
                        }
                    }
                ?>
            </h2>
        </div>

        <?php echo Theme::widget('productsList', array('data' => $data))->render(); ?>

    </div>
</div>
</div>