<?php if ( ! empty($product)):?>
<?php
	$showClockCountdown = false;
	$showBanner = false;
	$variants = array_get($product, 'variants');
	foreach ($variants as $variant) {
		if(!empty($variant['active_special_discount']['ended_at'])){
			$showClockCountdown = str_replace('T', ' ', $variant['active_special_discount']['ended_at']);
			$showBanner = true;
			break;
		}
	} 
?>

<?php echo Theme::widget('breadcrumbs', array('showBanner' => $showBanner) )->render(); ?>

<!-- Product Detail -->
<div class="product__bg">
<div class="product__inner_wrapper">
	<div class="product__info">
		<div class="product__name">
			<h1 <?php echo empty($showClockCountdown) ? 'class="leveld_full_width" ' : ''; ?>>
			<?php
                $product_name = null;
				if(App::getLocale()=='th')
				{
                    $product_name = array_get($product,'title');
				}
				else
				{
					if(array_get($product,'translate') != null)
					{
                        $product_name =  array_get($product,'translate.title');
					}
					else
					{
                        $product_name =  array_get($product,'title');
					}
				}
                echo $product_name;
			?>
			</h1>
			<?php if(!empty($showClockCountdown)): ?>
				<div class="campaign_countdown">
					<img src="<?php echo Theme::asset()->usePath()->url('images/icn/time.png'); ?>" />
					<div class="box_timecount">
						<span><?php echo __('time_left_to_buy');?></span>
						<div class="countdown" data-countdown="<?php echo date('Y/m/d H:i:s', strtotime($showClockCountdown))?>"></div>
					</div>
				</div>
			<?php endif ?>
		</div>
		<div class="product__container">
			<?php /* Widget Product's photo zoom */ ?>
			<?php echo Theme::widget('productsZoom', array('product' => $product))->render(); ?>

			<div class="prd_price_box">
				<?php 
					$product_caption = null;
					if(App::getLocale()=='th')
					{
						$product_caption = array_get($product,'caption');
					}
					else
					{
						if(array_get($product,'translate.caption') != null)
						{
							$product_caption =  array_get($product,'translate.caption');
						}
						else
						{
							$product_caption =  array_get($product,'caption');
						}
					}
				?>
				<?php if(!empty($product_caption)):?>
				<div class="prd_type">
					<img src="<?php echo Theme::asset()->usePath()->url('images/icn/product-type.png'); ?>" /><span><?php echo $product_caption;?></span>
				</div>
				<?php endif;?>

				<?php /* Widget Product Price box */ ?>
				<?php echo Theme::widget('productsPriceBox', array('product' => $product))->render(); ?>

				<?php /* Widget Product True You */ ?>
				<?php echo Theme::widget('productsTrueU', array('product' => $product))->render(); ?>

				<?php /* Widget Product Payment Channel */ ?>
				<?php echo Theme::widget('productsPaymentChannel', array('product' => $product))->render(); ?>
                <?php
                    $product_id = $product['pkey'];
                    $str_len = strlen($product_id);
                    $str_for_calculate =  (int)(10 - $str_len);
                    $product_ref = 200 + substr($product_id,$str_for_calculate);

                ?>
				<div id="share" rel="<?php echo $product_ref;?>" class="productSocial_container" data-url="<?php echo Request::url(); ?>" data-text="<?php echo $product_name;?>">
				</div>
			</div>
		</div>
	</div>

	<?php /* Widget Product Promotion */ ?>
	<?php echo Theme::widget('productsPromotion', array('product' => $product))->render(); ?>

	<?php /* Widget Product Description */ ?>
	<?php echo Theme::widget('productsDescription', array('product' => $product))->render(); ?>

	<?php /* Widget Product Policy */ ?>
	<?php echo Theme::widget('productsPolicies', array('product' => $product))->render(); ?>

	<?php /* Widget Product Related */ ?>
	<?php echo Theme::widget('productsRelateNew', array('product' => $product))->render(); ?>


</div>

</div>
<?php endif;?>

<!-- [S] Reveal Dialogs -->
<?php echo Theme::partial("revealDialogLevelD", array("product"=>$product)); ?>
<!-- [E] Reveal Dialogs -->
