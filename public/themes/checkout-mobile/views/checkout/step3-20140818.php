<style>
    .icon-success-2 {
        left: 455px;
        position : absolute;
        top: 15px;
    }

    .product-list{
        background-color: #ffffff;
        padding: 0 1.8em;
    }
</style>
<div class="row profile-container">
    <!-- Start Menu Right -->
	<?php $open_https = Config::get("https.useHttps"); ?>
    <form id="form-payment" action="<?php echo URL::toLang('checkout/step3', array(), $open_https); ?>" method="post" autocomplete="off" data-tab-active="<?php if( empty($cart['data']['payment_method_code']) && $cart["data"]["type"] == "installment" ) { echo "ccinstm"; } elseif(!empty($cart['data']['payment_method_code'])){ echo $cart['data']['payment_method_code']; }; ?>" >
        <input type="hidden" checked="" autocomplete="off" value="Y" class="inv-addr" id="add-invoice" name="add_invoice">
        <div class="col-xs-12 col-sm-3 col-sm-push-9">
            <div class="text-center menu-right">
                <div class="well text-left list-payment-channel">
                    <!-- Payment Channel -->
                    <div class="inc-title">
                        <h2><?php echo __('step3-payment-method'); ?></h2>
                    </div>
					<!--============================-->
                    <!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                    <!--============================-->
                    <?php $key = '156813837979402'; # Installment?>  
                    <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <!-- [S] Installment -->
                        <?php //echo Theme::widget("payInstallment", array('cart' => $cart, 'monthly_installment' => $monthly_installment))->render(); ?>
                        <!-- [E] /Installment -->
                    <?php endif; ?>
                    <!--============================-->
                    <?php $key = '155413837979192'; # CCW?>  
                    <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <!--[S] Credit Card -->
                        <?php echo Theme::widget('payCcw', array())->render(); ?>
                        <!--[E] /Credit Card -->
                    <?php endif; ?>
                    <!--============================-->
                    <!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                    <!--============================-->
                    <?php $key = '156513837979495'; # ATM?>  
                    <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <!--[S] ATM -->
                        <?php //echo Theme::widget('payAtm', array())->render(); ?>
                        <!--[E] /ATM -->
                    <?php endif; ?>
                    <!--============================-->
                    <!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                    <!--============================-->
					<?php $key = '158913837979603'; # Ibanking?>  
                    <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <!--[S] Ibanking -->
                        <?php //echo Theme::widget('payIbank', array())->render(); ?>
                        <!--[E] /Ibanking -->
                    <?php endif; ?>
                    <!--============================-->
                    <!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                    <!--============================-->
                    <?php $key = '152313837979681'; # Bank Transfer?>  
                    <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <!--[S] Bank Transfer -->
                        <?php //echo Theme::widget('payBankTrans', array())->render(); ?>
                        <!--[E] /Bank Transfer -->
                    <?php endif; ?>
                    <!--============================-->
                    <!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                    <!--============================-->
					<?php $key = '153213837979857'; # Counter Service?>  
                    <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <!--[S] Ibanking -->
                        <?php //echo Theme::widget('payCs', array())->render(); ?>
                        <!--[E] /Ibanking -->
                    <?php endif; ?>
                    <!--============================-->
                    <!--++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
                    <!--============================-->
					<?php $key = '155613837979771'; # COD?>  
                    <?php if (isset($checkout['available_payment_methods']) && array_key_exists($key, $checkout['available_payment_methods'])): ?>
                        <!--[S] COD -->
                        <?php //echo Theme::widget('payCod', array())->render(); ?>
                        <!--[E] /COD -->
                    <?php endif; ?>
                    <!--============================-->

                    <!-- END Payment Channel -->
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9 col-sm-pull-3">
            <?php echo Theme::widget("miniAddress", array('checkout' => $checkout))->render(); ?>
            <?php echo Theme::widget("miniCart", array('cart' => $cart, 'checkout' => $checkout, 'step' => '3'))->render(); ?>    
        </div>
        <div id="inc-action-box">
            <?php
            $start_close = new DateTime('2014-07-09 22:50:00');
            $stop_close = new DateTime('2014-07-10 03:10:00');
            $time_now = new DateTime('now');

            if ($time_now >= $start_close && $time_now <= $stop_close)
            {}else{
            ?>
            <input id="step3-submit" class="inc-btn" name="step3_submit" type="submit" value="<?php echo __('step3-order'); ?>" autocomplete="off" />
            <?php
            }
            ?>
        </div>
    </form>
</div>