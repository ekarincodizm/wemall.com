<?php
$payment_channel = array(
    '155413837979192' => 'visa', // Credit Card
    '156513837979495' => 'atm', // ATM
    '158913837979603' => 'ibank', // iBanking
    '152313837979681' => 'bank', // Banktrans
    '153213837979857' => 'cservice', // Counter Service
    '155613837979771' => 'hservice', // COD
    '156813837979402' => 'install', // Installment
);
$shipment_cod = "14456917914435";

$count_inv = 0;
$shipment = array();
$cod = FALSE;
?>

<?php
if ( isset($checkout['shipments']))
{
    foreach ($checkout['shipments'] as $i => $val)
    {
        $count_inv += count($val['items']);
        foreach ($val['available_shipping_methods'] as $shipment_item => $shipment_val)
        {
            $shipment[$shipment_item] = $shipment_val;
            if (isset($shipment[$shipment_cod]))
            {
                $cod = TRUE;
            }
        }
    }
}
?>

<div id="step3-errmsg-container">
    <?php if ( isset ($checkout['all_payment_methods'])):?>
        <?php foreach ($checkout['all_payment_methods'] as $item => $value):?>
            <?php if (isset($payment_channel[$item])): ?>
                <?php if ( empty($value['inventory_ids'])): ?>
                    <!-- Do not support this payment channel -->
                    <div id="<?php echo $payment_channel[$item];?>" class="ui-msg-box alert alert-danger" style="display: none;" rel="" >
                        <p class="ui-msg-box__main-text--alert">
                            <img class="icn__close-msgbox" src="<?php echo Theme::asset()->usePath()->url('images/warning_icon_s.png');?>"/>
                        </p>
                        <p class="ui-msg-box__main-text--alert">
                            <?php echo __("checkout3-your-cart-cannot-pay-with-this-method",
                                array("paymentmethod" => __($payment_channel[$item]))); ?>
                        </p>
                        <p class="ui-msg-box__sub-text--alert"><?php echo __("checkout3-please-select-other-channel"); ?></p>
                    </div>

                <?php else : ?>
                    <!-- Check items on shipment and items in cart -->
                    <?php if (count($value['inventory_ids']) == $count_inv) : ?>
                        <!-- For COD >> Check payment channel is available for COD -->
                        <?php if ($payment_channel[$item] == "hservoce" && $cod === FALSE) :?>
                            <div id="<?php echo $payment_channel[$item];?>" class="ui-msg-box alert alert-danger" style="display: none;" rel="">
                                <p class="ui-msg-box__main-text--alert">
                                    <img class="icn__close-msgbox" src="<?php echo Theme::asset()->usePath()->url('images/warning_icon_s.png');?>"/>
                                </p>
                                <p class="ui-msg-box__main-text--alert">
                                    <?php echo __("checkout3-your-cart-cannot-pay-with-this-method",
                                        array("paymentmethod" => __($payment_channel[$item]))); ?>
                                </p>
                                <p class="ui-msg-box__sub-text--alert"><?php echo __("checkout3-please-select-other-channel"); ?></p>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php if ($payment_channel[$item] != "install") :?>
                        <div id="<?php echo $payment_channel[$item];?>" class="ui-msg-box alert alert-danger" style="display: none;" rel="different" >
                            <p class="ui-msg-box__main-text--alert">
                                <img class="icn__close-msgbox" src="<?php echo Theme::asset()->usePath()->url('images/warning_icon_s.png');?>"/>
                            </p>
                            <p class="ui-msg-box__main-text--alert">
                                <?php echo __("checkout3-some-product-in-your-cart-cannot-select",
                                    array("paymentmethod" => __($payment_channel[$item]))); ?>
                            </p>
                            <p class="ui-msg-box__sub-text--alert"><?php echo __("checkout3-please-select-other-channel"); ?></p>
                            <p class="ui-msg-box__sub-text--alert"><?php echo __("checkout3-or"); ?></p>
                            <p class="ui-msg-box__sub-text--alert"><?php echo __("checkout3-if-you-want-to-pay-this-method"); ?>
                                <br/><?php echo __("checkout3-please-delete-unpayable-list-from-your-cart"); ?></p>
                            <a href="javascript:void(0);" class="ui-msg-box_link show-manageitempayment-btn"><?php echo __("checkout3-delete-item-in-cart"); ?></a>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>



<?php #alert($checkout);?>
<?php  //alert($checkout['all_payment_methods'], 'red', 'All'); ?>
<?php  //alert($checkout['available_payment_methods'], 'blue', 'Available'); ?>

<!-- Error 1
สินค้าในตะกร้าของคุณไม่สามารถเลือกการชำระแบบ
"ช่องทางการชำระเงินที่เลือก"
ได้
กรุณาเลือกช่องทางอื่นในการชำระเงินค่ะ
-->

<!-- Error 2 // COD
พื้นที่จัดส่งสินค้าของคุณไม่สามารถเลือกชำระแบบ
"ช่องทางการชำระเงินที่เลือก"
ได้
กรุณาเลือกช่องทางอื่นในการชำระเงินค่ะ
-->

<!-- Error 3
มีสินค้าในตะกร้าไม่สามารถชำระแบบ
"ช่องทางการชำระเงินที่เลือก"
ได้
กรุณาเลือกช่องทางการชำระเงินอื่น
หรือ
หากคุณต้องการชำระด้วยวิธีนี้
กรุณาลบสินค้าที่ไม่สามารถชำระได้ออกก่อนค่ะ
ลบสินค้าในตะกร้า
-->

<!-- Error 4
สินค้าในตะกร้าของคุณไม่สามารถเลือกชำระแบบ
"ช่องทางการชำระเงินที่เลือก"
ได้
กรุณาเลือกช่องทางอื่นในการชำระเงินค่ะ
-->
