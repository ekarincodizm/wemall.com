<?php
    # alert($collection['children'],  'blue', 'COLLECTION');
    # dd($banners_brand);
?>

<?php if($type == 'promotion'):?>
	<?php if ( ! empty($banners_promotion)):?>
	<?php if ($banners_promotion['group_total'] > 0):?>
		<?php #Promotion of collection => set from banner MGT ?>
		<?php foreach ($banners_promotion['group_list'] as $k_promotion =>$v_promotion):?>
			<?php if ($v_promotion['is_random'] == 'Y'){ shuffle($v_promotion['banner_list']);}?>
			<?php foreach ($v_promotion['banner_list'] as $key =>$val):?>
			<div class="banner-bar">
				<a href="<?php echo $val['url_link']; ?>" title="<?php echo htmlspecialchars($val['name']);?>">
					<img src="<?php echo $val['img_path']; ?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['name']);?>">
				</a>
			</div>
			<?php if ($v_promotion['show_per_time'] == 1){break 1;}?>
			<?php endforeach;?>
		<?php endforeach;?>
	<?php endif;?>
	<?php endif;?>
<?php else:?>
	<?php if( ! empty($banners)):?>
	<?php if( $banners['group_total'] >= 5):?>
	<?php if( ! empty($collection)):?>
	<?php #Collection banner => set from banner MGT ?>
	<?php #alert($collection,  'green');?>
		<div class="category-box">
			<div class="category-header">
				<h3 class="header-text-container">
					<img src="/themes/itruemart/assets/images/icn/category/icn-ct-1.png" alt="" />

					<?php
						$main_cat = $collection['name'];
						if(App::getLocale() == 'en') :
							$main_cat = isset($collection['translate']['name']) ? $collection['translate']['name'] : $collection['name'];
						endif;
					?>
					<a href="<?php echo get_permalink('category', $collection) ?>"><?php echo $main_cat;?></a>
				</h3>
				<?php $collection['children'] = array();?>
				<?php if ( ! empty($collection['children'])):?>
				<ul>
					<?php foreach ($collection['children'] as $key_children => $val_children):?>
						<?php
							$sub_cat = $val_children['name'];
							if(App::getLocale() == 'en') :
								$sub_cat = isset($val_children['translate']['name']) ? $val_children['translate']['name'] : $val_children['name'];
							endif;
						?>
						<li><a href="<?php echo get_permalink('category', $val_children) ?>"><?php echo $sub_cat;?></a></li>
					<?php endforeach;?>
				</ul>
				<?php endif;?>
			</div>

			<div class="category-content">
				<div class="banner-box">
					<?php if ($banners['group_list'][0]['banner_total'] > 0):?>
						<div class="pos-1">
							<ul class="category-banner">
								<?php foreach ($banners['group_list'][0]['banner_list'] as $key_banner => $val_banner):?>
								<li>
									<a href="<?php echo $val_banner['url_link']; ?>" title="<?php echo htmlspecialchars($val_banner['name']);?>">
										<img src="<?php echo $val_banner['img_path']; ?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val_banner['name']);?>" />
									</a>
								</li>
								<?php endforeach;?>
							</ul>
						</div>
					<?php endif;?>

					<?php if ($banners['group_list'][1]['banner_total'] > 0):?>
						<a href="<?php echo $banners['group_list'][1]['banner_list'][0]['url_link']; ?>" title="<?php echo htmlspecialchars($banners['group_list'][1]['banner_list'][0]['name']);?>" class="pos-2" rel="slideDescription">
							<img src="<?php echo $banners['group_list'][1]['banner_list'][0]['img_path']; ?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($banners['group_list'][1]['banner_list'][0]['name']);?>" />
							<?php if ( ! empty($banners['group_list'][1]['banner_list'][0]['description'])):?>
								<span class="banner-desc"><?php echo strip_words($banners['group_list'][1]['banner_list'][0]['description'], 110 ); ?></span>
							<?php endif;?>
						</a>
					<?php endif ?>

					<?php if ($banners['group_list'][2]['banner_total'] > 0):?>
						<a href="<?php echo $banners['group_list'][2]['banner_list'][0]['url_link']; ?>" title="<?php echo htmlspecialchars($banners['group_list'][2]['banner_list'][0]['name']);?>" class="pos-3" rel="slideDescription">
							<img src="<?php echo $banners['group_list'][2]['banner_list'][0]['img_path']; ?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($banners['group_list'][3]['banner_list'][0]['name']);?>" />
							<?php if ( ! empty($banners['group_list'][2]['banner_list'][0]['description'])):?>
								<span class="banner-desc"><?php echo strip_words($banners['group_list'][2]['banner_list'][0]['description'], 110 ); ?></span>
							<?php endif;?>
						</a>
					<?php endif ?>

					<?php if ($banners['group_list'][3]['banner_total'] > 0):?>
						<a href="<?php echo $banners['group_list'][3]['banner_list'][0]['url_link']; ?>" title="<?php echo htmlspecialchars($banners['group_list'][3]['banner_list'][0]['name']);?>" class="pos-4" rel="slideDescription">
							<img src="<?php echo $banners['group_list'][3]['banner_list'][0]['img_path']; ?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($banners['group_list'][3]['banner_list'][0]['name']);?>" />
							<?php if ( ! empty($banners['group_list'][3]['banner_list'][0]['description'])):?>
								<span class="banner-desc"><?php echo strip_words($banners['group_list'][3]['banner_list'][0]['description'], 85 ); ?></span>
							<?php endif;?>
						</a>
					<?php endif ?>

					<?php if ($banners['group_list'][4]['banner_total'] > 0):?>
						<a href="<?php echo $banners['group_list'][4]['banner_list'][0]['url_link']; ?>" title="<?php echo htmlspecialchars($banners['group_list'][4]['banner_list'][0]['name']);?>" class="pos-5" rel="slideDescription">
							<img src="<?php echo $banners['group_list'][4]['banner_list'][0]['img_path']; ?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($banners['group_list'][4]['banner_list'][0]['name']);?>" />
							<?php if ( ! empty($banners['group_list'][4]['banner_list'][0]['description'])):?>
								<span class="banner-desc"><?php echo strip_words($banners['group_list'][4]['banner_list'][0]['description'], 85 ); ?></span>
							<?php endif;?>
						</a>
					<?php endif ?>
				</div>
				<div class="product-box">
					<h4><?php echo __("home-hot-sell-lbl"); ?></h4>
					<?php if ( ! empty($bestseller)) : ?>
					<?php #alert($bestseller); ?>
					<ul>

						<?php foreach ($bestseller as $key => $value) : ?>
						<?php if ($key <= 4) : ?>
						<li <?php echo ($key == 1) ? 'class="active"' : ""; ?>>
							<a href="<?php echo levelDUrl($value['slug'], $value['pkey']); ?>" title="<?php echo $value['title']; ?>">
								<span><?php echo $value['title']; ?></span>
								<p class="product-detail">
									<?php if(isset($value['image_cover'])): ?>
										<img src="<?php echo $value['image_cover']['thumbnails']['medium']; ?>" alt="" style="width:100px; height:100px;" />
									<?php else: ?>
										<img src="/themes/itruemart/assets/images/no_image.png" alt="" style="width:100px; height:100px;" />
									<?php endif; ?>
									<span>
										<?php $labelDiscount = (!empty($value['percent_discount']['max']) && $value['percent_discount']['max'] > 0) ? (int) $value['percent_discount']['max'] : 0; ?>

										<?php if($labelDiscount > 0): ?>
											<?php if(isset($value['variants'][0]['active_special_discount'])) : ?>
												<?php
													$item_variants = $value['variants'][0]['active_special_discount'];
													if(!empty($item_variants)) :
														$discountPercent = ($item_variants['discount_type'] == 'percent') ? $item_variants['discount'] : ($value['variants'][0]['normal_price'] - $item_variants['discount_price']) / ($value['variants'][0]['normal_price'] * 100);
														if ( !empty($item_variants['campaign_type']) ) :
															$discountType = ($labelDiscount == $discountPercent) ? $item_variants['campaign_type'] : 'onsale';
														else :
															$discountType = 'onsale';
														endif;
													endif;
												?>
										<?php endif; ?>

											<span class="p-label home <?php echo (isset($discountType)) ? $discountType : 'onsale'; ?>">
												<?php echo $labelDiscount; ?><i>%</i>
										</span>
										<?php endif; ?>
										<span class="price">
											<?php if ( ! empty($value['special_price_range']['min']) && ! empty($value['special_price_range']['max'])) : ?>
												<?php if ($value['net_price_range']['min'] == $value['net_price_range']['max']) : ?>
												<i><?php echo price_format($value['net_price_range']['min']); ?> .-</i>
												<?php echo price_format($value['price_range']['min']); ?> .-
												<?php else : ?>
												<i><?php echo price_format($value['net_price_range']['min']); ?> - <?php echo price_format($value['net_price_range']['max']); ?></i>
												<?php echo price_format($value['price_range']['min']); ?> - <?php echo price_format($value['price_range']['max']); ?>
												<?php endif; ?>

											<?php else : ?>
												<?php if ($value['price_range']['min'] == $value['price_range']['max']) : ?>
												<?php echo price_format($value['price_range']['min']); ?> .-
												<?php else : ?>
												<?php echo price_format($value['price_range']['min']); ?> - <?php echo price_format($value['price_range']['max']); ?>
												<?php endif; ?>
											<?php endif; ?>
										</span>
									</span>
								</p>
							</a>
						</li>
						<?php endif; ?>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( ! empty($banners_brand)):?>
			<?php if ($banners_brand['group_total'] > 0):?>
			<?php if ( $banners_brand['group_list'][0]['banner_total'] >= 8):?>
			<?php #Brand of collection => set from banner MGT ?>
			<div class="category-footer">
				<ul class="brand-box">
					<?php foreach ($banners_brand['group_list'][0]['banner_list'] as $key_brand => $val_brand ):?>
						<li>
							<a href="<?php echo $val_brand['url_link']; ?>" title="<?php echo htmlspecialchars($val_brand['name']);?>">
								<img src="<?php echo $val_brand['img_path']; ?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val_brand['name']);?>" />
							</a>
						</li>
						<?php if ($key_brand == 7){break 1;} // Show 8 banner?>
					<?php endforeach;?>
				</ul>
			</div>
			<?php endif;?>
			<?php endif;?>
			<?php endif;?>
		</div>

		<?php if ( ! empty($banners_promotion)):?>
		<?php if ($banners_promotion['group_total'] > 0):?>
			<?php #Promotion of collection => set from banner MGT ?>
			<?php foreach ($banners_promotion['group_list'] as $k_promotion => $v_promotion):?>
				<?php if ($v_promotion['is_random'] == 'Y'){ shuffle($v_promotion['banner_list']);}?>
				<?php foreach ($v_promotion['banner_list'] as $key =>$val):?>
				<div class="banner-bar">
					<a href="<?php echo $val['url_link']; ?>" title="<?php echo htmlspecialchars($val['name']);?>">
						<img src="<?php echo $val['img_path']; ?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['name']);?>">
					</a>
				</div>
				<?php if ($v_promotion['show_per_time'] == 1){break 1;}?>
				<?php endforeach;?>
			<?php endforeach;?>
		<?php endif;?>
		<?php endif;?>

	<?php endif;?>
	<?php endif;?>
	<?php endif;?>
<?php endif;?>