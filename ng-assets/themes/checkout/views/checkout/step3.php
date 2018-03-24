<?php 
	$ccw_pkey 			= '155413837979192';
	$atm_pkey 			= '156513837979495';
	$ibank_pkey 		= '158913837979603';
	$pay_counter_pkey 	= '152313837979681';
	$cs_pkey 			= '153213837979857';
	$cod_pkey 			= '155613837979771';
	$installment_pkey 	= '156813837979402';

    $open_https = Config::get("https.useHttps");
?>

<div class="title">
    <h1><?php echo __('step3-payment-method'); ?></h1>
</div>
<div class="c-main" data-tab-active="<?php /*if( empty($cart['data']['payment_method_code']) && $cart["data"]["type"] == "installment" ) { echo "ccinstm"; } elseif(!empty($cart['data']['payment_method_code'])){ echo $cart['data']['payment_method_code']; };*/ ?>">
    <!-- [S] Payment channel Menu -->
    <div class="c-tab-2">

        <ul id="payment-channel-selection">
            <li class="install" rel="<?php if( ! empty($cart['data']['all_payment_methods'][$installment_pkey]['inventory_ids']) ){echo 'available';} ?>">
                <h2>
                    <a href="#instalment" data-toggle="tab">
                        <span class="payment-title">[ผ่อนชำระ] เครดิต</span><br/>
                        <span>Installment (Visa/Master)</span>
                    </a>
                </h2>
            </li>
            <li class="visa active" rel="<?php if( ! empty($cart['data']['all_payment_methods'][$ccw_pkey]['inventory_ids']) ){echo 'available';} ?>">
                <h2>
                    <a href="#channel-ccw" data-toggle="tab">
                        <span class="payment-title">[จ่ายเต็ม] เครดิต/เดบิต</span><br/>
                        <span>VISA Card / Master card</span>
                    </a>
                </h2>
            </li>
            <li class="atm" rel="<?php if( ! empty($cart['data']['all_payment_methods'][$atm_pkey]['inventory_ids']) ){echo 'available';} ?>" >
                <h2>
                    <a href="#channel-atm" data-toggle="tab">
                        <span class="payment-title">[จ่ายเต็ม] ตู้เอทีเอ็ม</span><br/>
                        <span>ATM</span>
                    </a>
                </h2>
            </li>
			<li class="ibank" rel="<?php if( ! empty($cart['data']['all_payment_methods'][$ibank_pkey]['inventory_ids']) ){echo 'available';} ?>" >
                <h2>
                    <a href="#channel-ibanking" data-toggle="tab">
                        <span class="payment-title">[จ่ายเต็ม] ไอแบงก์กิ้ง</span><br/>
                        <span>Internet Banking</span>
                    </a>
                </h2>
            </li>
            <li class="bank" rel="<?php if( ! empty($cart['data']['all_payment_methods'][$pay_counter_pkey]['inventory_ids']) ){echo 'available';} ?>" >
                <h2>
                    <a href="#channel-paymentcounter" data-toggle="tab">
                        <span class="payment-title">[จ่ายเต็ม] เคาน์เตอร์ธนาคาร</span><br/>
                        <span>Bank Counter</span>
                    </a>
                </h2>
            </li>
            <li class="cservice" rel="<?php if( ! empty($cart['data']['all_payment_methods'][$cs_pkey]['inventory_ids']) ){echo 'available';} ?>" >
                <h2>
                    <a href="#channel-counterservice" data-toggle="tab">
                        <span class="payment-title">[จ่ายเต็ม] เคาน์เตอร์เซอร์วิส</span><br/>
                        <span>Counter Service</span>
                    </a>
                </h2>
            </li>
            <li class="hservice" rel="<?php if( ! empty($cart['data']['all_payment_methods'][$cod_pkey]['inventory_ids']) ){echo 'available';} ?>" >
                <h2>
                    <a href="#channel-cod" data-toggle="tab">
                        <span class="payment-title">[จ่ายเต็ม] เก็บเงินปลายทาง</span><br/>
                        <span>Cash on Delivery</span>
                    </a>
                </h2>
            </li>
        </ul>
    </div>
    <!-- [E] Payment channel Menu -->
    <form id="form-payment" action="<?php echo URL::toLang('checkout/step3', array(), $open_https); ?>" method="post">
        <div class="c-info">
            <div class="c-info-in tab-content">

                <!-- Message box -->
                <?php echo Theme::widget("checkoutAlertMsg", array("checkout"=>$checkout))->render(); ?>
                <!-- Message box -->

				<?php //if( array_key_exists($ccw_pkey, $cart['data']['available_payment_methods']) ): ?>
					<!--[S] Credit Card -->
					<?php echo Theme::widget('payCcw', array())->render(); ?>
					<!--[E] /Credit Card -->
				<?php //endif; ?>

				<?php //if( array_key_exists($atm_pkey, $cart['data']['available_payment_methods']) ): ?>
					<!--[S] ATM -->
					<?php echo Theme::widget('payAtm', array('cart' => $cart))->render(); ?>
					<!--[E]/ATM -->
				<?php //endif; ?>
				
				<?php //if( array_key_exists($installment_pkey, $cart['data']['available_payment_methods']) ): ?>
					<!--[S] Instalment -->
					<div id="channel-instalment" class="tab-pane">
					</div>
					<!--[E] /Instalment -->
				<?php //endif; ?>
				
				<?php //if( array_key_exists($ibank_pkey, $cart['data']['available_payment_methods']) ): ?>
					<!--[S] iBanking -->
					<?php echo Theme::widget('payIbank', array())->render(); ?>
					<!--[E] /iBanking -->
				<?php //endif; ?>
				
				<?php //if( array_key_exists($pay_counter_pkey, $cart['data']['available_payment_methods']) ): ?>
					<!--[S] Paymentcounter -->
					<?php echo Theme::widget('payBankTrans', array())->render(); ?>
					<!--[E] /Paymentcounter -->
				<?php //endif; ?>
				
				<?php //if( array_key_exists($cs_pkey, $cart['data']['available_payment_methods']) ): ?>
					<!--[S] Counter Service -->
					<?php echo Theme::widget('payCs', array())->render(); ?>
					<!--[E] /Counter Service -->
				<?php //endif; ?>
				
				<?php //if( array_key_exists($cod_pkey, $cart['data']['available_payment_methods']) ): ?>
					<!--[S] COD -->
					<?php echo Theme::widget('payCod', array())->render(); ?>
					<!--[E] /COD -->
				<?php //endif; ?>
                
				<?php //if( array_key_exists($installment_pkey, $cart['data']['available_payment_methods']) ): ?>
					<!-- [S] Installment -->
					<?php echo Theme::widget("payInstallment", array('checkout' => $checkout, 'monthly_installment' => $monthly_installment))->render(); ?>
					<!-- [E] /Installment -->
				<?php //endif; ?>

                <!-- [S] Error installment --->
                <div class="clear"></div>
                <br/>
                <?php echo Theme::partial("installErrorContainer", array()); ?>
                <!-- [S] Error installment --->

				<!-- [S] Billing Address -->
				<?php echo Theme::widget('billingAddress', array('cart' => $cart))->render(); ?>
				<!-- [E] Billing Address -->
				
                <div class="clear"></div>

                <div class="control-label-name">
                    <p class="control-label-info left">&nbsp;</p>
                    <div class=" form-max-info">
                        <?php
                        if(Config::get('maintenance.show_btn') == true)
                        {
                         ?>
                            <input id="step3-submit" class="form-bot" name="step3_submit" type="submit" value="<?php echo __('step3-order'); ?>" autocomplete="off" />

                        <?php } ?>
                    </div>
                </div>

                <div style="display: block; text-align: center;" id="close_msg">
                    <div style="font-size: 16px;" class="active-alert-text"></div>
                    <br>
                </div>

            </div>
        </div>
        <div class="clear"></div>
    </form>
	<span class="last-payment" style="display:none;"><?php echo ( ! empty($cart['data']['payment_method_code'])) ? $cart['data']['payment_method_code'] : ""; ?></span>
