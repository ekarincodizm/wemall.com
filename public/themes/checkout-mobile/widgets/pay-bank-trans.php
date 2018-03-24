<div class="payment-channel">
	<input type="radio" name="payment_channel" value="bank" id="bank-counter"  />
	<label for="bank-counter">
		<img src="<?php echo Theme::asset()->usePath()->url('images/ico-counterbank.png');?>" class="ico_payment_channel" />
		<span class="payment-name">เคาน์เตอร์ธนาคาร<br/><small>Bank Counter</small></span>
	</label>
	<div class="divider-menu">
		<div class="add-remark">
			<p><?php echo __("step3-mobile-banktrans-title"); ?> <img src="<?php echo Theme::asset()->usePath()->url('images/bank_banner.png'); ?>" width="162" /></p>
			<p><?php echo __("step3-mobile-banktrans-desc"); ?></p>
			<p>* <?php echo __("thankyou-banktrans-payment-notice1"); ?></p>
		</div>
	</div>
</div>