<div class="main_checkout" style="background-color:#f2f2f2;">

	<!-----------  alltotal ------------>
	<div class="alltotal">
		<div class="result">
			<?php if (array_get($data, 'data.payment_status') === 'waiting' || array_get($data, 'data.payment_status') === 'failed') : ?>
			<div>
				<span class="complete"><h8>คุณทำรายการ<span class="redfont">ไม่สมบูรณ์</span></h8></span>
			</div>
			<button type="submit" onclick="location.href='<?php echo URL::route('checkout.requery');?>?order_id=<?php echo array_get($data,'data.order_id'); ?>'" class="btn btn-primary re-checkout">คลิกเพื่อทำรายการอีกครั้ง</button>
			<?php elseif (array_get($data, 'data.payment_status') === 'cancel' ) : ?>
			<div>
				<span class="complete">
					<h8>คุณทำรายการ<span class="redfont">ไม่สมบูรณ์</span></h8><br>
					<span class="redfont"><?php echo __('Thank you');?>  iTrueMart.com</span>
				</span>
			</div>		
			<?php elseif (array_get($data, 'data.payment_status') === 'expired'): ?>
			<div>
				<span class="complete">
					<h8>รายการนี้<span class="redfont">หมดอายุแล้ว</span></h8><br>
					<span class="redfont"><?php echo __('Thank you');?>  iTrueMart.com</span>
				</span>
			</div>				
			<?php endif; ?>
		</div>
	</div> <!------------ End alltotal------------>

</div>