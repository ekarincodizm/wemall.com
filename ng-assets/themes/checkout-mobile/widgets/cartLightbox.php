<!-- Modal -->
<div id="cart-popup" class="cart-popup modal fade" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="title bdr-btm-none">
        <div class="left">
            <h1><?php echo __("cart-summary"); ?></h1>
        </div>
        <div class="right">
            <div class="left cart-label-header"><strong><span class="clr-3"><?php echo __("cart-you-have-product"); ?></span></strong> <span id="cartlightbox-item-quantity"><?php echo !empty($checkout['items_count']) ? $checkout['items_count'] : "0"; ?></span> <?php echo __("cart-product-unit"); ?></div>
<!--            <div class="left cart-close"><img src="<?php //echo Theme::asset()->url('images/close.png'); ?>" width="27" height="27"></div>-->
        </div>
        <div class="clear"></div>
    </div>
    <div class="cart-cat cart-title-header" >
        <div class="left cart-title-header-col-1"><?php echo __("cart-product-lbl"); ?></div>
        <div class="left cart-title-header-col-2"><?php echo __("cart-product-price-lbl"); ?></div>
        <div class="left cart-title-header-col-3"><?php echo __("cart-number-of-product-lbl"); ?></div>
        <div class="left cart-title-header-col-4"><?php echo __("cart-price-per-product"); ?></div>

        <div class="clear"></div>
    </div>

    <?php if (!empty($checkout['items_count']) && intval($checkout['items_count']) > 0): ?>
        <?php $vendor_count = 1;?>
        <?php $show_group = false;?>
        <?php
            if(count($checkout['shipments']) > 1)
            {
                $show_group = true;
            }
        ?>
        <?php foreach ($checkout['shipments'] as $skey => $shipment): ?>
            <div id="cartlightbox-product-list-container" class="cart-box">
                <div class="cart-title"><?php echo __("cart-shops-product-lbl"); ?> :
                    <span class="vendor-name"><?php echo __('replace-shop-name'); //$shipment['shop_name']; ?>
                        <?php if($show_group == true):?>
                        (<?php echo __('replace-vendor-name').' '.$vendor_count;$vendor_count++; //$shipment['vendor_name'] ?>)
                        <?php endif;?>
                    </span> (<?php echo $shipment['items_count']; ?> <?php echo __("cart-item-unit"); ?>)</div>
                
                <!-- [S] Product list per shop -->
                <?php foreach ($shipment['items'] as $ikey => $item): ?>
                    <div class="cart-title-list" >
                        <div class="cart-box-img" ><img src="<?php echo !empty($item['thumbnail'])? $item['thumbnail'] : Theme::asset()->url("images/product/image-not-found-105.jpg") ; ?>" width="95" height="95" /></div>
                        <div class="left">
                            <div class="cart-box-name" >
                                <h2><?php echo (!empty($item['name']))? $item['name']: ""; ?></h2>
                            </div>
                            <div class="cart-box-price" >
                                <?php if($item['total_discount'] > 0) : ?>
                                    <span class="alert"><?php echo ($item['total_price'] - $item['total_discount']); ?></span><br />
                                    <span class="line-through"><?php echo $item['total_price']; ?></span><br />
                                    <?php echo __("cart-discount-percent-lbl"); ?> <?php echo round(($item['total_discount']/$item['total_price']) * 100); ?> %
                                <?php else: ?>
                                    <span><?php echo ($item['total_price'] - $item['total_discount']); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="cart-box-no">
                                <?php if ($editQty === true): ?>
                                    <?php
                                        // set maxQty to maximum if $item['quantity'] more than maxQty.
                                        $limit = max($maxQty, $item['quantity']);
                                    ?>
                                    <select name="nday2" class="select-cart cartlightbox-update-item-qty" data-inventory-id="<?php echo $item['inventory_id']; ?>">
                                        <?php for ($i = 1; $i <= $limit; $i++): ?>
                                            <option <?php echo ($item['quantity'] == $i) ? "selected='selected'" : ""; ?>  value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                <?php else: ?>
                                    <span class="select-cart select-disable"><?php echo $item['quantity']; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="cart-box-price2"><?php echo ($item['price'] - $item['discount']); ?></div>
                            <div class="clear"></div>
                            <div  class="cart-box-action">
                                <?php if($itemCount > 1): ?>
                                    <ul>
                                        <li class="bullet-dot"><a class="cartlightbox-delete-item" data-inventory-id="<?php echo $item['inventory_id']; ?>" href="javascript:void();"><?php echo __("cart-delete-item-lbl"); ?></a></li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php endforeach; ?>
                <?php if($showShippingMethod === true): ?>
                    <?php if ($editShippingMethod === true): ?>
                <!--  <div class="cart-send">
                            <div class="total-list bdr-none">
                                <p class="control-label-total"><?php //echo __("cart-shipping-method-lbl"); ?> :
                                    <select name='' class="select-cart-send cartlightbox-update-shipping-method"  data-shipment-id="<?php echo $skey; ?>">
                                        <?php if (!empty($shipment['available_shipping_methods'])): ?>
                                            <?php foreach ($shipment['available_shipping_methods'] as $key => $shipmentMethod): ?>
                                                <option <?php echo ((string) $key == $shipment['shipping_method']) ? "selected='selected'" : ""; ?> value="<?php echo $key; ?>"><?php echo $shipmentMethod['name'] . " (" . $shipmentMethod['description'] . ") ".__("cart-delivery-fare")." " . $shipmentMethod['fee'].' '.__('cart-baht-lbl'); ?></option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option><?php echo __("cart-enter-address-lbl"); ?></option>
                                        <?php endif; ?>
                                    </select>
                                </p>
                                <div class="clear"></div>
                            </div>
                        </div> -->
                        <div class="clear"></div>
                    <?php else: ?>
                <!--   <div class="cart-send">
                            <div class="total-list bdr-none">
                                <p class="control-label-total"><?php //echo __("cart-shipping-method-lbl"); ?> :
                                    <?php
                                        /*if (!empty($shipment['available_shipping_methods'][$shipment['shipping_method']]))
                                        {
                                            $shipmentMethod = $shipment['available_shipping_methods'][$shipment['shipping_method']];
                                            echo $shipmentMethod['name'] . " (" . $shipmentMethod['description'] . ") ".__("cart-delivery-fare")." " . $shipmentMethod['fee'];
                                        }*/
                                    ?>
                                </p>
                                <div class="clear"></div>
                            </div>
                        </div> -->
                        <div class="clear"></div>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- [E] Product list per shop -->
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="text-align: center;color:red;padding-bottom: 50px; padding-top: 50px;"><?php echo __("cart-no-item"); ?></div>
    <?php endif; ?>

    <div class="cart-sum">
        <div id="cartlightbox-sumary-bottom" class="cart-sum-on">
            <div class="total-list">
                <p class="control-label-total"><?php echo __("cart-cost-lbl"); ?></p>
                <div class="sum"><?php echo (!empty($checkout['total_price'])) ? $checkout['total_price'] : '0'; ?> </div>
                <div class="clear"></div>
            </div>
            <div class="total-list">
                <p class="control-label-total"><?php echo __("cart-total-delivery-fare"); ?></p>
                <div class="sum">
                    <?php
                        if (isset($checkout['total_shipping_fee']) && $checkout['total_shipping_fee'] == 0)
                        {
                            echo __("cart-free-lbl");
                        } elseif (isset($checkout['total_shipping_fee']))
                        {
                            echo $checkout['total_shipping_fee'] ;
                        } else
                        {
                            echo '0';
                        }
                    ?>
                </div>
                <div class="clear"></div>
            </div>
<!--            <div class="total-list">
                <p class="control-label-total"><?php //echo __("cart-discount-lbl"); ?></p>
                <div class="sum alert"><?php //echo (!empty($checkout['discount']) ? $checkout['discount'] : 0 ) + (!empty($checkout['total_discount']) ? $checkout['total_discount'] : 0 ); ?> <?php //echo __("cart-baht-lbl"); ?></div>
                <div class="clear"></div>
            </div>-->
            <div class="total-list box">
                <p class="control-label-total clr-5"><?php echo __("cart-total-price-lbl"); ?></p>
                <div class="sum clr-5"><?php echo (!empty($checkout['sub_total'])) ? $checkout['sub_total'] : "0" ?> </div>
                <div class="clear"></div>
            </div>
            <div class="btn-action-box">
                <input class="form-bot cart-close" name="" type="button" value="<?php echo __("cart-make-order-btn"); ?>" />
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!-- /Modal -->