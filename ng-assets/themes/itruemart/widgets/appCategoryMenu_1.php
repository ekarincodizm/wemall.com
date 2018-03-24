<?php //sd($category); ?>
<div class="header__sidebar">
	<ul class="sidebar_1">
		<li class="active">
			<a href="<?php echo URL::to('shopbybrand') ?>" title="<?php echo strtoupper(__('shop_by_brand')); ?>" data-id="category_1"><?php echo strtoupper(__('shop_by_brand')); ?></a>
		</li>
		
		<?php if ( ! empty($category['collections'])): ?>
		<?php foreach ($category['collections'] as $item => $value): ?>
			<li>
				<a href="<?php echo get_permalink('category', $value) ?>" data-id="category_3">
				<?php
					if(App::getLocale()=='th')
					{
						echo array_get($value,'name');
					}
					else
					{
						if(array_get($value,'translate') != null)
						{
							echo array_get($value,'translate.name');
						}
						else
						{
							echo array_get($value,'name');
						}
					}
				?>
				</a>
				<div class="sidebar_group">
					<?php if ( ! empty($value['children'])): ?>
					<!-- Sub Category -->
						<ul class="sidebar_2" id="category_1">
							<li class="sidebar_name">\ 
							<?php
								if(App::getLocale()=='th')
								{
									echo array_get($value,'name');
								}
								else
								{
									if(array_get($value,'translate') != null)
									{
										echo array_get($value,'translate.name');
									}
									else
									{
										echo array_get($value,'name');
									}
								}
							?>
							</li>
							<?php foreach ($value['children'] as $c_key => $children): ?>
								<li>
									<a href="<?php echo get_permalink('category', $children) ?>">
									<?php
										if(App::getLocale()=='th')
										{
											echo array_get($children,'name');
										}
										else
										{
											if(array_get($children,'translate') != null)
											{
												echo array_get($children,'translate.name');
											}
											else
											{
												echo array_get($children,'name');
											}
										}
									?>
									</a>
								</li>
							<?php endforeach;?>
						</ul>
					<?php endif; ?>
					
					<?php if ( ! empty($value['brands'])): ?>
					<!-- Brands -->
						<ul class="sidebar_3">
							<li>
								<?php foreach ($value['brands'] as $b_key => $brand): ?>
									<a href="<?php echo URL::toLang('/brand/'.$brand['pkey'].'');?>" alt="<?php echo $brand['name']; ?>">
										<!--
										<img src="<?php echo $brand['image']; ?>" title="<?php echo $brand['name']; ?>" />
										-->
										<img src="<?php echo Theme::asset()->usePath()->url('images/logo/nokia.png'); ?>" title="<?php echo $brand['name']; ?>" />
									</a>
									<?php if ($b_key == 12): ?>
										<a href="<?php echo URL::to('shopbybrand') ?>" class="other_brand" title="<?php echo strtoupper(__('shop_by_brand')); ?>">...</a>
										<?php break 1; ?>	
									<?php endif; ?>	
								<?php endforeach; ?>	
							</li>
						</ul>
					<?php endif; ?>
					
					<?php if ( ! empty($value['products'])): ?>
					<!-- Products -->
						<?php 
							if (count($value['products']) == 1)
							{
								$product_style = "lay_col_1";
							}
							elseif (count($value['products']) == 2)
							{
								$product_style = "lay_col_2";
							}
							elseif (count($value['products']) == 3)
							{
								$product_style = "lay_col_3";
							}
							elseif (count($value['products']) >= 4)
							{
								$product_style = "lay_col_4";
							}
							else
							{
								$product_style = "";
							}
						?>
						<ul class="sidebar_4 <?php echo $product_style;?>">
							<?php foreach ($value['products'] as $p_key => $product): ?>
							<?php $product_title = isset($product['title']) ? $product['title'] : ""; ?>
							<li>
								<a href="<?php echo get_permalink('products', $product) ?>">
									<?php $percent_discount_max = isset($product['percent_discount']['max']) ? $product['percent_discount']['max'] : 0;?>
									<?php $percent_discount_min = isset($product['percent_discount']['min']) ? $product['percent_discount']['min'] : 0;?>
									<?php if ($percent_discount_max > 0): ?>
										<?php if (count($value['products']) == 1 || count($value['products']) == 2 || (count($value['products']) == 3 && $p_key == 0)): ?>
											<span class="price_tag">
												<span class="price_no">
													<?php 
														// if($percent_discount_max != $percent_discount_min)
														// {
															// echo $percent_discount_min."-".$percent_discount_max;
														// }
														// else
														// {
															// echo $percent_discount_max;
														// }
														echo $percent_discount_max;
													?>
												</span>
												<sup>%</sup>
												<sub>OFF</sub>
											</span>
										<?php endif; ?>
									<?php endif; ?>
									<?php
									/*
									<img src="<?php echo $product['image_cover']['normal']; ?>" title="<?php echo $product_title; ?>" />
									*/
									?>
									<img src="<?php echo Theme::asset()->usePath()->url('images/banner/ex-product.jpg'); ?>" title="<?php echo $product_title; ?>" />
									<span class="product_information">
									<span class="tag_product_name"><?php echo $product_title; ?></span>
									<span class="tag_price">
									
									<?php if ($percent_discount_max > 0): ?>
										<span class="price_discount">
										<?php 
											$percent_discount_max = isset($product['percent_discount']['max']) ? $product['percent_discount']['max'] : 0;
											$percent_discount_min = isset($product['percent_discount']['min']) ? $product['percent_discount']['min'] : 0;
											if($percent_discount_max > $percent_discount_min)
											{
												echo price_format($percent_discount_min) . " - " . price_format($percent_discount_max) . " .-";
											}
											else
											{
												echo price_format($percent_discount_max)." .-";
											}
										?>
										</span>
									<?php endif; ?>
									
									<span class="price_normal <?php if($percent_discount_max > 0){echo "discount";} ?>">
										<?php 
											$net_price_range_max = isset($product['net_price_range']['max']) ? $product['net_price_range']['max'] : 0;
											$net_price_range_min = isset($product['net_price_range']['min']) ? $product['net_price_range']['min'] : 0;
											if($net_price_range_max != $net_price_range_min)
											{
												echo price_format($net_price_range_min) . " - " . price_format($net_price_range_max)." .-";
											}
											else
											{
												echo price_format($net_price_range_max)." .-";
											}
										?>
									</span>
									</span>
									</span>
								</a>
							</li>
							<?php if ($p_key == 3): ?>
								<?php break 1; ?>	
							<?php endif; ?>	
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
		<?php endif; ?>
	</ul>
</div>
