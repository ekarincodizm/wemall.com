<div class="content-home sub">
	<div class="breadcrumbs">
        <div id="link_map">
            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                <a class="map" itemprop="url" href="<?php echo url(); ?>" title="ช้อปปิ้งออนไลน์">
                    <span itemprop="title"><?php echo __('ช้อปปิ้งออนไลน์'); ?></span>
                </a>
            </span> <!-- &gt; <a class="map">แฟชั่นผู้ชาย</a> -->
            <?php echo Theme::breadcrumb()->render(); ?>
        </div>
    </div>
	<div id="news" style="margin-left:150px;">
		<div id="banner-header">
			<img src="<?php echo Theme::asset()->usePath()->url('images/news/banner-header-news.jpg'); ?>">
		</div>
		<?php echo Theme::widget('newsUpdate')->render(); ?>

		<!-- Main content -->
		<div id="main-content">
	        <div class="clearfix"></div>
			<div id="news-category">					
				<?php
				echo Theme::widget('newsCategory', array('category_id' => $category_id))->render(); 
				?>
				<div class="clearfix"></div>
				<ul id="news-category-list">
					<?php if ( ! empty($news['data_response']['data_record'])) : ?>
					<?php foreach ($news['data_response']['data_record'] as $key => $value) : ?>
					<li class="news-category-item">
						<span class="title">
							<?php echo $value['language'][App::getLocale()]['title']; ?>
						</span> 
						<?php #alert($value, 'red'); ?>
						<span class="date-modify"><?php echo newsDate($value['create_date']); ?></span>
						<p class="content-container">
							<img src="<?php echo $value['images']['path_medium']; ?>" class="content-thumb" width="240" height="180">
							<span class="content-box-outer">
								<span class="content-box-inner">
									<span class="content-desc">
										<?php echo $value['language'][App::getLocale()]['description']; ?>
										<a href="<?php echo newsLevelDUrl($value['language']['en']['title'], $value['news_id']); ?>" title="<?php echo $value['language'][App::getLocale()]['title']; ?>" class="more"><?php echo trans('news.read_more'); ?> &gt;&gt;</a>
									</span>
								</span>
							</span>
						</p>
						<div class="social-container">
							<div class="sc-box">
								<a target="_blank" href="https://twitter.com/share?url=<?php echo newsLevelDUrl($value['language']['en']['title'], $value['news_id']); ?>">
									<img src="<?php echo Theme::asset()->usePath()->url('images/news/icon-news-tw-on.jpg'); ?>" height="30" width="30" alt="Share on Twitter">
								</a>
							</div>
							<div class="sc-box">
								<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo newsLevelDUrl($value['language']['en']['title'], $value['news_id']); ?>">
									<img src="<?php echo Theme::asset()->usePath()->url('images/news/icon-news-fb-on.jpg'); ?>" height="30" width="30" alt="Share on Facebook">
								</a>
							</div>
							<div class="sc-box">
								<a href="https://plus.google.com/share?url=<?php echo newsLevelDUrl($value['language']['en']['title'], $value['news_id']); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
									<img src="https://www.gstatic.com/images/icons/gplus-32.png" height="30" width="30" alt="Share on Google+">
								</a>
							</div>
						</div>
					</li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
               	<?php if ( ! empty($news['data_response']) && $news['data_response']['paging']['total_page'] > 1) : ?>
				<div id="news-paging">
					<?php if ($news['data_response']['paging']['page'] > 1) : ?>
					<a id="news-prev" href="<?php echo newsLevelBUrl($category_slug, $category_id); ?>?page=<?php echo $news['data_response']['paging']['page'] - 1; ?>"> &lt;&lt; <?php echo trans('news.older'); ?></a>
					<?php endif; ?>

					<?php if ($news['data_response']['paging']['page'] < $news['data_response']['paging']['total_page']) : ?>
					<a id="news-next" href="<?php echo newsLevelBUrl($category_slug, $category_id); ?>?page=<?php echo $news['data_response']['paging']['page'] + 1; ?>"> <?php echo trans('news.newer'); ?> &gt;&gt;</a>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<div class="clearfix"></div>
			</div>
			<?php //--- News Category ---// ?>
			<?php echo Theme::widget('newsFbBox')->render(); ?>	
		</div>
		<?php //--- Main Content ---// ?>
		
		<?php echo Theme::widget('newsSide')->render(); ?>	
		<div class="clearfix"></div>
    </div>
	
	


</div>
</div>

