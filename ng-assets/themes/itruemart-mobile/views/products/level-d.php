<div id="container" style="padding-top:10px;">
    <div class="banner"> 
        <!--Sold out--> 
        <div class="soldout" style="display:none;">
            <div class="soldout_bt">สินค้าหมด</div>
        </div>
        <!--End Sold out-->

        <?php
        $sliderImageList = array();
        if (!empty($product['media_contents']))
        {
            foreach ($product['media_contents'] as $image)
            {
                if ($image['mode'] == "image")
                {
                    $sliderImageList[] = $image['thumb']['thumbnails']['zoom'];
                }
            }
        } else
        {
            $sliderImageList[] = Theme::asset()->usePath()->url('images/product/image-not-found-338.jpg');
        }
        ?>

        <!-- Main Slider for beginning. -->
        <ul id="campaign" class="bxslider-main">
            <?php foreach ($sliderImageList as $key => $value): ?>
                <li>
                    <a href="#"  data-color-id="<?php echo $key; ?>">
                        <img src="<?php echo $value; ?>" width="100%">
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <!--Hided Slider for media set (No need to load the images by ajax.)-->
        <ul id="default-slider" style="display:none;visibility:hidden;">
            <?php foreach ($sliderImageList as $key => $value): ?>
                <li>
                    <a href="#"  data-color-id="<?php echo $key; ?>">
                        <img src="<?php echo $value; ?>" width="100%">
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if (!empty($product['style_types'][0]['options'])) : ?>
            <?php foreach ($product['style_types'] as $key => $style_type): ?>
                <?php array_push($styleTypeArray, $style_type['pkey']); ?>
                <?php if ($style_type['media_set']): ?>
                    <?php foreach ($style_type['options'] as $styleOption) : ?>
                        <?php if (isset($styleOption['media_contents']) && count($styleOption['media_contents']) > 0) : ?>

                            <ul id="slider-template-<?php echo $styleOption['pkey'] ?>" style="display:none;visibility:hidden;" class="bxslider-media-set">

                                <?php foreach ($styleOption['media_contents'] as $media) : ?>
                                    <?php if ($media['mode'] != 'image') continue; ?>
                                    <li>
                                        <a href="#"  data-color-id="<?php echo $key; ?>">
                                            <img src="<?php echo $media['thumb']['thumbnails']['zoom']; ?>" width="100%">
                                        </a>
                                    </li>
                                <?php endforeach; ?>

                            </ul>

                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="price">
        <div style="float:left; padding-left:10px;">
            <h1>
                <?php
                if (App::getLocale() == 'th')
                {
                    echo array_get($product, 'title');
                } else
                {
                    if (array_get($product, 'translate') != null)
                    {
                        echo array_get($product, 'translate.title');
                    } else
                    {
                        echo array_get($product, 'title');
                    }
                }
                ?>
            </h1>
        </div>
        <div class="clear"></div>
        <div style="border-top:1px dotted #990000; margin:10px 0 0px 0; padding:10px 0 0 0">
            <div style=" float:right; padding-right: 10px; text-align:right; width:400px; ">
                <div class="product_status" id="product-status">
                    <div id="variant-status-default">
                        <?php if ($product['has_variants'] == 0): ?>
                            <?php echo __('Status'); ?><span class="bullet-col">:</span>
                            <div class="status_type"></div>
                        <?php endif ?>

                        <?php if ($product['special_price_range']['max'] || $product['special_price_range']['min']): ?>
                            <?php if ($product['net_price_range']['min'] != $product['net_price_range']['max']): ?>
                                <h2><span class="product-price get-discount" style=" text-decoration:line-through;"><?php echo price_format($product['net_price_range']['min']) ?> - <?php echo price_format($product['net_price_range']['max']) ?> </span></h2>
                            <?php else : ?>
                                <h2><span class="product-price get-discount" style=" text-decoration:line-through;"><?php echo price_format($product['net_price_range']['min']) ?> .- </span></h2>
                            <?php endif; ?>

                            <?php if ($product['price_range']['min'] != $product['price_range']['max']): ?>
                                <h1><span class="product-price discount-price"><?php echo price_format($product['price_range']['min']) ?> -  <?php echo price_format($product['price_range']['max']) ?>  </span></h1>
                            <?php else : ?>
                                <h1><span class="product-price discount-price"><?php echo price_format($product['price_range']['min']) ?> .-</span></h1>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php if ($product['price_range']['min'] != $product['price_range']['max']): ?>
                                <h1><span class="product-price"><?php echo price_format($product['price_range']['min']) ?> - <?php echo price_format($product['price_range']['max']) ?> </span></h1>
                            <?php else : ?>
                                <h1><span class="product-price"><?php echo price_format($product['price_range']['min']) ?> .-</span></h1>
                            <?php endif; ?>

                        <?php endif; ?>
                    </div>
                    <div id="variant-status-backbone" ></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>	

    <div id="wrapper_content">
        <?php echo Form::open(array('class' => 'product-form')); ?>
        <div class="content" style="padding:0;">
            <div class="content-right box-sizing">
                <div id="product_detail">
                    <div class="product_status">
                        <?php if (!empty($product['style_types'][0]['options'])) : ?>
                            <?php foreach ($product['style_types'] as $key => $style_type): ?>
                                <?php //array_push($styleTypeArray, $style_type['pkey']); ?>
                                <?php if ($key == 0): ?>
                                    <div style="padding:10px; position:relative;overflow: hidden;">
                                        <div style="position: absolute; right: 78px; top: 0px;">
                                            <img src="<?php echo Theme::asset()->usePath()->url('images/arrow.png'); ?>" width="18" height="6" />
                                        </div>
                                    <?php else: ?>
                                        <div style="padding:10px; border-top:1px dotted #CCC; overflow: hidden;">
                                    <?php endif; ?>

                                        <div class="<?php echo ($style_type['name'] == 'สี') ? 'color' : 'size'; ?>">
                                            <?php echo $style_type['name']; ?> : <span class="bullet-col"></span>
                                            
                                            <ul class="color_of_size style-type" data-style-type="<?php echo $style_type['pkey'] ?>" <?php if ($style_type['media_set'] == true) echo 'id="media-set"'; ?>>
                                                <?php foreach ($style_type['options'] as $value): ?>
                                                    <?php $allVariantList[$style_type['pkey']][] = $value['pkey']; ?>
                                                    <li class="box_list number">
                                                        <a href="#" title="<?php echo $value['text']; ?>" rel="nofollow" class="<?php echo $value['meta']['type'] === 'color' ? 'select_color' : 'select_size'; ?> box-sizing style-option" data-style-option="<?php echo $value['pkey'] ?>" data-style-name="<?php echo $value['text']; ?>" data-product-id="<?php echo $product['pkey']; ?>" data-color-id="<?php echo $value['pkey'] ?>" data-pkey="<?php echo $value['pkey'] ?>" >
                                                            <?php
                                                            if ($value['meta']['type'] === 'color')
                                                            {
                                                                echo '<div style="background-color:' . $value['meta']['value'] . '"></div>';
                                                            } elseif ($value['meta']['type'] === 'text')
                                                            {
                                                                echo $value['meta']['value'];
                                                            } elseif ($value['meta']['type'] === 'image')
                                                            {
                                                                echo "<img src='" . $value['meta']['value'] . "' alt='" . $product['title'] . "' width='100%' height='100%' />";
                                                            } else
                                                            {
                                                                echo $value['meta']['value'];
                                                            }
                                                            ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="buy">
            <div style="float:left; padding-left:15px;">จำนวน :
            <!-- <select name="item_qty" id="item_qty" class="input-mini text-center product-qty">
                <?php //for ($v = 1; $v <= 5; $v++):  ?>
                    <option value="<?php //echo $v;  ?>"><?php //echo $v;  ?></option>
                <?php //endfor  ?>
            </select>-->
                <input type="item_qty" id="item_qty" style="padding: 5px 20px 5px 20px; width:24px;font-size: 1.2em;margin-left: 15px;background-color: #FFF;border: 1px solid #CCC;-webkit-border-radius: 4px;" class="qty form-control product-qty input-sm stepper-input" value="1"/>
            </div>
            <div style="float:right; position:relative;">
                <div style="position:absolute; right:45%; top:-10px;"></div>
                <button style="display: inline;" type="submit" class="pull-right product-addtocart btn-blue-l btn-addcart add_cart" <?php
                if ($product['has_variants'] == 0){ echo ' data-inventory-id="' . $product['variants'][0]['inventory_id'] . '"'; }
                if ($product['installment']['allow']) { echo ' data-allow-installment="true"'; } 
                ?> /><?php echo 'สั่งซื้อ'; ?></button>
                <!-- <button style="display: inline;" class="btn-blue-l btn-addcart add_cart" data-href="http://www.itruemart.com/cart/add/24189/42945">สั่งซื้อ</button> -->
            </div>
            <div class="clear"></div>
        </div>
        <?php echo Form::close(); ?>
        <div class="review">
            <div class="title">
                <h3>คุณสมบัติสินค้า</h3>
            </div>
            <div style="padding-left:15px; padding-right:15px;">
                <?php
                if (App::getLocale() == 'th')
                {
                    echo array_get($product, 'key_feature');
                } else
                {
                    if (array_get($product, 'translate') != null)
                    {
                        echo array_get($product, 'translate.key_feature');
                    } else
                    {
                        echo array_get($product, 'key_feature');
                    }
                }
                ?>
            </div>
        </div>
        <div class="content">
            <div class="title">
                <h3>รายละเอียดเพิ่มเติม</h3>
            </div>
            <div>
                <?php
                if (App::getLocale() == 'th')
                {
                    echo array_get($product, 'description');
                } else
                {
                    if (array_get($product, 'translate') != null)
                    {
                        echo array_get($product, 'translate.description');
                    } else
                    {
                        echo array_get($product, 'description');
                    }
                }
                ?>
            </div>
        </div>	  
    </div>

    <div id="cart-adding" class="reveal-modal">
        <div class="font2 msg-header">กำลังเพิ่มสินค้าลงตะกร้า...</div>
    </div>
