<?php
    if (array_get($data, 'payment_channel') === 'offline')
    {
        if (array_get($data, 'payment_status') === 'reconcile')
        {
            $thankyou_header = __("thankyou-success-title");
            $thankyou_content = __("thankyou-success-description");
            $image = 'ss_thank.png';
            $status = 'success';
            $status_class = 'text-complete';
        } else if(array_get($data, 'payment_status') === 'failed')
        {
            $thankyou_header = __("expired-header");
            $thankyou_content = __("expired-content");
            $image = 'error_thank.png';
            $status = 'error';
            $status_class = 'text-fail';
        } else if(array_get($data, 'payment_status') === 'waiting' && strtolower( $data['payment_method_code'] ) == 'cod')
        {
            $thankyou_header = __("offline-cod-waiting-header");
            $thankyou_content = __("offline-cod-waiting-content");
            $image = 'ss_thank.png';
            $status = 'wait';
            $status_class = 'text-complete';
        }else if(array_get($data, 'payment_status') === 'waiting')
        {
            $thankyou_header = __("offline-waiting-header");
            $thankyou_content = __("offline-waiting-content");
            $image = 'ss_thank.png';
            $status = 'wait';
            $status_class = 'text-complete';
        } else {
            //Default is "waiting".
            $thankyou_header = __("offline-waiting-header");
            $thankyou_content = __("offline-waiting-content");
            $image = 'clock_thank.png';
            $status = 'wait';
            $status_class = 'text-waiting';
        }
    } else if (array_get($data, 'payment_channel') === 'online' && strtolower( $data['payment_method_code'] ) == 'ccw')
    {
        if (array_get($data, 'payment_status') === 'success')
        {
            $thankyou_header = __("thankyou-success-title");
            $thankyou_content = __("thankyou-success-description");
            $image = 'ss_thank.png';
            $status = 'success';
            $status_class = 'text-complete';
        } else if(array_get($data, 'payment_status') === 'failed')
        {
            $thankyou_header = __("expired-header");
            $thankyou_content = __("ccw-fail-content");
            $image = 'error_thank.png';
            $status = 'error';
            $status_class = 'text-fail';
        }else if(array_get($data, 'payment_status') === 'waiting')
        {
            $thankyou_header = __("requery-header");
            $thankyou_content = __("requery-content");
            $image = 'clock_thank.png';
            $status = 'requery';
            $status_class = 'text-waiting';
        }else {
            // Default is waiting.
            $thankyou_header = __("requery-header");
            $thankyou_content = __("requery-content");
            $image = 'clock_thank.png';
            $status = 'requery';
            $status_class = 'text-waiting';
        }
    } else if( array_get($data, 'payment_channel') === 'online' ) {
        if (array_get($data, 'payment_status') === 'reconcile')
        {
            $thankyou_header = __("thankyou-success-title");
            $thankyou_content = __("thankyou-success-description");
            $image = 'ss_thank.png';
            $status = 'success';
            $status_class = 'text-complete';
        } else if(array_get($data, 'payment_status') === 'failed')
        {
            $thankyou_header = __("expired-header");
            $thankyou_content = __("ccw-fail-content");
            $image = 'error_thank.png';
            $status = 'error';
            $status_class = 'text-fail';
        }else if(array_get($data, 'payment_status') === 'waiting')
        {
            $thankyou_header = __("requery-header");
            $thankyou_content = __("requery-content");
            $image = 'clock_thank.png';
            $status = 'requery';
            $status_class = 'text-waiting';
        }else if(array_get($data, 'payment_status') === 'success'){
            $thankyou_header = __("thankyou-success-title");
            $thankyou_content = __("thankyou-success-description");
            $image = 'ss_thank.png';
            $status = 'success';
            $status_class = 'text-complete';
        } else {
            // Default is "waiting"
            $thankyou_header = __("requery-header");
            $thankyou_content = __("requery-content");
            $image = 'clock_thank.png';
            $status = 'requery';
            $status_class = 'text-waiting';
        }
    }
?>


