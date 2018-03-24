<div class="content-home sub">
	<div class="breadcrumbs">
		<div id="link_map">
			<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
				<a class="map" itemprop="url" href="http://www.itruemart.com/" title="Shopping Online">
					<span itemprop="title"><?php echo __('Shopping On-line'); ?></span>
				</a>
			</span>
			<?php echo Theme::breadcrumb()->render(); ?>
		</div>
	</div>
	<div id="wrapper_content">
		<div class="content">
		<div class="product_preview box-sizing">
						<div class="product_img_big">
							<h2>

								<?php if(!empty($product['image_cover'])): ?>
								<a href="<?php echo $product['image_cover']['thumbnails']['zoom']; ?>" class="zoomer"
								title="<?php echo $product['title']; ?>">
									<img src="<?php echo $product['image_cover']['thumbnails']['zoom']; ?>"
									alt="<?php echo $product['title']; ?>" width="338" height="338" class="path_original"
									 style="visibility: visible; opacity: 1; width: 338px; height: 338px;">
								</a>
								<?php endif; ?>

							</h2>
						</div>
						<div class="product_360degree-container">
							<!-- <div class="product_360degree" style="background: url(http://cdn.itruemart.com/files/product/827/13265/pano_13265_20130816190326_thumb.jpg) no-repeat center left;">
							</div> -->
                            <div class="product_360degree" >
                            </div>
						</div>
						<div class="vdo-container" style="position: relative;">
							<?php $youtube = ''; ?>
							<?php foreach($product['media_contents'] as $key => $mediaC){?>
								<?php if($mediaC['mode'] == 'youtube'){
									$youtube = $key;
								 } ?>
							<?php } ?>
							<div class="vdo-inner">
								<?php if($youtube){?>
									<?php $youtube_url = explode("=", $product['media_contents'][$youtube]['url']); ?>
									<iframe width="336" height="189" src="//www.youtube.com/embed/<?php echo $youtube_url[1]?>?rel=0"
										frameborder="0" allowfullscreen></iframe>
								<?php } ?>
							</div>
						</div>
						<div style="clear:both;"></div>


						<!--- tab bar pano ---->
						<div>
							<ul class="product-control">
								<li>
									<a href="javascript:;" rel="zoom">
										<img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon_zoomview.png">
										<span>Zoom View</span>
									</a>
								</li>
                                <?php if(isset($image360)): ?>
								<li>
									<a href="javascript:;" rel="360">
										<img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon_360.png">
										<span>Product 360</span>
									</a>
								</li>
                                <?php endif; ?>
                                <?php if(isset($youtube_url)): ?>
								<li>
									<a href="javascript:;" rel="vdo">
										<img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon_vdo.png">
										<span>Video</span>
									</a>
								</li>
                            <?php endif; ?>
							</ul>
							<div class="divide"></div>
						</div>
						<!--- tab bar pano ---->

						<div style="clear:both;"></div>
						<div class="img_preview_wrapper product-images" id="original-images"  style="display:block;">
							<div class="img_preview_next" id="img_preview_next_0"></div>
							<ul class="img_preview_content" >
							<?php foreach($product['media_contents'] as $key => $mediaC){?>
								<?php if($mediaC['mode'] == 'image'){ ?>
								<li class="product-image">
									<img src="<?php echo $mediaC['thumb']['thumbnails']['zoom']; ?>" alt="<?php echo $product['title']; ?>" class="path_show" style="display:none;">
									<img src="<?php echo $mediaC['thumb']['thumbnails']['zoom'] ?>" alt="<?php echo $product['title']; ?>" class="path_original" style="display:none;">

									<a href="javascript:" class="show_thumb" rel="nofollow" title="<?php echo $product['title']; ?>">
										<img src="<?php echo $mediaC['thumb']['thumbnails']['square'] ?>" alt="<?php echo $product['title']; ?>" alt="<?php echo $product['title']; ?>">
									</a>
								</li>
								<?php } ?>
							<?php } ?>
							</ul>

							<div class="img_preview_prev" id="img_preview_prev_0"></div>
							<div style="clear:both;"></div>
						</div>

						<?php if ( ! empty($product['style_types'][0]['options'])) : ?>
						<?php foreach ($product['style_types'] as $key => $style_type): array_push($styleTypeArray, $style_type['pkey']); ?>
						<?php $iterator = 0; ?>

						<?php if($style_type['media_set']): $iterator++; ?>
						<?php foreach ($style_type['options'] as $styleOption) : ?>
							<?php if (isset($styleOption['media_contents'])) : ?>
								<div class="img_preview_wrapper other-images" style="visibility:hidden" id="media-set-images-<?php echo $styleOption['pkey'] ?>">
									<div class="img_preview_next" id="img_preview_next_<?php echo $iterator; ?>"></div>
										<ul class="img_preview_content">
											<?php foreach ($styleOption['media_contents'] as $media) : ?>
												<?php if ($media['mode'] != 'image') continue; ?>
												<li class="product-image">
													<img src="<?php echo $media['url']; ?>" alt="<?php echo $product['title']; ?>" class="path_show" style="display:none">
													<img src="<?php echo $media['url']; ?>" alt="<?php echo $product['title']; ?>" class="path_original" style="display:none">

													<a href="javascript:" class="show_thumb" rel="nofollow" title="<?php echo $product['title']; ?>">
														<img src="<?php echo $media['url']; ?>" alt="<?php echo $product['title']; ?>" alt="<?php echo $product['title']; ?>">
													</a>
												</li>
											<?php endforeach; ?>
										</ul>
									<div class="img_preview_prev" id="img_preview_prev_<?php echo $iterator; ?>"></div>
									<div style="clear:both;"></div>
								</div>
							<?php endif; ?>
						<?php endforeach ?>
						<?php endif ?>
						<?php endforeach; ?>

						<?php endif; ?>

				<!-- widget share -->
				<?php echo Theme::widget('social', array('product'=>$product))->render(); ?>
				<!-- End NewDesign -->
			</div>

			<div class="content-right box-sizing">
				<div id="product_detail">
					<h1>
						<?php
							if(App::getLocale()=='th')
							{
								echo array_get($product,'title');
							}
							else
							{
								if(array_get($product,'translate')!=null)
								{
									echo array_get($product,'translate.title');
								}
								else
								{
									echo array_get($product,'title');
								}
							}
						?>
					</h1>
					<div class="box-review">
					</div>

					<!-- widget product discount countdown -->
					<?php echo Theme::widget('countdown', array('product'=>$product))->render(); ?>

					<?php echo Form::open(array('class' => 'product-form')); ?>

					<div class="product_status" id="product-status">
						<div id="variant-status-default">
							<dl>

							<?php
								//s($product);
								if($product['has_variants'] == 0): ?>
									<dt><?php echo __('Status');?><span class="bullet-col">:</span></dt>
									<dd>
										<div class="status_type">
											<!-- <img src="<?php //echo Theme::asset()->url('images/stock-checking.gif') ?>" style="margin-top:7px;"> -->
										</div>
									</dd>
								<?php endif ?>


								<?php if($product['special_price_range']['max'] || $product['special_price_range']['min']){ ?>
											 <dt><?php echo __('Price');?><span class="bullet-col">:</span></dt>
													<dd>
														<?php if($product['net_price_range']['min'] != $product['net_price_range']['max'] ){ ?>
															<span class="product-price get-discount"><?php echo price_format( $product['net_price_range']['min']) ?> - <?php echo price_format( $product['net_price_range']['max']) ?> </span>
														<?php }else{ ?>
															<span class="product-price get-discount"><?php echo price_format( $product['net_price_range']['min']) ?> .- </span>
														<?php }?>
													</dd>
													<dt><?php echo __('Special Offer');?><span class="bullet-col">:</span></dt>
													<dd>
														<?php if($product['price_range']['min'] != $product['price_range']['max'] ){ ?>
															<span class="product-price discount-price"><?php echo price_format( $product['price_range']['min']) ?> -  <?php echo price_format( $product['price_range']['max']) ?>  </span>
														<?php }else{ ?>
															<span class="product-price discount-price"><?php echo price_format( $product['price_range']['min']) ?> .-</span>
														<?php }?>

													</dd>
								<?php }else{ ?>

											<dt><?php echo __('Price');?><span class="bullet-col">:</span></dt>
												<dd>
												<?php if($product['price_range']['min'] != $product['price_range']['max'] ){ ?>
													<span class="product-price"><?php echo price_format( $product['price_range']['min']) ?> - <?php echo price_format( $product['price_range']['max']) ?> </span>
												 <?php }else{ ?>
													<span class="product-price"><?php echo price_format( $product['price_range']['min']) ?> .-
												 <?php }?>
												</dd>

								<?php } ?>
							</dl>
						</div>
						<div id="variant-status-backbone" ></div>
					</div>
						<div class="product_status">
						<dl>
							<?php $styleTypeArray = array(); ?>
							<?php if(!empty($product['style_types'][0]['options'])){ ?>
								<?php foreach ($product['style_types'] as $key => $style_type){ array_push($styleTypeArray, $style_type['pkey']); ?>
								<dt><?php echo $style_type['name']; ?><span class="bullet-col">:</span></dt>
								<dd>
									<div class="color_of_size style-type" data-style-type="<?php echo $style_type['pkey'] ?>" <?php if ($style_type['media_set']==true) echo 'id="media-set"'; ?>>
									<?php foreach ($style_type['options'] as $value){ ?>
										<div class="box_list number">
											<a href="#" title="35" rel="nofollow" class="<?php echo $value['meta']['type']==='color' ? 'select_color' : 'select_size'; ?> box-sizing style-option" data-style-option="<?php echo $value['pkey'] ?>">
												<?php if($value['meta']['type'] === 'color'){
													echo '<div style="width:22px;height:22px;border:0;padding:0;background-color:'.$value['meta']['value'].'"></div>' ;
												}elseif($value['meta']['type'] === 'text'){
													echo $value['meta']['value'];
												}elseif($value['meta']['type'] === 'image' ){
													 echo "<img src='".$value['meta']['value']."' alt='".$product['title']."' width='20' height='20' />";
												}else{
													echo $value['meta']['value'];
												}
												?>
											</a>
										</div>
									<?php } ?>
									</div>
								</dd>
								<?php } ?>
							<?php } ?>

							<dt><?php echo __('Quantity');?><span class="bullet-col">:</span></dt>
							<dd>
								<input type="text" value="1" name="item_qty" id="item_qty" class="input-mini text-center product-qty" />
								<?php echo __('piece'); ?>
							</dd>
						</dl>
						</div>

						<div class="clear">
						</div>

						<div class="action-box">
							<div class="col-50">
								<input type="submit" class="btn btn-buynow pull-right product-buynow" <?php if ($product['has_variants'] == 0) { echo 'data-inventory-id="' . $product['variants'][0]['inventory_id'] . '"'; } ?> value="<?php echo __('buy now');?>" /></div>
							<div class="col-50">
								<input type="submit" class="btn btn-addcart pull-left product-addtocart" <?php if ($product['has_variants'] == 0) { echo 'data-inventory-id="' . $product['variants'][0]['inventory_id'] . '"'; if ($product['installment']['allow']) { echo 'data-allow-installment="true"'; } } ?> value="" /></div>
						</div>
						 <div class="clear">
						</div>
							<!-- [S] E-Book -->
							<?php if (!empty($product['metas']['ebook-link'])) : ?>
							<div class="ebook">
								<a target="_blank" href="<?php echo $product['metas']['ebook-link'];?>">
									<img src="http://www.itruemart.com/assets/itruemart_new/global/images/ebook.png">
								</a>

								<p>คลิกปุ่ม เพื่อดาวน์โหลด หนังสือเล่มนี้ในรูปแบบ E-Book</p>
							</div>
							<?php endif ;?>
							<!-- [E] E-Book -->

							<div class="container-product container-product-properties">
								<div class="title-text"><h2><?php echo __('Benefits');?></h2></div>
								<div class="content-text">
								<?php
									if(App::getLocale()=='th')
									{
										echo array_get($product,'key_feature');
									}
									else
									{
										if(array_get($product,'translate')!=null)
										{
											echo array_get($product,'translate.key_feature');
										}
										else
										{
											echo array_get($product,'key_feature');
										}
									}
								?>
								</div>
							</div>
						</div><!-- end product detail-->



						<div class="right_ad">

							 <?php echo Theme::widget('productsInBrand', array('product'=>$product))->render(); ?>

							<!-- Right Banner -->
							<div class="right_ad_product"><h2>โปรโมชั่น</h2><a href="http://www.itruemart.com/product/apple-ipod-touch-64gb-blue-14781.html" title="ipodtouch-191213" target="_blank" data="610" class="save_stat" onclick="_gaq.push(['_trackEvent', 'Product', 'Promotion Banner', 'GG000000000000525']);"><img src="http://cdn.itruemart.com/files/banner/14/610.jpg" width="132" height="182" alt="ipodtouch-191213" class="img-ads"></a>
						   </div>
						</div>

						 <div class="clear">
							<br>
						</div>

					<?php echo Form::close(); ?>

					<?php // widget true card ?>
					<?php echo Theme::widget('productTrueCard', array('product'=>$product))->render(); ?>

					<?php if ($product['installment']['allow']): ?>
					<?php foreach ($product['variants'] as $variant): ?>
					<div class="container-product container-product-installment" id="installment-<?php echo $variant['inventory_id']; ?>" <?php echo ($product['has_variants']==1)?'style="display: none;"':''; ?>>
						<div class="title-text"><h2>ระยะเวลาในการผ่อนชำระ</h2></div>
						<div class="content-text">
							<ul>
								<?php foreach ($product['installment']['periods'] as $period): ?>
								<li>เดือนละ <?php echo price_format($variant['price']/$period); ?> บาท <?php echo $period; ?> เดือน</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
					<?php endforeach; ?>
					<?php endif; ?>
					<br>

					<?php if($product['policies']){?>
					<div class="container-product container-product-policy">
						<div class="title-text">
							<h2>ความคุ้มครองผู้บริโภค</h2>
						</div>
						<div class="content-text text-left">
						  
								<?php foreach($product['policies'] as $key => $policy ){?>
									<a href="#policies<?php echo $key; ?>" class="product_service_name link-policy inline policy">
										<img src="<?php echo $policy['image'] ?>" width="50" height="50" alt="<?php echo $policy['policy_title_th']; ?>" />
										<span class="policy-text"><?php echo $policy['policy_title_th']; ?></span>
										<span class="policy-type"><?php echo $policy['policy_title']; ?></span></a>
								<?php } ?>
							
						</div>
					</div>
					<?php } ?>

				</div>



			</div>
			<div class="clear"></div>
			<div class="product_review_comment">
				<div style="overflow: hidden; display: block;" id="product_tab_comment_text">
						<?php
							if(App::getLocale()=='th')
							{
								echo array_get($product,'description');
							}
							else
							{
								if(array_get($product,'translate')!=null)
								{
									echo array_get($product,'translate.description');
								}
								else
								{
									echo array_get($product,'description');
								}
							}
						?>
				</div>

				<div class="product_tab">
					<!--<a href="http://www.itruemart.com/product/more_detail/get_brand_detail">-->
					<div style="cursor:pointer" id="detail" class="product_tab_description product_tab_comment selected"><?php echo __('Description'); ?></div>
					<!--<a href="http://www.itruemart.com/product/more_detail/get_coment">-->


					<div style="cursor:pointer" id="policy" class="product_tab_comment">นโยบายการจัดส่งและรับประกันสินค้า</div>
				</div>

				<div id="review_comment_top"></div>

				<div id="review_policy" style="display: none;">
					<div id="wrapper">
						<!--start wrapper-->
						<div id="container">
							<!--start container-->
								<?php if($product['policies']){?>
									<?php foreach($product['policies'] as $key => $policy ){?>
										<a name="policies<?php echo $key; ?>"></a>
										<div class="policycontent">
										   <?php echo $policy['policy_description']; ?>
											<div class="clear">
											</div>
										</div>
										<br>
									<?php } ?>
								<?php } ?>
							<!--end container-->
						</div>
						<br>
							<!--end wrapper-->
					</div>
						<!--end wrapper_content-->
				</div>
			</div>
			<div class="border_line"></div>


			<div class="tag_product">
				<!-- <script>var cat_id = 382;</script>
				<script>var tags = "ไร้สาย|ขยายเครือข่าย|วามน่าเชื่อถือสูง|internet";</script> -->

				<!-- related product -->
				<?php echo Theme::widget('productsRelated', array('product' => $product))->render(); ?>

				<!-- recommend product -->
				<?php echo Theme::widget('productsRecommend', array('product' => $product))->render(); ?>

				<div class="bm_show_related_product" style="display:none;">0.5985</div>
			</div>
			<div class="border_line"></div>
		</div>
	</div>
