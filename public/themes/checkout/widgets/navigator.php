<div id="header">
	<div class="sub-content <?php echo ( ! empty($step)) ? $step : "step"; ?>">
		<div class="logo left"><img src="<?php echo Theme::asset()->usePath()->url('images/logo.jpg'); ?>" width="215" height="44" style="border:none;">
			<p><a href="<?php echo url(); ?>" alt="www.itruemart.com" title="www.itruemart.com">www.itruemart.com</a></p>
		</div>
		<div class="right top-head-box">
			<div class="right top-lang">ภาษา : <img src="<?php echo Theme::asset()->usePath()->url('images/th.png'); ?>" width="16" height="11"></div>
	        <div class="right top-lang">สกุลเงิน :<span class="alert"> PHP</span></div>
			<div class="clear"></div>
	        <div class="on-profile">
			    <div class="on-login">
					<div class="pic-profile"></div>
			        <div class="name-profile"><a href="#">ชินวัฒน์ ตู้ธีระ</a></div>
				</div>
			</div>
	        <div class="clear"></div>
		</div>
		<div class="step-on">
			<ul>
				<li><a href="<?php echo url(); ?>">ล็อกอิน</a></li>
				<li><a href="<?php echo url(); ?>">กรอกที่อยู่จัดส่งสินค้า</a></li>
				<li><a href="<?php echo url(); ?>">เลือกช่องทางการชำระเงิน</a></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>