<div class="row">
    <div class="col-sm-12 text-center chekout-info-complete">
        <img src="<?php echo Theme::asset()->usePath()->url('images/' . $image); ?>"/>
        <span class="main-text-info <?php echo $status_class; ?>"><?php echo $thankyou_header; ?></span><br class="hidden-xs" />
        <span class="sub-text-info visible-xs"><div class="<?php echo $status_class; ?>"><?php echo $thankyou_content; ?></div><br/>
            <?php if ($status == 'requery') { ?>
                <a href="<?php echo URL::route('checkout.requery'); ?>?order_id=<?php echo $data['order_id']; ?>" class="btn btn-success btn-lg"><?php echo __('requery-button'); ?></a><br/>
            <?php } ?>
            <img class="thank-logo" src="<?php echo Theme::asset()->usePath()->url('images/logo/logo_itruemart.png'); ?>" alt="itruemart" />
        </span>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="order-detail">
            <div class="well well-sm text-center"><?php echo __("thankyou-order-list-title"); ?></div>
            <div class="thankyou-container">
                <?php foreach($ecommerce['shipments'] as $skey => $shipment): ?>
                    <?php foreach($shipment['items'] as $ikey => $item): ?>
                        <div class="product-container">
                            <div class="product-name"><?php echo $item['name']; ?></div>
                            <span class="product-unit"><?php echo $item["quantity"]; ?> <?php echo __("cart-item-unit"); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <div class="product-container">
                        <div class="product-summary-label"><?php echo __("cart-total-price-lbl"); ?></div>
                        <span class="product-summary-price">
                            <?php if($ecommerce['shipments_summary']['sub_total'] > 0){
                                echo number_format($ecommerce['shipments_summary']['sub_total'],2);
                            }else{
                                echo '0.00';
                            } ?><br/><small>(<?php echo __("cart-vat-included"); ?>)</small>
                        </span>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 checkout-detail">
        <div class="order-detail">
            <div class="well well-sm text-center"><?php echo __("thankyou-order-info-title"); ?></div>
            <div class="col-sm-12">
                <ul class="list-unstyled">
                    <li><span class="thankyou-title"><?php echo __("thankyou-order-no"); ?></span> : 
                        <?php if (isset($data['payment_method_code']) && ($data['payment_method_code'] == 'ccw' || $data['payment_method_code'] == 'cod')): ?>
                            <?php
                            if (!empty($data['order_id'])) {
                                echo $data['order_id'];
                            }
                            ?>
                        <?php else: ?>
                            <?php echo (!empty($data['payment_order_id'])) ? $data['payment_order_id'] : ""; ?> <?php
                            if (!empty($data['order_id'])) {
                                echo '(' . $data['order_id'] . ')';
                            }
                            ?>
                    <?php endif; ?></li>
                    <?php if ( $data['payment_method_code'] != 'ccw' && $data['payment_method_code'] != 'cod' && $data['payment_method_code'] != 'ccinstm' &&  $data['payment_method_code'] != 'zero'): ?>
                        <li><span class="thankyou-title"><?php echo __("thankyou-order-refno-1"); ?></span> : <?php echo (isset($data['ref1']) && $data['ref1'] != "NULL") ? $data['ref1'] : "-"; ?></li>
                        <li><span class="thankyou-title"><?php echo __("thankyou-order-refno-2"); ?></span> : <?php echo (isset($data['ref2']) && $data["ref2"] != "NULL") ? $data['ref2'] : "-"; ?></li>
                    <?php endif; ?>
                    <li><span class="thankyou-title"><?php echo __("thankyou-order-date"); ?></span> : <?php
                    if (!empty($data['ordered_date']['date'])) {
                        echo formatDate($data['ordered_date']['date'], "d F y", Lang::getLocale());
                    }
                    ?></li>
                    <li><span class="thankyou-title"><?php echo __("thankyou-customer-name-lbl"); ?></span> : <?php echo (!empty($data['customer_name'])) ? $data['customer_name'] : ""; ?></li>
                    <?php if(!empty($data["customer_tel"])): ?>
                        <li><span class="thankyou-title"><?php echo __("thankyou-customer-phone-lbl"); ?></span> : <?php echo $data["customer_tel"]; ?></li>
                    <?php endif; ?>
                    <?php if(!empty($data["customer_email"])): ?>
                        <li><span class="thankyou-title"><?php echo __("thankyou-customer-email-lbl"); ?></span> : <?php echo $data["customer_email"]; ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="addr-detail">
            <div class="well well-sm text-center"><?php echo __("thankyou-customer-address-lbl"); ?> </div>
            <div class="col-sm-12">
                <ul class="list-unstyled">
                    <li>
                            <?php
                            $address = '';
                            $address .= (!empty($data['customer_address'])) ? $data['customer_address'] . " " : "";

                            if (!empty($data['customer_province']) && !empty($data['customer_district'])) {
                                $address .= ($data['customer_province'] == 'กรุงเทพมหานคร') ? __("step2-special-subdistrict") . " " : __("step2-subdistrict") . " ";
                            }
                            $address .= (!empty($data['customer_district'])) ? $data['customer_district'] . " " : "";

                            if (!empty($data['customer_province']) && !empty($data['customer_city'])) {
                                $address .= ($data['customer_province'] == 'กรุงเทพมหานคร') ? __("step2-special-district") . " " : __("step2-district") . " ";
                            }
                            $address .= (!empty($data['customer_city'])) ? $data['customer_city'] . " " : '';
                            $address .= (!empty($data['customer_province']) && $data['customer_province'] != 'กรุงเทพมหานคร' && $data['customer_province'] != 'BANGKOK') ? __("step2-province") . " " : "";
                            $address .= (!empty($data['customer_province'])) ? $data['customer_province'] . " " : "";
                            $address .= (!empty($data['customer_postcode'])) ? $data['customer_postcode'] . " " : "";
                            echo $address;
                            ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div id="payment-channel-name" class="visible-xs col-sm-12">
        <h2 class="payment-channel-title"><?php echo __("thankyou-order-payment-channel"); ?></h2>
        <!-- [S] Payment Channel right side -->
        <?php if ($data['payment_method_code'] == 'ccw'): ?>
            <p><?php echo __("thankyou-ccw-payment-title"); ?></p>
            <div class="payment-channel-desc">
                <span><?php echo __("thankyou-ccw-payment-desc"); ?></span>
            </div>
        <?php elseif ($data['payment_method_code'] == 'atm'): ?>
            <p><?php echo __("thankyou-atm-payment-title"); ?></p>
            <div class="payment-channel-desc">
                <span><?php echo __("thankyou-atm-payment-desc"); ?></span>
                <ul>
                    <li><span class="clr-8">*</span> <?php echo __("thankyou-atm-payment-notice1"); ?></li>
                </ul>
            </div>
        <?php elseif ($data['payment_method_code'] == 'ibank'): ?>
            <p><?php echo __("thankyou-ibank-payment-title"); ?></p>
            <div class="payment-channel-desc">
                <span><?php echo __("thankyou-ibank-payment-desc"); ?></span>
                <ul>
                    <li><span class="clr-8">*</span> <?php echo __("thankyou-ibank-payment-notice1"); ?></li>
                </ul>
            </div>
        <?php elseif ($data['payment_method_code'] == 'banktrans'): ?>
            <p><?php echo __("thankyou-banktrans-payment-title"); ?></p>
            <div class="payment-channel-desc">
                <span><?php 
                        $print_link = URL::toLang("checkout/print?order_id=") . ( !empty($data['order_id'])? $data['order_id'] : "" );
                        echo sprintf(__("thankyou-banktrans-payment-desc"), $print_link); 
                       ?></span>
                <ul>
                    <li><span class="clr-8">*</span> <?php echo __("thankyou-banktrans-payment-notice1"); ?></li>
                </ul>
            </div>
        <?php elseif ($data['payment_method_code'] == 'cs'): ?>
            <p><?php echo __("thankyou-cs-payment-title"); ?></p>
            <div class="payment-channel-desc">
                <span><?php echo __("thankyou-cs-payment-desc"); ?></span>
                <ul>
                    <li><span class="clr-8">*</span> <?php echo __("thankyou-cs-payment-notice1"); ?></li>
                </ul>
            </div>
        <?php elseif ($data['payment_method_code'] == 'cod'): ?>
            <p><?php echo __("thankyou-cod-payment-title"); ?></p>
            <p class="payment-channel-desc">
                <span><?php echo __("thankyou-cod-payment-desc"); ?></span>
            </p>
        <?php elseif ($data['payment_method_code'] == 'ccinstm'): ?>
            <p><?php echo __("thankyou-ccinstm-payment-title"); ?></p>
            <p class="payment-channel-desc">
                <span><?php echo __("thankyou-ccinstm-payment-desc"); ?></span>
            </p>
        <?php endif; ?>
        <!-- [E] Payment Channel right side -->
    </div>
