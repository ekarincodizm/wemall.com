<div id="channel-ibanking" class="tab-pane">
	<div>
		<div class=" form-max-info-2">
			<h1 class="clr-2"><?php echo __("step3-how-to-pay-with-ibank"); ?></h1>
		</div>
	</div>
	<div class="box-channel-bank">
		<div class=" form-max-info-2">
			<div class="bank-list">
				<div class="left control-label-icon">
					<input name="channel-ibank" class="channel-ibank" data-target="ibank-kbank" type="radio" value="" checked />
				</div>
				<div class=" bank-k"><?php echo __("step3-kbank"); ?></div>
			</div>
			<div class="bank-list">
				<div class="left control-label-icon">
					<input name="channel-ibank" class="channel-ibank" data-target="ibank-scb" type="radio" value="" />
				</div>
				<div class=" bank-scb"><?php echo __("step3-scb"); ?></div>
			</div>
			<div class="bank-list">
				<div class="left control-label-icon">
					<input name="channel-ibank" class="channel-ibank" data-target="ibank-bangkok" type="radio" value="" />
				</div>
				<div class=" bank-bkk"><?php echo __("step3-bbl"); ?></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
	<div>
		<div class=" form-max-info-2">
            <span><?php echo __("checkout3-how-to-pay");?></span>
			<ul class="payment-process-desc process-ibank open" id="ibank-kbank">
				<li><?php echo __("thankyou-ibankkbank-howto-step1"); ?></li>
				<li><?php echo __("thankyou-ibankkbank-howto-step2"); ?></li>
				<li><?php echo __("thankyou-ibankkbank-howto-step3"); ?></li>
				<li><?php echo __("thankyou-ibankkbank-howto-step4"); ?></li>
				<li><?php echo __("thankyou-ibankkbank-howto-step5"); ?></li>
				<li><?php echo __("thankyou-ibankkbank-howto-step6"); ?><br/>
					<ul>
						<li><?php echo __("thankyou-ibankkbank-howto-step6.1"); ?></li>
						<li><?php echo __("thankyou-ibankkbank-howto-step6.2"); ?></li>
						<li><?php echo __("thankyou-ibankkbank-howto-step6.3"); ?></li>
						<li><?php echo __("thankyou-ibankkbank-howto-step6.4"); ?></li>
						<li><?php echo __("thankyou-ibankkbank-howto-step6.5"); ?></li>
					</ul>
				</li>
				<li><?php echo __("thankyou-ibankkbank-howto-step7"); ?></li>
				<li><?php echo __("thankyou-ibankkbank-howto-step8"); ?></li>
				<li><?php echo __("thankyou-ibankkbank-howto-step9"); ?></li>			
			</ul>
			<ul class="payment-process-desc process-ibank" id="ibank-scb">
				<li><?php echo __("thankyou-ibankscb-howto-step1"); ?></li>
				<li><?php echo __("thankyou-ibankscb-howto-step2"); ?></li>
				<li><?php echo __("thankyou-ibankscb-howto-step3"); ?></li>
				<li><?php echo __("thankyou-ibankscb-howto-step4"); ?></li>
				<li><?php echo __("thankyou-ibankscb-howto-step5"); ?></li>
				<li><?php echo __("thankyou-ibankscb-howto-step6"); ?></li>
				<li><?php echo __("thankyou-ibankscb-howto-step7"); ?>
                                    <p><?php echo __("thankyou-ibankscb-howto-step7-subtitle"); ?></p>
					<ul>
						<li><?php echo __("thankyou-ibankscb-howto-step7.1"); ?></li>
                                                <li><?php echo __("thankyou-ibankscb-howto-step7.2"); ?></li>
                                                <li><?php echo __("thankyou-ibankscb-howto-step7.3"); ?></li>
                                                <li><?php echo __("thankyou-ibankscb-howto-step7.4"); ?></li>
					</ul>
				</li>
				<li><?php echo __("thankyou-ibankscb-howto-step8"); ?></li>
				<li><?php echo __("thankyou-ibankscb-howto-step9"); ?></li>
				<li><?php echo __("thankyou-ibankscb-howto-step10"); ?></li>
				<li><?php echo __("thankyou-ibankscb-howto-step11"); ?></li>
				<li><?php echo __("thankyou-ibankscb-howto-step12"); ?></li>

			</ul>
			<ul class="payment-process-desc process-ibank" id="ibank-bangkok">
				<li><?php echo __("thankyou-ibankbangkok-howto-step1"); ?></li>
				<li><?php echo __("thankyou-ibankbangkok-howto-step2"); ?></li>
				<li><?php echo __("thankyou-ibankbangkok-howto-step3"); ?></li>
				<li><?php echo __("thankyou-ibankbangkok-howto-step4"); ?></li>
				<li><?php echo __("thankyou-ibankbangkok-howto-step5"); ?></li>
				<li><?php echo __("thankyou-ibankbangkok-howto-step6"); ?></li>
				<li><?php echo __("thankyou-ibankbangkok-howto-step7"); ?>
				<p><?php echo __("thankyou-ibankbangkok-howto-step7-subtitle"); ?></p>
                                    <ul>
                                        <li><?php echo __("thankyou-ibankbangkok-howto-step7.1"); ?></li>
                                        <li><?php echo __("thankyou-ibankbangkok-howto-step7.2"); ?></li>
                                        <li><?php echo __("thankyou-ibankbangkok-howto-step7.3"); ?></li>
                                        <li><?php echo __("thankyou-ibankbangkok-howto-step7.4"); ?></li>
                                        <li><?php echo __("thankyou-ibankbangkok-howto-step7.5"); ?></li>
                                    </ul>
                                </li>
				<li><?php echo __("thankyou-ibankbangkok-howto-step8"); ?></li>
				<li><?php echo __("thankyou-ibankbangkok-howto-step9"); ?></li>
				<li><?php echo __("thankyou-ibankbangkok-howto-step10"); ?></li>
				<li><?php echo __("thankyou-ibankbangkok-howto-step11"); ?></li>
				<li><?php echo __("thankyou-ibankbangkok-howto-step12"); ?></li>
			</ul>
		</div>
	</div>
	<div class="box-sub-divider clear"></div>
</div>