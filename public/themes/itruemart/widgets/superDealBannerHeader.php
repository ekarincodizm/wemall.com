
<?php if ( !empty($banner["group_list"][0]["banner_list"][0]) ): ?>
    <?php $bannerList = $banner["group_list"][0]; ?>
    <?php if($bannerList["is_random"] == 'Y'){ shuffle($bannerList); } ?>
    <?php $bannerData = $bannerList["banner_list"][0]; ?>
    <?php if ( ! empty($bannerData['img_path'])): ?>
    <!-- typeidea script -->
		<a class="header__nav_banner ec-promotion" href="<?php echo $bannerData['url_link']; ?>" title="<?php //echo $bannerData['name']; ?>" data-ec-promotion="everyday-wow|everyday-wow|everyday-wow-top-banner">
		<!-- //typeidea script -->
			<img src="<?php echo $bannerData['img_path'].'?q='.md5($bannerData['url_link']); ?>" alt="<?php //echo $bannerData['name']; ?>" />
		</a>
	<?php endif; ?>
<?php endif; ?>