</div>

<script>
	var Product = Product || {};
	Product.data = eval(<?php echo json_encode($product); ?>);
</script>

<div id="cart-adding" class="reveal-modal">
	<div class="font2 msg-header">กำลังเพิ่มสินค้าลงตะกร้า...</div>
	</div>
</div>

<div id="cart-alert" class="reveal-modal">
	<div class="font2 msg-header text-center alert-title"></div>
	<div id="popup_message" class="alert-message"></div>
	<div id="popup_panel">
		<input type="button" class="popup_ok btn btn-success" value="<?php echo __('ok'); ?>">
	</div>
</div>

<div id="cart-installment" class="reveal-modal">
	<div class="font2 msg-header">ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้</div>
	<div id="popup_content" class="basket_put font2">
		<div style="margin-top: 10px;">
			<p class="installment_message installment_message_1">สินค้าชิ้นนี้จะไม่สามารถผ่อนชำระได้ เนื่องจากสินค้าผ่อนชำระ"ไม่"สามารถชำระรวมกับสินค้าอื่นได้ค่ะ</p>
			<p class="installment_message installment_message_2">ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้ เนื่องจากสินค้าในตะกร้าเป็นแบบ "ผ่อนชำระ"<br />กรุณาชำระสินค้าในตะกร้าก่อนค่ะ</p>
			<p class="installment_message installment_message_3">ไม่สามารถนำสินค้าชิ้นนี้ลงตะกร้าได้ เนื่องจากสินค้าในตะกร้าเป็นแบบ "ผ่อนชำระ"<br />กรุณาชำระสินค้าในตะกร้าก่อนค่ะ</p>
		</div>
		<div id="popup_message">
			<img src="<?php echo $product['media_contents'][0]['thumb']['thumbnails']['small']; ?>" alt="<?php echo $product['title']; ?>" class="img-cart">
			<dl class="detail-cart">
				<dt><?php echo __('items'); ?></dt>
				<dd id="resp-product-title"><?php echo $product['title']; ?></dd>
			</dl>
			<div class="clearfix"></div>
		</div>
		<div id="popup_panel">
			<input type="button" class="popup_ok btn btn-success cart-installment-button cart-installment-button_ok" value="<?php echo __('ok');?>">
			<input type="button" class="popup_ok btn btn-success cart-installment-button cart-installment-button_add" value="เพิ่มสินค้าแบบชำระเงินปกติ">
			<input type="button" class="popup_ok btn cart-installment-button cart-installment-button_cancel" value="ยกเลิก">
		</div>
	</div>
