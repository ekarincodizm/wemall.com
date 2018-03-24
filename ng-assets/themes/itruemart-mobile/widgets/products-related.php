<?php if(count($relatedProduct['products']) > 0): ?>
<div class="related_product">
    <div class="header_text">
        <h3><?php echo __('Related items');?></h3>
    </div>
    <div class="product_wraper">

        <div class="bx-controller shadow-left">
            <div id="r_back" class="bx-btn btn_next">
            </div>
        </div>

        <div class="product_display">
            <div id="r_ajax" class="ajx_loader" style="display: none; text-align: center; height: 300px;">
                <img src="http://www.itruemart.com/assets/itruemart_new/global/images/bx_loader.gif">
            </div>
            <div class="product_container">
                <div id="related_product" class="product_select_display">
                    <div class="container-selected">

                        <?php foreach($relatedProduct['products'] as $num => $product) : ?>
                        <?php
                            if ( !empty($product['image_cover']['thumbnails']['square']) )
                            {
                                $imgCoverThumbSquare = $product['image_cover']['thumbnails']['square'];
                            }
                            else
                            {
                                $imgCoverThumbSquare = Theme::asset()->usePath()->url('images/product/image-not-found-105.jpg');
                            }
                        ?>
                        <div class="product_info_detail">
                            <div class="product_img">
                                <a href="<?php echo get_permalink('products', $product) ?>" title="<?php echo $product['title'] ?>">
                                    <img src="<?php echo $imgCoverThumbSquare ?>" alt="<?php echo $product['title'] ?>" width="100" height="100">

                                    <?php if(!empty($product['percent_discount'])) : ?>
                                    <div class="discount_tag3"></div>
                                    <div class="hilightdiscounttext">
                                        <span class="discountfont"><span class="text-percent">%</span><br><?php echo floor(array_get($product,'percent_discount.max')); ?></span>
                                    </div>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="product_info">
                                <a href="<?php echo get_permalink('products', $product) ?>" title="<?php echo $product['title'];?>">
                                <div class="product_info_name">
                                    <?php
                                        if(App::getLocale()=='th')
                                        {
                                            echo array_get($product,'title');
                                        }
                                        else
                                        {
                                            if(array_get($product,'translate')!=null)
                                            {
                                                echo array_get($product,'translate.title');
                                            }
                                            else
                                            {
                                                echo array_get($product,'title');
                                            }
                                        }
                                    ?>
                                </div>
                                    <div class="product_info_price">
                                        <?php
                                        if ($product['special_price_range']['max'] || $product['special_price_range']['min'])
                                        {
                                        ?>
                                            <span>
                                             <?php
                                            if ($product['net_price_range']['max'] == $product['net_price_range']['min'])
                                            {
                                                echo  price_format( $product['net_price_range']['max']); echo ".-";
                                            }
                                            else
                                            {
                                                echo  price_format( $product['net_price_range']['min']), ' - ', price_format( $product['net_price_range']['max']), '';
                                            }
                                            ?>
                                            </span><br>
                                            <span>
                                            <?php
                                            if ($product['price_range']['max'] == $product['price_range']['min'])
                                            {
                                                echo  price_format( $product['price_range']['max']);echo ".-";
                                            }
                                            else
                                            {
                                                echo  price_format( $product['price_range']['min']), ' - ',  price_format( $product['price_range']['max']), '';
                                            }
                                            ?>
                                            </span>
                                                <?php
                                                }
                                                else
                                                {
                                            ?>
                                            <b>
                                           <?php
                                            if ($product['price_range']['max'] == $product['price_range']['min'])
                                            {
                                                echo  price_format( $product['price_range']['max']);echo ".-";
                                            }
                                            else
                                            {
                                                echo price_format( $product['price_range']['min']), ' - ', price_format( $product['price_range']['max']), '';
                                            }
                                            ?>
                                            </b>
                                          <?php
                                            }
                                         ?>
                                    </div>
                                </a>
                                <div class="product_shop">
                                    <a href="<?php echo get_permalink('products', $product) ?>" title="<?php echo $product['title'];?>">
                                        <img src="http://www.itruemart.com/assets/itruemart_new/global/images/level_d/detail.jpg">
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php if(($num/4)==0):?>
                    </div>
                    <div class="container-selected">
                    <?php endif; ?>

                        <div class="product_info_detail">
                            <div class="product_img">
                                <a href="<?php echo get_permalink('products', $product) ?>" title="<?php echo $product['title'] ?>">
                                    <img src="<?php echo $imgCoverThumbSquare ?>" alt="<?php echo $product['title'] ?>" width="100" height="100">

                                    <?php if(!empty($product['percent_discount'])) : ?>
                                    <div class="discount_tag3"></div>
                                    <div class="hilightdiscounttext">
                                        <span class="discountfont"><span class="text-percent">%</span><br><?php echo floor(array_get($product,'percent_discount.max')); ?></span>
                                    </div>
                                    <?php endif; ?>

                                </a>
                            </div>
                            <div class="product_info">
                                <a href="<?php echo get_permalink('products', $product) ?>" title="<?php echo $product['title'];?>">
                                <div class="product_info_name">
                                    <?php echo $product['title']; ?>
                                </div>
                                    <div class="product_info_price">
                                        <?php
                                        if ($product['special_price_range']['max'] || $product['special_price_range']['min'])
                                        {
                                        ?>
                                            <span>
                                             <?php
                                            if ($product['net_price_range']['max'] == $product['net_price_range']['min'])
                                            {
                                                echo price_format( $product['net_price_range']['max']);echo ".-";
                                            }
                                            else
                                            {
                                                echo price_format( $product['net_price_range']['min']), ' - ', price_format( $product['net_price_range']['max']), '';
                                            }
                                            ?>
                                            </span><br>
                                            <span>
                                            <?php
                                            if ($product['price_range']['max'] == $product['price_range']['min'])
                                            {
                                                echo price_format( $product['price_range']['max']);echo ".-";
                                            }
                                            else
                                            {
                                                echo price_format( $product['price_range']['min']), ' - ', price_format( $product['net_price_range']['max']), '';
                                            }
                                            ?>
                                            </span>
                                                <?php
                                                }
                                                else
                                                {
                                            ?>
                                            <b>
                                           <?php
                                            if ($product['price_range']['max'] == $product['price_range']['min'])
                                            {
                                                 echo price_format( $product['price_range']['max']);echo ".-";
                                            }
                                            else
                                            {
                                                echo price_format( $product['price_range']['min']), ' - ', price_format( $product['price_range']['max']), '';
                                            }
                                            ?>
                                            </b>
                                          <?php
                                            }
                                         ?>
                                    </div>
                                </a>
                                <div class="product_shop">
                                    <a href="<?php echo get_permalink('products', $product) ?>" title="<?php echo $product['title'];?>">
                                        <img src="http://www.itruemart.com/assets/itruemart_new/global/images/level_d/detail.jpg">
                                    </a>
                                </div>

                            </div>
                        </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="bx-controller shadow-right">
            <div id="r_next" class="bx-btn btn_prev" style="cursor: pointer;">
            </div>
        </div>
    </div>
</div>
<?php endif; ?>