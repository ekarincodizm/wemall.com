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
?>
<div class="product__relate">
	<h2 class="product__relate_name"><?php echo __('Related items'); ?></h2>
	<ul class="product__relate_list">
		<?php for($i = 0;$i < 5;$i++){ ?>
			<?php if(sizeof($products) > $i): ?>
				<li class="product__relate_item">
                    <!-- typeidea script -->
					<a href="<?php echo $products[$i]['leveld_url']; ?>" class="ec-product" data-ec-item="product-relate-list|<?php echo $products[$i]['pkey']; ?>|<?php echo $i+1; ?>">
					<!-- //typeidea script -->
                        <?php if ($products[$i]['percent_discount'] != 0) { ?>
							<span class="price_tag">
								<span class="price_no">
									<?php echo $products[$i]['percent_discount']; ?>
								</span>
								<sup>%</sup>
								<sub>OFF</sub>
							</span>
						<?php } ?>
                        <?php //echo $products[$i]['title'];
                            if (App::getLocale() == 'th')
                            {
                                $product_name = $products[$i]['title'];
                            }
                            else
                            {
                                if(array_get($product,'translate')!=null)
                                {
                                    $product_name = $products[$i]['translate_title'];
                                }
                                else
                                {
                                    $product_name = $products[$i]['title'];
                                }
                            }
                        ?>
						<span class="product_thumbnail">
							<!--<img class="lazyload" data-original="<?php //echo Theme::asset()->usePath()->url('images/banner/product-showroom.jpg'); ?>" />-->
							<img class="lazyload" src="<?php echo $products[$i]['image_url']; ?>" alt="<?php echo $product_name; ?>"/>
						</span>
						<span class="product_name">
							<?php echo $product_name; ?>
						</span>
						<span class="product_price">

						<?php if ($products[$i]['special_price'] != 0) { ?>
							<span class="price_discount">
								<?php echo price_format($products[$i]['special_price']); ?>
							</span>
						<?php } ?>
							<span class="price_normal <?php if ($products[$i]['special_price'] != 0){ echo 'discount'; } ?>">
								<?php echo price_format($products[$i]['net_price']); ?>
							</span>
						</span>
					</a>
				</li>
			<?php endif; ?>

		<?php } ?>
	</ul>
</div>
<!-- typeidea script -->
<script type="text/javascript">
<?php  $ec_products = array(); ?>
  <?php 
    $ec_products = array();
    for($i = 0;$i < 5;$i++):
        if(sizeof($products) > $i){
             array_push($ec_products, 
            array(  'id' => $products[$i]['pkey'], 
                    'name' => $products[$i]['title'], 
                    'price' => $products[$i]['net_price'], 
                    'brand' => $products[$i]['brand'], 
                    'category' => $products[$i]['collections'],
                    'list' => 'product-relate-list', 
                    'position' => $i+1));
        }
       
    endfor; 
    ?>
    if(typeof ec_products === 'undefined'){
    	var ec_products = [];
    } 
    ec_products['product-relate-list'] = <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>;

    dataLayer.push({
      'ecommerce': {
        'currencyCode': 'PHP',
        'impressions': <?php echo jsonUnescapedUnicode(json_encode($ec_products)); ?>
      }
    });
</script>
<!-- //typeidea script -->