</div>

<div class="box-footer">
    <p>
        <input id="subscribe_email" name="subscribe_email" type="checkbox" checked="checked" value="<?php echo (!empty($cart['data']['customer_email']))? $cart['data']['customer_email'] : ""; ?>" class="control-form" />
        <?php echo __('step3-subscribe-news-with'); ?> iTruemart.com <?php echo __('step3-promotions-and-special-offer'); ?>
    </p>
    <p>*<?php echo __('step3-iread'); ?><a href="#" style="color:blue;" data-toggle="modal" data-target="#termServicesDialog"><?php echo __('step3-policy'); ?></a><?php echo __('step3-already'); ?></p>
    <br />
    <div class="clear"></div>

</div>

<div id="close_time" style="display:none;">
    <span id="start_time"><?php echo strtotime('2014-07-09 22:50:00');?></span>
    <span id="stop_time"><?php echo strtotime('2014-07-10 03:10:00');?></span>
    <span id="now"><?php echo strtotime(date('Y-m-d H:i:s'));?></span>
</div>

<?php echo Theme::widget("manageItemForPaymentLightbox", array("checkout"=>$checkout))->render(); ?>

<?php echo Theme::widget("manageCampaignProductLightbox", array())->render(); ?>

<!-- Confirm Payment Popup -->
<?php echo Theme::partial("confirmPaymentPopup", array()); ?>
<!-- /Confirm Payment Popup -->