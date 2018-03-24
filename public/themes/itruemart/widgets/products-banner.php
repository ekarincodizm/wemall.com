<?php
	// Default Banner.
	$bannerPath = 'http://cdn.itruemart.com/files/category/166/166_720x290_1380880335.jpg';

	if ( !empty($metas['banner']) )
	{
		$bannerPath = $metas['banner'];
	}
	elseif ( !empty($collectionDetail['parents']) )
	{
		$firstParents = $collectionDetail['parents'][0];
		if ( !empty($firstParents['metas']) )
		{
			if ( !empty($firstParents['metas']['banner']) )
			{
				$bannerPath = $firstParents['metas']['banner'];
			}
		}
	}

?>
<div class="brand_banner_img">
	<img src="<?php echo $bannerPath ?>" alt="category">
</div>