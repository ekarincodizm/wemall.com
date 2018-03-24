<?php $lang = App::getLocale();?>
<!-- Update -->
<div id="update">
	<div id="hotnews">
		<div id="ht-head"><span>UPDATE</span></div>
		<div id="ht-content">
			<?php if(!empty($hot_news_update)): ?>
			<ul>
				<?php if(!empty($hot_news_update['data_record'])) : ?>
					<?php foreach($hot_news_update['data_record'] as $hotkey => $hot_news): ?>
					<li <?php if($hotkey == 0): ?> class="active" <?php else: ?> class="inactive" <?php endif; ?> <?php if($hotkey != 0){ echo 'style="display:none;"';}?>>
						<a href="<?php echo UrlManager::newsLevelDUrl(htmlspecialchars($hot_news['language'][$lang]['title']), $hot_news['news_id']);?>" title="<?php echo htmlspecialchars($hot_news['language'][$lang]['title']); ?>">
							<span>
								<?php if(!empty($hot_news['language'][$lang]['title'])): 
									echo htmlspecialchars($hot_news['language'][$lang]['title']); 
								endif; ?>-
								<?php if(!empty($hot_news['language'][$lang]['short_description'])):
									echo htmlspecialchars($hot_news['language'][$lang]['short_description']);
								else:
									if(!empty($hot_news['language'][$lang]['description'])):
										echo htmlspecialchars($hot_news['language'][$lang]['description']);
									endif;
								endif;?>
							</span>
						</a>
					</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
			<?php endif; ?>
		</div>		
	</div>
	<div id="ico-social">
		<a rel="nofollow" href="https://www.facebook.com/itruemart" target="_blank" id="fb">facebook</a> 
		<a rel="nofollow" href="https://twitter.com/iTrueMart" id="tw" target="_blank">twitter</a> 
	</div>
</div>