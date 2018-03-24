<?php if ( ! empty($html)) : ?>
	<?php echo $html; ?> 
<?php else : ?>
<div class="slide-up show" data-slug-pkey="<?php echo ( ! empty($slugpkey)) ? $slugpkey : ""; ?>" data-no-cache="<?php echo ( ! empty($no_cache)) ? $no_cache : ""; ?>">
	<div style="padding:9px 0 0 10px; float:left;"> 
		<img width="135" height="26" src="/themes/itruemart-mobile/assets/images/logo.png">
	</div>
	<div style="float:right; padding-top:3px;">
		<button class="btn-blue-l-slide" style="display: inline;">สั่งซื้อ</button>
	</div>
</div>
<?php endif; ?>
<div style="margin: 0 auto; text-align: center; padding: 30px;" class="loading">
    <img src="<?php echo Theme::asset()->url('images/bx_loader.gif'); ?>">
</div>