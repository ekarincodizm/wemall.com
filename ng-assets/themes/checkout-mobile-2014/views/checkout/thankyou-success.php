<?php
if (array_get($data, 'payment_channel') === 'offline')
{
    if (array_get($data, 'payment_status') === 'reconcile')
    {
        $thankyou_header = __("thankyou-success-title");
        $thankyou_content = __("thankyou-success-description");
        $image = 'success.png';
        $status = 'success';
        $status_class = 'text--success';
    }
    else if(array_get($data, 'payment_status') === 'failed')
    {
        $thankyou_header = __("expired-header");
        $thankyou_content = __("expired-content");
        $image = 'error_thank.png';
        $status = 'error';
        $status_class = 'text--fail';
    }
    else if(array_get($data, 'payment_status') === 'waiting' && strtolower( $data['payment_method_code'] ) == 'cod')
    {
        $thankyou_header = __("offline-cod-waiting-header");
        $thankyou_content = __("offline-cod-waiting-content");
        $image = 'success.png';
        $status = 'wait';
        $status_class = 'text--success';
    }
    else if (array_get($data, 'payment_status') === 'waiting')
    {
        $thankyou_header = __("offline-waiting-header");
        $thankyou_content = __("offline-waiting-content");
        $image = 'success.png';
        $status = 'wait';
        $status_class = 'text--success';
    }
    else
    {
        //Default is "waiting".
        $thankyou_header = __("offline-waiting-header");
        $thankyou_content = __("offline-waiting-content");
        $image = 'clock_thank.png';
        $status = 'wait';
        $status_class = 'text--waiting';
    }
}
else if (array_get($data, 'payment_channel') === 'online' && strtolower( $data['payment_method_code'] ) == 'ccw')
{
    if (array_get($data, 'payment_status') === 'success')
    {
        $thankyou_header = __("thankyou-success-title");
        $thankyou_content = __("thankyou-success-description");
        $image = 'success.png';
        $status = 'success';
        $status_class = 'text--success';
    }
    else if (array_get($data, 'payment_status') === 'failed')
    {
        $thankyou_header = __("expired-header");
        $thankyou_content = __("ccw-fail-content");
        $image = 'error_thank.png';
        $status = 'error';
        $status_class = 'text--fail';
    }
    else if(array_get($data, 'payment_status') === 'waiting')
    {
        $thankyou_header = __("requery-header");
        $thankyou_content = __("requery-content");
        $image = 'clock_thank.png';
        $status = 'requery';
        $status_class = 'text--waiting';
    }
    else
    {
        // Default is waiting.
        $thankyou_header = __("requery-header");
        $thankyou_content = __("requery-content");
        $image = 'clock_thank.png';
        $status = 'requery';
        $status_class = 'text--waiting';
    }
}
else if( array_get($data, 'payment_channel') === 'online' )
{
    if (array_get($data, 'payment_status') === 'reconcile')
    {
        $thankyou_header = __("thankyou-success-title");
        $thankyou_content = __("thankyou-success-description");
        $image = 'success.png';
        $status = 'success';
        $status_class = 'text--success';
    }
    else if(array_get($data, 'payment_status') === 'failed')
    {
        $thankyou_header = __("expired-header");
        $thankyou_content = __("ccw-fail-content");
        $image = 'error_thank.png';
        $status = 'error';
        $status_class = 'text--fail';
    }
    else if(array_get($data, 'payment_status') === 'waiting')
    {
        $thankyou_header = __("requery-header");
        $thankyou_content = __("requery-content");
        $image = 'clock_thank.png';
        $status = 'requery';
        $status_class = 'text--waiting';
    }
    else if (array_get($data, 'payment_status') === 'success')
    {
        $thankyou_header = __("thankyou-success-title");
        $thankyou_content = __("thankyou-success-description");
        $image = 'success.png';
        $status = 'success';
        $status_class = 'text--success';
    }
    else
    {

        // Default is "waiting"
        $thankyou_header = __("requery-header");
        $thankyou_content = __("requery-content");
        $image = 'clock_thank.png';
        $status = 'requery';
        $status_class = 'text--waiting';
    }
}
?>
<div class="row-custom">
    <div class="col-custom">
        <div class="thankyou-msg">
            <img class="thankyou-msg__icn" src="<?php echo Theme::asset()->usePath()->url('img/icn/'.$image); ?>" alt="www.itruemart.com"/>
            <p class="thankyou-msg__main-text <?php echo $status_class?:""; ?>">
                <?php echo $thankyou_header; ?>
            </p>
			<span class="thankyou-msg__sub-text <?php if($status == "error"){ echo "text--fail"; }else { echo "text--success"; } ?>">
                <?php echo $thankyou_content; ?>
			</span>

            <?php if($data['payment_status'] == 'waiting' && $data['payment_channel'] == 'online'):?>
                <br/><br/>
                <a href="<?php echo URL::route('checkout.requery');?>?order_id=<?php echo $data['order_id']; ?>" class="btn btn-success"><?php echo __('requery-button'); ?></a>
            <?php endif; ?>
        </div>
        <div class="purchase-order">
            <table class="table table-bordered border-bottom--none">
                <tbody>
                    <tr>
                        <td class="background-order purchase-order__title">
							<span><?php echo __("thankyou-order-date"); ?></span>
                        </td>
                        <td class="background-order">
                            <span class="text--precendence--bold"><?php if(!empty($data['ordered_date']['date'])){ echo formatDate($data['ordered_date']['date'], "d F y", Lang::getLocale()); } ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="background-order--alter">
                            <span class="text--precendence--bold"><?php echo __("thankyou-order-status"); ?></span>
                        </td>
                        <td class="background-order--alter">
                            <span class="text--precendence--bold text--success">
                                <?php
                                if (array_get($data, 'payment_channel') === 'offline')
                                {
                                    if (array_get($data, 'payment_status') === 'reconcile')
                                    {
                                        echo __('payment-reconcile');
                                    } else if(array_get($data, 'payment_status') === 'failed')
                                    {
                                        echo __('payment-failed');
                                    }else if(array_get($data, 'payment_status') === 'waiting')
                                    {
                                        echo __('payment-waiting');
                                    } else {
                                        echo '-';
                                    }
                                } else if (array_get($data, 'payment_channel') === 'online' && strtolower( $data['payment_method_code'] ) == 'ccw')
                                {
                                    if (array_get($data, 'payment_status') === 'success')
                                    {
                                        echo __('payment-reconcile');
                                    } else if(array_get($data, 'payment_status') === 'failed')
                                    {
                                        echo __('payment-failed');
                                    }else if(array_get($data, 'payment_status') === 'waiting')
                                    {
                                        echo __('payment-waiting');
                                    }else {
                                        echo '-';
                                    }
                                }else if( array_get($data, 'payment_channel') === 'online' ){
                                    if (array_get($data, 'payment_status') === 'reconcile')
                                    {
                                        echo __('payment-reconcile');
                                    } else if(array_get($data, 'payment_status') === 'failed')
                                    {
                                        echo __('payment-failed');
                                    }else if(array_get($data, 'payment_status') === 'waiting')
                                    {
                                        echo __('payment-waiting');
                                    }else if(array_get($data, 'payment_status') === 'success'){
                                        echo __('payment-reconcile');
                                    } else {
                                        echo '-';
                                    }
                                }
                                ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="background-order">
                            <span><?php echo __("thankyou-order-no-notice1"); ?></span>
                            <br/>
                            <span class="text--precendence"><?php echo __("thankyou-order-no"); ?></span>
                        </td>
                        <td class="background-order">
                            <span class="text--precendence">
                                <?php if($data['payment_method_code'] == 'ccw' || $data['payment_method_code'] == 'cod'): ?>
                                    <?php if(!empty($data['order_id'])){ echo $data['order_id']; } ?>
                                <?php else: ?>
                                    <?php echo (!empty($data['payment_order_id']))? $data['payment_order_id'] : "";?> <?php if(!empty($data['order_id'])){ echo '('. $data['order_id'] .')'; } ?>
                                <?php endif; ?>
                            </span>
                            <br/>
                            <span class="text--small"><?php echo __("thankyou-order-no-notice2"); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
							<span class="text--precendence--bold"><?php echo __("order-detail"); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="border-bottom--none">
                            <div>
                                <?php if ( ! empty($data['customer_name'])) : ?>
                                <label>
									<span class="text--regular">
										<?php echo __("thankyou-customer-name-lbl"); ?>
									</span>
                                    <p class="text--default">
                                        <?php echo $data['customer_name']; ?>
                                    </p>
                                </label>
                                <?php endif; ?>

                                <?php if ( ! empty($data['customer_tel'])) : ?>
                                <label>
									<span class="text--regular"><?php echo __("thankyou-customer-phone-lbl"); ?></span>
                                    <p class="text--default">
                                        <?php echo $data['customer_tel']; ?>
                                    </p>
                                </label>
                                <?php endif; ?>

                                <?php if ( ! empty($data['customer_email'])) : ?>
                                <label>
									<span class="text--regular"><?php echo __("thankyou-customer-email-lbl"); ?></span>
                                    <p class="text--default">
                                        <?php echo $data['customer_email']; ?>
                                    </p>
                                </label>
                                <?php endif; ?>
                                <label>
									<span class="text--regular"><?php echo __("thankyou-customer-address-lbl"); ?></span>
                                    <p class="text--default">
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
                                    </p>
                                </label>
                                <?php if( $data['billing_address_address'] != $data['customer_address'] &&
                                    $data['billing_address_district'] != $data["customer_district"] &&
                                    $data['billing_address_city'] != $data['customer_city'] &&
                                    $data["billing_address_province"] != $data['customer_province'] &&
                                    $data["billing_address_postcode"] != $data["customer_postcode"]
                                ): ?>
                                    <label>
                                        <span class="text--regular"><?php echo __("thankyou-customer-billing-addr-lbl"); ?></span>
                                        <p class="text--default">
                                            <?php
                                                $Billaddress = '';
                                                $Billaddress = '';
                                                $Billaddress .= (!empty($data['billing_address_address']))? htmlentities($data['billing_address_address']) . " " : "";

                                                if(!empty($data['billing_address_province']) && !empty($data['billing_address_district'])){
                                                    $Billaddress .= ($data['billing_address_province'] == 'กรุงเทพมหานคร')? __("step2-special-subdistrict") . " " :  __("step2-subdistrict") . " ";
                                                }
                                                $Billaddress .= (!empty($data['billing_address_district']))? $data['billing_address_district'] . " " : "";

                                                if(!empty($data['billing_address_province']) && !empty($data['billing_address_city'])){
                                                    $Billaddress .= ($data['billing_address_province'] == 'กรุงเทพมหานคร')? __("step2-special-district") . " " : __("step2-district") . " ";
                                                }
                                                $Billaddress .= (!empty($data['billing_address_city']))? $data['billing_address_city'] . " " : '';
                                                $Billaddress .= (!empty($data['billing_address_province']) && $data['billing_address_province'] != 'กรุงเทพมหานคร' && $data['billing_address_province'] != 'BANGKOK')? __("step2-province") . " " : "";
                                                $Billaddress .= (!empty($data['billing_address_province']))? $data['billing_address_province'] . " " : "";
                                                $Billaddress .= (!empty($data['billing_address_postcode']))? $data['billing_address_postcode'] . " " : "";
                                                echo $Billaddress;
                                            ?>
                                        </p>
                                    </label>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>


            <table class="table table-bordered table-order border-top--dotted">
                <tbody>
                    <tr>
                        <td colspan="3" class="border-top--dotted head-line">
                            <span class="text--precendence--bold"><?php echo __("thankyou-order-list-title"); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="sum-product">
                            <span class="text--precendence--bold"><?php echo __("cart-product-lbl"); ?></span>
                        </td>
                        <td class="sum-amount">
                            <span class="text--precendence--bold"><?php echo __("cart-number-of-product-lbl"); ?></span>
                        </td>
                        <td class="sum-value">
                            <span class="text--precendence--bold"><?php echo __("fullcart-product-price-lbl"); ?></span>
                        </td>
                    </tr>

                    <?php if ( ! empty($ecommerce['shipments'])) : ?>
                        <?php
                            $vendor_count = 1;
                            $show_group = false;
                            if(count($ecommerce['shipments']) > 1)
                            {
                                $show_group = true;
                            }
                        ?>
                        <?php foreach ($ecommerce['shipments'] as $s_key => $s_value) : ?>
                            <tr>
                                <td colspan="3" class="list-order">
                                    <div class="list-order__merchant-name">
                                        <span class="text--regular--bold"><?php echo __("cart-shops-product-lbl"); ?> : <?php echo __('replace-shop-name'); ?> <?php if($show_group == true):?> (<?php echo __('replace-vendor-name').' '.$vendor_count; $vendor_count++; ?>) <?php endif;?> (<?php echo $s_value['item_count']; ?> <?php echo __("cart-item-unit"); ?>)</span>
                                    </div>
                                    <?php if ( ! empty($s_value['items'])) : ?>
                                        <?php foreach ($s_value['items'] as $p_key => $p_value) : ?>
                                            <div class="list-order__items">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="item-name">
                                                                <span class="text--regular"><?php echo $p_value['name']; ?></span>
                                                            </td>
                                                            <td class="item-amount">
                                                                <span><?php echo $p_value['quantity']; ?></span>
                                                            </td>
                                                            <td class="item-value">
                                                                <span class="text--regular"><?php echo number_format(array_get($p_value, 'total_price'),2); ?></span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text--right">
                                    <span><?php //echo __("thankyou-order-from-lbl"); ?> <?php //echo __('replace-shop-name');?> <?php //echo array_get($shipment, 'shop_name'); ?> <?php //echo __("thankyou-order-delivery-txt"); ?>  <?php echo __('thankyou-delivery-time')?>: </span>
                                    <span class="delivery-date">
                                        <?php echo __("thankyou-order-delivery-date"); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(!empty($ecommerce['shipments_summary'])): ?>
                        <?php if(!empty($ecommerce['shipments_summary']['total_price'])): ?>
                            <tr>
                                <td colspan="3">
                                    <span class="text--regular"><?php echo __("cart-cost-lbl"); ?> : </span>
                                    <span class="text--regular pull-right"><?php echo $ecommerce['shipments_summary']['total_price']; ?> <?php echo __("order-tracking-baht"); ?></span>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if(isset($ecommerce['shipments_summary']['total_shipping_fee'])): ?>
                            <tr>
                                <td colspan="3">
                                    <span class="text--regular"><?php echo __("cart-total-delivery-fare"); ?> : </span>
                                    <span class="text--regular pull-right">
                                        <?php if($ecommerce['shipments_summary']['total_shipping_fee'] > 0){
                                            echo number_format($ecommerce['shipments_summary']['total_shipping_fee'],2);
                                        }else{
                                            echo __("cart-free-lbl");
                                        } ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if(isset($ecommerce['shipments_summary']['discount'])): ?>
                            <tr>
                                <td colspan="3">
                                    <span class="text--regular"><?php echo __("cart-discount-lbl"); ?> : </span>
                                    <span class="text--regular pull-right">
                                        <?php if($ecommerce['shipments_summary']['discount'] > 0){
                                            echo '-' . number_format($ecommerce['shipments_summary']['discount'],2);
                                        }else{
                                            echo '0.00';
                                        }?>
                                    </span>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if($ecommerce['shipments_summary']['sub_total'] == NULL){ $ecommerce['shipments_summary']['sub_total'] = 0; }  ?>
                        <?php if(isset($ecommerce['shipments_summary']['sub_total'])): ?>
                            <tr>
                                <td colspan="3" class="order-summary">
                                    <span class="text--precendence--bold"><?php echo __("cart-total-price-lbl"); ?> :</span>
                                    <span class="text--summary pull-right">
                                        <?php if($ecommerce['shipments_summary']['sub_total'] > 0){
                                            echo number_format($ecommerce['shipments_summary']['sub_total'],2);
                                        }else{
                                            echo '0.00';
                                        } ?>
                                    </span>
                                    <span class="text--small pull-right--bottom">(<?php echo __("cart-vat-included"); ?>)</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                    <tr>
                        <td colspan="3" class="list-order__divide"></td>
                    </tr>
                </tbody>
            </table>

            <?php if($data['payment_method_code'] == 'ccw'): ?>
                <!-- Credit card -->
                <table class="table table-bordered border-top--dotted">
                    <tbody>
                        <tr>
                            <td class="border-top--none">
                                <div class="channel-payment">
                                    <div class="channel-payment__head">
                                        <div class="channel-payment__name">
                                            <p class="text--regular"><?php echo __("thankyou-order-payment-channel"); ?></p>
                                            <span class="text--payment-name"><?php echo __("thankyou-ccw-payment-title"); ?></span>
                                        </div>
                                        <div class="channel-payment__icn">
                                            <img src="<?php echo Theme::asset()->usePath()->url('img/icn/ico-credit.png'); ?>"/>
                                        </div>
                                    </div>
                                    <div class="channel-payment__content">
                                        <span class="text--default"><?php echo __("thankyou-ccw-payment-desc"); ?></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- /Credit card -->
            <?php elseif($data['payment_method_code'] == 'atm'): ?>
                <!-- ATM -->
                <table class="table table-bordered border-top--dotted">
                    <tbody>
                        <tr>
                            <td class="border-top--none border-bottom--none">
                                <div class="channel-payment">
                                    <div class="channel-payment__head">
                                        <div class="channel-payment__name">
                                            <p class="text--regular"><?php echo __("thankyou-order-payment-channel"); ?></p>
                                            <span class="text--payment-name">เอทีเอ็ม</span>
                                        </div>
                                        <div class="channel-payment__icn">
                                            <img src="<?php echo Theme::asset()->usePath()->url('img/icn/ico-atm.png'); ?>"/>
                                        </div>
                                    </div>
                                    <div class="channel-payment__content">
                                        <p class="text--default">
                                            สามารถชำระเงินค่าสินค้าผ่านตู้เอทีเอ็มของ ธนาคารไทยพาณิชย์ ธนาคารกรุงเทพ หรือ
                                            ธนาคารกสิกรไทย ทุกสาขาทั่วประเทศ ตลอด 24 ชั่วโมง
                                            โดยธนาคารจะขอเรียกเก็บค่าธรรมเนียมการชำระเงิน* จากคุณ
                                        </p>
                                        <span class="text--small">
                                            * อัตราค่าธรรมเนียมขึ้นอยู่กับแต่ละธนาคาร (20 - 40 บาท)
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-top--dotted">
                                <div class="channel-payment__content">
                                    <p class="text--default">สำหรับใช้อ้างอิงในการชำระเงินที่ตู้เอทีเอ็ม</p>
                                    <p class="text--regular">ธนาคารกสิกรไทย COMP CODE : 35002<br/>
                                        ธนาคารไทยพาณิชย์ COMP CODE : 0546<br/>
                                        ธนาคารกรุงเทพ COMP CODE : 60000</p>

                                    <p class="text--regular">
                                        หมายเลขอ้างอิง 1 (Customer No.) : 41592662<br/>
                                        หมายเลขอ้างอิง 2 (Ref No.2) : 269702675228<br/>
                                    </p>
                                    <span class="text--small">* อัตราค่าธรรมเนียมขึ้นอยู่กับแต่ละธนาคาร (20 - 40 บาท)</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="channel-payment__guide">
                                <div class="channel-payment__guide__heading">
                                    <div class="text--regular">
                                        <img class="icon" src="<?php echo Theme::asset()->usePath()->url('img/icn/k_bank_new.png'); ?>"/>
                                        วิธีการชำระเงินที่ตู้เอทีเอ็มกสิกรไทย
                                        <span class="caret--big"></span>
                                    </div>
                                </div>
                                <div class="channel-payment__guide__content">
                                    <ol class="guide__step">
                                        <li>สอดบัตร ATM ของธนาคารกสิกรไทยที่ตู้ ATM ธนาคารกสิกรไทย</li>
                                        <li>ใส่รหัสบัตร ATM 4 หลัก</li>
                                        <li>กดปุ่ม "ซื้อและชำระเงิน"</li>
                                        <li>กดปุ่ม "อื่นๆ/ระบุรหัสบริษัท"</li>
                                        <li>กดปุ่มเลือกชำระเงินจาก บัญชีออมทรัพย์ หรือ กระแสรายวัน</li>
                                        <li>ใส่รหัสบริษัท 5 หลัก หมายเลข "35002" แล้วกดปุ่ม "รหัสบริษัทถูกต้อง"</li>
                                        <li>กด หมายเลขอ้างอิง 1 (Customer No.) จำนวน 8 หลัก ตามที่ปรากฏในใบสรุปการสั่งซื่อ
                                            แล้วกดปุ่ม "หมายเลขถูกต้อง"
                                        </li>
                                        <li>กด หมายเลขอ้างอิง 2 (Ref No.2 ) จำนวน 12 หลักตามที่ปรากฏในใบสรุปการสั่งซื่อ
                                            แล้วกดปุ่ม "หมายเลขถูกต้อง"
                                        </li>
                                    </ol>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="channel-payment__guide">
                                <div class="channel-payment__guide__heading">
                                    <div class="text--regular">
                                        <img class="icon" src="<?php echo Theme::asset()->usePath()->url('img/icn/scb_bank.png'); ?>"/>วิธีการชำระเงินที่ตู้เอทีเอ็มไทยพาณิชย์
                                        <span class="caret--big"></span>
                                    </div>
                                </div>
                                <div class="channel-payment__guide__content">
                                    <ol class="guide__step">
                                        <li>สอดบัตร ATM ของธนาคารไทยพาณิชย์ที่ตู้ ATM ธนาคารไทยพาณิชย์</li>
                                        <li>ใส่รหัสบัตร ATM 4 หลัก</li>
                                        <li>กดปุ่ม "อื่นๆ"</li>
                                        <li>เลือก "ชำระค่าสินค้า/บริการ"</li>
                                        <li>เลือก "ชำระเงิน"</li>
                                        <li>เลือก "ชำระเงินเข้าบริษัทอื่นๆ"</li>
                                        <li>เลือกชำระเงินจากบัญชีออมทรัพย์</li>
                                        <li>ใส่รหัสบริษัท (Comp Code) หมายเลข "0546" แล้วกดปุ่ม "ถูกต้อง"</li>
                                        <li>กดจำนวนเงินที่ต้องการชำระ</li>
                                        <li>
                                            กด หมายเลขอ้างอิง 1 (Customer No.) จำนวน 8 หลักตามที่ปรากฏในใบสรุปการสั่งซื้อ
                                        </li>
                                        <li>
                                            กด หมายเลขอ้างอิง 2 (Reference No.) จำนวน 12
                                            หลักตามที่ปรากฏในใบสรุปการสั่งซื้อ
                                        </li>
                                        <li>
                                            ตรวจสอบความถูกต้องว่าเป็นบัญชีเป็นชื่อ บริษัท TRUE MONEY แล้วเลือก "ยืนยัน"
                                            เพื่อชำระค่าสินค้า/บริการ
                                        </li>
                                    </ol>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="channel-payment__guide">
                                <div class="channel-payment__guide__heading">
                                    <div class="text--regular">
                                        <img class="icon" src="<?php echo Theme::asset()->usePath()->url('img/icn/bkk_bank.png'); ?>"/>วิธีการชำระเงินที่ตู้เอทีเอ็มกรุงเทพ
                                        <span class="caret--big"></span>
                                    </div>
                                </div>
                                <div class="channel-payment__guide__content">
                                    <ol class="guide__step">
                                        <li>สอดบัตร ATM ของธนาคารกรุงเทพที่ตู้ ATM ธนาคารกรุงเทพ พร้อมใส่รหัสบัตร 4 หลัก
                                        </li>
                                        <li>เลือก อื่นๆ &gt; ชำระเงินด้วย Comp Code &gt; บัญชีสะสมทรัพย์</li>
                                        <li>ใส่รหัสบริษัท (Comp Code) หมายเลข "60000" แล้วกดปุ่มถูกต้อง</li>
                                        <li>ใส่หมายเลขอ้างอิง 1 (Customer No.) จำนวน 8 หลัก และ หมายเลขอ้างอิง 2 (Reference
                                            No.) จำนวน 12 หลักตามที่ปรากฎในใบสรุปการสั่งซื้อ
                                        </li>
                                        <li>กดจำนวนเงินที่ต้องการชำระ</li>
                                        <li>ตรวจสอบความถูกต้องว่าเป็นบัญชีชื่อบริษัท TRUE MONEY แล้วกด "ยืนยัน"
                                            เพื่อชำระค่าสินค้า
                                        </li>
                                        <li>รอรับสลิปไว้เป็นหลักฐาน</li>
                                    </ol>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            <!-- /ATM -->
            <?php elseif($data['payment_method_code'] == 'ibank'): ?>
                <!--  iBanking -->
                <table class="table table-bordered border-top--dotted">
                    <tbody>
                        <tr>
                            <td class="border-top--none border-bottom--none">
                                <div class="channel-payment">
                                    <div class="channel-payment__head">
                                        <div class="channel-payment__name">
                                            <p class="text--regular"><?php echo __("thankyou-order-payment-channel"); ?></p>
                                            <span class="text--payment-name">ไอแบงก์กิ้ง</span>
                                        </div>
                                        <div class="channel-payment__icn">
                                            <img src="<?php echo Theme::asset()->usePath()->url('img/icn/ico-ibanking.png'); ?>"/>
                                        </div>
                                    </div>
                                    <div class="channel-payment__content">
                                        <p class="text--default">
                                            สามารถชำระเงินค่าสินค้าด้วย iBanking ของธนาคารไทยพาณิชย์ ธนาคารกรุงเทพ หรือ ธนาคารกสิกรไทย ตลอด 24 ชั่วโมง
                                            โดยธนาคารจะขอเรียกเก็บค่าธรรมเนียมการชำระเงิน* จากคุณ
                                        </p>
                                        <span class="text--small">
                                            * อัตราค่าธรรมเนียมขึ้นอยู่กับแต่ละธนาคาร (20 - 40 บาท)
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-top--dotted">
                                <div class="channel-payment__content">
                                    <p class="text--default">สำหรับใช้อ้างอิงในการชำระเงินผ่านไอแบงก์กิ้ง</p>

                                    <p class="text--regular">ธนาคารกสิกรไทย COMP CODE : ทีเพย์ - weloveshopping<br/>
                                        ธนาคารไทยพาณิชย์ COMP CODE :  บริษัททรูมันนีจำกัด comp code 0546<br/>
                                        ธนาคารกรุงเทพ COMP CODE : TMNWLS * True Money Company Limited</p>

                                    <p class="text--regular">หมายเลขอ้างอิง 1 (Ref No.1) : 41592662<br/>
                                        หมายเลขอ้างอิง 2 (Ref No.2) : 269702675228</p>

                                    <span class="text--small">* อัตราค่าธรรมเนียมขึ้นอยู่กับแต่ละธนาคาร (20 - 40 บาท)</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="channel-payment__guide">
                                <div class="channel-payment__guide__heading">
                                    <div class="text--regular">
                                        <img class="icon" src="<?php echo Theme::asset()->usePath()->url('img/icn/k_bank_new.png'); ?>"/>วิธีการชำระเงินผ่านไอแบงก็กิ้งธนาคารกสิกรไทย
                                        <span class="caret--big"></span>
                                    </div>
                                </div>
                                <div class="channel-payment__guide__content">
                                    <ol class="guide__step">
                                        <li>เข้าไปที่เว็บไซต์ www.kasikornbank.com</li>
                                        <li>เลือกบริการออนไลน์ที่ต้องการเป็น “K-Cyber Banking</li>
                                        <li>เข้าสู่ระบบโดยระบุ User ID และ Password ที่ได้รับจากทางธนาคาร แล้วคลิก
                                            “เข้าสู่ระบบ
                                        </li>
                                        <li>ในแถบเมนูบริการ เลือกเมนู "ชำระค่าสินค้าและบริการ" แล้วเลือก
                                            “ชำระค่าสินค้าและบริการ”
                                        </li>
                                        <li>เลือกแบบฟอร์มบริษัทที่ต้องการชำระเงินค่าสินค้า (ถ้ายังไม่ได้สร้าง
                                            สามารถสร้างได้โดยคลิกที่ “สร้างแบบฟอร์ม”)
                                        </li>
                                        <li>กรอกข้อมูลเพื่อชำระค่าสินค้าและบริการ<br>
                                            <ul>
                                                <li>i. ตั้งชื่อแบบฟอร์ม</li>
                                                <li>ii. ประเภทบริการ เลือกประเภท เป็น “อินเทอร์เน็ต”</li>
                                                <li>iii. บริษัท เลือกชื่อบริษัท เป็น “ทีเพย์ - weloveshopping”</li>
                                                <li>iv. จากบัญชี ให้เลือก เลขที่บัญชีที่ต้องการใช้ชำระเงิน</li>
                                                <li>v. ระบุ "เลขที่อ้างอิง 1 (Ref No.1)” และ "เลขที่อ้างอิง 2 (Ref No.2)”
                                                    ตามที่ปรากฎในหน้าสรุปรายการสั่งซื้อ
                                                </li>
                                            </ul>
                                        </li>
                                        <li>ระบุจำนวนเงินที่ต้องการชำระ</li>
                                        <li>ตรวจสอบข้อมูลการชำระค่าสินค้าและบริการ</li>
                                        <li>กดปุ่ม “ยืนยัน” เพื่อชำระค่าสินค้าและบริการ</li>
                                    </ol>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="channel-payment__guide">
                                <div class="channel-payment__guide__heading">
                                    <div class="text--regular">
                                        <img class="icon" src="<?php echo Theme::asset()->usePath()->url('img/icn/scb_bank.png'); ?>"/>วิธีการชำระเงินผ่านไอแบงก์กิ้งธนาคารไทยพาณิชย์
                                        <span class="caret--big"></span>
                                    </div>
                                </div>
                                <div class="channel-payment__guide__content">
                                    <ol class="guide__step">
                                        <li>เข้าไปที่เว็บไซต์ www.scbeasy.com</li>
                                        <li>เข้าสู่ระบบโดยระบุ Login Name และ Password ที่ได้รับจากทางธนาคาร แล้วคลิก
                                            “Login”
                                        </li>
                                        <li>เลือกรายการ “ชำระเงิน”</li>
                                        <li>ในเมนู ชำระเงิน และ e-Bill เลือก “ค่าสินค้าและบริการ”</li>
                                        <li>กรอกข้อมูลเพื่อชำระค่าสินค้าและบริการ</li>
                                        <li>เลือกเลขที่บัญชีที่ต้องการใช้ชำระเงิน</li>
                                        <li>บัญชีผู้ให้บริการ เลือก "บริษัททรูมันนี่จำกัด :หมายเลข comp code 0546”
                                            (ถ้ายังไม่ได้สร้าง สามารถสร้างได้โดยคลิกที่ “เพิ่มรายชื่อผู้รับชำระ”) <p>
                                                การเพิ่มรายชื่อผู้รับชำระ ทำได้ดังนี้</p>
                                            <ul>
                                                <li>i. เลือกที่แถบเมนูค่าสินค้าและบริการ คลิกที่ “Add from quick search”
                                                </li>
                                                <li>ii. ระบุหมายเลข Comp Code เป็น 0546 แล้วคลิก “Search”
                                                    จะพบรายชื่อผู้ให้บริการ เป็นบริษัท ทรู มันนี่ จำกัด
                                                </li>
                                                <li>iii. กด + เพื่อเพิ่มผู้ให้บริการ</li>
                                                <li>iv. ตั้งชื่อเรียก</li>
                                            </ul>
                                        </li>
                                        <li>ระบุ ชื่อ-นามสกุลลูกค้า เป็นภาษาอังกฤษ</li>
                                        <li>ระบุ "หมายเลขลูกค้า / Ref.1" และ “หมายเลขอ้างอิง / Ref.2”
                                            ตามที่ปรากฎในหน้าสรุปรายการสั่งซื้อ
                                        </li>
                                        <li>ระบุจำนวนเงินที่ต้องการชำระ</li>
                                        <li>ตรวจสอบข้อมูลการชำระค่าสินค้าและบริการ</li>
                                        <li>กดปุ่ม “ยืนยัน” เพื่อชำระค่าสินค้าและบริการ</li>
                                    </ol>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="channel-payment__guide">
                                <div class="channel-payment__guide__heading">
                                    <div class="text--regular">
                                        <img class="icon" src="<?php echo Theme::asset()->usePath()->url('img/icn/bkk_bank.png'); ?>"/>วิธีการชำระเงินผ่านไอแบงก์กิ้งธนาคารกรุงเทพ
                                        <span class="caret--big"></span>
                                    </div>
                                </div>
                                <div class="channel-payment__guide__content">
                                    <ol class="guide__step">
                                        <li>เข้าไปที่เว็บไซต์ www.bangkokbank.com</li>
                                        <li>เลือก “Bualuang iBanking”</li>
                                        <li>เข้าสู่ระบบโดยระบุ รหัสประจำตัว และ รหัสลับแรกเข้า/รหัสลับส่วนตัว
                                            ที่ได้รับจากทางธนาคาร แล้วคลิก “เข้าสู่บริการ”
                                        </li>
                                        <li>เลือกรายการ “ชำระเงิน”</li>
                                        <li>เลือก “ชำระค่าสินค้าและบริการ”</li>
                                        <li>กรอกข้อมูลเพื่อชำระค่าสินค้าและบริการ</li>
                                        <li>เลือกผู้รับชำระ เป็น “TMNWLS * True Money Company Limited” (ถ้ายังไม่ได้สร้าง
                                            สามารถสร้างได้โดยคลิกที่ “เพิ่มผู้รับชำระ”) <p>การเพิ่มผู้รับชำระ
                                                ทำได้ดังนี้</p>
                                            <ul>
                                                <li>i. เลือกจากประเภทธุรกิจ เป็น “สินค้า/บริการ”</li>
                                                <li>ii. ค้นหาจากรหัสบริษัท/ชื่อบริษัทผู้รับชำระ ระบุเป็น “TMNWLS”
                                                    แล้วกดค้นหา จะพบผู้ให้บริการ เป็นบริษัท ทรู มันนี่ จำกัด
                                                </li>
                                                <li>iii. คลิกที่ บริษัท ทรู มันนี่ จำกัด เพื่อเลือกบริษัทผู้รับชำระเงิน</li>
                                                <li>iv. ระบุหมายเลขประจำตัวลูกค้า (เลขที่อ้างอิง 1)</li>
                                                <li>v. กด “ขั้นตอนต่อไป” คุณจะได้รับรหัสผ่านครั้งเดียว (OTP)
                                                    ที่เบอร์โทรศัพท์มือถือของคุณทาง SMS
                                                </li>
                                            </ul>
                                        </li>
                                        <li>เลือกเลขที่บัญชีที่ต้องการใช้ชำระเงิน</li>
                                        <li>ระบุ "หมายเลขลูกค้า / Ref.1" และ “หมายเลขอ้างอิง / Ref.2”
                                            ตามที่ปรากฎในหน้าสรุปรายการสั่งซื้อตามที่ปรากฎในหน้าสรุปรายการสั่งซื้อ
                                        </li>
                                        <li>ระบุจำนวนเงินที่ต้องการชำระ</li>
                                        <li>ตรวจสอบข้อมูลการชำระค่าสินค้าและบริการ</li>
                                        <li>กดปุ่ม "ยืนยัน" เพื่อชำระค่าสินค้าและบริการ</li>
                                    </ol>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <!-- /iBanking -->
            <?php elseif($data['payment_method_code'] == 'banktrans'): ?>
                <!-- Bank Counter -->
                <table class="table table-bordered border-top--dotted">
                    <tbody>
                        <tr>
                            <td class="border-top--none">
                                <div class="channel-payment">
                                    <div class="channel-payment__head">
                                        <div class="channel-payment__name">
                                            <p class="text--regular"><?php echo __("thankyou-order-payment-channel"); ?></p>
                                            <span class="text--payment-name">เคาน์เตอร์ธนาคาร</span>
                                        </div>
                                        <div class="channel-payment__icn">
                                            <img src="<?php echo Theme::asset()->usePath()->url('img/icn/ico-bankcounter.png'); ?>"/>
                                        </div>
                                    </div>
                                    <div class="channel-payment__content">
                                        <p class="text--default">สามารถชำระเงินค่าสินค้าโดยการ<a href="#">พิมพ์แบบฟอร์มชำระเงิน</a> แล้วนำไปชำระเงินผ่าน
                                            ธนาคารไทยพาณิชย์ ธนาคารกรุงเทพ หรือ ธนาคารกสิกรไทยทุกสาขาทั่วประเทศ
                                            โดยธนาคารจะขอเรียกเก็บค่าธรรมเนียมการชำระเงิน* จากคุณ
                                        </p>
                                                        <span class="text--small">
                                                            * อัตราค่าธรรมเนียมขึ้นอยู่กับแต่ละธนาคาร (20-40 บาท)
                                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- /Bank Counter -->
            <?php elseif($data['payment_method_code'] == 'cod'): ?>
                <!-- COD -->
                <table class="table table-bordered border-top--dotted">
                    <tbody>
                        <tr>
                            <td class="border-top--none">
                                <div class="channel-payment">
                                    <div class="channel-payment__head">
                                        <div class="channel-payment__name">
                                            <p class="text--regular"><?php echo __("thankyou-order-payment-channel"); ?></p>
                                            <span class="text--payment-name">เก็บเงินปลายทาง</span>
                                        </div>
                                        <div class="channel-payment__icn">
                                            <img src="<?php echo Theme::asset()->usePath()->url('img/icn/cod_icon.png'); ?>"/>
                                        </div>
                                    </div>
                                    <div class="channel-payment__content">
                                        <p class="text--default">สามารถชำระเงินค่าสินค้าเป็นเงินสดให้กับพนักงานจัดส่งสินค้าเมื่อคุณเลือกรับสินค้าที่บ้าน</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- /COD -->
            <?php elseif($data['payment_method_code'] == 'cs'): ?>
                <!-- Counter Service -->
                <table class="table table-bordered border-top--dotted">
                    <tbody>
                        <tr>
                            <td class="border-top--none">
                                <div class="channel-payment">
                                    <div class="channel-payment__head">
                                        <div class="channel-payment__name">
                                            <p class="text--regular"><?php echo __("thankyou-order-payment-channel"); ?></p>
                                            <span class="text--payment-name">เคาน์เตอร์เซอร์วิส</span>
                                        </div>
                                        <div class="channel-payment__icn">
                                            <img src="<?php echo Theme::asset()->usePath()->url('img/icn/ico-counterservice.png'); ?>"/>
                                        </div>
                                    </div>
                                    <div class="channel-payment__content">
                                        <p class="text--default">
                                            สามารถชำระเงินค่าสินค้าโดยการนำบาร์โค้ดตามที่ปรากฎในหน้าสรุปรายการสั่งซื้อหรืออีเมล์ของคุณ
                                            แล้วนำไปชำระเงินผ่านเคาน์เตอร์เซอร์วิสทุกสาขาทั่วประเทศ โดยจะมีการเรียกเก็บค่าธรรมเนียมการชำระเงิน* จากคุณ
                                        </p>
                                        ​<span class="text--small">* อัตราค่าธรรมเนียม 15  บาท</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-top--dotted">
                                <div class="channel-payment__content">
                                    <p class="text--default">บาร์โค้ดสำหรับชำระเงินที่เคาน์เตอร์เซอร์วิส</p>

                                    <p class="text--regular">
                                        <img src="<?php echo Theme::asset()->usePath()->url('img/bq-2.jpg'); ?>" />
                                    </p>

                                    <span class="text--small">* อัตราค่าธรรมเนียม 15  บาท</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- /Counter Service -->
            <?php elseif($data['payment_method_code'] == 'ccinstm'): ?>
                <!-- Installment -->
                <table class="table table-bordered border-top--dotted">
                    <tbody>
                        <tr>
                            <td class="border-top--none">
                                <div class="channel-payment">
                                    <div class="channel-payment__head">
                                        <div class="channel-payment__name">
                                            <p class="text--regular"><?php echo __("thankyou-order-payment-channel"); ?></p>
                                            <span class="text--payment-name">
                                                <?php echo __("thankyou-payment-installment-subtitle"); ?>
                                                <?php if(!empty($data["installment_bank"]["abbreviation"])): ?>
                                                    (<?php echo __("bank-installment-".$data["installment_bank"]["abbreviation"]); ?> 0% <?php if(!empty($data['installment'])){ echo $data['installment'] . " "  . __("month");} ?>)
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <div class="channel-payment__icn">
                                            <img src="<?php echo Theme::asset()->usePath()->url('img/icn/ico-installment.png'); ?>"/>
                                        </div>
                                    </div>
                                    <div class="channel-payment__content">
                                        <p class="text--default"><?php echo __("thankyou-ccinstm-payment-desc"); ?></p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- /Installment -->
            <?php endif; ?>
        </div>
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