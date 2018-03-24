<div class="sub-content headline" >
    <div class="box-done">
        <div class="in-form">
			<?php
				$icon = '';
				if($data['payment_status'] == 'waiting' && $data['payment_channel'] == 'online')
				{
					$icon = 'icon-wait';
				}
				else
				{
					if($data['payment_status'] == 'expired' || $data['payment_status'] == 'failed')
					{
						$icon = 'icon-cancel';
					}
				}
			?>


                        <div class="thank-icon clr-2 <?php echo $icon?>">
				<?php if($data['payment_status'] == 'waiting' && $data['payment_channel'] == 'online'):?>
					<h1><?php echo __('requery-header'); ?></h1>
					<br />
					<div style="color: #999; width: 780px; margin: 0 auto; text-align: left;">
						<?php echo __('requery-content'); ?>
					</div>

				<?php elseif($data['payment_status'] == 'waiting' && $data['payment_channel'] == 'offline'):?>
					<h1><?php echo __("offline-waiting-header"); ?></h1>
					<br />
					<div><?php echo __("offline-waiting-content"); ?></div>
				<?php else:?>
					<?php if($data['payment_status'] == 'expired' || $data['payment_status'] == 'failed'):?>
						<h1><?php echo __('expired-header'); ?></h1>
						<br />
                        <div>
                        <?php
                        if (array_get($data, 'payment_channel') === 'online' && strtolower( $data['payment_method_code'] ) == 'ccw')
                        {
                            echo __('ccw-fail-content');
                        }else{
                            echo __('expired-content');
                        }
                        ?>
						</div>
					<?php elseif($data['payment_status'] == 'success' || $data['payment_status'] == 'reconcile'):?>
						<h1><?php echo __("thankyou-success-title"); ?></h1>
						<br />
						<div><?php echo __("thankyou-success-description"); ?></div>
					<?php endif;?>
				<?php endif;?>
			</div>
            <div class="clear"></div>
            <div class="success-thank">

                <div class="success-box-main">
                    <div class="p-header">
                        <div class="p-logo"><img src="<?php echo Theme::asset()->usePath()->url('images/logo.jpg'); ?>" width="150" height="31" />
                            <p><a href="<?php echo URL::toLang("/"); ?>" alt="www.itruemart.com" title="www.itruemart.com">www.itruemart.com</a></p>
                        </div>
                        <div class="p-box2">
                            <div class="p-detail-2">
                                <p>
                                    <h2><?php echo __("thankyou-company-name"); ?></h2>
                                </p>
                                <p><?php echo __("thankyou-company-address"); ?></p>
                                <p><?php echo __("thankyou-company-contact-info"); ?></p>
                            </div>
                            <div class="clear"></div>
                            <div class="clear"></div>
                            <div class="clear"></div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="p-name">
                        <div class="p-box1">
                            <div class="p-label"><?php echo __("thankyou-customer-name-lbl"); ?> :</div>
                            <div class="p-detail" id="thank_customer_name"><?php echo (!empty($data['customer_name']))? $data['customer_name'] : "" ; ?></div>
                            <div class="clear"></div>
                            <div class="p-label"><?php echo __("thankyou-customer-phone-lbl"); ?> :</div>
                            <div class="p-detail" id="thank_phone_number"><?php echo (!empty($data['customer_tel']))? $data['customer_tel'] : "" ; ?></div>
                            <div class="clear"></div>
                            <div class="p-label"><?php echo __("thankyou-customer-email-lbl"); ?> :</div>
                            <div class="p-detail" id="thank_email"><?php echo (!empty($data['customer_email']))? $data['customer_email'] : "" ; ?></div>
                            <div class="clear"></div>
                            <div class="clear"></div>
                        </div>
                        <div class="p-box3">
                            <div class="p-label"><?php echo __("thankyou-customer-address-lbl"); ?> :</div>
                            <div class="p-detail" id="thank_shipping_address">
                                <?php
                                    $address = '';
                                    $address .= (!empty($data['customer_address']))? htmlentities($data['customer_address']) . " " : "";

                                    if(!empty($data['customer_province']) && !empty($data['customer_district'])){
                                       $address .= ($data['customer_province'] == 'กรุงเทพมหานคร')? __("step2-special-subdistrict") . " " :  __("step2-subdistrict") . " ";
                                    }
                                    $address .= (!empty($data['customer_district']))? $data['customer_district'] . " " : "";

                                    if(!empty($data['customer_province']) && !empty($data['customer_city'])){
                                        $address .= ($data['customer_province'] == 'กรุงเทพมหานคร')? __("step2-special-district") . " " : __("step2-district") . " ";
                                    }
                                    $address .= (!empty($data['customer_city']))? $data['customer_city'] . " " : '';
                                    $address .= (!empty($data['customer_province']) && $data['customer_province'] != 'กรุงเทพมหานคร' && $data['customer_province'] != 'BANGKOK')? __("step2-province") . " " : "";
                                    $address .= (!empty($data['customer_province']))? $data['customer_province'] . " " : "";
                                    $address .= (!empty($data['customer_postcode']))? $data['customer_postcode'] . " " : "";
                                    echo $address;
                                ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                        <div class="p-box4 invoice">
                            <div class="p-label"><?php echo __("thankyou-customer-billing-addr-lbl"); ?> :</div>
                            <div class="p-detail" id="thank_billing_address">
                                <?php
                                    $address = '';
                                    $address .= (!empty($data['billing_address_address']))? htmlentities($data['billing_address_address']) . " " : "";

                                    if(!empty($data['billing_address_province']) && !empty($data['billing_address_district'])){
                                       $address .= ($data['billing_address_province'] == 'กรุงเทพมหานคร')? __("step2-special-subdistrict") . " " :  __("step2-subdistrict") . " ";
                                    }
                                    $address .= (!empty($data['billing_address_district']))? $data['billing_address_district'] . " " : "";

                                    if(!empty($data['billing_address_province']) && !empty($data['billing_address_city'])){
                                        $address .= ($data['billing_address_province'] == 'กรุงเทพมหานคร')? __("step2-special-district") . " " : __("step2-district") . " ";
                                    }
                                    $address .= (!empty($data['billing_address_city']))? $data['billing_address_city'] . " " : '';
                                    $address .= (!empty($data['billing_address_province']) && $data['billing_address_province'] != 'กรุงเทพมหานคร' && $data['billing_address_province'] != 'BANGKOK')? __("step2-province") . " " : "";
                                    $address .= (!empty($data['billing_address_province']))? $data['billing_address_province'] . " " : "";
                                    $address .= (!empty($data['billing_address_postcode']))? $data['billing_address_postcode'] . " " : "";
                                    echo $address;
                                ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="p-order">
                        <h2><?php echo __("thankyou-order-list-title"); ?></h2>
                        <div class="p-title">
                            <div class="p-title-p"><?php echo __("cart-product-lbl"); ?></div>
                            <div class="p-title-c"><?php echo __("cart-price-per-product"); ?></div>
                            <div class="p-title-n"><?php echo __("cart-number-of-product-lbl"); ?></div>
                            <div class="p-title-n-s"><?php echo __("fullcart-product-price-lbl"); ?></div>
                            <div class="clear"></div>
                        </div>
                        <?php if(!empty($ecommerce['shipments'])): ?>
                            <?php $vendor_count = 1; ?>
                            <?php
                                $show_group = false;
                                if(count($ecommerce['shipments']) > 1)
                                {
                                    $show_group = true;
                                }
                            ?>

                            <?php foreach($ecommerce['shipments'] as $key=>$shipment): ?>
                                <div>

                                    <div class="clear"></div>
                                    <?php foreach($shipment['items'] as $key=>$item): ?>
                                        <div class="p-row">
                                            <div class="p-title-p p-non-bor"><?php echo array_get($item, 'name'); ?><br />
                                            <b><?php echo __('Payment-Status'); ?> : </b> 
                                            <?php echo array_get($item, 'payment_status_customer', '-')?><br />


                                            <b><?php echo __('Order-Status'); ?> : </b>
                                            <?php
                                            $item_status_customer = array_get($item, 'item_status_customer', '-');
                                            if ($item_status_customer == '-') {
                                                $item_status_customer = __('order-tracking-item-status-default');
                                            }
                                            ?>
                                            <?php echo $item_status_customer;?>
                                            <br />

                                            <b><?php echo __('tracking-no-title'); ?> : </b>
                                            <?php
                                                $tracking_num = array_get($item, 'tracking_number', NULL);
                                                if(empty($tracking_num))
                                                {
                                                    $tracking_num =  __("not-found-tracking");
                                                }
                                                echo $tracking_num;
                                            ?>
                                            <br />

                                            <b><?php echo __('delivery-periods-txt'); ?> : </b>
                                            <br/>

                                            <?php
                                                $deliver_date = '';
                                                $expected_delivery_min = array_get($item, 'expected_delivery_min', NULL);
                                                $expected_delivery_max = array_get($item, 'expected_delivery_max', NULL);

                                                if(!empty($expected_delivery_min) && !empty($expected_delivery_max))
                                                {
                                                    $deliver_date = $expected_delivery_min.' - '.$expected_delivery_max;
                                                }
                                                else
                                                {
                                                    if(!empty($data['ordered_date']['date']))
                                                    {
                                                        $deliver_date = deliveryPeriod($data['ordered_date']['date']);
                                                    }
                                                }
                                            ?>
                                            <span class="alert-2"><?php echo $deliver_date; ?></span>

                                            <div class="p-title-c p-non-bor"></div>
                                            <br />

                                            </div>
                                            <div class="p-title-c p-non-bor">
                                            <?php if($item['price'] != $item['net_price']): ?>
                                                    <span class="alert"><?php echo number_format(array_get($item, 'price'),2); ?></span><br />
                                                    <span class="line-through"><?php echo number_format(array_get($item, 'net_price'),2); ?></span><br />
                                                    <?php echo __("cart-discount-percent-lbl"); ?> <?php echo floor( (( array_get($item, 'net_price') -  array_get($item, 'price')) / array_get($item, 'net_price') ) * 100); ?>%
                                            <?php else: ?>
                                                <span><?php echo number_format(array_get($item, 'price'),2); ?></span><br />
                                            <?php endif; ?>
                                            </div>

                                            <div class="p-title-n p-non-bor"><?php echo array_get($item, "quantity"); ?></div>
                                            <div class="p-title-n-s p-non-bor"><?php echo number_format(array_get($item, 'total_price'),2); ?></div> 

                                            <div class="clear"></div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div>
                            <div class="p-sum-bar">
                            </div>
                            <?php if(!empty($ecommerce['shipments_summary'])): ?>
                                <div class="p-sum-footer">
                                    <?php if(!empty($ecommerce['shipments_summary']['total_price'])): ?>
                                        <div class="p-row-sum">
                                            <div class="p-title-c p-non-bor p-text-r"><?php echo __("cart-cost-lbl"); ?></div>
                                            <div class="p-title-n-s p-non-bor p-text-r">
                                                <?php if($ecommerce['shipments_summary']['total_price'] > 0) {
                                                    echo number_format($ecommerce['shipments_summary']['total_price'],2);
                                                }else{
                                                    echo '0';
                                                }?>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="clear"></div>
                                    <?php endif; ?>

                                    <?php if(isset($ecommerce['shipments_summary']['total_shipping_fee'])): ?>
                                        <div class="p-row-sum">
                                            <div class="p-title-c p-non-bor p-text-r"><?php echo __("cart-total-delivery-fare"); ?></div>
                                            <div class="p-title-n-s p-non-bor p-text-r <?php echo ($ecommerce['shipments_summary']['total_shipping_fee'] == 0)? "text-green" : ""; ?>">
                                                <?php if($ecommerce['shipments_summary']['total_shipping_fee'] > 0){
                                                    echo number_format($ecommerce['shipments_summary']['total_shipping_fee'],2);
                                                }else{
                                                    echo __("cart-free-lbl");
                                                } ?>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="clear"></div>
                                    <?php endif; ?>
                                    <?php if(isset($ecommerce['shipments_summary']['discount'])): ?>
                                        <div class="p-row-sum">
                                            <div class="p-title-c p-non-bor p-text-r"><?php echo __("cart-discount-lbl"); ?></div>
                                            <div class="p-title-n-s p-non-bor p-text-r">
                                            <?php if($ecommerce['shipments_summary']['discount'] > 0){
                                                    echo "-" . number_format($ecommerce['shipments_summary']['discount'],2);
                                                }else{
                                                    echo '0.00';
                                                }?>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    <div class="clear"></div>
                                    <?php endif; ?>
									<?php if($ecommerce['shipments_summary']['sub_total'] == NULL){ $ecommerce['shipments_summary']['sub_total'] = 0; }  ?>
                                    <?php if(isset($ecommerce['shipments_summary']['sub_total'])): ?>
                                    <div class="p-row-sum p-bg-sum">
                                        <div class="p-title-c p-non-bor p-text-r"><?php echo __("cart-total-price-lbl"); ?></div>
                                        <div class="p-title-n-s p-non-bor p-text-r">
                                            <span id="thank_total_pay">
                                            <?php if($ecommerce['shipments_summary']['sub_total'] > 0){
                                                echo number_format($ecommerce['shipments_summary']['sub_total'],2);
                                            }else{
                                                echo '0.00';
                                            } ?>
                                            </span>
                                            <br/>
                                            <small>(<?php echo __("cart-vat-included"); ?>)</small>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                    <?php endif; ?>
                                </div>
                                <div class="clear"></div>
                            <?php endif; ?>

                            <!-- [S] payment description -->
                            <?php if($data['payment_method_code'] == 'atm'): ?>
                                <div class="p-box-footer" >
                                    <ul class="nav nav-tabs how-to">
                                        <li class="active">
                                            <a href="#atm-kbank" data-toggle="tab"><img src="<?php echo Theme::asset()->usePath()->url('images/icon-kbank.png');?>" class="icon-bank"/><?php echo __("thankyou-atm-kbank-tab"); ?></a>
                                        </li>
                                        <li>
                                            <a href="#atm-scb" data-toggle="tab"><img src="<?php echo Theme::asset()->usePath()->url('images/icon-scb.jpg');?>" class="icon-bank"/><?php echo __("thankyou-atm-scb-tab"); ?></a>
                                        </li>
                                        <li>
                                            <a href="#atm-bangkok" data-toggle="tab"><img src="<?php echo Theme::asset()->usePath()->url('images/icon-bangkok.png');?>" class="icon-bank" /><?php echo __("thankyou-atm-bbank-tab"); ?></a>
                                        </li>
                                    </ul>
                                    <div class="panel panel-body-no-top">
                                        <div class="tab-content panel-body">
                                            <div id="atm-kbank" class="tab-pane how-to-desc active">
                                                <div class="text-center">
                                                    <img src="<?php echo Theme::asset()->usePath()->url('images/logo_kbank.jpg');?>">
                                                </div>
                                                <div>
                                                    <dl>
                                                        <dt><?php echo __("thankyou-atm-howto-title"); ?></dt>
                                                        <dd>
                                                            <ol>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step1"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step2"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step3"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step4"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step5"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step6"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step7"); ?></li>
                                                                <li><?php echo __("thankyou-atmkbank-howto-step8"); ?></li>
                                                            </ol>
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>
                                            <div id="atm-scb" class="tab-pane how-to-desc">
                                                <div class="text-center">
                                                    <img src="<?php echo Theme::asset()->usePath()->url('images/logo_scb.jpg');?>">
                                                </div>
                                                <div>
                                                    <dl>
                                                        <dt><?php echo __("thankyou-atm-howto-title"); ?></dt>
                                                        <dd>
                                                            <ol>
                                                                <li><?php echo __("thankyou-atmscb-howto-step1"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step2"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step3"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step4"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step5"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step6"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step7"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step8"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step9"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step10"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step11"); ?></li>
                                                                <li><?php echo __("thankyou-atmscb-howto-step12"); ?></li>
                                                            </ol>
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>
                                            <div id="atm-bangkok" class="tab-pane how-to-desc">
                                                <div class="text-center">
                                                    <img src="<?php echo Theme::asset()->usePath()->url('images/logo_bangkok.jpg');?>">
                                                </div>
                                                <div>
                                                    <dl>
                                                        <dt><?php echo __("thankyou-atm-howto-title"); ?></dt>
                                                        <dd>
                                                            <ol>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step1"); ?></li>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step2"); ?></li>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step3"); ?></li>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step4"); ?></li>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step5"); ?></li>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step6"); ?></li>
                                                                <li><?php echo __("thankyou-atmbangkok-howto-step7"); ?></li>
                                                            </ol>
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif($data['payment_method_code'] == 'ibank'): ?>
                                <div class="p-box-footer" >
                                    <ul class="nav nav-tabs how-to">
                                        <li class="active">
                                            <a href="#atm-kbank" data-toggle="tab"><img src="<?php echo Theme::asset()->usePath()->url('images/icon-kbank.png');?>" class="icon-bank"/><?php echo __("thankyou-atm-kbank-tab"); ?></a>
                                        </li>
                                        <li>
                                            <a href="#atm-scb" data-toggle="tab"><img src="<?php echo Theme::asset()->usePath()->url('images/icon-scb.jpg');?>" class="icon-bank"/><?php echo __("thankyou-atm-scb-tab"); ?></a>
                                        </li>
                                        <li>
                                            <a href="#atm-bangkok" data-toggle="tab"><img src="<?php echo Theme::asset()->usePath()->url('images/icon-bangkok.png');?>" class="icon-bank" /><?php echo __("thankyou-atm-bbank-tab"); ?></a>
                                        </li>
                                    </ul>
                                    <div class="panel panel-body-no-top">
                                        <div class="tab-content panel-body">
                                            <div id="atm-kbank" class="tab-pane how-to-desc active">
                                                <div class="text-center">
                                                    <img src="http://www.itruemart.com/assets/itruemart_responsive/global/images/logo_kbank.jpg">
                                                </div>
                                                <div>
                                                    <dl>
                                                        <dt><?php echo __("thankyou-atm-howto-title"); ?></dt>
                                                        <dd>
                                                            <ol>
                                                                <li><?php echo __("thankyou-ibankkbank-howto-step1"); ?></li>
                                                                <li><?php echo __("thankyou-ibankkbank-howto-step2"); ?></li>
                                                                <li><?php echo __("thankyou-ibankkbank-howto-step3"); ?></li>
                                                                <li><?php echo __("thankyou-ibankkbank-howto-step4"); ?></li>
                                                                <li><?php echo __("thankyou-ibankkbank-howto-step5"); ?></li>
                                                                <li><?php echo __("thankyou-ibankkbank-howto-step6"); ?>
                                                                    <ol>
                                                                        <li><?php echo __("thankyou-ibankkbank-howto-step6.1"); ?></li>
                                                                        <li><?php echo __("thankyou-ibankkbank-howto-step6.2"); ?></li>
                                                                        <li><?php echo __("thankyou-ibankkbank-howto-step6.3"); ?></li>
                                                                        <li><?php echo __("thankyou-ibankkbank-howto-step6.4"); ?></li>
                                                                        <li><?php echo __("thankyou-ibankkbank-howto-step6.5"); ?></li>
                                                                    </ol>
                                                                </li>
                                                                <li><?php echo __("thankyou-ibankkbank-howto-step7"); ?></li>
                                                                <li><?php echo __("thankyou-ibankkbank-howto-step8"); ?></li>
                                                                <li><?php echo __("thankyou-ibankkbank-howto-step9"); ?></li>
                                                            </ol>
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>
                                            <div id="atm-scb" class="tab-pane how-to-desc">
                                                <div class="text-center">
                                                    <img src="http://www.itruemart.com/assets/itruemart_responsive/global/images/logo_scb.jpg">
                                                </div>
                                                <div>
                                                    <dl>
                                                        <dt><?php echo __("thankyou-atm-howto-title"); ?></dt>
                                                        <dd>
                                                            <ol>
                                                                <li><?php echo __("thankyou-ibankscb-howto-step1"); ?></li>
                                                                <li><?php echo __("thankyou-ibankscb-howto-step2"); ?></li>
                                                                <li><?php echo __("thankyou-ibankscb-howto-step3"); ?></li>
                                                                <li><?php echo __("thankyou-ibankscb-howto-step4"); ?></li>
                                                                <li><?php echo __("thankyou-ibankscb-howto-step5"); ?></li>
                                                                <li><?php echo __("thankyou-ibankscb-howto-step6"); ?></li>
                                                                <li><?php echo __("thankyou-ibankscb-howto-step7"); ?>
                                                                    <p><?php echo __("thankyou-ibankscb-howto-step7-subtitle"); ?></p>
                                                                    <ol>
                                                                        <li><?php echo __("thankyou-ibankscb-howto-step7.1"); ?></li>
                                                                        <li><?php echo __("thankyou-ibankscb-howto-step7.2"); ?></li>
                                                                        <li><?php echo __("thankyou-ibankscb-howto-step7.3"); ?></li>
                                                                        <li><?php echo __("thankyou-ibankscb-howto-step7.4"); ?></li>
                                                                    </ol>
                                                                </li>
                                                                <li><?php echo __("thankyou-ibankscb-howto-step8"); ?></li>
                                                                <li><?php echo __("thankyou-ibankscb-howto-step9"); ?></li>
                                                                <li><?php echo __("thankyou-ibankscb-howto-step10"); ?></li>
                                                                <li><?php echo __("thankyou-ibankscb-howto-step11"); ?></li>
                                                                <li><?php echo __("thankyou-ibankscb-howto-step12"); ?></li>
                                                            </ol>
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>
                                            <div id="atm-bangkok" class="tab-pane how-to-desc">
                                                <div class="text-center">
                                                    <img src="http://www.itruemart.com/assets/itruemart_responsive/global/images/logo_bangkok.jpg">
                                                </div>
                                                <div>
                                                    <dl>
                                                        <dt><?php echo __("thankyou-atm-howto-title"); ?></dt>
                                                        <dd>
                                                            <ol>
                                                                <li><?php echo __("thankyou-ibankbangkok-howto-step1"); ?></li>
                                                                <li><?php echo __("thankyou-ibankbangkok-howto-step2"); ?></li>
                                                                <li><?php echo __("thankyou-ibankbangkok-howto-step3"); ?></li>
                                                                <li><?php echo __("thankyou-ibankbangkok-howto-step4"); ?></li>
                                                                <li><?php echo __("thankyou-ibankbangkok-howto-step5"); ?></li>
                                                                <li><?php echo __("thankyou-ibankbangkok-howto-step6"); ?></li>
                                                                <li><?php echo __("thankyou-ibankbangkok-howto-step7"); ?>
                                                                    <ol><p><?php echo __("thankyou-ibankbangkok-howto-step7-subtitle"); ?></p>
                                                                        <li><?php echo __("thankyou-ibankbangkok-howto-step7.1"); ?></li>
                                                                        <li><?php echo __("thankyou-ibankbangkok-howto-step7.2"); ?></li>
                                                                        <li><?php echo __('thankyou-ibankbangkok-howto-step7.3'); ?></li>
                                                                        <li><?php echo __('thankyou-ibankbangkok-howto-step7.4'); ?></li>
                                                                        <li><?php echo __('thankyou-ibankbangkok-howto-step7.5'); ?></li>
                                                                    </ol>
                                                                </li>
                                                                <li><?php echo __("thankyou-ibankbangkok-howto-step8"); ?></li>
                                                                <li><?php echo __("thankyou-ibankbangkok-howto-step9"); ?></li>
                                                                <li><?php echo __("thankyou-ibankbangkok-howto-step10"); ?></li>
                                                                <li><?php echo __("thankyou-ibankbangkok-howto-step11"); ?></li>
                                                                <li><?php echo __("thankyou-ibankbangkok-howto-step12"); ?></li>
                                                            </ol>
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif($data['payment_method_code'] == 'cod'): ?>
                                <div class="p-box-footer" ><?php echo __("thankyou-cod-howto-title"); ?><br />
                                    <ul class="payment-process-desc">
                                        <li><?php echo __("thankyou-cod-howto-step1"); ?></li>
                                        <li><?php echo __("thankyou-cod-howto-step2"); ?></li>
                                        <li><?php echo __("thankyou-cod-howto-step3"); ?></li>
                                        <li><?php echo __("thankyou-cod-howto-step4"); ?></li>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                            <?php endif; ?>
                            <!-- [E] payment description -->
                        </div>

                    </div>

                </div>
                <div class="success-box3">
                    <div>
                        <div class="p-box-right p-title-right">
                            <p><?php echo __("thankyou-order-no"); ?></p>
                            <div class="p-title-b">
                                <h2>
                                    <?php if($data['payment_method_code'] == 'ccw' || $data['payment_method_code'] == 'cod'): ?>
                                        <?php if(!empty($data['order_id'])){ echo '<span id="thank_order_id">'.$data['order_id'].'</span>'; } ?>
                                    <?php else: ?>
                                        <?php echo (!empty($data['payment_order_id']))? '<span id="thank_payment_id">'.$data['payment_order_id'].'</span>' : "";?> <?php if(!empty($data['order_id'])){ echo '(<span id="thank_order_id">'. $data['order_id'] .'</span>)'; } ?>
                                    <?php endif; ?>
                                </h2>
                            </div>
                        </div>
                        <?php if($data['payment_method_code'] != 'ccw' && $data['payment_method_code'] != 'cod' && $data['payment_method_code'] != 'ccinstm' && $data['payment_method_code'] != 'zero'): ?>
                            <div class="p-box-right p-title-right">
                                <p><?php echo __("thankyou-order-refno-1"); ?></p>
                                <div class="p-title-b">
                                    <h2 id="thank_ref1"><?php echo !empty($data['ref1'])? $data['ref1'] : ""; ?></h2>
                                </div>
                            </div>
                            <div class="p-box-right p-title-right">
                                <p><?php echo __("thankyou-order-refno-2"); ?></p>
                                <div class="p-title-b">
                                    <h2 id="thank_ref2"><?php echo !empty($data['ref2'])? $data['ref2'] : ""; ?></h2>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="p-box-right p-title-right">
                            <p><?php echo __("thankyou-order-date"); ?></p>
                            <div class="p-title-b">
                                <h2 id="thank_order_date"><?php if(!empty($data['ordered_date']['date'])){ echo formatDate($data['ordered_date']['date'], "d F y", Lang::getLocale()); } ?></h2>
                            </div>
                        </div>
                        <?php if(isset($data["payment_method_code"]) && $data["payment_method_code"] != "zero"): ?>
                            <div class="p-box-right p-title-right">
                                <p><?php echo __("thankyou-order-payment-channel"); ?></p>
                                <!-- [S] Payment Channel right side -->
                                <?php if($data['payment_method_code'] == 'ccw'): ?>
                                    <div>
                                        <div class="p-title-b-pay "><h2 id="thank_payment_channel"><?php echo __("thankyou-ccw-payment-title"); ?></h2></div>
                                        <!--<p><img src="<?php /*echo Theme::asset()->usePath()->url('images/visa_banner.png'); */?>" /></p><br />-->
                                        <p><img src="<?php echo Theme::asset()->usePath()->url('images/thank_visa.png?random='.random_string('numeric', 4)); ?>" /></p><br />
                                        <p id="thank_payment_channel_detail"><?php echo __("thankyou-ccw-payment-desc"); ?></p>
                                    </div>
                                <?php elseif($data['payment_method_code'] == 'atm'): ?>
                                    <div>
                                        <div class="p-title-b-pay "><h2 id="thank_payment_channel"><?php echo __("thankyou-atm-payment-title"); ?></h2></div>
                                        <!--<img src="<?php /*echo Theme::asset()->usePath()->url('images/bank_banner.png');*/?>" width="156" /></p><br />-->
                                        <img src="<?php echo Theme::asset()->usePath()->url('images/thank_atm.png?random='.random_string('numeric', 4));?>" /></p><br />
                                        <p id="thank_payment_channel_detail"><?php echo __("thankyou-atm-payment-desc"); ?></p>
                                        <ul>
                                            <li>
                                                <span class="clr-8">*</span>
                                                <?php echo __("thankyou-atm-payment-notice1"); ?>
                                            </li>
                                        </ul>
                                    </div>
                                <?php elseif($data['payment_method_code'] == 'ibank'): ?>
                                    <div>
                                        <div class="p-title-b-pay "><h2 id="thank_payment_channel"><?php echo __("thankyou-ibank-payment-title"); ?></h2></div>
                                        <!--<p><img src="<?php /*echo Theme::asset()->usePath()->url('images/bank_banner.png'); */?>" width="156" height="72" /></p><br />-->
                                        <p><img src="<?php echo Theme::asset()->usePath()->url('images/thank_ibank.png?random='.random_string('numeric', 4)); ?>"  /></p><br />
                                        <p id="thank_payment_channel_detail"><?php echo __("thankyou-ibank-payment-desc"); ?></p>
                                        <ul class="pm-rm-notice">
                                            <li>
                                                <span class="clr-8">*</span>
                                                <?php echo __("thankyou-ibank-payment-notice1"); ?>
                                            </li>
                                        </ul>
                                    </div>
                                <?php elseif($data['payment_method_code'] == 'banktrans'): ?>
                                    <div>
                                        <div class="p-title-b-pay "><h2 id="thank_payment_channel"><?php echo __("thankyou-banktrans-payment-title"); ?></h2></div>
                                        <!--<p><img src="<?php /*echo Theme::asset()->usePath()->url('images/bank_banner.png'); */?>" width="156" /></p><br />-->
                                        <p><img src="<?php echo Theme::asset()->usePath()->url('images/thank_banktrans.png?random='.random_string('numeric', 4)); ?>" /></p><br />
                                        <p id="thank_payment_channel_detail"><?php
                                            $print_link = URL::toLang("checkout/print?order_id=") . ( !empty($data['order_id'])? $data['order_id'] : "" );
                                            echo sprintf(__("thankyou-banktrans-payment-desc"), $print_link); ?></p>
                                        <ul class="pm-rm-notice">
                                            <li><span style="color: red">*</span><?php echo __("thankyou-banktrans-payment-notice1"); ?></li>
                                        </ul>
                                    </div>
                                <?php elseif($data['payment_method_code'] == 'cs'): ?>
                                    <div>
                                        <div class="p-title-b-pay "><h2 id="thank_payment_channel"><?php echo __("thankyou-cs-payment-title"); ?></h2></div>
                                        <!--<p><img src="<?php /*echo Theme::asset()->usePath()->url('images/counter_service.png'); */?>" width="156" /></p><br />-->
                                        <p><img src="<?php echo Theme::asset()->usePath()->url('images/thank_cs.png?random='.random_string('numeric', 4)); ?>"  /></p><br />
                                        <p id="thank_payment_channel_detail"><?php echo __("thankyou-cs-payment-desc"); ?></p>
                                        <div>
                                            <ul>
                                                <li><span class="clr-8">*</span><?php echo __('thankyou-cs-payment-notice1'); ?></li>
                                            </ul>
                                        </div>
                                        <?php if ( ! empty($data['barcode'])) : ?>
                                        <p><img id="thank_barcode" src="<?php echo $data['barcode'] ?>" width="240px;"></p>
                                        <?php endif; ?>
                                        <?php //alert($data); ?>
                                    </div>
                                <?php elseif($data['payment_method_code'] == 'cod'): ?>
                                    <div>
                                        <div class="p-title-b-pay "><h2 id="thank_payment_channel"><?php echo __("thankyou-cod-payment-title"); ?></h2></div>
                                        <p><img src="<?php echo Theme::asset()->usePath()->url('images/thank_cod.png?random='.random_string('numeric', 4)); ?>"  /></p><br />
                                        <p id="thank_payment_channel_detail"><?php echo __("thankyou-cod-payment-desc"); ?></p>
                                    </div>
                                <?php elseif($data['payment_method_code'] == 'ccinstm'): ?>
                                    <div>
                                        <div class="p-title-b-pay "><h2 id="thank_payment_channel"><?php echo __("thankyou-ccinstm-payment-title").' '.$data['installment'].' '.__('step3-month'); ?></h2></div>
                                        <p>
                                            <?php if( !empty($data["installment_bank"]["abbreviation"]) && $data["installment_bank"]["abbreviation"] == "bay" ) : ?>
                                                <img src="<?php echo Theme::asset()->url("images/icn/inst_bay.png"); ?>" />
                                            <?php elseif( !empty($data["installment_bank"]["abbreviation"]) && $data["installment_bank"]["abbreviation"] == "centralcard" ) : ?>
                                                <img src="<?php echo Theme::asset()->url("images/icn/inst_central.png"); ?>"  />
                                            <?php elseif( !empty($data["installment_bank"]["abbreviation"]) && $data["installment_bank"]["abbreviation"] == "firstchoice" ) : ?>
                                                <img src="<?php echo Theme::asset()->url("images/icn/inst_firstchoice.png"); ?>" />
                                            <?php elseif( !empty($data["installment_bank"]["abbreviation"]) && $data["installment_bank"]["abbreviation"] == "tescolotus" ) : ?>
                                                <img src="<?php echo Theme::asset()->url("images/icn/inst_tesco.png"); ?>" height="66" />
                                            <?php elseif( !empty($data["installment_bank"]["abbreviation"]) && $data["installment_bank"]["abbreviation"] == "ktc" ): ?>
                                                <img src="<?php echo Theme::asset()->url("images/icn/inst_ktc.jpg"); ?>" />
                                            <?php elseif( !empty($data["installment_bank"]["abbreviation"]) && $data["installment_bank"]["abbreviation"] == "bbl" ): ?>
                                                <img src="<?php echo Theme::asset()->url("images/icn/inst_bbl.png"); ?>" />
                                            <?php else : ?>
                                                <img src="http://www.nitithamclinic.com/news_image/33_18072012154305_0.jpg" height="66" />
                                            <?php endif ; ?>
                                        </p><br />
                                        <p id="thank_payment_channel_detail"><?php echo __("thankyou-ccinstm-payment-desc"); ?></p>
                                    </div>
                                <?php endif; ?>
                                <!-- [E] Payment Channel right side -->
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <div class="print-box">
                <div class="print"><a href="javascript:window.print();"><?php echo __("thankyou-print-btn"); ?></a></div>
                <div class="next_shop"><a href="<?php echo URL::toLang("/"); ?>"><?php echo __("thankyou-goto-home"); ?></a></div>
                <div class="clear"></div>
            </div>
            <div class="success-box-footer"> <?php echo __("thankyou-footer-success-txt"); ?> </div>
        </div>
        <div class="box-footer"> <br />
            <div class="success-box-contact"> <?php echo __("thankyou-footer-success-contact-phone"); ?><br />
                 <?php echo __("thankyou-footer-success-contact-time"); ?></div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>


