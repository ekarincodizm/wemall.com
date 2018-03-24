<div class="prd_media">
	<?php if (!empty($price['percent_discount']['min']) && !empty($price['percent_discount']['max'])): ?>
		<span class="price_tag">
			<?php if ($price['percent_discount']['min'] == $price['percent_discount']['max']): ?>
				<span class="price_no">
				<?php $percent_discount = floor($price['percent_discount']['min']); echo $percent_discount>=100 ? 99: $percent_discount; ?>
				</span>
			<?php else: ?>
				<span class="price_text"><?php echo __("up_to"); ?></span>
				<span class="price_no">
				<?php $percent_discount = floor($price['percent_discount']['max']); echo $percent_discount>=100 ? 99 : $percent_discount; ?>
				</span>
			<?php endif; ?>

			<sup>%</sup>
			<sub>OFF</sub>
		</span>
	<?php endif; ?>
	<div id="product_image" class="prd_img" data-zoom-image="<?php echo $image_cover; ?>">
		<img id="product_thumbnail" src="<?php echo $image_cover; ?>" alt="<?php echo !empty($price["product_name"])? $price["product_name"] :"" ; ?>"  />
	</div>
	
	<?php if($image_cover != "") { ?>
	<div class="prd_group">
		<a href="#" class="productCarousel__navigate_prev">
		</a>
		<div class="productCarousel__wrapper">
			<div class="productCarousel__container owl-carousel owl-theme">

				<?php foreach ($media_contents as $thumbnail) { ?>

					<div class="owl-item">
						<div class="productCarousel__item">
							<a href class="show_thumb small" rel="nofollow">
								<img src="<?php echo $thumbnail['small']; ?>" data-zoom-large="<?php echo $thumbnail['zoom']; ?>" alt="<?php echo !empty($price["product_name"])? $price["product_name"] :"" ; ?>" />

							</a>
						</div>
					</div>
				<?php } ?>

			</div>
		</div>
		<a href="#" class="productCarousel__navigate_next">
		</a>
	</div>
	<?php } ?>
</div>
