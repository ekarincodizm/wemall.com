<div class="payment-channel">
	<input type="radio" name="payment_channel" value="atm" id="atm"  />
	<label for="atm">
		<img src="<?php echo Theme::asset()->usePath()->url('images/ico-atm.png'); ?>" class="ico_payment_channel" />
		<span class="payment-name">ตู้ ATM<br/><small>ATM</small></span>
	</label>
	<div class="divider-menu">
		<div class="add-remark">
			<p><?php echo __("step3-mobile-atm-title");?> <img src="<?php echo Theme::asset()->usePath()->url('images/bank_banner.png'); ?>" height="55" /></p>
			<p><?php echo __("thankyou-atm-payment-desc"); ?></p>
			<ul>
				<li>
					<span class="clr-8">*</span> 
					<?php echo __("thankyou-atm-payment-notice1"); ?> 
				</li>
			</ul>
		</div>
	</div>
</div>