</div>

<!-- cart alert lightbox -->
<div id="cart-alert" class="reveal-modal">
    <div class="font2 msg-header text-center alert-title"></div>
    <div id="popup_message" class="alert-message"></div>
    <div id="popup_panel">
        <input type="button" class="popup_ok btn btn-success" value="<?php echo __('ok'); ?>">
    </div>
</div>

<!-- cart success lightbox -->
<div id="cart-alert" class="reveal-modal">
    <div class="font2 msg-header text-center alert-title"></div>
    <div id="popup_message" class="alert-message"></div>
    <div id="popup_panel">
        <input type="button" class="popup_ok btn btn-success" value="<?php echo __('ok'); ?>">
    </div>
</div>

<!-- installment alert lightbox. -->
<div id="cart-installment" class="reveal-modal">
    <div class="font2 msg-header">ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้</div>
    <div id="popup_content" class="basket_put font2">
        <div style="margin-top: 10px;">
            <p class="installment_message installment_message_1">สินค้าชิ้นนี้จะไม่สามารถผ่อนชำระได้ เนื่องจากสินค้าผ่อนชำระ"ไม่"สามารถชำระรวมกับสินค้าอื่นได้ค่ะ</p>
            <p class="installment_message installment_message_2">ไม่สามารถนำสินค้าชิ้นนี้ใส่ตะกร้าได้ เนื่องจากสินค้าในตะกร้าเป็นแบบ "ผ่อนชำระ"<br />กรุณาชำระสินค้าในตะกร้าก่อนค่ะ</p>
            <p class="installment_message installment_message_3">ไม่สามารถนำสินค้าชิ้นนี้ลงตะกร้าได้ เนื่องจากสินค้าในตะกร้าเป็นแบบ "ผ่อนชำระ"<br />กรุณาชำระสินค้าในตะกร้าก่อนค่ะ</p>
        </div>
        <div id="popup_message">

            <?php if (!empty($product['media_contents'])): ?>
                <img src="<?php echo $product['media_contents'][0]['thumb']['thumbnails']['small']; ?>" alt="<?php echo $product['title']; ?>" class="img-cart">
            <?php endif; ?>

            <dl class="detail-cart">
                <dt><?php echo __('items'); ?></dt>
                <dd id="resp-product-title"><?php echo $product['title']; ?></dd>
            </dl>
            <div class="clearfix"></div>
        </div>
        <div id="popup_panel">
            <input type="button" class="popup_ok btn btn-success cart-installment-button cart-installment-button_ok" value="<?php echo __('ok'); ?>">
            <input type="button" class="popup_ok btn btn-success cart-installment-button cart-installment-button_add" value="เพิ่มสินค้าแบบชำระเงินปกติ">
            <input type="button" class="popup_ok btn cart-installment-button cart-installment-button_cancel" value="ยกเลิก">
        </div>
    </div>
