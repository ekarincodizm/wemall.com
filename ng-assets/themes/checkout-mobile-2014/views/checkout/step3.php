<form id="form-payment" action="<?php echo URL::toLang('checkout/step3', array(), Config::get("https.useHttps")); ?>" method="post">
    <!-- Payment option -->
    <div class="row">
        <div class="col-xs-12 payment-option-section">
            <h2><?php echo __('step3-payment-method'); ?></h2>
            <!-- [S] Installment -->
            <?php echo Theme::widget("payInstallment", array('checkout' => $checkout))->render(); ?>
            <!-- [E] Installment Tab -->

            <!-- [S] CCW -->
            <?php echo Theme::widget("payCcw", array('checkout' => $checkout))->render(); ?>
            <!-- [E] CCW -->

            <!-- [S] ATM -->
            <?php // echo Theme::widget("payAtm", array())->render(); ?>
            <!-- [E] ATM -->

            <!-- [S] iBanking -->
            <?php // echo Theme::widget("payIbank", array())->render(); ?>
            <!-- [E] iBanking -->

            <!-- [S] Bank Transfer -->
            <?php // echo Theme::widget("payBankTrans")->render(); ?>
            <!-- [E] Bank Transfer -->

            <!-- [S] Counter Services -->
            <?php // echo Theme::widget("payCs", array())->render(); ?>
            <!-- [E] Counter Services -->

            <!-- [S] Pay COD -->
            <?php //echo Theme::widget("payCod", array())->render(); ?>
            <!-- [E] Pay COD -->
        </div>
    </div>
    <!-- End Payment option div-->

    <!-- [S] Address -->
    <?php echo Theme::widget("billingAddress", array('checkout' => $checkout, 'cart' => $cart))->render(); ?>
    <!-- [E] Address -->

    <!-- [S] minicart -->
    <?php echo Theme::partial('minicart'); ?>
    <!-- [E] minicart -->

    <!-- ex.Buy Button Disable (Grey button) -->
    <!-- <div class="row button-buy disable">
      <div class="col-xs-12"><a href="#"><div class="button"><span>ดำเนินการต่อ</span></div></a></div>
    </div> -->
    <!-- Buy Button Enable (Green button) -->
    <?php
    if(Config::get('maintenance.show_btn') == true)
    {
    ?>
    <div class="row button-buy disable">
        <div class="col-xs-12">
            <a href="javascript:void(0);" id="payment-submit-btn"><div class="button"><span><?php echo __('step3-order'); ?></span></div></a>
        </div>
    </div>
    <?php } ?>


</form>
<form action="<?php echo Url::toLang('checkout/apply-coupon', array(), Config::get("https.useHttps")); ?>" id='coupon-submit' method='post' target='_top'>
<input type="hidden" name="code" id="coupon-code">
</form>