<?php if ( ! empty($banners['position_15'])) :?>
<?php //alert($banner_list); exit();?>
	<?php $val = $banners['position_15'];?>
		<!-- Banner Position 15 = Level A Recommended -->
			<?php if ( count($val['group_list']) >= 10): ?>
			<?php //alert($val); exit();?>
			<?php if ( ! empty($val['group_list'])): ?>
				<?php if ($val['group_list'][0]['banner_total'] != 0): ?>
					<!-- Recommended not shuffle -->
					<div class="recommend">
						<h3 class="header-text-container"><?php echo __('home-recommend-lbl');?></h3>
						<ul class="recommend-banner">
							<li class="rec-banner-left">
								<?php if (isset($val['group_list'][0]['banner_list'][0])): ?>
								<?php if ($val['group_list'][0]['is_random'] == 'Y'){ shuffle($val['group_list'][0]['banner_list']); }?>
								<a rel="slideDescription" href="<?php echo urldecode($val['group_list'][0]['banner_list'][0]['url_link']);?>" title="<?php echo htmlspecialchars($val['group_list'][0]['banner_list'][0]['name']);?>">
									<img src="<?php echo $val['group_list'][0]['banner_list'][0]['img_path'];?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['group_list'][0]['banner_list'][0]['name']);?>" />
									<span class="banner-desc" ><?php echo strip_words($val['group_list'][0]['banner_list'][0]['description'], 195);?></span>
								</a>
								<?php endif;?>
							</li>
							<li class="rec-banner-center">
								<ul>
									<li class="rec-banner-center-top">
										<?php if (isset($val['group_list'][1]['banner_list'][0])): ?>
										<?php if ($val['group_list'][1]['is_random'] == 'Y'){ shuffle($val['group_list'][1]['banner_list']); }?>
										<a rel="slideDescription" href="<?php echo urldecode($val['group_list'][1]['banner_list'][0]['url_link']);?>" title="<?php echo htmlspecialchars($val['group_list'][1]['banner_list'][0]['name']);?>">
											<img src="<?php echo $val['group_list'][1]['banner_list'][0]['img_path'];?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['group_list'][1]['banner_list'][0]['name']);?>"/>
											<span class="banner-desc" ><?php echo strip_words($val['group_list'][1]['banner_list'][0]['description']);?></span>
										</a>
										<?php endif;?>
									</li>
									<li class="rec-banner-center-top">
										<?php if (isset($val['group_list'][2]['banner_list'][0])): ?>
										<?php if ($val['group_list'][2]['is_random'] == 'Y'){ shuffle($val['group_list'][2]['banner_list']); }?>
										<a rel="slideDescription" href="<?php echo urldecode($val['group_list'][2]['banner_list'][0]['url_link']);?>" title="<?php echo htmlspecialchars($val['group_list'][2]['banner_list'][0]['name']);?>">
											<img src="<?php echo $val['group_list'][2]['banner_list'][0]['img_path'];?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['group_list'][2]['banner_list'][0]['name']);?>"/>
											<span class="banner-desc" ><?php echo strip_words($val['group_list'][2]['banner_list'][0]['description']);?></span>
										</a>
										<?php endif;?>
									</li>
									<li class="rec-banner-center-center">
										<?php if (isset($val['group_list'][4]['banner_list'][0])): ?>
										<?php if ($val['group_list'][4]['is_random'] == 'Y'){ shuffle($val['group_list'][4]['banner_list']); }?>
										<a rel="slideDescription" href="<?php echo urldecode($val['group_list'][4]['banner_list'][0]['url_link']);?>" title="<?php echo htmlspecialchars($val['group_list'][4]['banner_list'][0]['name']);?>">
											<img src="<?php echo $val['group_list'][4]['banner_list'][0]['img_path'];?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['group_list'][4]['banner_list'][0]['name']);?>"/>
											<span class="banner-desc" ><?php echo strip_words($val['group_list'][4]['banner_list'][0]['description']);?></span>
										</a>
										<?php endif;?>
									</li>
									<li class="rec-banner-center-bottom">
										<?php if (isset($val['group_list'][5]['banner_list'][0])): ?>
										<?php if ($val['group_list'][5]['is_random'] == 'Y'){ shuffle($val['group_list'][5]['banner_list']); }?>
										<a rel="slideDescription" href="<?php echo urldecode($val['group_list'][5]['banner_list'][0]['url_link']);?>" title="<?php echo htmlspecialchars($val['group_list'][5]['banner_list'][0]['name']);?>">
											<img src="<?php echo $val['group_list'][5]['banner_list'][0]['img_path'];?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['group_list'][5]['banner_list'][0]['name']);?>"/>
											<span class="banner-desc" ><?php echo strip_words($val['group_list'][5]['banner_list'][0]['description']);?></span>
										</a>
										<?php endif;?>
									</li>
									<li class="rec-banner-center-bottom">
										<?php if (isset($val['group_list'][6]['banner_list'][0])): ?>
										<?php if ($val['group_list'][6]['is_random'] == 'Y'){ shuffle($val['group_list'][6]['banner_list']); }?>
										<a rel="slideDescription" href="<?php echo urldecode($val['group_list'][6]['banner_list'][0]['url_link']);?>" title="<?php echo htmlspecialchars($val['group_list'][6]['banner_list'][0]['name']);?>">
											<img src="<?php echo $val['group_list'][6]['banner_list'][0]['img_path'];?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['group_list'][6]['banner_list'][0]['name']);?>"/>
											<span class="banner-desc" ><?php echo strip_words($val['group_list'][6]['banner_list'][0]['description']);?></span>
										</a>
										<?php endif;?>
									</li>
									<li class="rec-banner-center-bottom">
										<?php if (isset($val['group_list'][7]['banner_list'][0])): ?>
										<?php if ($val['group_list'][7]['is_random'] == 'Y'){ shuffle($val['group_list'][7]['banner_list']); }?>
										<a rel="slideDescription" href="<?php echo urldecode($val['group_list'][7]['banner_list'][0]['url_link']);?>" title="<?php echo htmlspecialchars($val['group_list'][7]['banner_list'][0]['name']);?>">
											<img src="<?php echo $val['group_list'][7]['banner_list'][0]['img_path'];?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['group_list'][7]['banner_list'][0]['name']);?>"/>
											<span class="banner-desc" ><?php echo strip_words($val['group_list'][7]['banner_list'][0]['description']);?></span>
										</a>
										<?php endif;?>
									</li>
								</ul>
							</li>
							<li class="rec-banner-right">
								<?php if (isset($val['group_list'][3]['banner_list'][0])): ?>
								<?php if ($val['group_list'][3]['is_random'] == 'Y'){ shuffle($val['group_list'][3]['banner_list']); }?>
								<a rel="slideDescription" href="<?php echo urldecode($val['group_list'][3]['banner_list'][0]['url_link']);?>" title="<?php echo htmlspecialchars($val['group_list'][3]['banner_list'][0]['name']);?>">
									<img src="<?php echo $val['group_list'][3]['banner_list'][0]['img_path'];?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['group_list'][3]['banner_list'][0]['name']);?>"/>
									<span class="banner-desc" ><?php echo strip_words($val['group_list'][3]['banner_list'][0]['description']);?></span>
								</a>
								<?php endif;?>
							</li>
						</ul>
					</div>
					<div class="new-arrival">
						<h3 class="header-text-container"><?php echo __('home-new-arrival-lbl');?></h3>
						<div class="box-banner">
							<?php if (isset($val['group_list'][8]['banner_list'][0])): ?>
							<?php if ($val['group_list'][8]['is_random'] == 'Y'){ shuffle($val['group_list'][8]['banner_list']); }?>
							<a rel="slideDescription" href="<?php echo urldecode($val['group_list'][8]['banner_list'][0]['url_link']);?>" title="<?php echo htmlspecialchars($val['group_list'][8]['banner_list'][0]['name']);?>">
								<img src="<?php echo $val['group_list'][8]['banner_list'][0]['img_path'];?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['group_list'][8]['banner_list'][0]['name']);?>"/>
								<span class="banner-desc" ><?php echo strip_words($val['group_list'][8]['banner_list'][0]['description']);?></span>
							</a>
							<?php endif;?>
						</div>
					</div>
					<div class="best-seller">
						<h3 class="header-text-container"><?php echo __('home-best-seller-lbl');?></h3>
						<div class="box-banner">
							<?php if (isset($val['group_list'][9]['banner_list'][0])): ?>
							<?php if ($val['group_list'][9]['is_random'] == 'Y'){ shuffle($val['group_list'][9]['banner_list']); }?>
							<a rel="slideDescription" href="<?php echo urldecode($val['group_list'][9]['banner_list'][0]['url_link']);?>" title="<?php echo htmlspecialchars($val['group_list'][9]['banner_list'][0]['name']);?>">
								<img src="<?php echo $val['group_list'][9]['banner_list'][0]['img_path'];?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo htmlspecialchars($val['group_list'][9]['banner_list'][0]['name']);?>"/>
								<span class="banner-desc" ><?php echo strip_words($val['group_list'][9]['banner_list'][0]['description']);?></span>
							</a>
							<?php endif;?>
						</div>
					</div>
				<?php //break;?>
				<?php endif;?>
			<?php endif;?>
			<?php endif;?>
		
	
<?php endif;?>		