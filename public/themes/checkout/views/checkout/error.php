<div class="sub-content headline">
	<div class="box-done">
		<div class="in-form">
			<div class="thank-icon clr-2 icon-cancel">
				<h1><?php echo __('out-of-stock-header'); ?></h1>
				<br>
				<span><?php echo __('out-of-stock-content');?></span>
				<br>
				<br>
				<a class="form-bot" href="/" style="color:#fff;"><?php echo __('Go back for shopping');?></a>
			</div>
			<div class="clear"></div>
		</div>

		<div style="display:none;">
		<?php
			if(!empty($response))
			{
				s($response); 
			}
		?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>