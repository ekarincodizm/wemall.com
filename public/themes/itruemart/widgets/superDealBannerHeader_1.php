
<?php if ( !empty($banner["group_list"][0]["banner_list"][0]) ): ?>
    <?php $bannerList = $banner["group_list"][0]; ?>
    <?php if($bannerList["is_random"] == 'Y'){ shuffle($bannerList); } ?>
    <?php $bannerData = $bannerList["banner_list"][0]; ?>
    <?php if ( ! empty($bannerData['img_path'])): ?>
		<a class="header__nav_banner" href="<?php echo $bannerData['url_link']; ?>" title="<?php echo $bannerData['name']; ?>" >
			<img src="<?php echo ($bannerData['img_path']); ?>" alt="<?php echo $bannerData['name']; ?>" />
		</a>
	<?php endif; ?>
<?php endif; ?>
