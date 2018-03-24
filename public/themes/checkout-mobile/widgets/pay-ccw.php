<div class="payment-channel">
    <input type="radio" name="payment_channel" value="visa" id="credit-card" />
    <label for="credit-card">
        <img src="<?php echo Theme::asset()->usePath()->url('images/ico-visa.png'); ?>" class="ico_payment_channel" /><span class="payment-name">[จ่ายเต็มจำนวน]<sup class="text--red">***</sup> เครดิต/เดบิต<br/><small>VISA Card / Master Card</small></span>
    </label>
    <div class="divider-menu divider-menu-active">
        <div class="add-remark">
            <div class="form-group">
                <div class="col-xs-12" style="position: relative;">
                    <input id="ccw-info-name" class="form-control" name="creditname" type="text" placeholder="<?php echo __('step3-name-surname-on-card'); ?>" autocomplete="off" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12" style="position: relative;">
                    <input id="ccw-info-no" class="form-control" name="creditnum" maxlength="16" type="text" placeholder="<?php echo __('step3-type-credit-number'); ?>" autocomplete="off" />
                </div>
            </div>
            <div class="form-group select-group" style="position: relative;">
                <label class="control-label"><?php echo __('step3-expire-date') ?></label>
                <div class="select-control" id="expired_input">
                    <select id="expire" name="expiremonth" class="form-control" autocomplete="off" >
                        <option value=""><?php echo __('step3-month'); ?></option>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <?php
                            if ($i <= 9) {
                                $str_val = '0' . $i;
                            } else {
                                $str_val = $i;
                            }
                            ?>
                            <option value="<?php echo $str_val; ?>">
                                <?php echo $str_val; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                    <select id="expire" name="expireyear" class="form-control" autocomplete="off" >
                        <option value=""><?php echo __('step3-year'); ?></option>
                        <?php $year = date('Y') + 10; ?>
                        <?php for ($i = 2014; $i <= $year; $i++): ?>
                            <option value="<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="form-group select-group" style="position: relative;">
                <label class="control-label">
                    <?php echo __('step3-ccv'); ?>
                </label>
                <div class="col-xs-6" id="ccv_input">
                    <input class="form-control" id="ccv" maxlength="3" name="ccv" type="password" placeholder="000" autocomplete="off"  style=""/>
                    <div class="cvv-control">
                        <img src="<?php echo Theme::asset()->usePath()->url('images/visa_ex.png'); ?>" alt="" width="80px"/>
                    </div>
                </div>
				<div class="cybersource">
                    <span>Secure by</span> <a href="#">CyberSource</a>
                </div>
            </div>
        </div>
    </div>
</div>