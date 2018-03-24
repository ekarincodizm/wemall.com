<?php $lang = App::getLocale();?>
<div id="live">		
	<?php if(!empty($hot_news)): ?>
		<?php if(!empty($hot_news['data_record'])): ?>
		<h2 class="header">Hot news</h2>
		<div class="news-container">
			<!--- Loop news-box -->
			<?php foreach($hot_news['data_record'] as $hnews):?>
			<div class="news-box">
				<div class="news-thumbnail">
					<img src="<?php echo $hnews['images']['path_thumb']; ?>">
				</div>
				<div class="news-content">
					<p class="title">
						<?php if(!empty($hnews['language'][$lang]['title'])): ?>
							<?php echo htmlspecialchars($hnews['language'][$lang]['title']); ?>
						<?php endif; ?>
					</p>
					<span class="desc">
						<?php if(!empty($hnews['language'][$lang]['title'])): 
							echo htmlspecialchars($hnews['language'][$lang]['title']); 
						endif; ?>-
						<?php if(!empty($hnews['language'][$lang]['short_description'])):
							echo htmlspecialchars($hnews['language'][$lang]['short_description']);
						else:
							if(!empty($hnews['language'][$lang]['description'])):
								echo htmlspecialchars($hnews['language'][$lang]['description']);
							endif;
						endif;?>				
					</span>
					<a href="<?php echo UrlManager::newsLevelDUrl(htmlspecialchars($hnews['language'][$lang]['title']), $hnews['news_id']);?>" class="more">Read more</a>
				</div>
			</div>
			<?php endforeach; ?>
			<!--- Loop news-box -->
		</div>											
		<?php endif; ?>
	<?php endif; ?>
	<?php if(!empty($lastest_news)): ?>
		<?php if(!empty($lastest_news['data_record'])): ?>	
		<h2 class="header">Lastest news</h2>
		<div class="news-container">
			<!--- Loop news-box -->
			<?php foreach($lastest_news['data_record'] as $lnews):?>
			<div class="news-box">
				<div class="news-thumbnail">
					<img src="<?php echo $lnews['images']['path_thumb']; ?>">
				</div>
				<div class="news-content">
					<p class="title">						
						<?php if(!empty($lnews['language'][$lang]['title'])): ?>
							<?php echo htmlspecialchars($lnews['language'][$lang]['title']); ?>
						<?php endif; ?></p>
					<span class="desc">
						<?php if(!empty($lnews['language'][$lang]['title'])): 
							echo htmlspecialchars($lnews['language'][$lang]['title']); 
						endif; ?>-
						<?php if(!empty($lnews['language'][$lang]['short_description'])):
							echo htmlspecialchars($lnews['language'][$lang]['short_description']);
						else:
							if(!empty($lnews['language'][$lang]['description'])):
								echo htmlspecialchars($lnews['language'][$lang]['description']);
							endif;
						endif;?>
					</span>
					<a href="<?php echo UrlManager::newsLevelDUrl(htmlspecialchars($lnews['language'][$lang]['title']), $lnews['news_id']);?>" class="more">Read more</a>
				</div>
			</div>
			<?php endforeach; ?>
			<!--- Loop news-box -->
		</div>	
		<?php endif; ?>
	<?php endif; ?>
</div>