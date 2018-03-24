<div class="visible-xs">
    <h2 class="address-title"><?php echo __("cart-summary"); ?> : </h2>
</div>
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
        <div class="group_cart product-list product-list-first">
            <div class="row col-xs-white">
                <div class="col-sm-6 vender-name">
                    <strong><?php echo __("cart-shops-product-lbl"); ?>:
                        <span class="vender-product-amount" id="shipment_<?php echo $shipment['shop_id']; ?>">
                            <span class="text-red-1">
                                <?php echo __('replace-shop-name');//$shipment['shop_name']; ?>
                                <?php if($show_group == true):?>
                                    (<?php echo __('replace-vendor-name').' '.$vendor_count;$vendor_count++; //$shipment['vendor_name'] ?>)
                                <?php endif;?>
                            </span>
                            (  <span id="shipment_count_<?php echo $shipment['shop_id']; ?>"><?php echo $shipment['items_count']; ?></span><?php echo __("cart-item-unit"); ?>)
                        </span>
                    </strong>
                </div>
            </div>
            <?php foreach ( $shipment['items'] as $key => $item ): ?>
                <div class="row col-xs-white product-box-info">
                    <div class="col-xs-12 col-sm-6 product-info">
                        <img class="product-image" style="class: product-image" alt="<?php echo (!empty($item['name'])) ? $item['name'] : ""; ?>" src="<?php echo (!empty($item['thumbnail'])) ? $item['thumbnail'] : ""; ?>">

                        <p class="product-description">
                            <?php echo (!empty($item['name'])) ? $item['name'] : ""; ?>
                        </p>
                    </div>

                    <div class="col-xs-6 col-sm-1 text-center product-amount">
                        <div class="row">
                            <div class="visible-xs pr-am-text col-xs-6"><?php echo __("cart-number-of-product-lbl"); ?></div>
                            <div class="col-sm-12 col-xs-6">
                                <?php if ( $step == '2' )
                                { ?>
                                    <input type="number" readonly max="9" min="1" class="inventory_item form-control input-sm" data-inventory-id ="<?php echo $item['inventory_id']; ?>"  id="quantity" name="quantity" value="<?php echo $item['quantity']; ?>" onkeypress="return AllowedNumber(event)">
                                <?php }
                                else
                                { ?>
                                    <input type="text" disabled="" value="<?php echo $item['quantity']; ?>" class="form-control input-sm text-center">
            <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-2 text-center product-total">
                        <div class="row">
                            <div class="visible-xs pr-to-text col-xs-6">
                            <?php echo __("cart-product-price-lbl"); ?>									</div>
                            <div class="text-red-1 col-sm-12 col-xs-6" id="total_inventory_id_<?php echo $item['inventory_id']; ?>">
                                <?php echo number_format(($item['total_price'] - $item['total_discount']), 2) . ' ' . __("cart-baht-lbl"); ?>
                            </div>
                        </div>
                    </div>
            <?php if ( $step == '2' )
            { ?>
                        <!--
                        <div class="col-xs-6 col-sm-1 text-center product-del">
                            <span class="visible-xs delete_inventory" rel="<?php echo $item['inventory_id']; ?>" data-inventory-id ="<?php echo $item['inventory_id']; ?>" ><?php echo __("cart-delete-item-lbl"); ?></span>
                            <input type="button" class="btn btn-delete delete_inventory" rel="<?php echo $item['inventory_id']; ?>" data-inventory-id ="<?php echo $item['inventory_id']; ?>" value="">
                        </div>
                        -->
                <?php } ?>
                </div>
                <div class="row col-xs-white">
                    <div class="col-sm-12 divider"></div>
                </div>
        <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?php if ( $step == '3' )
{ ?>
    <div class="visible-xs price-summary-box">
        <span class="price-summary"><?php echo __("cart-total-price-lbl"); ?> <?php echo (!empty($checkout['sub_total'])) ? number_format($checkout['sub_total'], 2) : "0" ?> <?php //echo __("cart-baht-lbl"); ?></span><br><span>(<?php echo __("cart-vat-included"); ?>)</span>
    </div>
<?php } ?>