</div>

<div id="cart-select-installment" class="reveal-modal">
	<div class="font2 msg-header">กรุณาเลือกรูปแบบการชำระ</div>
	<div id="popup_content" class="basket_put font2">
		<div id="popup_message">
			<img src="<?php echo $product['media_contents'][0]['thumb']['thumbnails']['small']; ?>" alt="<?php echo $product['title']; ?>" class="img-cart">
			<dl class="detail-cart">
				<dt><?php echo __('items'); ?></dt>
				<dd id="resp-product-title"><?php echo $product['title']; ?></dd>
				<dt>รูปแบบการชำระ</dt>
				<dd id="resp-product-title">
					<label><input type="radio" name="cart-installment-select" class="cart-installment-select" value="normal" style="margin-right: 5px;" checked />ปกติ</label>
					<label><input type="radio" name="cart-installment-select" class="cart-installment-select" value="installment" style="margin-right: 5px;" />ผ่อนชำระ</label>
				</dd>
			</dl>
			<div class="clearfix"></div>
		</div>
		<div id="popup_panel">
			<input type="button" class="popup_ok btn btn-success cart-installment-button_next" value="ต่อไป">
		</div>
	</div>
</div>

<div id="cart-result" class="reveal-modal">
	<div class="font2 msg-header"><?php echo __('This item has been added');?></div>
	<div id="popup_content" class="basket_put font2">
		<div id="popup_message">
			<img src="<?php echo $product['media_contents'][0]['thumb']['thumbnails']['small']; ?>" alt="<?php echo $product['title']; ?>" class="img-cart">
			<dl class="detail-cart">
				<dt><?php echo __('Product');?></dt>
				<dd id="resp-product-title"><?php echo $product['title']; ?></dd>
				<dt><?php echo __('Quantity');?></dt>
				<dd id="resp-product-qty">0</dd>
				<dt><?php echo __('Total Amount');?></dt>
				<dd id="resp-product-totalprice">0</dd>
			</dl>
		</div>
		<div id="popup_panel">
			<input type="button" class="popup_ok btn btn-success" value="<?php echo __('ok');?>">
		</div>
	</div>
