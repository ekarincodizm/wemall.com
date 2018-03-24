<?php
//if ( App::environment('production') || App::environment("beta") )
//{
//    // The environment is production
//    $open_https = true;
//}
//else
//{
//    $open_https = false;
//}
$open_https = Config::get("https.useHttps");
?>
<div class="title">
    <div class="left">
        <h1 class="title-order"><?php echo __("cart-summary"); ?></h1>
    </div>
    <div class="right edit-box">
        <a id="btn-edit-cart" href="javascript:void(0);" class="clr-6"><?php echo __("cart-edit-btn"); ?></a>
    </div>
    <div class="clear"></div>
</div>

<div class="on-cart">
    <p class="control-label-total"><?php echo __("cart-you-have-product"); ?></p>
    <div class="sum" ><span id="minicart-item-quantity"><?php echo!empty($checkout['items_count']) ? $checkout['items_count'] : "0"; ?></span> <?php echo __("cart-product-unit"); ?></div>
    <div class="clear"></div>
</div>
<div class="cart-cat">
    <p class="cart-header-col-1"><?php echo __("cart-product-lbl"); ?></p>
    <p class="cart-header-col-2"><?php echo __("cart-number-of-product-lbl"); ?></p>
    <p class="cart-header-col-3"><?php echo __("cart-product-price-lbl"); ?></p>
    <div class="clear"></div>
