<div class="row box-padding">
    <div class="col-xs-12"><?php echo __('cart'); ?> <span>(<span class="checkout-items_count"><?php echo isset($checkout['items_count']) ? $checkout['items_count'] : 0; ?></span> <?php echo __('piece'); ?>)</span></div>
</div>

<?php $items_count = isset($checkout['items_count']) ? $checkout['items_count'] : 0; ?>
<?php if ($items_count > 0): ?>
    <?php $vendor_count = 1;?>
    <?php $show_group = false;?>
    <?php
        if(!empty($checkout['shipments']))
        {
            if(count($checkout['shipments']) > 1)
            {
                $show_group = true;
            }
        }
    ?>
<?php foreach ($checkout['shipments'] as $key => $shipment): ?>
<div class="row box-padding" id="shipment_key-<?php echo $key; ?>">
    <div class="col-xs-12"><?php echo __('cart-shops-product-lbl'); ?>: <span id="cart-shop-name"><?php echo __('replace-shop-name');//$shipment['shop_name']; ?></span>
        <?php if($show_group == true):?>
            <span class="shop_vendor">(<?php echo __('replace-vendor-name').' <span class="shipment-'.$key.'-vendor vendor_count">'.$vendor_count.'</span>'; $vendor_count++;?>)</span>
        <?php endif;?>
        (<span class="shipment-<?php echo $key; ?>-items_count">
        <?php echo $shipment['items_count']; ?></span> <?php echo __('piece'); ?>)
    </div>

    <?php if ($showSelectShippingMethod): ?>
    <div class="row">
        <div class="col-xs-12 shipping">
           <!-- <div class="col-xs-4"><?php //echo __('cart-shipping-method-lbl'); ?></div>
            <div class="col-xs-8">
                <?php $methods = array(); ?>
                <select class="form-control shipping-methods" data-shipment_key="<?php echo $key; ?>">
                <?php foreach ($shipment['available_shipping_methods'] as $pkey => $method): ?>
                    <option value="<?php echo $pkey; ?>"<?php echo ($shipment['shipping_method']==$pkey)?'selected':''; ?>>
                    <?php echo $method['name'].' - '.$method['description'].' ('.$method['fee'].' บาท)'; ?>
                    </option>
                <?php endforeach; ?>
                </select>
                <img src="<?php echo Theme::asset()->usePath()->url('img/loading.gif'); ?>" class="checkout-calculating" style="display: none;" />
            </div> -->
        </div>
    </div>
    <?php endif; ?>
</div>
<?php foreach ($shipment['items'] as $item): ?>

