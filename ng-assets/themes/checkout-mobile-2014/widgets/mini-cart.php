<div class="row">
    <div class="col-xs-12 summary-section" id="minicart-container">
        <h2><?php echo __("cart-summary"); ?></h2>

        <?php if ( !empty($checkout['items_count']) && intval($checkout['items_count']) > 0 ): ?>
            <?php
                $show_group = false;
                if(count($checkout['shipments']) > 1)
                {
                    $show_group = true;
                }
                $vendor_count = 1;
            ?>
            <?php foreach ( $checkout['shipments'] as $key => $shipment ): ?>
                <h3><?php echo __("cart-shops-product-lbl"); ?> :
                    <?php echo __('replace-shop-name');//$shipment['shop_name']; ?>
                    <?php if($show_group == true):?>
                        (<?php echo __('replace-vendor-name').' '.$vendor_count;$vendor_count++; //echo $shipment['vendor_name'] ?>)
                    <?php endif;?>
                    (<?php echo $shipment['items_count']; ?> <?php echo __("cart-item-unit"); ?>)
                </h3>

                <!-- [S] Product list per shop -->
                <?php foreach ( $shipment['items'] as $key => $item ): ?>
                    <div class="row item-list">
                        <div class="col-xs-4"><img src="<?php echo !empty($item['thumbnail']) ? $item['thumbnail'] : Theme::asset()->usePath()->url("img/image-not-found-105.jpg"); ?>"></div>
                        <div class="col-xs-8">
                            <h4><?php echo (!empty($item['name'])) ? $item['name'] : ""; ?></h4>
                            <span class="price"><?php echo number_format($item['price']*$item['quantity'], 2); ?>.-</span><span class="quantity">(<?php echo $item['quantity']; ?> <?php echo __("cart-product-unit"); ?>)</span>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- [E] Product list per shop -->
            <?php endforeach; ?>
        <?php else: ?>
            <div class='cart-title' style='text-align: center;color:red;'><php echo __('cart-no-item') %></div>
        <?php endif; ?>
        <div class="row">
            <div class="col-xs-12"><a href="<?php echo URL::toLang("cart"); ?>" class="blue-link"><?php echo __("cart-edit-btn"); ?></a></div>
        </div>
    </div>
</div>
<div class="row summary-text" id="minicart-sum-container">
    <!-- coupon | use js for detect button enable/disable at checkout-step3.js -->
    <?php if ( $showCoupon === true ): ?>
        <?php if ( ! empty($checkout['promotions'])) : ?>
            <div id="coupon-list">
            </div>
        <?php endif; ?>

        <div class="col-xs-12 coupon-box disable">
            <form action="<?php echo Url::toLang('checkout/apply-coupon', array(), $open_https); ?>" id='coupon-form' method='get' target='_top' autocomplete="off">
                <input id='coupon-text' name='coupon' class="form-control" placeholder='<?php echo __("cart-coupon-placeholder"); ?>' type='text'/>
                <button id='coupon-button'><?php echo __("cart-use-coupon-btn"); ?></button>

                <?php if ( $errors->first('message') ): ?>
                <div id="coupon_code_error" style="display: block;">
                        <?php echo $errors->first('message'); ?>
                </div>
                <?php endif; ?>


            </form>
        </div>
    <?php endif; ?>
    <div class="col-xs-7">
        <p><?php echo __("cart-cost-lbl"); ?></p>
        <p><?php echo __("cart-total-delivery-fare"); ?></p>
        <?php if ( $showDiscount === true ): ?>
            <p><?php echo __("cart-discount-lbl"); ?></p>
        <?php endif; ?>
    </div>
    <div class="col-xs-5 text-right">
        <div =id"total_price"><p><?php echo (!empty($checkout['total_price'])) ? number_format($checkout['total_price'], 2) : number_format(0, 2); ?></p></div>
        <div =id="total_shipping_fee"><p><?php
            if ( isset($checkout['total_shipping_fee']) && $checkout['total_shipping_fee'] == 0 )
            {
                echo __("cart-free-lbl");
            }
            elseif ( isset($checkout['total_shipping_fee']) )
            {
                echo number_format($checkout['total_shipping_fee'], 2);
            }
            else
            {
                echo number_format(0, 2);
            }
        ?></p></div>
        <?php if ( $showDiscount === true ): ?>
            <div id="total_discount"><p><?php echo!empty($checkout['total_discount']) ? number_format(-$checkout['total_discount'], 2) : number_format(0, 2); ?></p></div>
        <?php endif; ?>
    </div>
    <div class="col-xs-7">
        <h3><?php echo __("cart-total-price-lbl"); ?></h3>
    </div>
    <div class="col-xs-5 text-right">
        <div id="sub_total"><h3><?php echo (!empty($checkout['sub_total'])) ? number_format($checkout['sub_total'], 2) : number_format(0, 2); ?></h3></div>
    </div>
    <div class="col-xs-12 text-right">
        <span>(<?php echo __("cart-vat-included"); ?>)</span>
    </div>
</div>