</div>
<div class="cart">
    <?php if ( !empty($checkout['items_count']) && intval($checkout['items_count']) > 0 ): ?>
        <?php
            $show_group = false;
            if(count($checkout['shipments']) > 1)
            {
                $show_group = true;
            }
        ?>
        <?php $vendor_count = 1;?>
        <?php foreach ( $checkout['shipments'] as $key => $shipment ): ?>
            <ul>
                <div class="cart-title"><?php echo __("cart-shops-product-lbl"); ?> :
                    <span class="vendor-name">
                        <?php echo __('replace-shop-name');//$shipment['shop_name']; ?>
                        <?php if($show_group == true):?>
                            (<?php echo __('replace-vendor-name').' '.$vendor_count;$vendor_count++; //echo $shipment['vendor_name'] ?>)
                        <?php endif;?>
                    </span>
                    (<?php echo $shipment['items_count']; ?> <?php echo __("cart-item-unit"); ?>)
                </div>
                <!-- [S] Product list per shop -->
                <?php foreach ( $shipment['items'] as $key => $item ): ?>
                    <li>
                        <div class="total-list">
                            <p class="left product-name"><?php echo (!empty($item['name'])) ? $item['name'] : ""; ?></p>
                            <div class="no-product-list">
                                <p class="left">
                                    <?php if ( $editQty === true ): ?>
                                        <?php
                                        // set maxQty to maximum if $item['quantity'] more than maxQty.
                                        $limit = max($maxQty, $item['quantity']);
                                        ?>
                                        <select name="nday2" class="select-cart"  onchange="">
                                            <?php for ( $i = 0; $i <= $limit; $i++ ): ?>
                                                <option <?php echo ($item['quantity'] == $i) ? "selected='selected'" : ""; ?>  value="<?php echo $i; ?>"><?php echo ($i == 0) ? __("cart-delete-lbl") : $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    <?php else: ?>
                                        <span class="select-cart select-disable"><?php echo $item['quantity']; ?></span>
                                    <?php endif; ?>
                                </p>
                                <p><?php echo number_format($item['price']*$item['quantity'], 2); ?></p>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </li>
                <?php endforeach; ?>
                <!-- [E] Product list per shop -->

                <!-- [S] Shipment method -->
                <?php if ( $showShippingMethod === true ): ?>
                    <?php if ( $editShippingMethod === true ): ?>
<!--                        <li>-->
<!--                            <div class="total-list bdr-btm-none">-->
<!--                                <p class="left product-name clr-5">--><?php //echo "eieieiei";//echo __("cart-shipping-method-lbl"); ?><!--</p>-->
<!--                                <div class="no-product-list">-->
<!--                                    <p class="right">-->
<!--                                        <span class="clr-5">-->
<!--                                            <select>-->
<!--                                                --><?php //if ( !empty($shipment['available_shipping_methods']) ): ?>
<!--                                                    --><?php //foreach ( $shipment['available_shipping_methods'] as $key => $shipmentMethod ): ?>
<!--                                                        <option --><?php //echo ((string) $key == $shipment['shipping_method']) ? "selected='selected'" : ""; ?><!-- value="--><?php //echo $key; ?><!--">-->
<!--                                                            --><?php
//                                                            //echo $shipmentMethod['name'] . " (" . $shipmentMethod['description'] . ") " . __("cart-delivery-fare") . " " . number_format($shipmentMethod['fee'], 2);
//                                                            echo $shipmentMethod['name'] . " (" . number_format($shipmentMethod['fee'], 2) . " " . __('cart-baht-lbl') . ")";
//                                                            ?>
<!--                                                        </option>-->
<!--                                                    --><?php //endforeach; ?>
<!--                                                --><?php //else: ?>
<!--                                                    <option>--><?php //echo __("cart-enter-address-lbl"); ?><!--</option>-->
<!--                                                --><?php //endif; ?>
<!--                                            </select>-->
<!--                                        </span>-->
<!--                                    </p>-->
<!--                                    <div class="clear"></div>-->
<!--                                </div>-->
<!--                                <div class="clear"></div>-->
<!--                            </div>-->
<!--                            <div class="clear"></div>-->
<!--                        </li>-->
                    <?php else: ?>
<!--                        <li>-->
<!--                            <div class="total-list bdr-btm-none">-->
<!--                                <p class="left product-name clr-5">--><?php //echo "bbbbbbssss";//echo __("cart-shipping-method-lbl"); ?><!--</p>-->
<!--                                <div class="no-product-list">-->
<!--                                    <p class="right">-->
<!--                                        <span class="clr-5">-->
<!--                                            --><?php
//                                            if ( !empty($shipment['available_shipping_methods'][$shipment['shipping_method']]) )
//                                            {
//                                                $shipmentMethod = $shipment['available_shipping_methods'][$shipment['shipping_method']];
//                                                //echo $shipmentMethod['name'] . " (" . $shipmentMethod['description'] . ") " . __("cart-delivery-fare") . " " . $shipmentMethod['fee'];// . __("cart-baht-lbl");
//                                                echo $shipmentMethod['name'] . " (" . number_format($shipmentMethod['fee'], 2) . " " . __('cart-baht-lbl') . ")";
//                                            }
//                                            else
//                                            {
//                                                echo __("cart-free-shipping-lbl");
//                                            }
//                                            ?>
<!--                                        </span>-->
<!--                                    </p>-->
<!--                                    <div class="clear"></div>-->
<!--                                </div>-->
<!--                                <div class="clear"></div>-->
<!--                            </div>-->
<!--                            <div class="clear"></div>-->
<!--                        </li>-->
                    <?php endif; ?>
                <?php endif; ?>
                <!-- [E] Shipment method -->
            </ul>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="cart-title" style="text-align: center;color:red;"><?php echo __("cart-no-item"); ?></div>
    <?php endif; ?>
</div>
<div class="total-list">
    <p class="control-label-total"><?php echo __("cart-cost-lbl"); ?></p>
    <div class="sum sum_total_price"><?php echo (!empty($checkout['total_price'])) ? number_format($checkout['total_price'], 2) : number_format(0, 2); ?></div>
    <div class="clear"></div>
</div>
<div class="total-list">
    <p class='control-label-total'><?php echo __('cart-total-delivery-fare') ?></p>
    <div class="sum text-blink">
        <?php
        if ( isset($checkout['total_shipping_fee']) && $checkout['total_shipping_fee'] == 0 ) { ?>
            <span class="text-blink" style='color:#95C126;'><?php echo __("cart-free-lbl"); ?> </span>
        <?php } elseif ( isset($checkout['total_shipping_fee']) ) { ?>
            <?php echo '<span class="text-blink">'.number_format($checkout['total_shipping_fee'], 2).'</span>';
        } else {
            echo '<span class="text-blink">'.number_format(0, 2).'</span>';
        }
        ?>
    </div>
    <div>
        <?php if( isset($checkout['shipping_config']) && !empty($checkout['shipping_config']['shipping_link']) ) { ?>
            <a href='<?php echo $checkout['shipping_config']['shipping_link']; ?>'><span class="text-blink" style='color:#1155cc;'><?php echo $checkout['shipping_config']['shipping_note']; ?></span></a>
        <?php } else if ( isset($checkout['shipping_config']) && !empty($checkout['shipping_config']['shipping_note']) ) { ?>
            <span class="text-blink"> <?php echo $checkout['shipping_config']['shipping_note']; ?> </span>
        <?php } ?>
    </div>

    <div class="clear"></div>
</div>

<?php //if ( $showTrueyou == true && $isTUAvailablePage == true ): ?>
<!--    --><?php //if ( ( empty($user['trueyou']) && ACL::isLoggedIn() == true ) || (empty($checkout['cart_trueyou']) && ACL::isLoggedIn() == false) ): ?>
<!--        <div class="total-list trueyou-container">-->
<!--            <div class="box-discount">-->
<!--                <p class="control-label-total clr-5">ABC--><?php ////echo __("cart-discount-trueyou"); ?><!--</p>-->
<!--                <div class="sum edit-box"><a href="#" id="auth-trueyou" class="clr-6">--><?php //echo __("cart-verify-trueyou-btn"); ?><!--</a></div>-->
<!--                <div class="clear"></div>-->
<!--            </div>-->
<!--        </div>-->
<!--    --><?php //endif; ?>
<!--    <div class="total-list trueyou-container" style="display: --><?php //echo ( ( empty($user['trueyou']) && ACL::isLoggedIn() == true ) || (empty($checkout['cart_trueyou']) && ACL::isLoggedIn() == false) ) ? 'none' : "block"; ?><!--">-->
<!--        <div class="box-discount">-->
<!--            <p class="control-label-total clr-7 text-blink">-->
<!--                <span>--><?php //echo __("cart-discount-trueyou"); ?><!--</span>-->
<!--                --><?php //if ( !empty($user['trueyou']) && ACL::isLoggedIn() == true ): ?>
<!--                    <span>-->
<!--                        --><?php //if ( (!empty($user['trueyou']) && $user['trueyou'] == 'red' ) ): ?>
<!--                            <img width="30" src="--><?php //echo Theme::asset()->usePath()->url('images/card-red.png'); ?><!--" />-->
<!--                        --><?php //elseif ( (!empty($user['trueyou']) && $user['trueyou'] == 'black' ) ): ?>
<!--                            <img width="30" src="--><?php //echo Theme::asset()->usePath()->url('images/card-black.png'); ?><!--" />-->
<!--                        --><?php //endif; ?>
<!--                    </span>-->
<!--                --><?php //elseif ( !empty($checkout['cart_trueyou']) && ACL::isLoggedIn() == false ): ?>
<!--                    <span>-->
<!--                        --><?php //if ( (!empty($checkout['cart_trueyou']['card']) && $checkout['cart_trueyou']['card'] == 'red' ) ): ?>
<!--                            <img width="30" src="--><?php //echo Theme::asset()->usePath()->url('images/card-red.png'); ?><!--" />-->
<!--                        --><?php //elseif ( (!empty($checkout['cart_trueyou']['card']) && $checkout['cart_trueyou']['card'] == 'black' ) ): ?>
<!--                            <img width="30" src="--><?php //echo Theme::asset()->usePath()->url('images/card-black.png'); ?><!--" />-->
<!--                        --><?php //endif; ?>
<!--                    </span>-->
<!--                --><?php //endif; ?>
<!--            </p>-->
<!--            <div class="sum clr-7 text-blink">--><?php //echo ($trueyouDiscount > 0 ? '-' : '') . number_format($trueyouDiscount, 2); ?><!-- --><?php ////echo __("cart-baht-lbl")   ?><!--</div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="clear"></div>-->
<?php //endif; ?>

<?php if ( $showCoupon === true ): ?>
    <div class="total-list" id="coupon-container">
        <?php if ( ! empty($checkout['promotions'])) : ?>
        <?php foreach ( $checkout['promotions'] as $promotion ): ?>
            <?php if ( empty($promotion['code']) ) continue; ?>
            <div class="box-discount">
                <p class="control-label-total clr-7">
                    <span class="text-blink"><?php echo __("cart-discount-coupon") . ' ' . $promotion['name']; ?></span>
                    <span class="close-discount remove-coupon" data-code="<?php echo $promotion['code']; ?>">
                        <img src="<?php echo Theme::asset()->url("images/close.gif") ?>"/>
                    </span>
                </p>
                <div class="sum clr-7 text-blink"><?php echo ($promotion['totalDiscount']>0 ? '-' : '') . number_format($promotion['totalDiscount'], 2); ?> <?php // echo __("cart-baht-lbl");   ?></div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <div class="box-discount">
            <div class="control-group">
                <form id="coupon_voucher_code" method="post" action="<?php //echo Url::toLang('checkout/apply-coupon', array(), $open_https); ?>">
                    <input id="coupon-text" type="text" name="code" class="input-info control-form-coupon" placeholder="<?php echo __("cart-coupon-placeholder"); ?>" autocomplete="off" /><input id="coupon_button" type="submit" class="btn-use-coupon" value="<?php echo __("cart-use-coupon-btn"); ?>" />
                    <?php if( $errors->first('message') ): ?>
                        <div id="coupon_code_error"><?php echo $errors->first('message'); ?></div>
                    <?php else: ?>
                        <div id="coupon_code_error" style="display: none;"></div>
                    <?php endif; ?>
                </form>
            </div>
            <p class="coupon-title clr-5"><?php echo __("cart-remark-coupon"); ?></p>
        </div>
    </div>
<?php endif; ?>

<?php if ( $showDiscount === true ): ?>
    <div class="total-list bold">
        <p class="control-label-total"><?php echo __("cart-discount-lbl"); ?></p>
        <div class="sum"><?php echo!empty($checkout['total_discount']) ? number_format(-$checkout['total_discount'], 2) : number_format(0, 2); ?> <?php //echo __("cart-baht-lbl");    ?></div>
        <div class="clear"></div>
    </div>
<?php endif; ?>

<div class="total-list box">
    <p class="control-label-total clr-5"><?php echo __("cart-total-price-lbl"); ?></p>
    <div class="sum clr-3"><?php echo (!empty($checkout['sub_total'])) ? number_format($checkout['sub_total'], 2) : number_format(0, 2); ?> <?php //echo __("cart-baht-lbl");    ?><br/><small>(<?php echo __("cart-vat-included"); ?>)</small></div>
    <div class="clear"></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        MiniCart.Main.config.usertrueyou = <?php echo!empty($user['trueyou']) ? 'true' : 'false'; ?>;
        MiniCart.Main.config.isLogedin = <?php echo ACL::isLoggedIn() ? 'true' : 'false'; ?>;
<?php if ( !empty($user['trueyou']) ): ?>
            MiniCart.Main.config.usertrueyou_card = "<?php echo $user['trueyou']; ?>";
<?php endif; ?>
    });
</script>

<!-- typeidea script -->
<script type="text/javascript">
var cart_items = [];

<?php if ( !empty($checkout['items_count']) && intval($checkout['items_count']) > 0 ): ?>
<?php foreach ( $checkout['shipments'] as $key => $shipment ): ?>
<?php foreach ( $shipment['items'] as $key => $item ): ?>

cart_items.push({
        "id": "<?php echo $item['product_pkey']; ?>",
        "name": "<?php echo $item['name']; ?>",
        "price": "<?php echo $item['price']; ?>",
        "quantity": "<?php echo $item['quantity']; ?>"
      });

<?php endforeach; ?>
<?php endforeach; ?>
<?php endif; ?>

</script>
<!-- //typeidea script -->