</div>

<!-- select payment type lightbox. -->
<div id="cart-select-installment" class="reveal-modal">
    <div class="font2 msg-header">กรุณาเลือกรูปแบบการชำระ</div>
    <div id="popup_content" class="basket_put font2">
        <div id="popup_message">

            <?php if (!empty($product['media_contents'])): ?>
                <img src="<?php echo $product['media_contents'][0]['thumb']['thumbnails']['small']; ?>" alt="<?php echo $product['title']; ?>" class="img-cart">
            <?php endif; ?>

            <dl class="detail-cart">
                <dt><?php echo __('items'); ?></dt>
                <dd id="resp-product-title"><?php echo $product['title']; ?></dd>
                <dt>รูปแบบการชำระ</dt>
                <dd id="resp-product-title">
                    <label><input type="radio" name="cart-installment-select" class="cart-installment-select" value="normal" style="margin-right: 5px;" checked="checked" />ปกติ</label>
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
<!-- cart summary lightbox. -->
<div id="cart-result" class="reveal-modal">
    <div class="font2 msg-header"><?php echo __('This item has been added'); ?></div>
    <div id="popup_content" class="basket_put font2">
        <div id="popup_message">

            <?php if (!empty($product['media_contents'])): ?>
                <img src="<?php echo $product['media_contents'][0]['thumb']['thumbnails']['small']; ?>" alt="<?php echo $product['title']; ?>" class="img-cart">
            <?php endif; ?>

            <dl class="detail-cart">
                <dt><?php echo __('Product'); ?></dt>
                <dd id="resp-product-title"><?php echo $product['title']; ?></dd>
                <dt><?php echo __('Quantity'); ?></dt>
                <dd id="resp-product-qty">0</dd>
                <dt><?php echo __('Total Amount'); ?></dt>
                <dd id="resp-product-totalprice">0</dd>
            </dl>
        </div>
        <div id="popup_panel">
            <input type="button" class="popup_ok btn btn-success" value="<?php echo __('ok'); ?>">
        </div>
    </div>
