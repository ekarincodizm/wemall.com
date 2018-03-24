<div class="content-home sub">
    <div class="breadcrumbs">
        <div id="link_map">
            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                <a class="map" itemprop="url" href="http://www.itruemart.com/" title="<?php echo __('Shopping On-line'); ?>">
                    <span itemprop="title"><?php echo __('Shopping On-line'); ?></span>
                </a>
            </span>
            <?php echo Theme::breadcrumb()->render(); ?>
        </div>
    </div>
    <div id="wrapper_content">
        <div class="content">
            <div class="brand_banner">
                <!-- Previous -->
                <div class="prev_lvb" style="display: none;">
                    <a href="#">
                        <img src="http://www.itruemart.com/assets/itruemart_new/global/images/level_b/levelB_container_01.jpg" width="20" height="290" alt="">
                    </a>
                </div>

                <?php echo Theme::widget('productsBrandStory', array('description' => $brandDetail['description'], 'metas'=>$brandDetail['metas']))->render(); ?>

                <!-- Next -->
                <div class="next_lvb" style="display: none;">
                    <a href="#">
                        <img src="http://www.itruemart.com/assets/itruemart_new/global/images/level_b/levelB_container_01_2.jpg" width="20" height="290" alt="">
                    </a>
                </div>
            </div>
        </div>
        <div class="left_menu_lvb">
            <!-- [S] FILTER SHOP BY -->
            <h3><?php echo __('เลือกซื้อโดย'); ?></h3>
            <div class="line_lvb"></div>
            <div class="space"></div>
            <h4>ตัวเลือกการซื้อ</h4>
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
            <div class="by_price_list"><a href="<?php echo $urlPriceRange1 ?>" title="under - ₱200">ต่ำกว่า - ₱200 <span class="font8"></span></a></div>
            <div class="by_price_list"><a href="<?php echo $urlPriceRange2 ?>" title="₱200 - ₱500">₱200 - ₱500 <span class="font8"></span></a></div>
            <div class="by_price_list"><a href="<?php echo $urlPriceRange3 ?>" title="₱500 - ₱1,000">₱500 - ₱1,000  <span class="font8"></span></a></div>
            <div class="by_price_list"><a href="<?php echo $urlPriceRange4 ?>" title="₱1,000 - ₱2,000">₱1,000 - ₱2,000 <span class="font8"></span></a></div>
            <div class="by_price_list"><a href="<?php echo $urlPriceRange5 ?>" title="₱2,000 - ₱3,000">₱2,000 - ₱3,000  <span class="font8"></span></a></div>
            <div class="by_price_list"><a href="<?php echo $urlPriceRange6 ?>" title="₱3,000 and Over">₱3,000 ขึ้นไป <span class="font8"></span></a></div>
            <div class="line_lvb2"></div>

            <!-- Brand -->
            <?php if (!empty($brandLists)) { ?>
                <div class="by_brand"><?php echo __("brands");?></div>
                <div class="search_input_box"><input id="key_brand" name="key_brand" class="search_input"></div><div class="search_button_box"><img class="btn_key_brand" src="http://www.itruemart.com/assets/itruemart_new/global/images/level_b/search_button.jpg" alt="search"></div>
                <div class="space"></div>
                <div class="brandlist">
                    <div>
                        <div class="brandlist_options">
                            <ul>
                                <?php foreach ($brandLists as $brand) : ?>
                                <li>
                                    <a href="<?php echo route('brands.products', $brand['pkey']) ?>" title="<?php echo $brand['name'] ?>"><?php echo $brand['name'] ?></a>
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
            <a href="http://www.itruemart.com/brand/fcuk-watch-988.html" title="FCUK-121213" target="_blank">
                <img src="http://cdn.itruemart.com/files/banner/11/583.jpg" width="246" height="246" alt="FCUK-121213">
            </a>
            <?php
                /*
                <div class="seo-box-left">
                    <p>ศูนย์รวมแฟชั่นผู้ชายที่อัดแน่นไปด้วยแบรนด์คุณภาพ เพิ่มลุคให้ดูดีแบบมีสไตล์ ในหลากหลายโอกาส ไม่ว่าจะเป็นสูท เสื้อโปโล เสื้อกล้าม เสื้อเชิ๊ตเสื้อยืดชุดลำลอง&nbsp;กางเกงยีนส์&nbsp;กระเป๋า รองเท้า เครื่องประดับ คุณภาพดี ดีไซน์สวย เป็นสินค้าเกรดพรีเมี่ยม อาทิ Esprit watch,&nbsp;<a href="http://www.itruemart.com/brand/giorgio-armani-844.html">GIORGIO&nbsp;ARMANI</a>, LEVI'S, Pierre Cardin, Toy Watch พาเรดมาให้คุณเลือกช้อปให้เหมาะกับสไตล์คุณได้ที่&nbsp; iTrueMart&nbsp; ได้ทุกที่ ทุกเวลา กับ 3 ขั้นตอนง่ายๆ เพียงเลือกสินค้าที่คุณต้องการ ระบุชื่อ ที่อยู่ และเลือกวิธีการจัดส่งสินค้า เลือกช่องทางการชำระเงิน เรายังมีระบบผ่อน 0% กับธนาคารกสิกรไทย และที่สะดวกไปกว่านั้นเรามีบริการ<strong>เก็บเงินปลายทาง</strong> (Cash On Delivery) คุณสามารถ<strong>จ่ายเงินเมื่อได้รับสินค้า</strong>ได้ทันที เพียงเท่านี้สินค้าที่คุณต้องการจะส่งถึงมือคุณนอกจากนี้ คุณยังสามารถติดตามข้อมูลข่าวสารของ iTrueMart ได้ทาง&nbsp; Blog Facebook instagramหากมีข้อสงสัยเกี่ยวกับสินค้าและบริการ หรือต้องการสอบถามข้อมูลเพิ่มเติม ติดต่อได้ที่ Customer Service โทร 02-900-9999 เรายินดีให้บริการลูกค้าทุกท่านด้วยความเต็มใจเป็นอย่างยิ่ง</p>
                </div>
                */
            ?>
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