<!-- ALL Analytic -->
<?php if ($data['analytics_status'] == "N" && (App::environment('production') || App::environment('alpha') || App::environment('aws-staging'))): ?>
    <?php
    // ########################## Google Tag ########################################
    $tracking = '';
    $tracking .= "
var transactionId =  '". $data['order_id'] ."';
var cartProducts = [];
var affil = 'itruemart.com';
var google_transaction_total= ".$ecommerce["shipments_summary"]["sub_total"].";
";
    $sum = 0;
    // items
    // start loop
    $fb_item_arr = array();
    if(!empty($ecommerce["order_item"])){
        foreach($ecommerce["order_item"] as $key => $item) {
            $tracking .= "cartProducts.push({
                    'id': '". $item["product_pkey"] ."',
                    'name': '" . $item["name"] .  "',   // product name
                    'category': '" . $item["category"] . "',    // category name
                    'brand': '" . $item["brand"] . "',    // brand name
                    'price': ". $item["price_per_unit"] .",       // unit product price without tax and shipping
                    'quantity': " . $item["quantity"] . "         // item count
                });";

            $sum += $item["quantity"];

            $fb_item_arr[] = array(
                'price'=> $item['price_per_unit'],
                'product_id'=> $item['product_pkey'],
                'product_category' => $item['category'],
                'product_name' => $item["name"]
            );
        }
    }

    // end loop