</div>

<?php
	$searchKeyData = '';
	$backboneData = '';
	foreach($product['variants'] as $keyvariant => $variant){
        $styleOptions = array();
		if(!empty($variant['style_options'])){
		   foreach($variant['style_options'] as $keyStyle => $style_option){
				if($keyStyle == 0){
					$searchKeyData = $style_option['option'];
				}else{
					$searchKeyData = $searchKeyData."-".$style_option['option'];
				}
                $styleOptions['style-option-'.$style_option['option']] = $style_option['option'];
		   }
		}

		$data = array_merge(array(
			'searchKey' => $searchKeyData,
			'inventoryId' => $variant['inventory_id'],
			'netPrice' => price_format($variant['net_price']),
			'specialPrice' => price_format($variant['special_price']),
			'normalPrice' => price_format($variant['normal_price']),
			'price' => price_format($variant['price']),
		),$styleOptions);

	   $backboneData .= "\napp.variantCollection.add(new Variant(".json_encode($data)."));";
	}

?>

<?php
Theme::asset()->container('footer')->usePath()->add('js-underscore-min', 'js/underscore-min.js');
Theme::asset()->container('footer')->usePath()->add('js-backbone-min', 'js/backbone-min.js');
Theme::asset()->container('footer')->writeContent('js-price-template', '
<script type="text/template" id="price-template">
	<dl>
		<dt>'.__("Status").'<span class="bullet-col">:</span></dt>
		<dd>
			<% if(model.get("remaining")===true){ %><div class="status_type instock">'.__("In stock").'</div><% }
			else if(model.get("remaining")===false) { %><div class="status_type out_of_stock">'.__("out of stock").'</div><% }
			else { %><div class="status_type"></div><% } %>
		</dd>
		<% if(model.get("specialPrice") == 0){ %>
			<dt>'.__("Price").'<span class="bullet-col">:</span></dt>
			<dd>
				<span class="product-price"> <%= model.get("price") %> .- </span>
			</dd>
		<% }else if(model.get("specialPrice") != 0){ %>
			<dt>'.__("Price").'<span class="bullet-col">:</span></dt>
			<dd>
				<span class="product-price get-discount"> <%= model.get("netPrice") %> .- </span>
			</dd>
			<dt>'.__("Special Offer").'<span class="bullet-col">:</span></dt>
			<dd>
				<span class="product-price discount-price"> <%= model.get("price") %> .-</span>
			</dd>
		<% } %>
	</dl>
</script>
<script>
var Variant = Backbone.Model.extend ({
	idAttribute: "searchKey",

	defaults: {
		remaining: null
	}
});

var VariantCollection = Backbone.Collection.extend({
	model: Variant
});

var AppView = Backbone.View.extend({

	priceTemplate: _.template($("#price-template").html()),
	priceTarget: $("#variant-status-backbone"),

	el: ".content",
	events: {
        "click a.style-option": "handleSelectOption"
	},

	variantCollection: null,
	currentVariant: null,

	initialize: function() {
		var _t = this;
		_t.variantCollection = new VariantCollection();
		$(document).on("sync-stock", function(e, inventoryId, stockStatus){
			_t.variantCollection.map(function(item){
				item.get("inventoryId")==inventoryId && item.set("remaining", (stockStatus=="in" ? true : false));
			});
		})
	},
	getSearchKey: function() {
		var searchKey = ":'.implode(':-:',$styleTypeArray).':",
			styleOptions = $(".style-type .style-option.active"),
			o;
		styleOptions.each(function(){
			searchKey = searchKey.replace(new RegExp(":"+$(this).parents(".style-type").data("styleType")+":"), $(this).data("styleOption"));
		});
		// console.log(searchKey);
		return searchKey;
	},
	handleSelectOption: function(e) {
		e.preventDefault();
		var _b = this,
			o = $(e.currentTarget),
			p = o.parents(".style-type"),
			variant;
		p.find(".style-option").removeClass("active");
		o.addClass("active");
		o.trigger("select");

		variant = this.variantCollection.get(this.getSearchKey());
		if(variant) {
			$(document).trigger("set-inventory-id",variant.get("inventoryId"));
			this.renderStatus(variant);
			if(variant.get("remaining")==null)
				$.get("/products/check/"+variant.get("inventoryId"),function(result){
					if(result.status===200) {
						variant.set("remaining", (result.stock=="in" ? true : false));
						if(_b.currentVariant == variant.get("inventoryId"))
							_b.renderStatus(variant);
					}
				})
		} else {
			$(document).trigger("set-inventory-id", null);
			this.renderDefault();
		}
	},
    disableEmptyStock: function()
    {
    },

	renderDefault: function() {
		$("#variant-status-backbone").hide();
		$("#variant-status-default").show();
	},
	renderStatus: function(variant) {
		this.currentVariant = variant.get("inventoryId");
		this.priceTarget.html(this.priceTemplate({
			model: variant
		}));
		$("#variant-status-default").hide();
		$("#variant-status-backbone").show();
	}

});

var app = new AppView;
'.$backboneData.'
</script> ');

Theme::asset()->container('footer')->writeScript('js-select-style-option','


	$("#media-set .style-option").on("select", function(e) {
		$(".other-images").css("visibility","hidden").hide();
		var selected = $("#media-set-images-"+$(this).data("style-option")),
			product = $(".product-images"),
			img = $(".product_img_big img.path_original");
		if(selected.length) {
			selected.css("visibility","visible").show();
			img.attr("src",selected.find("li.product-image:first img.path_original").attr("src"));
			product.hide();
		}
		else {
			img.attr("src",product.find("li.product-image:first img.path_original").attr("src"));
			product.show();
		}
	})


', 'product');

	if($product['has_variants'] == 0)
	{
		Theme::asset()->container('footer')->writeScript('checkStockSingleVariant', '
		$.get("/products/check/'.$product['variants'][0]['inventory_id'].'",function(result){
			if(result.status===200)
				if(result.stock === "in")
					$(".status_type").addClass("instock").html("'.__("In stock").'");
				else
					$(".status_type").addClass("out_of_stock").html("'.__("out of stock").'");
			else
				$(".status_type").addClass("out_of_stock").html(__("ไม่สามารถตรวจสอบได้ กรุณาลองใหม่"));
		});');
	}
	else
	{
		$inventoryIds = implode(',',array_pluck($product['variants'], 'inventory_id'));

		Theme::asset()->container('footer')->writeScript('checkStockMultiVariant', '
		$.get("/products/check/'.$inventoryIds.'",function(result){
			if (result.status===200)
				for(var id in result.stocks)
					$(document).trigger("sync-stock", [id, result.stocks[id]]);
		});');
	}


?>