</div>

<div class="cart-template">
</div>

<?php
    $searchKeyData = '';
    $backboneData = '';
    $cart = array(
        'totalQty' => 0,
        'totalItem' => 0,
        'cart_details' => ''
    );

    $tmpVariantList = $allVariantList;
    $allVariantList = array();
    foreach($tmpVariantList as $pkey=>$row){
        $allVariantList = array_combind_v2($allVariantList, $row);
    }

    foreach ($product['variants'] as $keyvariant => $variant)
    {
        $styleOptions = array();
        if (!empty($variant['style_options']))
        {
            foreach ($variant['style_options'] as $keyStyle => $style_option)
            {
                if ($keyStyle == 0)
                {
                    $searchKeyData = $style_option['option'];
                } else
                {
                    $searchKeyData = $searchKeyData . "-" . $style_option['option'];
                }
                $styleOptions['style-option-' . $style_option['style']] = $style_option['option'];
            }
        }

        $data = array_merge(array(
            'searchKey' => $searchKeyData,
            'inventoryId' => $variant['inventory_id'],
            'netPrice' => price_format($variant['net_price']),
            'specialPrice' => price_format($variant['special_price']),
            'normalPrice' => price_format($variant['normal_price']),
            'price' => price_format($variant['price']),
                ), $styleOptions);

        $backboneData .= "\napp.variantCollection.add(new Variant(" . json_encode($data) . "));";
    }

