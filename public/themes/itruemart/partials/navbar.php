<div class="header__bg_nav">
	<div class="header__inner_wrapper">
		<div class="header__bar_nav">
			<ul class="header__nav_container">
				<li>
					<a class="header__nav_category" href="#">
						<span class="icn_categories"></span>
                        <?php echo strtoupper(__('categories')); ?>
						<span class="caret"></span>
					</a>
				</li>
				
				<!-- Navigation Menu -->
				<?php $nev = Config::get('widget_params.header_nevbar'); ?>
				<?php if ( ! empty($nev)): ?>
					<?php if ( is_array($nev)): ?>
						<?php foreach ($nev as $value): ?>
						<li>
							<a class="header__nav_link" href="<?php echo $value['url_link'];?>" title="<?php echo __($value['title']);?>" ><?php echo __($value['title']);?></a>
						</li>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endif; ?>
				
				<li>
					<!-- Everyday WoW Banner -->
					<?php echo Theme::widget('superDealBannerHeader')->render(); ?>
				</li>
			</ul>
			
			<?php /* Widget Category Top Menu */ ?>
			<?php echo Theme::widget('appCategoryMenu')->render(); ?>
		</div>
	</div>
</div>
