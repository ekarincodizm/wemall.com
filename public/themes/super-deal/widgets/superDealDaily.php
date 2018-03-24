<?php $ln = Lang::getLocale();?>
<div class="daily-deal">
	<?php foreach($product_today as $key => $product):?>
	<?php 
		if($key == 0){
			$div_class_name = 'today';
			$disabled = '';
			$tagIcon = 'label-red-1.png';
		}
		else
		{
			$div_class_name = 'tomorrow';
			$disabled = 'disabled';
			$tagIcon = 'label-red-2.png';
		}
	?>
    <div class="<?php echo $div_class_name?>">
		<?php //echo $product['id']; ?>
        <div class="dd-title">
			<?php if($key == 0): ?>
				<h2 class="dd-title-name">
					Today's <span class="orange">Deal!</span>
				</h2>
			<?php else:?>
				<h3 class="dd-title-name">
					Tomorrow <span class="orange">Deal!</span>
				</h3>
			<?php endif;?>
        </div>

        <div class="sd-product-info <?php echo $disabled;?>">
			<?php
				/** prepair data */
				/* if(!isset($product["variants"][0]["active_special_discount"]["flashsale_type"])){
					$tagCls = "label-red";
					$tagIcon = "label-red-2.png";
					$isLineCampaign = false;
				}elseif( isset($product["variants"][0]["active_special_discount"]["flashsale_type"]) && 
						($product["variants"][0]["active_special_discount"]["flashsale_type"] == "tmvh" || 
						$product["variants"][0]["active_special_discount"]["flashsale_type"] == "trueu")){
					$tagCls = "label-green";
					$tagIcon = "label-green-1.png";
					$isLineCampaign = true;
				}else{
					$tagCls = "label-red";
					$tagIcon = "label-red-2.png";
					$isLineCampaign = false;
				} */
			?>
            <div class="label-red">
                <span class="label-percent-discount">
                    <?php echo (isset($product["percent_discount"]["min"]))? intval(floor($product["percent_discount"]["min"])) : "0"; ?><sup>%</sup><sub>OFF</sub>
                </span>
				
				<?php
					$discount_title 		= !empty($product['variants'][0]['active_special_discount']['discount_title'])? $product['variants'][0]['active_special_discount']['discount_title']: '';
					$banner_web_today 		= !empty($product['variants'][0]['active_special_discount']['banner_web_today'])? $product['variants'][0]['active_special_discount']['banner_web_today']: '';
					$banner_web_tomorrow 	= !empty($product['variants'][0]['active_special_discount']['banner_web_tomorrow'])? $product['variants'][0]['active_special_discount']['banner_web_tomorrow']: '';
					$banner_mobile_tomorrow = !empty($product['variants'][0]['active_special_discount']['banner_mobile_tomorrow'])? $product['variants'][0]['active_special_discount']['banner_mobile_tomorrow']: '';
					$product_pkey 			= !empty($product['variants'][0]['active_special_discount']['product_pkey'])? $product['variants'][0]['active_special_discount']['product_pkey']: '';
					$started_at 			= !empty($product['variants'][0]['active_special_discount']['started_at'])? str_replace('T', ' ', $product['variants'][0]['active_special_discount']['started_at']): '';
					$ended_at 				= !empty($product['variants'][0]['active_special_discount']['ended_at'])? str_replace('T', ' ', $product['variants'][0]['active_special_discount']['ended_at']): '';
				?>
				
				<?php if(!empty($discount_title)):?>
                <span class="label-campaign">
					<?php echo $discount_title; ?>
                </span>
				<?php endif;?>
				
                <img class="img-eaves" src="<?php echo Theme::asset()->usePath()->url('images/label/'.$tagIcon); ?>" />
            </div>
            <!-- <a href="#">
                <img src="<?php echo Theme::asset()->usePath()->url('images/ex-today.jpg'); ?>" />
            </a>
			-->
			<a href="<?php echo URL::toLang("products/" . $product["slug"] . "-" . $product['pkey'] . ".html" ); ?>">
				<?php if($key == 0):?>
					<img src="<?php echo !empty($banner_web_today)? $banner_web_today : Theme::asset()->usePath()->url('images/ex-today.jpg'); ?>" />
				<?php else:?>
					<img src="<?php echo !empty($banner_web_tomorrow)? $banner_web_tomorrow : Theme::asset()->usePath()->url('images/ex-tmr.jpg'); ?>" />
				<?php endif;?>
			</a>
			
            <div class="sd-product-name">
				<?php 
					$product_name = "";
					if($ln == 'th')
					{
						$product_name = (!empty($product["title"]))? $product["title"] : "" ;
					}
					else
					{
						$product_name = (!empty($product ['translate']["title"]))? $product ['translate']["title"] : "" ;
					}
				?>
                <?php if($key == 0) :?>
					<h4>
						<?php echo $product_name; ?>
					</h4>
				<?php else:?>
					<h5>
						<?php echo $product_name; ?>
					</h5>
				<?php endif;?>
            </div>
			
            <div class="sd-prop-info">
				<?php if($key == 0):?>
                <div class="box-timecount">
                    <span class="box-title">
							<?php echo __('time_left_to_buy');?>
                        <div class="countdown" data-countdown="<?php echo (!empty($ended_at))? str_replace("-", "/", $ended_at) : date("Y/m/d H:i:s" );  ?>"></div>
                    </span>
                </div>
				<?php endif;?>
                <div class="box-price">
                    <div class="box-price-discount">
                        <span class="box-title">
							<?php echo __('normal_price');?>
                        </span>
                        <span class="price-discount">
                            <?php if($product["net_price_range"]["min"] != $product["net_price_range"]["min"]): ?>
								<?php echo price_format($product["net_price_range"]["min"]) . " - " . price_format($product["net_price_range"]["max"]); ?>
							<?php else: ?>
								<?php echo price_format($product["net_price_range"]["max"]); ?>
							<?php endif; ?>
						</span> .-
                    </div>
                    <div class="box-price-normal">
                        <span class="box-title">
							<?php echo __('special_price');?>
                        </span>
                        <span class="price-normal">
                            <?php if($product["price_range"]["min"] != $product["price_range"]["min"]): ?>
								<?php echo price_format($product["price_range"]["min"]) . " - " . price_format($product["price_range"]["max"]); ?>
							<?php else: ?>
								<?php echo price_format($product["price_range"]["max"]); ?>
							<?php endif; ?>
                        </span> .-
                    </div>
                </div>
				<?php if($key == 0):?>
					<div class="box-action">
						<a href="<?php echo URL::toLang("products/" . $product["slug"] . "-" . $product['pkey'] . ".html" ); ?>" class="btn-order">
							<?php echo __('buy');?>
						</a>
					</div>
				<?php endif;?>
				
				<?php if($key == 1):?>
				<div class="box-timecount">
					<?php echo __('open_in');?> : 
					<div class="countdown" data-countdown="<?php echo (!empty($started_at))? str_replace("-", "/", $started_at) : date("Y/m/d H:i:s");  ?>"></div>
				</div>
				<?php endif;?>
            </div>
			
        </div>
    </div>
	<?php endforeach;?>
	
</div>