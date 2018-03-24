<?php //sd($product); ?>
<ul
	class="prd_price_list"
	data-inventory-id="<?php echo ( ! empty($product['variants'][0]['inventory_id'])) ? $product['variants'][0]['inventory_id'] : ""; ?>"
	data-has-variant="<?php echo ($product['has_variants'] == 1) ? "1" : "0"; ?>"
	data-product-pkey="<?php echo ( ! empty($product['pkey'])) ? $product['pkey'] : ""; ?>">
	<li>
		<div class="prd_label">
			<span class="lbl_text"><?php echo __('Price');?></span>
		</div>
		<div class="prd_control price">
			<span class="normal_price"><?php echo $netprice_range['min']; ?><?php if($netprice_range['min'] != $netprice_range['max'])
			{
				echo ' - '.$netprice_range['max'];
			} ?></span><span> /<?php echo __("piece");?></span>
		</div>
	</li>

	<?php if (($specialprice_range['min'] != 0) || ($specialprice_range['max'] != 0)): ?>
	<li>
		<div class="prd_label">
			<span class="lbl_text special"><?php echo __('Discount Price'); ?></span>
		</div>
		<div class="prd_control price">
			<span class="special_price"><?php echo $specialprice_range['min']; ?><?php if($specialprice_range['min'] != $specialprice_range['max'])
			{
				echo ' - '.$specialprice_range['max'];
			} ?></span><span> /<?php echo __("piece");?></span>
		</div>
	</li>
	<?php endif; ?>


	<?php if ( ! empty($variants_color)) : ?>
	<li class="style-types">
		<div class="prd_label">
			<span class="lbl_text"><?php echo __('select_color') ?></span>
		</div>
		<div class="prd_control options">
			<ul class="type_container" data-style-name="color" data-options-name="<?php echo __("Color"); ?>" data-media-set="<?php echo ($variants_color['media_set'] == true) ? 1 : 0; ?>">
				<?php foreach ($variants_color['color_variants'] as $color) : ?>
					<?php //if ($variants_color['media_set'] == true) : ?>
					<?php if ($color['media_type'] == 'image') : ?>
						<li class="box_type">
							<!-- <a href="#"><img src="http://cdn.itruemart.com/files/product/802/24399/palette/2222_2.jpg" /></a> -->
							<a href="#" class="style-option style-color" title="<?php echo $color['colorText']; ?>" data-style-option="<?php echo $color['pkey']; ?>" data-pkey="<?php echo $color['pkey']; ?>"><img src=<?php echo $color['color_meta_value']; ?>></a>
						</li>
					<?php else : ?>
						<li class="box_type">
							<!-- <a href="#"><img src="http://cdn.itruemart.com/files/product/802/24399/palette/2222_2.jpg" /></a> -->
							<a href="#" class="style-option style-color" title="<?php echo $color['colorText']; ?>" data-style-option="<?php echo $color['pkey']; ?>" data-pkey="<?php echo $color['pkey']; ?>"><?php echo $color['color_meta_value']; ?></a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</li>
	<?php endif; ?>

	<?php if ( ! empty($variants_size)) : ?>
	<li class="style-types">
		<div class="prd_label">
			<span class="lbl_text"><?php echo __('select_size') ?></span>
		</div>
		<div class="prd_control options">
			<ul class="type_container" data-style-name="size" data-options-name="<?php echo __("Size"); ?>" data-media-set="<?php echo ($variants_size['media_set'] == true) ? 1 : 0; ?>">
				<?php foreach ($variants_size['size_variants'] as $size) : ?>
					<?php //if ($variants_size['media_set'] == true) : ?>
					<?php if ($size['media_type'] == 'image') : ?>
						<li class="box_type">
							<!-- <a href="#"><img src="http://cdn.itruemart.com/files/product/802/24399/palette/2222_2.jpg" /></a> -->
							<a href="#" class="style-option style-size" title="<?php echo $size['sizeText']; ?>" data-style-option="<?php echo $size['pkey']; ?>" data-pkey="<?php echo $size['pkey']; ?>"><img src=<?php echo $size['size_meta_value']; ?>></a>
						</li>
					<?php else : ?>
						<li class="box_type">
							<!-- <a href="#"><img src="http://cdn.itruemart.com/files/product/802/24399/palette/2222_2.jpg" /></a> -->
							<a href="#" class="style-option style-size" title="<?php echo $size['sizeText']; ?>" data-style-option="<?php echo $size['pkey']; ?>" data-pkey="<?php echo $size['pkey']; ?>"><?php echo $size['size_meta_value']; ?></a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>


			</ul>
		</div>
	</li>
	<?php endif; ?>

	<li>
		<div class="prd_label">
			<span class="lbl_text"><?php echo __("select_quantity");?></span>
		</div>

                <div class="prd_control options">
			<input type="number"
                   class="box_amount product-qty"
                   min="1" max="5"
                   value="1"
                   readonly="true"
                   data-is-wow='<?php echo json_encode($is_wow); ?>'
                   onfocus="this.blur()"/>
		</div>

	</li>
	<li>
		<div class="prd_label">
			<span class="lbl_text"><?php echo __('Status'); ?></span>
		</div>
		<div class="prd_control options">
			<div class="box_status blank">
			</div>
			<div class="box_status stock-loading" style="display:none;">
				<img src="<?php echo Theme::asset()->usePath()->url('images/loading.gif'); ?>">
			</div>

            <?php #alert($product, 'red'); ?>
            <?php if ($product['has_variants'] == 1) : ?>
            <?php // [B] PreLoad Status ---// ?>

            <div class="box_msg style-option-status" style="margin-top:10px;">
                <?php if ( ! empty($variants_color) && ! empty($variants_size)) : ?>
                <span class="no-color-size"><?php echo __("please-select-color-and-size-of-product"); ?></span>
                <span class="no-size" style="display:none;"><?php echo __("please-select-size-of-product"); ?></span>
                <span class="no-color" style="display:none;"><?php echo __("please-select-color-of-product"); ?></span>

                <?php elseif ( ! empty($variants_color) && empty($variants_size)) : ?>

                <span class="no-size" style="display:none;"><?php echo __("please-select-size-of-product"); ?></span>
                <span class="no-color-size" style="display:none;"><?php echo __("please-select-color-and-size-of-product"); ?></span>
                <span class="no-color"><?php echo __("please-select-color-of-product"); ?></span>
                <?php elseif ( ! empty($variants_size) && empty($variants_color)) : ?>

                <span class="no-color"><?php echo __("please-select-color-of-product"); ?></span>
                <span class="no-color-size" style="display:none;"><?php echo __("please-select-color-and-size-of-product"); ?></span>
                <span class="no-size" style="display:none;"><?php echo __("please-select-size-of-product"); ?></span>
                <?php endif; ?>


            </div>
            <?php // [E] PreLoad Status ---// ?>
            <?php endif; ?>

			<div class="box_status active box-status-has-stock" style="display:none;">
				<img src="<?php echo Theme::asset()->usePath()->url('images/icn/active.png'); ?>" /> <?php echo __('In stock'); ?>
			</div>
			<div class="box_status inc_active box-status-no-stock" style="display:none;">
				<img src="<?php echo Theme::asset()->usePath()->url('images/icn/in-active.png'); ?>" /> <?php echo __('out of stock'); ?>
			</div>

		</div>
	</li>
</ul>
<div class="order_container">

    <?php
    if(Config::get('maintenance.show_btn') == true){
    ?>
    <button class="btn_order product-addtocart" data-inventories-wow-in-cart='<?php echo json_encode(array()); ?>' data-inventory-id="" data-allow-installment="<?php echo ($product['installment']['allow'] == true) ? "true" : "false"; ?>"><?php echo __("buy now"); ?></button>
    <?php } ?>
</div>
