<ul id="nc-category-list">
	<?php if ( ! empty($categories)) : ?>
	<?php foreach ($categories as $key => $value) : ?>
	<li class="<?php echo ($value['id'] == $category_id) ? 'active' : "inactive"; ?>">		
		<h2 class="header">
			<a href="<?php echo newsLevelBUrl($value['name_en'], $value['id']); ?>" title="<?php echo $value['name_'.App::getLocale()]; ?>"><?php echo $value['name_'.App::getLocale()]; ?></a>
		</h2>
	</li>
	<?php endforeach; ?>		
	<?php endif; ?>
</ul>