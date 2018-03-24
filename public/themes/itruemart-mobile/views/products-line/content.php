<?php if ( ! empty($product)) : ?>
<div id="container" style="padding-top:10px;" data-stocks="" data-inv-id="<?php echo ( ! empty($str_inv_id)) ? $str_inv_id : ""; ?>">
	<div class="banner"> 
		<!--Sold out--> 
		<div class="soldout" style="<?php echo ( ! empty($is_timeout) && $is_timeout == "Y") ? '' : "display:none;"; ?>">
			<div class="soldout_bt">สินค้าหมด</div>
		</div>			
		<!--End Sold out-->

		<?php if ( ! empty($product)) : ?>

		<ul id="campaign" data-no-cache="<?php echo Input::has('nocache') ? Input::get('nocache') : ""; ?>" data-product-pkey="<?php echo ( ! empty($product_pkey)) ? $product_pkey : ""; ?>">
			<?php foreach ($product['media_contents'] as $mc_key => $mc_value): ?>
			<?php if ($mc_value['mode'] == "image") : ?>
			<li>
				<a href="#" data-img-id="" data-color-id="">
					<img src="<?php echo $mc_value['thumb']['thumbnails']['large']; ?>" width="100%"/>
				</a>
			</li>
			<?php endif; ?>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		  
	</div>
	<div class="price">
	  	<div style="float:left; padding-left:10px;">
			<h1><?php echo $product['title'];?></h1>
	  	</div>
	  	<div class="clear"></div>
	  	<div style="border-top:1px dotted #990000; margin:10px 0 0px 0; padding:10px 0 0 0">
			<div style=" float:right; padding-right: 10px; text-align:right; width:400px; ">
				<?php /***
				<h2><span style=" text-decoration:line-through;"><?php echo  number_format($product_detail['online_price'])?></span></h2>
				<h1><?php echo  number_format($product_detail['special_price'])?> สั่งซื้อ</h1>
				**/ ?>
				<?php if ( ! empty($product['special_price_range']['min']) && ! empty($product['special_price_range']['max'])) : ?>
				<?php if ($product['net_price_range']['min'] == $product['net_price_range']['max']) : ?>
				<h2><span style="text-decoration:line-through;"><?php echo price_format($product['net_price_range']['min']); ?> .-</h2>
				<h1><?php echo price_format($product['price_range']['min']); ?> .-</h1>
				<?php else : ?>
				<h2><span style="text-decoration:line-through"><?php echo price_format($product['net_price_range']['min']); ?> - <?php echo price_format($product['net_price_range']['max']); ?> .-</h2>
				<h1><?php echo price_format($product['price_range']['min']); ?> - <?php echo price_format($product['price_range']['max']); ?> .-</h1>
				<?php endif; ?>
				<?php else : ?>
				<?php if ($product['price_range']['min'] == $product['price_range']['max']) : ?>
				<?php echo price_format($product['price_range']['min']); ?> .-
				<?php else : ?>
				<?php echo price_format($product['price_range']['min']); ?> - <?php echo price_format($product['price_range']['max']); ?>
				<?php endif; ?>
				<?php endif; ?>											
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>	
		
		
	<?php if ( ! empty($product['style_types'])) : ?>
	<?php foreach ($product['style_types'] as $st_key => $st_value) : ?>
	<div class="style_types" style="padding:10px; position:relative; <?php echo ($st_key == 1) ? 'border-top:1px dotted #CCCCCC;' : ""; ?>">

		<?php if ($st_key == 0) : ?>
		<div style="position: absolute; right: 78px; top: 0px;"><img src="<?php echo Theme::asset()->usePath()->url('images/arrow.png'); ?>" width="18" height="6" /></div>
		<?php endif; ?>
			
		<div class="<?php echo ($st_key == 0) ? "color" : "size"; ?>" style="<?php echo ( ! empty($is_timeout) && $is_timeout == "Y") ? 'display:none;' : ""; ?>"> 
			<?php echo $st_value['name']; ?> :		
			<span style="color:<?php echo ($st_key == 0) ? '#099' : '#eb2227'; ?>; font-weight:bold;" class="option-name"><?php #echo $st_value['options'][0]['text']; ?></span> 
			<br/>
				
			<?php if ( ! empty($st_value['options'])) : ?>
			<ul data-style-pkey="<?php echo $st_value['pkey']; ?>" class="style-options-container" data-media-set="<?php echo ($st_value['media_set'] == TRUE) ? 1 : 0; ?>">
				<?php foreach ($st_value['options'] as $o_key => $o_value) : ?>
				<?php #alert($o_value, 'blue'); ?>
				<?php if ($o_value['meta']['type'] == "image" OR $o_value['meta']['type'] == "color") : ?>
				<li class="style-option" data-color-id="<?php #echo $c_value['color_id']; ?>" data-option-name="<?php echo $o_value['text']; ?>" data-pkey="<?php echo $o_value['pkey']; ?>" data-color-pkey="<?php echo $o_value['pkey']; ?>">
					<img src="<?php echo $o_value['meta']['value']; ?>" alt="<?php echo $o_value['text']; ?>">
				</li>
				<?php else : ?>
				<li class="style-option" data-option-name="<?php echo $o_value['text']; ?>" data-pkey="<?php echo $o_value['pkey']; ?>" data-size-pkey="<?php echo $o_value['pkey']; ?>">
					<?php echo $o_value['text']; ?>
				</li>
				<?php endif; ?>
				<?php endforeach; ?>					
			</ul>
			<?php endif; ?>

		</div>
		<div class="clear"></div>
	</div>
	<?php endforeach; ?>
	<?php endif; ?>
		
		
	<div class="buy" style="<?php echo ( ! empty($is_timeout) && $is_timeout == "Y") ? 'display:none;' : ""; ?>">
		<div style="float:left; padding-left:15px;">จำนวน :
			<select name="qty" id="qty">
				<option value="1">1</option>
				<?php /**
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				**/ ?>
			</select>
		</div>
		<div style="float:right; position:relative;">
			<div style="position:absolute; right:45%; top:-10px;" ></div>

			<button class="btn-blue-l btn-addcart add_cart product-addtocart" <?php if ($product['installment']['allow']) { echo 'data-allow-installment="true"'; }?>>สั่งซื้อ</button>
		</div>
		<div class="clear"></div>
	</div>
	<?php #echo Modules::run('campaign/vcache/review', $product_detail['product_id']);?>
	<div class="review">
	    <div class="title">
			<h3>คุณสมบัติสินค้า</h3>
	    </div>
	    <div  style="padding-left:15px; padding-right:15px;">
	        <?php echo ( ! empty($product['key_feature'])) ? $product['key_feature'] : ""; ?>
	    </div>
	</div>
