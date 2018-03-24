<?php $lang = App::getLocale();?>	
	<?php if ( ! empty($news_list)):?>
		<?php if (isset($news_list['data_record'])): ?>
			<div class="category-box news">
				<div class="category-header">
					<h3 class="header-text-container">
						<img src="<?php echo 'themes/itruemart/assets/images/icn/category/icn-ct-14.png';?>" alt="News iTrueMart" />
						<a href="<?php echo url('news'); ?>" title="<?php echo 'INSIGHT ITRUEMART';?>"><?php echo 'INSIGHT ITRUEMART';?></a>
					</h3>
				</div>
				<div class="category-content">
					<ul>
					<?php foreach ($news_list['data_record'] as $key => $val):?>
						<li>
							<?php if(!empty($val['language'][$lang]))
								{ 
									$title_slug = htmlspecialchars($val['language']['th']['title']); 
									$description = $val['language']['th']['description'];
								}
								else
								{
									if ($lang == 'th')
									{
										$title_slug = htmlspecialchars($val['language']['en']['title']);
										$description = $val['language']['en']['description'];
									}
									else
									{
										$title_slug = htmlspecialchars($val['language']['th']['title']);
										$description = $val['language']['th']['description'];
									}
								}
							?>
                            <a href="<?php echo newsLevelDUrl($title_slug, $val['news_id']);?>" title="<?php echo $title_slug;?>">
                                <img src="<?php echo $val['images']['path_thumb'];?><?php echo '?random='.random_string('numeric', 4); ?>" alt="<?php echo $title_slug;?>" />
                                <p>
                                    <b><?php echo $title_slug;?></b> <?php echo strip_tags($description);?>
                                </p>
								<a href="<?php echo newsLevelDUrl($title_slug, $val['news_id']);?>" title="<?php echo $title_slug;?>" class="more-detail">
									<?php echo 'Read more';?>
								</a>
								<span><?php echo insightDate($val['create_date']);?> By iTrueMart Team</span>
							</a>
						</li>
					<?php endforeach;?>
					</ul>
					
					<?php
						$banner_list = array();
						if (! empty($banners))
						{
							#sd($banners)->toArray();
							if (!empty($banners['position_32']))
							{
								if (! empty($banners['position_32']['group_list']))
								{
									if (! empty($banners['position_32']['group_list'][0]['banner_list']))
									{
										$banner_list = $banners['position_32']['group_list'][0]['banner_list'][0];
									}
								}
							}
						}
					?>
					<?php if (! empty($banner_list)):?>
						<div class="editor" style="background-image: url('<?php echo $banner_list['img_path'];?>');">
							<p>
								<?php echo $banner_list['description'];?>
							</p>
						</div>
					<?php endif;?>
				</div>
			</div>
		<?php endif;?>
	<?php endif;?>