//     $tracking .= "
// dataLayer.push({
//     'transactionId': transactionId,
//     'transactionAffiliation': affil,
//     'transactionTotal': ".$ecommerce["shipments_summary"]["sub_total"].",             // total renevue
//     'transactionTax': 0,               // tax
//     'transactionShipping': ".$ecommerce["shipments_summary"]["total_shipping_fee"].",        	 // shipping
//     'transactionProducts': cartProducts,
//     'country': '".$ecommerce["order"]["country"]."',	 // Custom Dimension 1
//     'province': '".$ecommerce["order"]["customer_province"]."',	 // Custom Dimension 2
//     'city': '".$ecommerce["order"]["customer_city"]."', // Custom Dimension 3
//     'total_revenue': 0, // Custom Dimension 4
//     'total_quantity': ".$sum.",	 // Custom Dimension 5
//     'event': 'trackTrans'
// });";

    $tracking .= "
dataLayer.push({
  'ecommerce': {
    'purchase': {
      'actionField': {
        'id': transactionId,                         // Transaction ID. Required for purchases and refunds.
        'affiliation': affil,
        'revenue': '".$ecommerce["shipments_summary"]["sub_total"]."',                     // Total transaction value (incl. tax and shipping)
        'tax':'0',
        'shipping': '".$ecommerce["shipments_summary"]["total_shipping_fee"]."',
      },
      'products': cartProducts
    }
  }
});";


    Theme::asset()->container("footer")->writeScript('analytic-goal', $tracking);

    ### marketing tag ###
    if(!empty($fb_item_arr))
    {
        $order_item_json = array();
        foreach ($fb_item_arr as $item) {
            $order_item = array();
            foreach ($item as $key => $value) {
                $order_item[] = sprintf('"%s":"%s"', $key, htmlspecialchars($value));
            }
            $order_item_json[] = "{" . implode(',', $order_item) . "}";
        }
        // $order_item_json = json_encode($fb_item_arr);
        $order_item_json = "[" . implode(',', $order_item_json) . "]";
        $fb_marketing_tag = 'var itma_item_arr = '.$order_item_json.';';
        $fb_marketing_tag .= '
        var itma_value = "'.$ecommerce["shipments_summary"]["sub_total"].'";';
        Theme::append('marketing_tag', $fb_marketing_tag);
    }

    // ########################## END Google Tag ########################################
    ?>

    <!-- [S] ajax to set analytics flag to Y -->
    <script type="text/javascript">

        $(document).ready(function(){
            $.ajax({
                url: "/ajax/checkout/set-analytics-status",
                type: "POST",
                data: { order_id :  <?php echo $data['order_id']; ?>, analytics_status : 'Y'},
                dataType: "json",
                success: function(res){
                    //console.log(res);
                }
            });
        });

    </script>
    <!-- [E] ajax to set analytics flag to Y -->
<?php endif;?>