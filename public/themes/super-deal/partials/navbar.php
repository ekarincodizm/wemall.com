<div class="header__bg_nav">
	<div class="header__inner_wrapper">
		<div class="header__bar_nav">
			<ul class="header__nav_container">
				<li>
					<a class="header__nav_category" href="#">
						<span class="icn_categories"></span>
						หมวดหมู่
						<?php //echo strtoupper(__('categories')); ?>
						<span class="caret"></span>
					</a>
				</li>
				
				<!-- Navigation Menu -->
				<?php $nev = Config::get('widget_params.header_nevbar'); ?>
				<?php if ( ! empty($nev)): ?>
					<?php if ( is_array($nev)): ?>
						<?php foreach ($nev as $value): ?>
						<li>
							<a class="header__nav_link" href="<?php echo $value['url_link'];?>" title="<?php echo $value['title'];?>" >
								<?php echo $value['title'];?>
							</a>
						</li>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endif; ?>
				
				<li>
					<!-- Everyday WoW Banner -->
					<?php echo Theme::widget('superDealBannerHeader')->render(); ?>
					
					<!--
					<a class="header__nav_banner" href="#">
						<img src="<?php echo Theme::asset()->usePath()->url('images/banner/everyday_wow.png'); ?>" />
					</a>
					-->
				</li>
			</ul>
			
			<?php /* Widget Category Top Menu */ ?>
			<?php echo Theme::widget('appCategoryMenu')->render(); ?>
			<!--
			<div class="header__sidebar">
				<ul class="sidebar_1">
					<li class="active">
						<a href="" data-id="category_1">SHOP BY BRAND</a>
					</li>
					
					<li><a href="" data-id="category_3">GADGET</a>
					<div class="sidebar_group">
						<ul class="sidebar_2" id="category_1">
							<li class="sidebar_name">\ GADGET</li>
							<li><a href="#">Headphones & Bluetooths</a></li>
							<li><a href="#">Speakers</a></li>
							<li><a href="#">Smart Gadget</a></li>
							<li><a href="#">Computers</a></li>
							<li><a href="#">Other gadget</a></li>
						</ul>
						<ul class="sidebar_3">
							<li>
								<a href="#"><img src="images/logo/nokia.png" /></a>
								<a href="#"><img src="images/logo/nokia.png" /></a>
								<a href="#"><img src="images/logo/nokia.png" /></a>
								<a href="#"><img src="images/logo/nokia.png" /></a>
								<a href="#"><img src="images/logo/nokia.png" /></a>
								<a href="#"><img src="images/logo/nokia.png" /></a>
								<a href="#"><img src="images/logo/nokia.png" /></a>
								<a href="#"><img src="images/logo/nokia.png" /></a>
								<a href="#"><img src="images/logo/nokia.png" /></a>
								<a href="#"><img src="images/logo/nokia.png" /></a>
								<a href="#"><img src="images/logo/nokia.png" /></a>
								<a href="#"><img src="images/logo/nokia.png" /></a>
								<a href="#"><img src="images/logo/nokia.png" /></a>
								<a href="#" class="other_brand">...</a>
							</li>
						</ul>
						<ul class="sidebar_4 lay_col_3">
							<li>
								<a href="">
									<span class="price_tag">
									<span class="price_no">
									90
									</span><sup>%</sup><sub>OFF</sub>
									</span>
									<img src="images/banner/ex-product-2.jpg" />
									<span class="product_information">
									<span class="tag_product_name">Huawei Ascend</span>
									<span class="tag_price">
									<span class="price_discount">417 บาท</span>
									<span class="price_normal discount">1,000 บาท</span>
									</span>
									</span>
								</a>
							</li>
							<li>
								<a href="">
									<img src="images/banner/ex-product-2.jpg" />
									<span class="product_information">
									<span class="tag_product_name">Huawei Ascend</span>
									<span class="tag_price">
									<span class="price_discount">417 บาท</span>
									<span class="price_normal discount">1,000 บาท</span>
									</span>
									</span>
								</a>
							</li>
							<li>
								<a href="">
									<img src="images/banner/ex-product-2.jpg" />
									<span class="product_information">
									<span class="tag_product_name">Huawei Ascend</span>
									<span class="tag_price">
									<span class="price_discount">417 บาท</span>
									<span class="price_normal discount">1,000 บาท</span>
									</span>
									</span>
								</a>
							</li>
						</ul>
					</div>
					</li>
				</ul>
			</div>
			-->
		</div>
	</div>
</div>
