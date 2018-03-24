<?php if (count($banners)) foreach ($banners as $banner) : ?>
<a href="<?php echo $banner['url_link']; ?>" target="_blank" title="<?php echo  $banner['name']; ?>">
	<img src="<?php echo $banner['img_path']; ?>" width="<?php echo $width; ?>" height="<?php echo $height;?>" alt="<?php echo $banner['name']; ?>">
</a>
<?php endforeach; ?>