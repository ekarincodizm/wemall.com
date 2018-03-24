<?php if(!empty($products)):?>
	<?php
		#เก็บค่าทั้งหมด ใส่ array เพื่อหา array ชุดแรก
		$tv_data = array();
		foreach($products as $key => $row):?>
		<?php 	
			$media_contents = array();
			if(! empty($row['media_contents']))
			{
				foreach($row['media_contents'] as $mkey => $mrow)
				{
					if($mrow['mode'] == 'youtube')
					{
						$media_contents = $mrow;
						$media_contents['pkey'] = $row['pkey'];
						$media_contents['slug'] = $row['slug'];
						$media_contents['title'] = $row['title'];
						$media_contents['key_feature'] = $row['key_feature'];
						break;
					}
				}
			}
		?>
		
		<?php if(! empty($media_contents)):?>
			<?php $tv_data[] = $media_contents;?>
		<?php else:?>
			<?php
				$media_contents['url'] = 'http://www.youtube.com/watch?v=9GOFZYxwyow';
				$media_contents['thumb']['thumbnails']['medium'] = asset('themes/itruemart/assets/images/tv/tv-preview-1.jpg');
				$media_contents['pkey'] = $row['pkey'];
				$media_contents['slug'] = $row['slug'];
				$media_contents['title'] = $row['title'];
				$media_contents['key_feature'] = $row['key_feature'];
				
				$tv_data[] = $media_contents;
			?>
		<?php endif;?>
		
	<?php endforeach;?>
	
	<?php if(! empty($tv_data)):?>
		<div class="category-box tv">
			<div class="category-header">
				<h3 class="header-text-container"><img src="/themes/itruemart/assets/images/icn/category/icn-ct-13.png" alt="" /><a href="<?php echo url('itruemart-tv');?>" title="itruemart-tv" >ITRUEMART 'S TV </a></h3>
				<ul>
					<li><a href="<?php echo url('itruemart-tv');?>" title="itruemart-tv" ><?php echo __("ชมสินค้า iTrueMart 's TV ทั้งหมด");?></a><img src="/themes/itruemart/assets/images/icn/arrow-collapse.png" alt="" /></li>
				</ul>
			</div>
			
			<div class="category-content">
				<?php #รูปแรกจะต้องใหญ่กว่า ทุกรูป ?>
				<ul>
					<?php foreach($tv_data as $tkey => $trow):?>
						<li>		
							<a href="<?php echo $trow['url']; ?>" rel="prettyPhoto">
								<?php 
									if($tkey == 0)
									{
										$width = 371;
										$height = 227;
									}
									else
									{
										$width = 191;
										$height = 118;
									}
								?>
								<img height="<?php echo $height;?>" width="<?php echo $width;?>" src="<?php echo $trow['thumb']['thumbnails']['medium']; ?>" alt="<?php echo $trow['title']; ?>" />
							</a>
							<a href="<?php echo get_permalink('products', $trow); ?>">
								<p class="header-detail">
									<?php echo $trow['title']; ?>
								</p>
								<p>
									<?php echo strip_words( strip_tags($trow['key_feature']), 200 ) ;?><span class="view-detail">Read more</span>
								</p>
							</a>
						</li>
					<?php endforeach;?>
				</ul>
			</div>
		</div>
	<?php endif;?>
	
<?php endif;?>