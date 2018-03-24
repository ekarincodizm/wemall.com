<?php $ln = Lang::getLocale(); ?>
<?php
		/*** Check Layout for product position ***/	
		$products_layout[1] = array('P1', 'P2', 'P3', 'P4', 'P5'); ?>
<?php 	$products_layout[2] = array('P1', 'P2', 'P3', 'P4', 'P5', 'P6', 'P7'); ?>
<?php 	$products_layout[3] = array('P1', 'P2', 'P3', 'P4', 'P5', 'P6', 'P7', 'P8', 'P9'); ?>
<?php 	$products_layout[4] = array('P1', 'P2', 'P3', 'P4', 'P5', 'P6'); ?>
<?php //alert($showroomData);die;?>
<?php if(!empty($showroomData)):?>
	<?php foreach($showroomData as $key => $row): ?>
		<?php if(!empty($row['layout_id'])):?>
			<div class="home__showroom_container layout_<?php echo $row['layout_id'];?>">
				<?php if(!empty($row['banner'])):?>
					<?php foreach($row['banner'] as $bkey => $brow):?>
						<?php if($brow['position_name'] == 'B1'):?>
							<a class="showroom_banner" href="<?php echo $brow['link_url'];?>">
								<img src="<?php echo $brow['img_path'];?>" alt="">
							</a>
						<?php endif;?>
					<?php endforeach;?>
				<?php endif;?>
				<div class="showroom_wrapper">
					<div class="showroom_header">
						<div class="showroom_name">
							\ <b><?php echo $row['name'];?></b>
						</div>
						<?php if(!empty($row['brand'])):?>
							<ul class="showroom_brand">
								<?php foreach($row['brand'] as $br_key => $br_row)?>
								<li class="brand_item">
									<a class="brand_link" href="<?php echo URL::toLang('brand/'.urlTitle($br_row['slug']).'-'.$br_row['pkey'].'.html');?>">
										<?php if( !empty($br_row['thumb'][0]) ):?>
											<img src="<?php echo $br_row['thumb'][0]; ?>" alt="<?php echo $br_row['name'];?>" >
										<?php endif;?>
									</a>
								</li>
							</ul>
						<?php endif;?>
					</div>
					<div class="showroom_content">
						<?php if(!empty($row['banner'])):?>
							<?php foreach($row['banner'] as $bkey => $brow):?>
								<?php $banner_pos_valid = array('B2', 'B3', 'B4');?>
								<?php if(in_array($brow['position_name'], $banner_pos_valid)):?>
									<?php 
										switch($brow['position_name'])
										{
											case 'B2':
												$bi_key = 1;
												break;
											case 'B3':
												$bi_key = 2;
												break;
											case 'B4':
												$bi_key = 3;
												break;
										}
									?>
									<div class="box_<?php echo $bi_key;?> box_banner">
										<a href="<?php echo $brow['link_url'];?>">
											<img data-original="<?php echo $brow['img_path'];?>" class="lazyload" src="<?php echo $brow['img_path'];?>" >
										</a>
									</div>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
						
						<?php if(!empty($row['products'])):?>
							<?php foreach($row['products'] as $pkey => $prow):?>
								<?php $products_pos_valid = $products_layout[$row['layout_id']];?>
								<?php if(in_array($prow['position_name'], $products_pos_valid)):?>
									<?php 
										switch($prow['position_name'])
										{
											case 'P1':
												switch($row['layout_id'])
												{
													case '1':
														$pi_key = 4;
														break;
													case '2':
														$pi_key = 2;
														break;
													case '3':
														$pi_key = 2;
														break;
													case '4':
														$pi_key = 3;
														break;
												}
												break;
											case 'P2':
												switch($row['layout_id'])
												{
													case '1':
														$pi_key = 5;
														break;
													case '2':
														$pi_key = 3;
														break;
													case '3':
														$pi_key = 3;
														break;
													case '4':
														$pi_key = 4;
														break;
												}
												break;
											case 'P3':
												switch($row['layout_id'])
												{
													case '1':
														$pi_key = 6;
														break;
													case '2':
														$pi_key = 4;
														break;
													case '3':
														$pi_key = 4;
														break;
													case '4':
														$pi_key = 5;
														break;
												}
												break;
											case 'P4':
												switch($row['layout_id'])
												{
													case '1':
														$pi_key = 7;
														break;
													case '2':
														$pi_key = 5;
														break;
													case '3':
														$pi_key = 5;
														break;
													case '4':
														$pi_key = 6;
														break;
												}
												break;
											case 'P5':
												switch($row['layout_id'])
												{
													case '1':
														$pi_key = 8;
														break;
													case '2':
														$pi_key = 6;
														break;
													case '3':
														$pi_key = 6;
														break;
													case '4':
														$pi_key = 7;
														break;
												}
												break;
											case 'P6':
												switch($row['layout_id'])
												{
													case '1':
														$pi_key = 9;
														break;
													case '2':
														$pi_key = 7;
														break;
													case '3':
														$pi_key = 7;
														break;
													case '4':
														$pi_key = 8;
														break;
												}
												break;
											case 'P7':
												switch($row['layout_id'])
												{
													case '1':
														$pi_key = 10;
														break;
													case '2':
														$pi_key = 8;
														break;
													case '3':
														$pi_key = 8;
														break;
													case '4':
														$pi_key = 9;
														break;
												}
												break;
											case 'P8':
												switch($row['layout_id'])
												{
													case '1':
														$pi_key = 11;
														break;
													case '2':
														$pi_key = 9;
														break;
													case '3':
														$pi_key = 9;
														break;
													case '4':
														$pi_key = 10;
														break;
												}
												break;
											case 'P9':
												switch($row['layout_id'])
												{
													case '1':
														$pi_key = 12;
														break;
													case '2':
														$pi_key = 10;
														break;
													case '3':
														$pi_key = 10;
														break;
													case '4':
														$pi_key = 11;
														break;
												}
												break;
										}
									?>
									<div class="box_<?php echo $pi_key;?> box_product">
										<a href="<?php echo levelDUrl($prow['slug'], $prow['pkey']);?>">
											<?php if(!empty($prow['percent_discount']['min']) && !empty($prow['percent_discount']['max'])):?>
												<span class="price_tag">
													<span class="price_no">
														<?php if($prow['percent_discount']['min'] == $prow['percent_discount']['max']):?>
															<?php echo floor($prow['percent_discount']['min']); ?>
														<?php else:?>
															<?php echo floor($prow['percent_discount']['min']); ?> - <?php echo floor($prow['percent_discount']['max']); ?>
														<?php endif;?>
													</span>
													<sup>%</sup>
													<sub>OFF</sub>
												</span>
											<?php endif;?>
											<?php 
												$name = $prow['title'];
												if($ln == 'en')
												{
													$name = $prow['translate']['title'];
												}
											?>
											<span class="product_thumbnail">
												<img data-original="<?php echo $prow['image_cover']['thumbnails']['square'];?>" class="lazyload" src="<?php echo $prow['image_cover']['thumbnails']['square'];?>" alt="<?php echo $name;?>">
											</span>
											<span class="product_name">
												<?php echo $name;?>
											</span>
											<span class="product_price">
												<?php if($prow['special_price_range']['max'] || $prow['special_price_range']['min']){ ?>
														<span class="price_discount">
															<?php if($prow['price_range']['min'] != $prow['price_range']['max'] ){ ?>
																<?php echo price_format( $prow['price_range']['min']) ?> -  <?php echo price_format( $prow['price_range']['max']) ?>
															<?php }else{ ?>
																<?php echo price_format( $prow['price_range']['min']) ?>
															<?php }?>
															.-
														</span>
														
														<span class="price_normal discount">
															<?php if($prow['net_price_range']['min'] != $prow['net_price_range']['max'] ){ ?>
																<?php echo price_format( $prow['net_price_range']['min']) ?> - <?php echo price_format( $prow['net_price_range']['max']) ?>
															<?php }else{ ?>
																<?php echo price_format( $prow['net_price_range']['min']) ?>
															<?php }?>
															.-
														</span>
													<?php }else{ ?>
														<span class="price_normal">
															<?php if($prow['price_range']['min'] != $prow['price_range']['max'] ){ ?>
																<?php echo price_format( $prow['price_range']['min']) ?> - <?php echo price_format( $prow['price_range']['max']) ?>
															<?php }else{ ?>
																<?php echo price_format( $prow['price_range']['min']) ?>
															<?php }?>
															.-
														</span>
													<?php } ?>
											</span>
										</a>
									</div>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>

					</div>
				</div>
			</div>
		<?php endif;?>
	<?php endforeach;?>
<?php endif;?>