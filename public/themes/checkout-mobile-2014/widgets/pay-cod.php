
<div class="payment-channel">
    <input type="radio" name="payment_channel" value="cod" id="cod"/>
    <label for="cod">
        <img src="<?php echo Theme::asset()->usePath()->url("img/ico-cod.png"); ?>" class="ico_payment_channel" alt="cash on delivery"/>
        <span class="payment-name"><small>Cash on Delivery</small></span>
    </label>

    <div class="divider-menu" id="box-cod">
        <!-- Duplicate this div-class to apply another warning message box kub -->
        <?php if( !isset($checkout['available_payment_methods']['155613837979771']) ): ?>
            <div class="clear-error-msg" id="cod-payment-error" style="display: none"></div>
        <?php endif ?>
        <div class="add-remark" id="cod-payment-block">
            <h3><?php echo __('cod-header1-mobile')?></h3>
<!--            <ol>-->
<!--                <li>--><?php //echo __('cod-content1');?><!--</li>-->
<!--                <li>--><?php //echo __('cod-content2');?><!--</li>-->
<!--                <li>--><?php //echo __('cod-content3');?><!--</li>-->
<!--                <li>--><?php //echo __('cod-content4');?><!--</li>-->
<!--            </ol>-->
        </div>
    </div>
</div>
