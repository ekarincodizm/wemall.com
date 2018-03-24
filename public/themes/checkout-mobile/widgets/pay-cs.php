<div class="payment-channel">
	<input type="radio" name="payment_channel" value="cservice" id="counter-service"  />
	<label for="counter-service">
		<img src="<?php echo Theme::asset()->usePath()->url('images/ico-counterservice.png');?>" class="ico_payment_channel" />
		<span class="payment-name">เคาน์เตอร์เซอร์วิส<br/><small>Counter Service</small></span>
	</label>
	<div class="divider-menu">
		<div class="add-remark">
			<p><?php echo __("thankyou-cs-payment-desc"); ?></p>
			<div>
				<ul>
					<li><span class="clr-8">*</span><?php echo __('thankyou-cs-payment-notice1'); ?></li>
				</ul>
			</div>
			<!--<p>ชำระเงินผ่านเคาน์เตอร์เซอร์วิส</p>
			<p style="text-indent: 30px;">สามารถชำระเงินค่าสินค้าโดยการดาวน์โหลดและพิมพ์แบบฟอร์มชำระเงินตามที่ปรากฎในหน้าสรุปรายการสั่งซื้อหรืออีเมล์ของคุณ 
			แล้วนำไปชำระเงินผ่านเคาน์เตอร์เซอร์วิสทุกสาขาทั่วประเทศ โดยธนาคารจะขอเรียกเก็บค่าธรรมเนียมการชำระเงิน<span class="red">*</span> จากคุณ</p><p style="padding-bottom: 1em;"><span class="red">*</span> อัตราค่าธรรมเนียม 15 บาท</p>
			-->
		</div>
	</div>
</div>