Theme::asset()->container('footer')->writeContent('js-price-template', '
    <script type="text/template" id="price-template">
                    <% if(model.get("remaining")===true){ 
                        $(".soldout").hide(); 
                    }else if(model.get("remaining")===false) { 
                        $(".soldout").show();
                    }else { 
                        $(".soldout").hide(); 
                    } %>
                    <% if(model.get("specialPrice") == 0 ){ %>
                            <span class="bullet-col"></span>
                            <h1><span class="product-price"> <%= model.get("price") %> .- </span></h1>
                    <% }else if(model.get("specialPrice") != 0 && (model.get("price") != model.get("specialPrice")) ){ %>
                            <span class="bullet-col"></span>
                            <h2><span class="product-price get-discount" style="text-decoration:line-through;"> <%= model.get("netPrice") %> .- </span></h2>
                            <span class="bullet-col"></span>
                            <h1><span class="product-price discount-price"> <%= model.get("price") %> .-</span></h1>
                    <% }else if(model.get("specialPrice") != 0 && (model.get("price") == model.get("specialPrice")) ){ %>
                            <span class="bullet-col"></span>
                            <h1><span class="product-price"> <%= model.get("price") %> .- </span></h1>
                    <% } %>
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
            variantCollection: null,
            currentVariant: null,

            el: ".content",
            events: {
                "click a.style-option": "handleSelectOption"
            },
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
                    var searchKey = ":' . implode(':-:', $styleTypeArray) . ':",
                            styleOptions = $(".style-type .style-option.active"),
                            o;
                    styleOptions.each(function(){
                            searchKey = searchKey.replace(new RegExp(":"+$(this).parents(".style-type").data("styleType")+":"), $(this).data("styleOption"));
                    });
                    return searchKey;
            },
            handleSelectOption: function(e) {
        
                    e.preventDefault();
                    var _b = this,
                            o = $(e.currentTarget),
                            p = o.parents(".style-type"),
                            variant;
                    p.find(".style-option").removeClass("active");
                    p.find(".box_list").removeClass("active");

                    var style_name = o.attr("data-style-name");
                    p.siblings().text(style_name);
                    o.parents(".box_list").addClass("active");
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
        disableEmptyStock: function(){
        },

        renderDefault: function() {
                $("#variant-status-backbone").hide();
                $("#variant-status-default").show();
                $(".soldout").hide();
                
                //check to show/hide sole out overlay.
                styleOptions = $(".style-type .style-option.active");
                if(styleOptions.length == ' . count($styleTypeArray) . '){
                    $(document).trigger("set-inventory-id", "out_of_order");
                    $(".soldout").show();
                }
        },
        renderStatus: function(variant) {
                this.currentVariant = variant.get("inventoryId");
                this.priceTarget.html(this.priceTemplate({
                        model: variant
                }));
                $("#variant-status-default").hide();
                $("#variant-status-backbone").show();
        },
        renderInProduct: function(){
            var that = this;
            var allVariantList = ["'.  implode('","', $allVariantList).'"];
            var variant = null;
            if(allVariantList.length > 0){
                if(allVariantList[0] != ""){
                    jQuery.each( allVariantList, function( idx, val ) {
                        variant = that.variantCollection.get(val);
                        if(variant && variant.toJSON().remaining){
                            return false;
                        }
                    });
                    if(variant){
                        jQuery.each( variant.toJSON(), function( idx, val ) {
                            pattern = /^style-option-/i;
                            if(pattern.test(idx)){
                                $("a[data-style-option=\'"+val+"\']").trigger("click");
                            }
                        });
                    }else{
                        $(".product-addtocart, .product-buynow").remove();
                    }
                }
            }
        }

    });

    var app = new AppView;
    ' . $backboneData . '
    </script> ');

if ($product['has_variants'] == 0)
{
    Theme::asset()->container('footer')->writeScript('checkStockSingleVariant', '
		$.get("/products/check/' . $product['variants'][0]['inventory_id'] . '",function(result){
			if(result.status===200){
					$(".soldout").hide();
				}else{
					$(".soldout").show();
                                        $(".product-addtocart, .product-buynow").remove();
                                }
			}else{
				$(".status_type").addClass("out_of_stock").html(__("ไม่สามารถตรวจสอบได้ กรุณาลองใหม่"));
                        }
		});');
} else
{
    $inventoryIds = implode(',', array_pluck($product['variants'], 'inventory_id'));

    Theme::asset()->container('footer')->writeScript('checkStockMultiVariant', '
		$.get("/products/check/' . $inventoryIds . '",function(result){
			if (result.status===200){
				for(var id in result.stocks){
					$(document).trigger("sync-stock", [id, result.stocks[id]]);
                                }
                                app.renderInProduct()
                        }
		});');
}
?>

<script>
    var Product = Product || {};
    Product.data = eval(<?php echo json_encode($product); ?>);
    var Cart = Cart || {};
    Cart.data = eval(<?php echo json_encode($cart); ?>);
    var siteURL = "<?php echo URL::to("/"); ?>";

</script>
