<?php if(count($product['tag']) > 0): ?>
<div class="you_may_like">
    <div class="header_text">
        <h3><?php echo __('My favorite');?></h3>
    </div>
    <div class="product_wraper">

        <div class="bx-controller shadow-left">
            <div id="s_back" class="bx-btn btn_next">
            </div>
        </div>

        <div class="product_display">
            <div id="r_ajax" class="ajx_loader" style="display: none; text-align: center; height: 300px;">
                <img src="http://www.itruemart.com/assets/itruemart_new/global/images/bx_loader.gif">
            </div>
            <div class="product_container">
                <div id="similar_product" class="product_select_display">
                    <div class="container-selected">
                        <?php foreach($recommendProduct['products'] as $num => $product) { ?>
                            <?php if ($num % 4 == 0 && $num > 0) { ?>
                            </div>
                            <div class="container-selected">
                            <?php } ?>
                            <?php
                                $hasImgThumb = ( !empty($product['image_cover']['thumbnails']['square']) );
                                $notfountThumb = Theme::asset()->usePath()->url('images/product/image-not-found-105.jpg');
                                $imgCoverThumbSquare = ($hasImgThumb) ? $product['image_cover']['thumbnails']['square'] : $notfountThumb ;

                                $productInfoName = '';
                                if (App::getLocale() == 'th')
                                {
                                    $productInfoName = array_get($product,'title');
                                }
                                else
                                {
                                    if(array_get($product,'translate')!=null)
                                    {
                                        $productInfoName = array_get($product,'translate.title');
                                    }
                                    else
                                    {
                                        $productInfoName = array_get($product,'title');
                                    }
                                }

                                $priceInfo = '';
                                if ($product['special_price_range']['max'] || $product['special_price_range']['min'])
                                {
                                    $priceInfo .= '<span>';
                                    if ($product['net_price_range']['max'] == $product['net_price_range']['min'])
                                    {
                                        $priceInfo .= price_format($product['net_price_range']['max']) . " .-";
                                    }
                                    else
                                    {
                                        $priceInfo .= price_format($product['net_price_range']['min']) . ' - ' . price_format($product['net_price_range']['max']) . ' ';
                                    }
                                    $priceInfo .= '</span><br>';

                                    $priceInfo .= '<span>';
                                    if ($product['price_range']['max'] == $product['price_range']['min'])
                                    {
                                        $priceInfo .= price_format($product['price_range']['max']) . ".-";
                                    }
                                    else
                                    {
                                        $priceInfo .= price_format($product['price_range']['min']) . ' - ' . price_format( $product['price_range']['max']) . ' ';
                                    }
                                    $priceInfo .= '</span>';
                                }
                                else
                                {
                                    if ($product['price_range']['max'] == $product['price_range']['min'])
                                    {
                                        $priceInfo = '<b>' . price_format($product['price_range']['max']) . '</b>';
                                    }
                                    else
                                    {
                                        $priceInfo = '<b>' . price_format($product['price_range']['min']) . ' - ' . price_format($product['price_range']['max']) . ' </b>';
                                    }
                                }
                            ?>
                            <div class="product_info_detail">
                                <div class="product_img">
                                    <a href="<?php echo get_permalink('products', $product) ?>" title="<?php echo $product['title'] ?>">
                                        <img src="<?php echo $imgCoverThumbSquare ?>" alt="<?php echo $product['title'] ?>" width="100" height="100">
                                        <?php if ( !empty($product['percent_discount']) ) { ?>
                                            <div class="discount_tag3"></div>
                                            <div class="hilightdiscounttext">
                                                <span class="discountfont"><span class="text-percent">%</span><br><?php echo floor(array_get($product,'percent_discount.max')); ?></span>
                                            </div>
                                        <?php } ?>
                                    </a>
                                </div>
                                <div class="product_info">
                                    <a href="<?php echo get_permalink('products', $product) ?>" title="<?php echo $product['title'] ?>">
                                        <div class="product_info_name"><?php echo $productInfoName ?></div>
                                    </a>
                                    <div class="product_info_price"><?php echo $priceInfo ?></div>
                                    <div class="product_shop">
                                        <a href="<?php echo get_permalink('products', $product) ?>" title="<?php echo $product['title'] ?>">
                                            <img src="<?php echo Theme::asset()->url('images/detail.jpg');?>">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="bx-controller shadow-right">
            <div id="s_next" class="bx-btn btn_prev" style="cursor: pointer;">
            </div>
        </div>
    </div>
</div>
<?php endif; ?>