<div id="channel-atm" class="tab-pane">
	<div>
		<div class=" form-max-info-2">
			<h1 class="clr-2"> <?php echo __("step3-how-to-pay-with-atm");/*ขั้นตอนการชำระเงินผ่าน ATM*/ ?></h1>
		</div>
	</div>
	<div class="box-channel-atm">
		<div class=" form-max-info-2">
			<div class="bank-list">
				<div class="left control-label-icon" >
					<input
					<?php echo (empty($cart['data']['bank_name']) OR ( ! empty($cart['data']['bank_name']) && $cart['data']['bank_name'] == "kbank")) ? 'checked="checked"' : ""; ?> 
					name="channel-atm" class="channel-atm" value="kbank" data-target="atm-kbank" type="radio" value="" checked="checked" />
				</div>
				<div class=" bank-k"><?php echo __("step3-kbank"); ?></div>
			</div>
			<div class="bank-list">
				<div class="left control-label-icon">
					<input 
					<?php echo ( ! empty($cart['data']['bank_name']) && $cart['data']['bank_name'] == "scb") ? 'checked="checked"' : ""; ?> 
					name="channel-atm" class="channel-atm" value="scb" data-target="atm-scb" type="radio" value="" />
				</div>
				<div class=" bank-scb"><?php echo __("step3-scb"); ?></div>
			</div>
			<div class="bank-list">
				<div class="left control-label-icon">
					<input <?php echo ( ! empty($cart['data']['bank_name']) && $cart['data']['bank_name'] == "bbl") ? 'checked="checked"' : ""; ?> name="channel-atm" class="channel-atm" value="bbl" data-target="atm-bangkok" type="radio" value="" />
				</div>
				<div class=" bank-bkk"><?php echo __("step3-bbl"); ?></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
	<div>
		<div class="form-max-info-2 payment-process">
            <span><?php echo __("checkout3-how-to-pay");?></span>
			<ul class="payment-process-desc process-atm open" id="atm-kbank">
				<li><?php echo __("thankyou-atmkbank-howto-step1"); ?></li>
				<li><?php echo __("thankyou-atmkbank-howto-step2"); ?></li>
				<li><?php echo __("thankyou-atmkbank-howto-step3"); ?></li>
				<li><?php echo __("thankyou-atmkbank-howto-step4"); ?></li>
				<li><?php echo __("thankyou-atmkbank-howto-step5"); ?></li>
				<li><?php echo __("thankyou-atmkbank-howto-step6"); ?></li>
				<li><?php echo __("thankyou-atmkbank-howto-step7"); ?></li>
				<li><?php echo __("thankyou-atmkbank-howto-step8"); ?></li>
			</ul>
			<ul class="payment-process-desc process-atm" id="atm-scb">
				<li><?php echo __("thankyou-atmscb-howto-step1"); ?></li>
				<li><?php echo __("thankyou-atmscb-howto-step2"); ?></li>
				<li><?php echo __("thankyou-atmscb-howto-step3"); ?></li>
				<li><?php echo __("thankyou-atmscb-howto-step4"); ?></li>
				<li><?php echo __("thankyou-atmscb-howto-step5"); ?></li>
				<li><?php echo __("thankyou-atmscb-howto-step6"); ?></li>
				<li><?php echo __("thankyou-atmscb-howto-step7"); ?></li>
				<li><?php echo __("thankyou-atmscb-howto-step8"); ?></li>
				<li><?php echo __("thankyou-atmscb-howto-step9"); ?></li>
				<li><?php echo __("thankyou-atmscb-howto-step10"); ?></li>
				<li><?php echo __("thankyou-atmscb-howto-step11"); ?></li>
				<li><?php echo __("thankyou-atmscb-howto-step12"); ?></li>
			</ul>
			<ul class="payment-process-desc process-atm" id="atm-bangkok">
				<li><?php echo __("thankyou-atmbangkok-howto-step1"); ?></li>
				<li><?php echo __("thankyou-atmbangkok-howto-step2"); ?></li>
				<li><?php echo __("thankyou-atmbangkok-howto-step3"); ?></li>
				<li><?php echo __("thankyou-atmbangkok-howto-step4"); ?></li>
				<li><?php echo __("thankyou-atmbangkok-howto-step5"); ?></li>
				<li><?php echo __("thankyou-atmbangkok-howto-step6"); ?></li>
				<li><?php echo __("thankyou-atmbangkok-howto-step7"); ?></li>
			</ul>
		</div>
	</div>
	<div>
<!--		<div class=" form-max-info-2"><br />
			<h2 class="clr-3"><?php echo __("thankyou-atm-payment-notice3-line1"); ?></h2>
			<?php echo __("thankyou-atm-payment-notice3-line2"); ?><br /><br />
			<h2 class="clr-3"><?php echo __("thankyou-atm-payment-notice4-line1"); ?></h2>
			<?php echo __("thankyou-atm-payment-notice4-line2"); ?><br /><br />
			<p class="alert">*<?php echo __("thankyou-atm-payment-notict5"); ?></p>
		</div>-->
	</div>
	<div class="box-sub-divider clear"></div>
</div>