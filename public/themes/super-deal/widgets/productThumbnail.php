<div class="flashsale">
    <div class="dd-title">
        <h2 class="dd-title-name">
            <span class="orange">Wow!</span>
        </h2>
        <div class="box-filter">
            <ul id="superdeal-filter">
                <li>
                    <span><?php echo __("filter_title"); ?> : </span>
                </li>
                <li>
                    <a id="published_at_filter" class="box-filter-type <?php if($params["orderBy"] == "published_at" && $params["order"] == "desc"){ echo "down"; }elseif($params["orderBy"] == "published_at" && $params["order"] == "asc"){ echo "up"; } ?>"
                       href="javascript:void(0);" data-orderby="published_at">
                        <?php echo __("filter_latest_txt"); ?> <span class="caret-down"></span><span class="caret-up"></span>
                    </a>
                </li>
                <li>
                    <a id="price_filter" class="box-filter-type <?php if($params["orderBy"] == "price" && $params["order"] == "desc"){ echo "down"; }elseif($params["orderBy"] == "price" && $params["order"] == "asc"){ echo "up"; } ?>"
                       href="javascript:void(0);" data-orderby="price">
                        <?php echo __("Price"); ?> <span class="caret-down"></span><span class="caret-up"></span>
                    </a>
                </li>
                <li>
                    <a id="discount_filter" class="box-filter-type <?php if($params["orderBy"] == "discount" && $params["order"] == "desc"){ echo "down"; }elseif($params["orderBy"] == "discount" && $params["order"] == "asc"){ echo "up"; } ?>"
                       href="javascript:void(0);"  data-orderby="discount">
                        <?php echo __("filter_discount_txt"); ?> <span class="caret-down"></span><span class="caret-up"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="fs-container" id="infinite-container">
        <?php if(!empty($products['products'])): ?>
            <?php foreach($products['products'] as $key => $product) : ?>
                <?php if(!empty($product["variants"][0]["active_special_discount"])) : ?>
                    <?php
                        /** prepair data */
                        if(!isset($product["variants"][0]["active_special_discount"]["flashsale_type"])){
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
                        }
                    ?>
                    <div class="fs-item-wrapper">
                        <div class="sd-product-info">
                            <div class="<?php echo $tagCls; ?>">
                                <?php if($isLineCampaign): ?>
                                    <img src="<?php echo Theme::asset()->usePath()->url('images/logo/line.jpg'); ?>" />
                                <?php endif; ?>
                                <span class="label-percent-discount">
                                    <?php echo (isset($product["percent_discount"]["min"]))? intval(floor($product["percent_discount"]["min"])) : "0"; ?><sup>%</sup><sub>OFF</sub>
                                </span>
                                <?php if(!empty($product["variants"][0]["active_special_discount"]["discount_title"])) : ?>
                                    <span class="label-campaign"><?php echo $product["variants"][0]["active_special_discount"]["discount_title"]; ?></span>
                                <?php endif; ?>
                                <img class="img-eaves" src="<?php echo Theme::asset()->usePath()->url('images/label/' . $tagIcon); ?>" />
                            </div>
                            <a href="<?php echo URL::toLang("products/" . $product["slug"] . "-" . $product['pkey'] . ".html" ); ?>">
                                <div style="height: 290px;overflow: hidden;width: 100%;">
                                    <img style="width:100%;" src="<?php echo !empty($product["image_cover"]["thumbnails"]["large"])? $product["image_cover"]["thumbnails"]["large"] : ""; ?>" />
                                </div>
                            </a>
                            <div class="sd-product-name">
                                <h5><?php
                                        if(Lang::getLocale() == "th"){
                                            echo (!empty($product["title"]))? $product["title"] : "" ;
                                        }else{
                                            echo (!empty($product["translate"]["title"]))? $product["translate"]["title"] : "";
                                        }
                                    ?>
                                </h5>
                                <?php if($isLineCampaign): ?>
                                    <?php if($product["variants"][0]["active_special_discount"]["flashsale_type"] == "tmvh"): ?>
                                        <span class="sd-product-logo"><img src="<?php echo Theme::asset()->usePath()->url('images/logo/line-truemove.png'); ?>" /></span>
                                    <?php elseif($product["variants"][0]["active_special_discount"]["flashsale_type"] == "trueu") : ?>
                                        <span class="sd-product-logo"><img src="<?php echo Theme::asset()->usePath()->url('images/logo/line-trueyou.png'); ?>" /></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="sd-prop-info">
                                <div class="box-price">
                                    <div class="box-price-discount">
                                        <span class="box-title"><?php echo __("normal_price"); ?></span>
                                        <span class="price-discount">
                                            <?php if($product["net_price_range"]["min"] != $product["net_price_range"]["min"]): ?>
                                                <?php echo price_format($product["net_price_range"]["min"]) . " - " . price_format($product["net_price_range"]["max"]); ?>
                                            <?php else: ?>
                                                <?php echo price_format($product["net_price_range"]["max"]); ?>
                                            <?php endif; ?>
                                        </span> .-
                                    </div>
                                    <div class="box-price-normal">
                                        <span class="box-title"><?php echo __("special_price"); ?></span>
                                        <span class="price-normal">
                                            <?php if($product["price_range"]["min"] != $product["price_range"]["min"]): ?>
                                                <?php echo price_format($product["price_range"]["min"]) . " - " . price_format($product["price_range"]["max"]); ?>
                                            <?php else: ?>
                                                <?php echo price_format($product["price_range"]["max"]); ?>
                                            <?php endif; ?>
                                        </span> .-
                                    </div>
                                </div>
                                <div class="box-action">
                                    <a href="<?php echo URL::toLang("products/" . $product["slug"] . "-" . $product['pkey'] . ".html" ); ?>" class="btn-order"><?php echo __("buy"); ?></a>
                                </div>
                                <div class="box-timecount"><?php echo __("time_left_to_buy"); ?> :
                                    <div class="countdown" data-countdown="<?php echo (!empty($product["discount_ended"]))? str_replace("-", "/", $product["discount_ended"]) : date("Y/m/d H:i:s", time()-1);  ?>"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if( ($key+1)%3 == 0): ?>
                        <div class="clearfix"></div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="next-product-container">
            <a id="next_product_btn"
               data-campaign="<?php echo $params["campaign"]?:"all"; ?>"
               data-limit="<?php echo $params["limit"]?:"6"; ?>"
               data-orderby="<?php echo $params["orderBy"]?:"published_at";  ?>"
               data-order="<?php echo $params["order"]?:"desc"; ?>"
               data-page="<?php echo $params["page"]?: '1'; ?>"
               href="<?php echo URL::toLang("ajax/super-deal/any-product"); ?>">
            </a>
        </div>
    </div>
</div>