<div class="payment-channel">
	<input type="radio" name="payment_channel" value="ibank" id="ibanking"  />
	<label for="ibanking">
		<img src="<?php echo Theme::asset()->usePath()->url('images/ico-ibanking.png');?>" class="ico_payment_channel" />
		<span class="payment-name">ไอแบงก์กิ้ง<br/><small>Internet Banking</small></span>
	</label>
	<div class="divider-menu">
		<div class="add-remark">
			<p><?php echo __("step3-mobile-ibank-title"); ?><img src="<?php echo Theme::asset()->usePath()->url('images/bank_banner.png'); ?>" width="162" height="66" /></p>
			<p><?php echo __("thankyou-ibank-payment-desc"); ?></p>

					<p>* <?php echo __("thankyou-ibank-payment-notice1"); ?></p>

		</div>
	</div>
</div>
