<div class="payment-channel">
	<input type="radio" name="payment_channel" value="hservice" id="cod"  />
	<label for="cod">
		<img src="<?php echo Theme::asset()->usePath()->url('images/ico-cod.png');?>" class="ico_payment_channel" />
		<span class="payment-name">เก็บเงินปลายทาง<br/><small>Cash on Delivery</small></span>
	</label>
	<div class="divider-menu">
		<div class="add-remark">
			<p><?php echo __("thankyou-cod-payment-title"); ?></p>
			<p><?php echo __("thankyou-cod-payment-desc"); ?></p>
			<p>&nbsp;</p>
		</div>
	</div>
</div>