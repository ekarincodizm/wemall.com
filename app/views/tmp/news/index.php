<?php $lang = App::getLocale();?>
<div class="content-home sub">
    <div class="breadcrumbs">
        <div id="link_map">
            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                <a class="map" itemprop="url" href="http://www.itruemart.com/" title="ช้อปปิ้งออนไลน์">
                    <span itemprop="title"><?php echo __('ช้อปปิ้งออนไลน์'); ?></span>
                </a>
            </span>
            <?php echo Theme::breadcrumb()->render(); ?>
        </div>
    </div>			
	<div id="news" style="margin-left:150px;">
		<div id="banner-header">
			<img src="themes/itruemart/assets/images/news/banner-header-news.jpg">
		</div>
		<!-- Update -->
		<?php echo Theme::widget('newsUpdate')->render(); ?>
	
		<!-- Main content -->
		<div id="main-content">
			<h2 class="header">ANNOUNCEMENT</h2>
			<div id="hilight-banner">
				<div id="slider-prev"></div>
				<div id="slider-next"></div>
				<div id="slider-container">
				<?php if ( ! empty($banner_list)) : ?>
					<ul class="bxslider" id="bxslider-hilight-banner">
					<?php foreach ($banner_list as $key => $val): ?>
						<?php if ($val['banner_total'] != 0): ?>
							<?php if ($val['is_random'] == 'Y'): shuffle($val['banner_list']); endif; ?>
							<?php foreach ($val['banner_list'] as $item => $value) :?>
								<?php if ($item < $val['show_per_time']): ?>
								<li>
									<div>
										<div class="hilight-thumb">
											<a href="<?php echo urldecode($value['url_link']); ?>" title="<?php echo htmlspecialchars($value['name']); ?>" target="_blank" data="<?php echo $value['id']; ?>" class="save_stat" >
												<img src="<?php echo $value['img_path']; ?>" width="640" height="260" alt="<?php echo htmlspecialchars($value['name']); ?>">
											</a>
										</div>
										<div class="hilight-title">
											<span class="hilight-title-head"><?php echo htmlspecialchars($value['name']); ?></span>
										</div>
									</div>
								</li>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				</div>
				<div class="clearfix"></div>
			</div>
			
			<div class="clearfix"></div>
			<?php if(!empty($main_list_news)) : ?>
				<?php foreach($main_list_news as $news_key => $news): ?>
				<?php if(!empty($news['data_record'])): ?>
				<?php 
					$classname = ($news_key == 0) ? 'f-left' : (($news_key == 1) ? 'f-right' : 'f-center'); 
					$category_name = isset($news['category_data']['title_'.$lang]) ? $news['category_data']['title_'.$lang] : '';
					$category_id = isset($news['category_data']['news_group_id']) ? $news['category_data']['news_group_id'] : ''; 
				?>
				<div class="column-news <?php echo $classname; ?>">
					<a class="read-all" href="<?php echo UrlManager::newsLevelBUrl($category_name, $category_id); ?>">	
						<h2 class="header"><?php echo $category_name; ?></h2>
					</a>
					<?php foreach($news['data_record'] as $key => $val) : ?>
					<div class="column-news-box">
						<div class="news-thumbnail">
							<a href="<?php if(!empty($val['language'][$lang]['title'])) : echo newsLevelDUrl(htmlspecialchars($val['language'][$lang]['title']), $val['news_id']); endif; ?>">
								<img src="<?php echo $val['images']['path_thumb']?>" width="240" height="180">
							</a>
						</div>
						<div class="news-content">
							<p class="title"><?php if(!empty($val['language'][$lang]['title'])){ echo htmlspecialchars($val['language'][$lang]['title']); } ?></p>
							<span class="desc">
								<?php 
									if(!empty($val['language'][$lang]['short_description'])):
										echo htmlspecialchars($val['language'][$lang]['short_description']);
									else:
										if(!empty($val['language'][$lang]['description'])):
											echo htmlspecialchars($val['language'][$lang]['description']);
										endif;
									endif;
								?>	
							</span><br>
							<a href="<?php if(!empty($val['language'][$lang]['title'])) : echo newsLevelDUrl(htmlspecialchars($val['language'][$lang]['title']), $val['news_id']); endif; ?>" class="more">Read more</a>
						</div>
						<div class="date-create"><?php echo date('F, d, Y', strtotime($val['create_date']));?> , By iTrueMart Team</div>
					</div>
					<?php endforeach; ?>
					<span class="read-all-box"><a class="read-all" href="<?php echo UrlManager::newsLevelBUrl($category_name, $category_id); ?>">Read All</a></span>
				</div>
				<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
			
			<?php echo Theme::widget('newsFbBox')->render(); ?>
			
		</div>
		
		<?php echo Theme::widget('newsSide')->render(); ?>
	</div>					
</div></div>