</div>

<div class="content">
	<div class="title">
		<h3>รายละเอียดเพิ่มเติม</h3>
	</div>
</div>

<?php echo ( ! empty($product['description'])) ? $product['description'] : ""; ?>
<div>
    <div class="clear"></div>
</div>
<!--</div>-->
<?php endif;?>	

<!-- installment alert lightbox. -->
<div id="cart-select-installment" class="reveal-modal">
	<div class="font2 msg-header important-green-bg">กรุณาเลือกรูปแบบการชำระ</div>
	<div id="popup_content" class="basket_put font2">
		<div id="popup_message">
			<dl class="detail-cart">
				<dt><?php echo __("inst-alert-payment-method"); ?></dt>
				<dd id="resp-product-title">
					<label><input type="radio" name="cart-installment-select" class="cart-installment-select" value="installment" style="margin-right: 5px;" autocomplete="off" checked /><?php echo __("inst-pay-installment"); ?></label>
					<label><input type="radio" name="cart-installment-select" class="cart-installment-select" value="normal" style="margin-right: 5px;" autocomplete="off" /><?php echo __("inst-pay-full"); ?></label>
				</dd>
			</dl>
			<div class="clearfix"></div>
		</div>
		<div id="popup_panel">
			<input type="button" class="popup_ok btn btn-success cart-installment-button_next" value="<?php echo __("inst-next"); ?>">
		</div>
	</div>
</div>

<div id="cart-adding" class="reveal-modal">
	<div class="font2 msg-header">กำลังเพิ่มสินค้าลงตะกร้า...</div>
</div>

<div id="cart-alert" class="reveal-modal">
	<div class="font2 msg-header text-center alert-title"></div>
	<div id="popup_message" class="alert-message"></div>
	<div id="popup_panel">
		<input id="go_checkout" type="button" class="popup_ok btn btn-success" value="ตกลง">
	</div>
</div>