<div class="content-home sub">
    <div id="wrapper_content">
        <div id="container">
            <!--Start container-->
            <div id="block_checkout">
                <div id="checkout_main">
                    <!--start checkout_main-->
                    <div id="checkout_center">

                        <?php if (!empty($order)): ?>
                            <div id="checkout_menu">
                                <!--start checkout_menu-->
                                <div class="bigheadline"><b><?php echo trans('ordertracking.Guest User'); ?></b></div>
                                <div class="bottom_line"></div>
                                <div class="g_info"><div class="headline"></div></div>
                                <div class="welcome"><b><?php echo trans('ordertracking.Welcome'); ?></b><br>
                                    <?php echo $order['customer_email']; ?>
                                </div>
                            </div>

                            <div id="checkout_detail">
                                <div class="headline_maincheckout" style="width:320px;"><b><?php echo __("order-tracking-check-shipment-status"); ?></b></div>
                                <div class="clear"></div>
                                <div class="line_mainbar_checkout"></div>
                                <ul id="profile-hd-list" class="hd-brd-btm order-tracking">
                                    <li><a><?php echo __("order-tracking-payment-channel"); ?></a></li>
                                </ul>

                                <div id="OT_topic">
                                    <div id="OT_date" class="headline"><?php echo __("order-tracking-order-date"); ?></div>
                                    <div id="OT_id" class="headline"><?php echo __("order-tracking-order-id"); ?></div>
                                    <div id="OT_total" class="headline"><?php echo __("order-tracking-total"); ?>(<strong>₱</strong>)</div>
                                    <div id="OT_status" class="headline"><?php echo __("order-tracking-payment-status"); ?></div>
                                    <div id="OT_statusdeli" class="headline"><?php echo __("order-tracking-shipment-status"); ?></div>
                                    <div id="OT_viewdetail" class="headline"><?php echo __("order-tracking-description"); ?></div>
                                    <div class="clear"></div>
                                </div>

                                <?php // foreach($order as $data): ?>
                                <?php $data = $order; ?>
                                <div id="total_cart">
                                    <!--Start total_cart-->
                                    <div id="OT_detail">
                                        <!--Start OT_detail-->
                                        <div id="OT_date" class="red "><?php echo date('Y-m-d', strtotime($data['created_at'])); ?></div>
                                        <div id="OT_id" class="black "><?php echo $data['id']; ?></div>
                                        <div id="OT_total" class=" "><?php echo number_format($data['sub_total'], 2, '.', ','); ?></div>
                                        <div id="OT_status" class="black  ">
                                            <span style="color:#CCCCCC;">
                                                <?php
                                                if (!empty($data['payment_status'])) :
                                                    if (App::getLocale() == 'th') :
                                                        echo array_get($th_payment_status, $data['payment_status']);
                                                    else:
                                                        echo $data['payment_status'];
                                                    endif;
                                                else:
                                                    echo '-';
                                                endif;
                                                ?>
                                            </span>							
                                        </div>
                                        <div id="OT_statusdeli" class="black  ">																
                                            <?php echo __("order-tracking-view-detail"); ?>
                                        </div>
                                        <div id="OT_viewdetail">
                                            <div id="button_down">										
                                                <a href="#" class="toggle_item"><img src="<?php echo Theme::asset()->usePath()->url('images/button_right.png'); ?>" alt="" width="20" height="19"></a>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <!--End OT_detail-->
                                    </div>   
                                    <!--End total_cart-->
                                </div>
                                <div class="slide_list">			
                                    <div id="block_conclusion">
                                        <!--start block_conclusion-->
                                        <div id="order_detail">
                                            <!--start order_detail-->
                                            <div class="OD_topic">
                                                <div>
                                                    <span class="mediumheadline"><strong><?php echo trans('ordertracking.Order date'); ?></strong><br />
                                                        <?php echo date('Y-m-d H:i:s', strtotime($data['created_at'])); ?>
                                                    </span>
                                                </div>
                                                <!--<div class="start_detail"><strong><?php echo trans('ordertracking.Shipping Method'); ?>:</strong></div>-->
                                            </div>
                                            <div class="OD_detail">
                                                <div>
                                                    <span class="mediumheadline"><strong><?php
                                                            if (!empty($data['customer_info_modified_at'])) {
                                                                echo $data['customer_info_modified_at'];
                                                            }
                                                            ?></strong></span>
                                                    <!--(Lastest)-->
                                                </div>
                                                <div class="start_detail graylight"></div>
                                                <div class="black"><?php echo trans('ordertracking.Address'); ?>:</div>
                                                <div class="graylight">
                                                    <?php echo $data['customer_name']; ?><br>
                                                    <?php echo $data['customer_address']; ?> <?php echo $data['customer_district']; ?> <?php echo $data['customer_city']; ?> <?php echo $data['customer_province']; ?> 
                                                    <?php echo $data['customer_postcode']; ?>		
                                                </div>
                                                <div class="black"><?php echo trans('ordertracking.Tel.'); ?>:</div>
                                                <div class="graylight"><?php echo $data['customer_tel']; ?></div>
                                            </div>
                                            <div class="clear"></div>
                                            <!--end order_detail-->
                                        </div>
                                        <div id="order_boxcart">
                                            <!--start order_boxcart-->
                                            <div id="no_id">
                                                <div class="headline left"><?php echo trans('ordertracking.No'); ?>:</div>
                                                <div class="mediumheadline right"><strong><?php echo $data['id']; ?></strong></div>
                                                <div class="clear"></div>
                                            </div>
                                            <div id="conclusion">
                                                <?php $totalSumDiscountShipment = 0; ?>
                                                <?php foreach ($data['shipments'] as $shipment): ?>
                                                    <?php foreach ($shipment['shipment_items'] as $item): ?>
                                                        <?php $totalSumDiscountShipment += $item['discount']; ?>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                                <div style="line-height:0em;">
                                                    <img src="<?php echo Theme::asset()->usePath()->url('images/bg_conclusion_box_top.png'); ?>" width="204" height="7" alt="">
                                                </div>
                                                <div id="conclution_center_gray">
                                                    <div class="cl_txt"><?php echo __("order-tracking-total-product-price"); ?>:</div>
                                                    <div class="cl_num"><strong>₱ </strong><?php echo number_format($data['total_price'], 2); ?></div><div class="clear"></div>
                                                    <div class="cl_txt"><?php echo __("order-tracking-discount"); ?>:</div>
                                                    <div class="cl_num"><strong>₱ </strong><?php echo number_format(($data['discount'] + $totalSumDiscountShipment), 2); ?></div><div class="clear"></div>
                                                    <div class="cl_txt"><?php echo __("order-tracking-shipping-price"); ?>:</div>
                                                    <div class="cl_num"><strong>₱ </strong><?php echo number_format($data['total_shipping_fee'], 2); ?></div><div class="clear"></div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div id="conclution_center_red">
                                                    <div class="netprice"><?php echo __("order-tracking-grand-total-price"); ?><br>
                                                        <h2>
                                                            <strong>₱ <?php echo number_format($data['sub_total'], 2); ?></strong>
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div style="line-height:0em;">
                                                    <img src="<?php echo Theme::asset()->usePath()->url('images/bg_conclusion_box_bottom.png'); ?>" width="204" height="7" alt="">
                                                </div>
                                                <!--end conclusion-->
                                            </div>
                                            <div class="clear"></div>
                                            <div>
                                                <div id="more-detail">
                                                    <a href="<?php echo URL::to('checkout/thank-you') . '?order_id=' . $data['id']; ?>" target="_blank" title="More detail"><?php echo __("order-tracking-more-detail"); ?></a>
                                                </div>
                                                <div id="print">
                                                    <a href="#" onclick="window.print()"><?php echo __("order-tracking-print"); ?></a>
                                                </div>
                                            </div>
                                            <div class="clear"></div>
                                            <!--end order_boxcart-->
                                        </div>
                                        <div class="clear"></div>
                                        <!--End block_conclusion-->
                                    </div>

                                    <?php if (!empty($data['shipments'][0]['shipment_items'])): //alertd($data);   ?>
                                        <div id="block_productlist">

                                            <div id="prolist_box_top">
                                                <div class="prolist_topic pronum"><?php echo __("order-tracking-no"); ?></div>
                                                <div class="prolist_topic proitem"><?php echo __("order-tracking-list-item"); ?></div>
                                                <div class="prolist_topic proimg">&nbsp;</div>
                                                <div class="prolist_topic proprice"><?php echo __("order-tracking-price-per-item"); ?> (<strong>₱</strong>)</div>
                                                <div class="prolist_topic proqty"><?php echo __("order-tracking-units"); ?></div>
                                                <div class="prolist_topic prototal"><?php echo __("order-tracking-overall-price"); ?> (<strong>₱</strong>)</div>
                                                <div class="prolist_topic prorate"><?php echo __("order-tracking-tracking-number"); ?></div>
                                                <div class="clear"></div>
                                            </div>
                                            <?php $vendor_count = 1;?>
                                            <?php foreach ($data['shipments'] as $shipment): ?>
                                                <div id="prolist_box_headline">
                                                    <div class="prolist_box_headline_detail">
                                                        <span>
                                                            <?php echo __("order-tracking-product-of-shop"); ?>:
                                                            <?php //echo $shipment['vendor']['name'];
                                                                echo __('replace-shop-name');
                                                            ?>
                                                            (<?php echo __('replace-vendor-name').' '.$vendor_count;$vendor_count++;?>)
                                                        </span>
                                                            (<?php echo $shipment['items_count']; ?> <?php echo __("order-tracking-piece"); ?>)
                                                    </div>
                                                </div>

                                                <?php $totalPriceShipment = 0; ?>
                                                <?php $totalDiscountShipment = 0; ?>

                                                <?php foreach ($shipment['shipment_items'] as $item): ?>
                                                    <?php $totalDiscountShipment += $item['discount']; ?>
                                                    <?php $totalPriceShipment += $item['total_price']; ?>
                                                    <div>
                                                        <div class="prolist pronum"><?php echo $item['id']; ?></div>
                                                        <div class="prolist proitem"><?php echo $item['name']; ?></div>
                                                        <div class="proimg"><img src="<?php echo $item['images']; ?>" alt="" width="105" height="105"></div>
                                                        <div class="prolist proprice"><?php echo number_format($item['price'], 2); ?></div>
                                                        <div class="prolist proqty"><?php echo number_format($item['quantity'], 0); ?></div>
                                                        <div class="prolist prototal"><?php echo number_format($item['total_price'], 2); ?></div>
                                                        <div class="prolist prorate"><?php
                                                            if (!empty($item['item_status'])):
                                                                if (App::getLocale() == 'th') :
                                                                    $item_status = array_get($item, 'item_status');
                                                                    echo array_get($th_shipment_status, $item_status);
                                                                else:
                                                                    echo $item['item_status'];
                                                                endif;
                                                            endif;
                                                            ?><?php if (!empty($item['tracking_number']) && tracking_type($item['tracking_number']) == "TNT"): ?>
                                                                <a style="color:#0000FF;" data-order-id="<?php echo $data['id']; ?>" data-tracking-number="<?php echo $item['tracking_number']; ?>" href="javascript:void(0);" class="tnt-order-btn">(<?php echo $item['tracking_number']; ?>)</a>
                                                            <?php elseif (!empty($item['tracking_number'])): ?>
                                                                (<?php echo $item['tracking_number']; ?>)
                                                            <?php else: ?>
                                                                -
                                                            <?php endif; ?>
                                                            <div class="clear"></div>
                                                        </div>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <?php endforeach; ?>
                                                    <div class="clear"></div>
                                                    <div style="background-color: #ddd;overflow: auto;padding:  15px;">
                                                        <span style="float: left"><b><?php echo __("order-tracking-shipment-method"); ?></b>: <?php echo $shipment['method']['name']; ?> (<?php echo $shipment['method']['description']; ?>)</span>
                                                        <span style="float: right"><b><?php echo __("order-tracking-shipment-price"); ?></b> : <?php echo $shipment['shipping_fee'];//number_format($shipment['shipping_fee'], 2); ?> <?php echo __("order-tracking-baht"); ?></span>
                                                        <div class="clearfix"></div>
                                                        <span style="float: right"><b><?php echo __("order-tracking-discount"); ?></b>: <?php echo $totalDiscountShipment//number_format($data['total_discount'], 2);//; ?> <?php echo __("order-tracking-baht"); ?></span>
                                                        <div class="clearfix"></div>
                                                        <span style="float: right"><b><?php echo __("order-tracking-overall-price"); ?></b>: <?php echo max($totalPriceShipment - $totalDiscountShipment, 0);//number_format($data['sub_total'], 2);// ?> <?php echo __("order-tracking-baht"); ?></span>
                                                        <div class="clearfix"></div>
                                                        <span style="float: left"><b><?php echo __("order-tracking-shipment-status"); ?></b>: <?php
                                                            if (!empty($shipment['shipment_status'])):
                                                                if (App::getLocale() == 'th') :
                                                                    echo array_get($th_shipment_status, $shipment['shipment_status']);
                                                                else:
                                                                    echo $shipment['shipment_status'];
                                                                endif;
                                                            else:
                                                                echo '-';
                                                            endif;
                                                            ?></span>
                                                        <span style="float: right"><b><?php echo __("order-tracking-tracking-number"); ?></b> : 
                                                            <?php if (!empty($shipment['tracking_number']) && tracking_type($shipment['tracking_number']) == "TNT"): ?>
                                                                <a style="color:#0000FF;" data-order-id="<?php echo $data['id']; ?>" data-tracking-number="<?php echo $shipment['tracking_number']; ?>" href="javascript:void(0);" class="tnt-order-btn"><?php echo $shipment['tracking_number']; ?></a>
                                                            <?php elseif (!empty($shipment['tracking_number'])): ?>
                                                                <?php echo $shipment['tracking_number']; ?>
                                                            <?php else: ?>
                                                                -
                                                            <?php endif; ?>                                 
                                                        </span>
                                                    </div>
                                                    <div class="clear"></div>
                                                <?php endforeach; ?>
                                            </div>

                                        <?php endif; ?>

                                        <div style="margin-top:10px;"></div>					
                                    </div>
                                    <?php //endforeach;  ?>

                                </div>        

                            <?php else: ?>
                                <div id="msg-box" style="margin:30px auto;">
                                    <h2><?php echo trans('ordertracking.Description'); ?><?php echo __("order-tracking-there-is-no-order"); ?></h2>
                                    <p><a href="<?php echo URL::to(''); ?>" title="shopping" class="link_red12"><?php echo __("order-tracking-back-to-shopping"); ?></a></p>
                                </div>							
                            <?php endif; ?>

                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <!--end checkout_main -->
                <div class="clear"></div>
                <div style="margin-top:10px;"></div>
            </div>
            <div class="container_line"></div>
        </div>
    </div>
</div>

<div id="profile-dialog" class="reveal-modal">

    <div class="font2 msg-header"><?php echo __("order-tracking-cannot-insert-item-to-cart"); ?></div>
    <div id="popup_content">
        <div id="popup_message">
            <dl class="detail-cart">

                <dt><?php echo __("order-tracking-product"); ?></dt>
            </dl>
            <div class="clearfix"></div>
        </div>
        <div id="popup_panel">
            <input type="button" class="popup_ok btn cart-installment-button cart-installment-button_cancel" value="ยกเลิก">
        </div>
    </div>
</div>

<div id="alert-dialog" class="reveal-modal">
    <div class="font2 msg-header text-center alert-title"></div>
    <div id="popup_message" class="alert-message"></div>
    <div id="popup_panel">
        <input type="button" class="popup_ok btn btn-success" value="ตกลง">
    </div>
</div>

<!-- [S] TNT tracking lightbox -->
<?php echo Theme::partial("TNTTrackOrder", array()); ?>
<!-- [E] TNT tracking lightbox -->