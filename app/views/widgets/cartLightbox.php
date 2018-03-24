<!-- Modal -->
<div id="cart-popup" data-ajax="<?php echo !empty($checkout)? "false" : "true"; ?>" class="cart-popup modal fade" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="title bdr-btm-none">
                <div class="left">
                    <span class="full_cart_title"><?php echo __("cart-summary"); ?></span>
                </div>
                <div class="right">
                    <div class="left cart-label-header"><strong><span class="clr-3"><?php echo __("cart-you-have-product"); ?></span></strong> <span id="cartlightbox-item-quantity"><?php echo!empty($checkout['items_count']) ? $checkout['items_count'] : "0"; ?></span> <?php echo __("cart-product-unit"); ?></div>
                    <?php if ($showCloseBtn === true): ?>
                        <div class="left cart-close" style="cursor:pointer; margi"><img src="<?php echo Theme::asset()->url('images/close.png'); ?>" width="27" height="27"></div>
                    <?php endif; ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="cart-cat cart-title-header" >
                <div class="left cart-title-header-col-1"><?php echo __("cart-product-lbl"); ?></div>
                <div class="left cart-title-header-col-2"><?php echo __("cart-price-per-product"); ?></div>
                <div class="left cart-title-header-col-3"><?php echo __("cart-number-of-product-lbl"); ?></div>
                <div class="left cart-title-header-col-4"><?php echo __("fullcart-product-price-lbl"); ?></div>

                <div class="clear"></div>
            </div>
            <div id="cart-box-info">
                <?php if (!empty($checkout['items_count']) && intval($checkout['items_count']) > 0): ?>
                    <?php
                    $show_group = false;
                    if(count($checkout['shipments']) > 1)
                    {
                        $show_group = true;
                    }
                    ?>
                    <?php $vendor_count = 1;?>
                    <?php foreach ($checkout['shipments'] as $skey => $shipment): ?>
                        <div id="cartlightbox-product-list-container" class="cart-box">
                            <div class="cart-title"><?php echo __("cart-shops-product-lbl"); ?> :
                                <span class="vendor-name"><?php echo __('replace-shop-name'); ?>
                                <?php if($show_group == true):?>
                                    (<?php echo __('replace-vendor-name').' '.$vendor_count ; $vendor_count++;  ?>)
                                <?php endif;?>
                                </span> (<?php echo $shipment['items_count']; ?> <?php echo __("cart-item-unit"); ?>)</div>

                            <!-- [S] Product list per shop -->
                            <?php foreach ($shipment['items'] as $ikey => $item): ?>
                                <div class="cart-title-list" >
                                    <?php if(!empty($showImage) && $showImage === true): ?>
                                        <div class="cart-box-img" ><img src="<?php echo !empty($item['thumbnail']) ? $item['thumbnail'] : Theme::asset()->url("images/product/image-not-found-105.jpg"); ?>" width="95" height="95" /></div>
                                    <?php endif; ?>
                                    <div class="left">
                                        <div class="cart-box-name" <?php if(isset($showImage) && $showImage === false){ echo "style='width:529px;'"; } ?>>
                                            <h2><?php echo (!empty($item['name'])) ? $item['name'] : ""; ?></h2>
                                        </div>
                                        <div class="cart-box-price" >
                                            <?php if ($item['price'] != $item['net_price']) : ?>
                                                <span class="alert"><?php echo number_format($item['price'], 2); ?></span><br />
                                                <span class="line-through"><?php echo number_format($item['net_price'], 2); ?></span><br />
                                                <?php echo __("cart-discount-percent-lbl"); ?> <?php echo floor( (( array_get($item, 'net_price') -  array_get($item, 'price')) / array_get($item, 'net_price') ) * 100); ?> %
                                            <?php else: ?>
                                                <span><?php echo number_format($item['price'], 2); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="cart-box-no">
                                            <?php //if ($editQty === true): ?>
                                            
                                            <?php if (isset($inventory_wow[$item['inventory_id']])): ?>
                                                <?php
                                                // set maxQty to maximum if $item['quantity'] more than maxQty.
                                                $limit = 1;
                                                ?>
                                                <select name="nday2" class="select-cart cartlightbox-update-item-qty" data-inventory-id="<?php echo $item['inventory_id']; ?>" autocomplete="off">
                                                    <?php for ($i = 1; $i <= $limit; $i++): ?>
                                                        <option <?php echo ($item['quantity'] == $i) ? "selected='selected'" : ""; ?>  value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            <?php else: ?>
                                                <?php
                                                // set maxQty to maximum if $item['quantity'] more than maxQty.
                                                $limit = max($maxQty, $item['quantity']);
                                                ?>
                                                <select name="nday2" class="select-cart cartlightbox-update-item-qty" data-inventory-id="<?php echo $item['inventory_id']; ?>" autocomplete="off">
                                                    <?php for ($i = 1; $i <= $limit; $i++): ?>
                                                        <option <?php echo ($item['quantity'] == $i) ? "selected='selected'" : ""; ?>  value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                        <div class="cart-box-price2">
                                            <?php
                                            echo number_format($item['price'] * $item['quantity'] , 2);
                                            ?>
                                        </div>
                                        <div class="clear"></div>
                                        <div  class="cart-box-action">
                                            <?php if ($itemCount > 1 || $forceShowRemoveBtn === true): ?>
                                                <ul>
                                                    <li class="bullet-dot"><a class="cartlightbox-delete-item" data-inventory-id="<?php echo $item['inventory_id']; ?>" href="javascript:void();"><?php echo __("cart-delete-item-lbl"); ?></a></li>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            <?php endforeach; ?>
                            <?php if ($showShippingMethod === true): ?>
                                <?php if ($editShippingMethod === true): ?>
                                  <!-- <div class="cart-send">
                                        <div class="total-list bdr-none">
                                            <p class="control-label-total"><?php echo __("cart-shipping-method-lbl"); ?> :
                                                <select name='' class="select-cart-send cartlightbox-update-shipping-method"  data-shipment-id="<?php echo $skey; ?>" autocomplete="off">
                                                    <?php if (!empty($shipment['available_shipping_methods'])): ?>
                                                        <?php foreach ($shipment['available_shipping_methods'] as $key => $shipmentMethod): ?>
                                                            <option <?php echo ((string) $key == $shipment['shipping_method']) ? "selected='selected'" : ""; ?> value="<?php echo $key; ?>">
                                                                <?php
                                                                //echo $shipmentMethod['name'] . " (" . $shipmentMethod['description'] . ") " . __("cart-delivery-fare") . " " . number_format($shipmentMethod['fee'], 2).' '.__('cart-baht-lbl');
                                                                echo $shipmentMethod['name'] . " (" . number_format($shipmentMethod['fee'], 2) . " " . __('cart-baht-lbl') . ")";
                                                                ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <option><?php echo __("cart-enter-address-lbl"); ?></option>
                                                    <?php endif; ?>
                                                </select>
                                            </p>
                                            <div class="clear"></div>
                                        </div>
                                    </div>-->
                                    <div class="clear"></div>
                                <?php else: ?>
                            <!--  <div class="cart-send">
                                        <div class="total-list bdr-none">
                                            <p class="control-label-total"><?php echo __("cart-shipping-method-lbl"); ?> :
                                                <?php
                                                if (!empty($shipment['available_shipping_methods'][$shipment['shipping_method']]))
                                                {
                                                    $shipmentMethod = $shipment['available_shipping_methods'][$shipment['shipping_method']];
                                                    //echo $shipmentMethod['name'] . " (" . $shipmentMethod['description'] . ") " . __("cart-delivery-fare") . " " . number_format($shipmentMethod['fee'], 2).__('cart-baht-lbl');
                                                    echo $shipmentMethod['name'] . " (" . number_format($shipmentMethod['fee'], 2) . " " . __('cart-baht-lbl') . ")";
                                                }
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
            </div>

            <div class="cart-sum">
                <div id="cartlightbox-sumary-bottom" class="cart-sum-on">
                    <div class="total-list">
                        <p class="control-label-total"><?php echo __("cart-cost-lbl"); ?></p>
                        <div class="sum"><?php echo (!empty($checkout['total_price'])) ? number_format($checkout['total_price'], 2) : number_format('0', 2); ?></div>
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
                                echo number_format($checkout['total_shipping_fee'], 2) ;
                            } else
                            {
                                echo number_format(0, 2);
                            }
                            ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="total-list">
                        <p class="control-label-total"><?php echo __("cart-discount-lbl");  ?></p>
                        <div class="sum">
                            <?php $checkoutTotalDiscont = !empty($checkout['total_discount']) ? -$checkout['total_discount'] : 0;
                            echo number_format($checkoutTotalDiscont, 2);
                            ?>
                        </div>
                        <div>
                            <?php if(!empty($checkout['promotions'])):?>
                                <?php
                                    $promotionTxt = ' ';
                                    foreach($checkout['promotions'] as $pro_key => $pro_row)
                                    {
                                        $promotionTxt .= $pro_row['name'].' ';
                                    }
                                ?>
                                <?php echo '('.__('show-discount-promotion').$promotionTxt.')';?>
                            <?php endif;?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="total-list box">
                        <p class="control-label-total clr-5"><?php echo __("cart-total-price-lbl"); ?></p>
                        <div class="sum clr-5">
                            <?php echo (!empty($checkout['sub_total'])) ? number_format($checkout['sub_total'], 2) : number_format(0, 2); ?>
                            <br/>
                            <small>(<?php echo __("cart-vat-included"); ?>)</small>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="btn-action-box">
                        <?php if (strtolower($nextBtnOperation) == 'gocheckout'): ?>
                            <input class="form-bot cart-goto-checkstep" id="cartlightbox-go-next" <?php if($itemCount < 1){ echo 'style="display:none;"'; } ?> name="" type="button" value="<?php echo __("cart-make-order-btn"); ?>" />
                        <?php else: ?>
                            <input class="form-bot cart-close" id="cartlightbox-go-next" <?php if($itemCount < 1){ echo 'style="display:none;"'; } ?> name="" type="button" value="<?php echo __("cart-make-order-btn"); ?>" />
                        <?php endif; ?>
                    </div>
                </div>
                <div class="clear"></div>
                <?php if ($showCloseBtn === true): ?>
                <div class="back-to-shopping cart-close">
                    <?php echo __("cart-back-to-shopping"); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- /Modal -->
<script type="text/javascript">
    $(document).ready(function(e){ 
        cartLightbox.config.forceShowRemoveBtn = <?php echo ($forceShowRemoveBtn == true) ? 'true' : 'false'; ?>;
        cartLightbox.config.showShippingMethod = <?php echo ($showShippingMethod == true) ? 'true' : 'false'; ?>;
        cartLightbox.config.editShippingMethod = <?php echo ($editShippingMethod == true) ? 'true' : 'false'; ?>;
        cartLightbox.config.showImage = <?php echo (isset($showImage) && $showImage == false )? 'false' : 'true'; ?>
    });
</script>