<div class="row product-list box-padding" id="inventory_id-<?php echo $item['inventory_id']; ?>">
    <div class="col-xs-12">
        <div class="row header">
            <div class="col-xs-4"><img src="<?php echo $item['thumbnail']; ?>"></div>
            <div class="col-xs-8"><?php echo $item['name']; ?></div>
        </div>
        <div class="row product-price">
            <div class="col-xs-4"><?php echo __('cart-price-per-product'); ?></div>
            <div class="col-xs-8">
                <h2><?php echo number_format($item['price'])?>.-</h2>
                <?php if ($item['net_price'] > $item['price']): ?>
                <span><?php echo number_format($item['net_price'])?>.-</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="row quantity">
            <div class="col-xs-4"><?php echo __('cart_vendor_name_item_total'); ?></div>
            <div class="col-xs-3">
                <?php
                    $is_disabled = "";
                    if(in_array($item['inventory_id'], $checkout['checkDeletedItem'])) {
                        $is_disabled = "disabled";
                    }
                ?>
                <select class="form-control item-quantity" data-inventory_id="<?php echo $item['inventory_id']; ?>" data-shipment_key="<?php echo $key; ?>" <?php echo $is_disabled; ?>>
                    <?php if (isset($limitQuantity[$item['inventory_id']])) : ?>
                        <?php foreach (range(1, max($item['quantity'], $limitQuantity[$item['inventory_id']])) as $i): ?>
                        <option value="<?php echo $i; ?>"<?php echo ($item['quantity']==$i)?'selected':''; ?>><?php echo $i; ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php foreach (range(1, max($item['quantity'], 5)) as $i): ?>
                        <option value="<?php echo $i; ?>"<?php echo ($item['quantity']==$i)?'selected':''; ?>><?php echo $i; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <!--<img src="<?php //echo Theme::asset()->usePath()->url('img/loading.gif'); ?>" class="checkout-calculating" style="display: none;" />-->
            </div>
            <div class="col-xs-5">
                <a href="#" class="remove-item" data-inventory_id="<?php echo $item['inventory_id']; ?>" data-shipment_key="<?php echo $key; ?>"><?php echo __('cart-delete-item-lbl'); ?></a>
                <img src="<?php echo Theme::asset()->usePath()->url('img/loading.gif'); ?>" class="checkout-calculating" style="display: none;" />
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endforeach; ?>

    <div class="row summary box-padding">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-7"><p><?php echo __('cart-cost-lbl'); ?></p></div>
                <div class="col-xs-5 text-right"><p
                        class="checkout-summary checkout-total_price"><?php echo number_format($checkout['total_price'], 2); ?></p>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-9">
                    <p class="text-blink"><?php echo __('cart-total-delivery-fare'); ?>
                        <br/>
                        <?php $notificationLink = array_get($checkout, "shipping_config.shipping_link", "javascript:void(0);"); ?>
                        <?php if (array_get($checkout, "shipping_config.shipping_link", "") != '') : ?>
                            <a target="_blank" href="<?php echo $notificationLink; ?>" class="text-blink fullcart-noti-shipping-fee <?php echo (!empty($notificationLink) && $notificationLink != "javascript:void(0);" )? "is-link": "isnot-link"; ?>">
                                <span style="font-size: 14px;"><?php echo array_get($checkout, "shipping_config.shipping_note", ""); ?></span>
                            </a>
                        <?php else :
                            echo '<span style="font-size: 14px;">'.array_get($checkout, "shipping_config.shipping_note", "").'</span>';
                        endif; ?>
                    </p>
                </div>
                <div class="col-xs-3 text-right">
                    <?php $shippingFee = array_get($checkout, "total_shipping_fee", 0); ?>
                    <p class="text-blink checkout-summary checkout-total_shipping_fee <?php echo ($shippingFee == 0)? "text-green" : ""; ?>">
                        <?php
                            if($shippingFee > 0){
                                echo number_format($checkout['total_shipping_fee'], 2);
                            }else{
                                echo __("cart-free-lbl");
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-7">
                    <p>
                        <?php echo __('cart-discount-lbl'); ?>
                        <?php
                        $promotext = '';
                        if (!empty($checkout['promotions'])) {
                            foreach ($checkout['promotions'] as $key => $row) {
                                $promotext .= $row['name'] . ' ';
                            }
                        }
                        if (!empty($promotext)) {
                            $promotext = '( ' . __('show-discount-promotion') . ' ' . $promotext . ' )';
                        }
                        ?>
                        <br/><span class="show-promotion" style="color: #959595;"><?php echo $promotext; ?></span>
                    </p>
                </div>
                <div class="col-xs-5 text-right">
                    <p class="checkout-summary checkout-total_discount">
                        <?php echo number_format(-$checkout['total_discount'], 2); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-7">
                    <h3><?php echo __('cart-total-price-lbl'); ?></h3>
                </div>
                <div class="col-xs-5 text-right">
                    <h3 class="checkout-summary checkout-sub_total"><?php echo number_format($checkout['sub_total'], 2); ?></h3>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 text-right tax-included">
                    <span><?php echo __('(cart-vat-included)'); ?></span>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
<div class="row no-cart box-padding">
    <div class="col-xs-12"><?php echo __('No item has been addedd to your cart'); ?></div>
</div>
<?php endif; ?>

<div class="row button-continue box-padding">
    <div class="col-xs-12">
        <?php //echo $continueButtonUrl; ?>
        <?php if ($hasItems == "1") : ?>
        <a href="javascript:void(0);" class="continue-button">
            <div class="button"><?php echo $continueButtonText; ?></div>

        </a>
        <?php else : ?>
        <a href="<?php echo url(); ?>" class="continue-button">
            <div class="button"><?php echo $continueButtonText; ?></div>
        </a>
        <?php endif; ?>
    </div>
</div>

<?php if (!$showSelectShippingMethod): ?>
    <?php if ($items_count > 0): ?>
    <div class="row text-right box-padding">
        <div class="col-xs-12">
            <a href="<?php echo $backButtonUrl; ?>" class="blue-link"><?php echo $backButtonText; ?></a>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>

<input type="hidden" id="refreshed" value="no">
<script>
    var Checkout = Checkout || [];
    Checkout.data = <?php echo json_encode($checkout); ?>;
    $("document").ready(function(){
        if(jQuery().textBlink){
            $(".text-blink").textBlink();
        }
    });
</script>