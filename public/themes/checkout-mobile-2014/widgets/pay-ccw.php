<div class="payment-channel">
    <input type="radio" name="payment_channel" value="credit-card" id="credit-card" <?php /*if(strtolower($checkout['payment_method_code']) == 'ccw'){ echo 'checked';};*/ ?> />
    <label for="credit-card">
        <img src="<?php echo Theme::asset()->usePath()->url("img/ico-visa.png"); ?>" class="ico_payment_channel" alt="credit card"/>
        <span class="payment-name">VISA Card / Master Card</span>
    </label>

    <div class="divider-menu" id="box-credit-card">
        <div class="add-remark">
            <div class="form-group select-group margin-top-10">
                <label class="control-label"><?php echo __('step3-name-surname'); ?></label>
                <input type="text" id="ccw-info-name" name="creditname" value="" class="form-control" placeholder="<?php echo __('step3-name-surname-on-card'); ?>" autocomplete="off">
            </div>
            <div class="form-group select-group">
                <label class="control-label"><?php echo __('step3-credit-number'); ?></label>
                <input type="number" name="creditnum" value="" maxlength="16" class="form-control" placeholder="<?php echo __('step3-type-credit-number'); ?>" autocomplete="off" id="creditnum">
            </div>
            <div class="form-group select-group">
                <label class="control-label"><?php echo __('step3-expire-date') ?></label>

                <div class="select-control">
                    <select class="form-control" name="expiremonth" autocomplete="off">
                        <option disabled="disabled" value="" selected="selected" hidden="hidden"><?php echo __('step3-month'); ?></option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <select class="form-control" name="expireyear" autocomplete="off">
                        <option disabled="disabled" selected="selected" hidden="hidden" value=""><?php echo __('step3-year'); ?></option>
                        <?php $start_year = date('Y'); ?>
                        <?php $year = $start_year + 10; ?>
                        <?php for ($i = $start_year; $i <= $year; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="form-group select-group">
                <label class="control-label"><?php echo __('step3-ccv'); ?></label>
                <div class="cvv-control">
                    <div class="ccv-container">
                        <input type="password" name="ccv" value="" class="form-control" placeholder="<?php echo __('step3-type-ccv'); ?>" maxlength="3" autocomplete="off">
                        <img src="<?php echo Theme::asset()->usePath()->url("img/visa_ex.png"); ?>" alt="visa"/>
                    </div>
                </div>
                ​
                <div class="cybersource">
                    <span>Secured by</span><img src="<?php echo Theme::asset()->usePath()->url("img/dragonpay-logo.png");?>" alt="dragonpay" />
                </div>
            </div>
        </div>
    </div>
</div>