</div>

<div class="row">
    <div class="col-sm-12 text-center callcenter-contact">
        <?php echo __("thankyou-footer-success-contact-phone"); ?><br/>
        <?php echo __("thankyou-footer-success-contact-time"); ?>
    </div>
</div>

<!-- ALL Analytic -->
<?php if ($data['analytics_status'] == "N" && (App::environment('production') || App::environment('alpha') || App::environment('aws-staging'))): ?>
    <?php
    // ########################## Google Tag ########################################
    $tracking = '';
    $tracking .= "
var transactionId =  '". $data['order_id'] ."';
var cartProducts = [];
var affil = 'itruemart.ph';
var google_transaction_total= ".$ecommerce["shipments_summary"]["sub_total"].";
";
    $sum = 0;
    // items
    // start loop
    $fb_item_arr = array();
    if(!empty($ecommerce["order_item"])){
        foreach($ecommerce["order_item"] as $key => $item) {
            $tracking .= "cartProducts.push({
                    'id': transactionId,
                    'sku': '". $item["inventory_id"] ."',        	 // product ID
                    'name': '" . $item["name"] .  "',   // product name
                    'category': '" . $item["category"] . "',    // category name
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

    $tracking .= "
dataLayer.push({
    'transactionId': transactionId,
    'transactionAffiliation': affil,
    'transactionTotal': ".$ecommerce["shipments_summary"]["sub_total"].",             // total renevue
    'transactionTax': 0,               // tax
    'transactionShipping': ".$ecommerce["shipments_summary"]["total_shipping_fee"].",        	 // shipping
    'transactionProducts': cartProducts,
    'country': '".$ecommerce["order"]["country"]."',	 // Custom Dimension 1
    'province': '".$ecommerce["order"]["customer_province"]."',	 // Custom Dimension 2
    'city': '".$ecommerce["order"]["customer_city"]."', // Custom Dimension 3
    'total_revenue': 0, // Custom Dimension 4
    'total_quantity': ".$sum.",	 // Custom Dimension 5
    'event': 'trackTrans'
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