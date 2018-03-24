<?php
    // alert($collection['children'],  'blue', 'COLLECTION');
    // dd($banners_brand);
?>

<?php if($type == 'promotion'):?>
	<?php if ( ! empty($banners_promotion)):?>
	<?php if ($banners_promotion['group_total'] > 0):?>
		<?php #Promotion of collection => set from banner MGT ?>
		<?php foreach ($banners_promotion['group_list'] as $k_promotion =>$v_promotion):?>
			<?php //dd($v_promotion['is_random']);?>
			<?php foreach ($v_promotion['banner_list'] as $key =>$val):?>
			<div class="banner-bar">
				<a href="<?php echo $val['url_link']; ?>" title="<?php echo htmlspecialchars($val['name']);?>">
					<img src="<?php echo $val['img_path']; ?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['name']);?>">
				</a>

			</div>
			<?php if ($v_promotion['is_random'] == 'Y'){break 1;}?>
			<?php endforeach;?>
		<?php endforeach;?>
	<?php endif;?>
	<?php endif;?>
<?php else:?>
	<?php if( ! empty($banners)):?>
	<?php if( $banners['group_total'] >= 5):?>
	<?php if( ! empty($collection)):?>
	<?php #Collection banner => set from banner MGT ?>
	<?php //alert($collection['children'],  'green');?>
		<div class="category-box">
			<div class="category-header">
				<h3 class="header-text-container"><img src="/themes/itruemart/assets/images/icn/category/icn-ct-1.png" alt="" /><?php echo $collection['name'];?></h3>
				<?php if ( ! empty($collection['children'])):?>
				<ul>
					<?php foreach ($collection['children'] as $key_children => $val_children):?>
						<li><a href="<?php echo get_permalink('category', $val_children) ?>"><?php echo $val_children['name'];?></a></li>
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
						<a href="<?php echo $banners['group_list'][0]['banner_list'][0]['url_link']; ?>" title="<?php echo htmlspecialchars($banners['group_list'][3]['banner_list'][0]['name']);?>" class="pos-3" rel="slideDescription">
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
					<h4>สินค้าขายดี</h4>
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
										
										<?php $promotion_type = ""; ?>
										<?php if (isset($value['variants'][0]['active_special_discount']['campaign_type']) && $value['variants'][0]['active_special_discount']['campaign_type'] == "flash_sale") : ?>
										<?php $promotion_type = "flash-sale"; ?>
										<?php elseif (isset($value['variants'][0]['active_special_discount']['campaign_type']) && $value['variants'][0]['active_special_discount']['campaign_type'] == "itruemart_tv") : ?>
										<?php $promotion_type = "today-special"; ?>
										<?php elseif (empty($value['variants'][0]['active_special_discount']['campaign_type']) && ! empty($value['variants'][0]['active_special_discount']['discount_price'])) : ?>
										<?php $promotion_type = "on-sale"; ?>
										<?php endif; ?>
										<?php if ( ! empty($promotion_type)) : ?>
										<span class="p-label home <?php echo $promotion_type; ?>">

											<?php echo $value['percent_discount']['max']; ?><i>%</i>
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
						
						
						<?php #alert($bestseller); ?>
						<?php /*
						<li class="active">
							<a href="#">
								<span>เสื้อคอกว้างผ้าโปร่ง ใส่สบาย ปกเชิ๊ต แขนสั้น</span>
								<p class="product-detail">
									<img src="/themes/itruemart/assets/images/product/product_1.jpg" alt=""/>
									<span>
										<span class="p-label home flash-sale">
											99<i>%</i>
										</span>
										<span class="price">
											<i>₱ 100.-</i>
											₱ 99,999.-
										</span>
									</span>
								</p>
							</a>
						</li>
						<li>
							<a href="#">
								<span>เสื้อคอกว้างผ้าโปร่ง ใส่สบาย ปกเชิ๊ต แขนสั้น</span>
								<p class="product-detail">
									<img src="/themes/itruemart/assets/images/product/product_1.jpg" alt=""/>
									<span>
										<span class="p-label home on-sale">
											99<i>%</i>
										</span>
										<span class="price">
											<i>₱ 100.-</i>
											₱ 99,999.-
										</span>
									</span>
								</p>
							</a>
						</li>
						<li>
							<a href="#">
								<span>เสื้อคอกว้างผ้าโปร่ง ใส่สบาย ปกเชิ๊ต แขนสั้น</span>
								<p class="product-detail">
									<img src="/themes/itruemart/assets/images/product/product_1.jpg" alt=""/>
									<span>
										<span class="p-label home on-sale">
											99<i>%</i>
										</span>
										<span class="price">
											<i>₱ 100.-</i>
											₱ 99,999.-
										</span>
									</span>
								</p>
							</a>
						</li>
						<li>
							<a href="#">
								<span>เสื้อคอกว้างผ้าโปร่ง ใส่สบาย</span>
								<p class="product-detail">
									<img src="/themes/itruemart/assets/images/product/product_1.jpg" alt=""/>
									<span>
										<span class="p-label home flash-sale">
											99<i>%</i>
										</span>
										<span class="price">
											<i>₱ 100.-</i>
											₱ 99,999.-
										</span>
									</span>
								</p>
							</a>
						</li>
						<li>
							<a href="#">
								<span>เสื้อคอกว้างผ้าโปร่ง ใส่สบาย</span>
								<p class="product-detail">
									<img src="/themes/itruemart/assets/images/product/product_1.jpg" alt=""/>
									<span>
										<span class="p-label home flash-sale">
											99<i>%</i>
										</span>
										<span class="price">
											<i>₱ 100.-</i>
											₱ 99,999.-
										</span>
									</span>
								</p>
							</a>
						</li>
						*/ ?>
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
				<?php foreach ($v_promotion['banner_list'] as $key =>$val):?>
				<div class="banner-bar">
					<a href="<?php echo $val['url_link']; ?>" title="<?php echo htmlspecialchars($val['name']);?>">
						<img src="<?php echo $val['img_path']; ?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['name']);?>">
					</a>
				</div>
				<?php if ($v_promotion['is_random'] == 'Y'){break 1;}?>
				<?php endforeach;?>
			<?php endforeach;?>
		<?php endif;?>
		<?php endif;?>
		
	<?php endif;?>
	<?php endif;?>
	<?php endif;?>
<?php endif;?>