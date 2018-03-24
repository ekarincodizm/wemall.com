<div class="flashsale">
    <div class="dd-title">
        <h3 class="dd-title-name">
            <span class="orange">Wow!</span>
        </h3>
        <div class="box-filter">
            <ul id="superdeal-filter">
                <li>
                    <span><?php echo __("filter_title"); ?> : </span>
                </li>
                <li class="<?php echo ($params["orderBy"] == "discount_started")? 'active':'';?>" >
                    <a id="published_at_filter" class="box-filter-type <?php if($params["orderBy"] == "discount_started" && $params["order"] == "desc"){ echo "down"; }elseif($params["orderBy"] == "discount_started" && $params["order"] == "asc"){ echo "up"; } ?>"
                       href="javascript:void(0);" data-orderby="discount_started">
                        <?php echo __("filter_latest_txt"); ?> <span class="caret-down"></span><span class="caret-up"></span>
                    </a>
                </li>
                <li class="<?php echo ($params["orderBy"] == "price")? 'active':'';?>">
                    <a id="price_filter" class="box-filter-type <?php if($params["orderBy"] == "price" && $params["order"] == "desc"){ echo "down"; }elseif($params["orderBy"] == "price" && $params["order"] == "asc"){ echo "up"; } ?>"
                       href="javascript:void(0);" data-orderby="price">
                        <?php echo __("Price"); ?> <span class="caret-down"></span><span class="caret-up"></span>
                    </a>
                </li>
                <li class="<?php echo ($params["orderBy"] == "discount")? 'active':'';?>">
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
                            $isLineCampaign = false;

                            if( !empty($product["variants"][0]["active_special_discount"]["discount_title"]) ){
                                $tagIcon = "label-red-1.png";
                            }else{
                                $tagIcon = "label-red-2.png";
                            }
                        }elseif( isset($product["variants"][0]["active_special_discount"]["flashsale_type"]) &&
                                ($product["variants"][0]["active_special_discount"]["flashsale_type"] == "tmvh" ||
                                $product["variants"][0]["active_special_discount"]["flashsale_type"] == "trueu")){
                            $tagCls = "label-green";
                            $tagIcon = "label-green-1.png";
                            $isLineCampaign = true;
                        }else{
                            $tagCls = "label-red";
                            $isLineCampaign = false;

                            if( !empty($product["variants"][0]["active_special_discount"]["discount_title"]) ){
                                $tagIcon = "label-red-1.png";
                            }else{
                                $tagIcon = "label-red-2.png";
                            }
                        }
                    ?>
                    <div class="fs-item-wrapper">
                        <div class="sd-product-info">
                            <div class="<?php echo $tagCls; ?>">
                                <?php if($isLineCampaign): ?>
                                    <img src="<?php echo Theme::asset()->usePath()->url('images/logo/line.jpg'); ?>" alt="iTruemart Everyday Wow Line" />
                                <?php endif; ?>
                                <span class="label-percent-discount">
                                    <?php //echo floor($product["percent_discount"]["max"]);
                                    $percent_show = 0;
                                    if(isset($product["percent_discount"]["max"]))
                                    {
                                        $cal_percent = floor($product["percent_discount"]["max"]);

                                        if($cal_percent == 100)
                                        {
                                            $percent_show = 99;
                                        }
                                        else
                                        {
                                            $percent_show = $cal_percent;
                                        }
                                    }
                                    echo $percent_show;
                                    ?><sup>%</sup><sub>OFF</sub>
                                </span>
                                <?php if( !empty($product["variants"][0]["active_special_discount"]["discount_title"]) ) : ?>
                                    <span class="label-campaign"><?php echo $product["variants"][0]["active_special_discount"]["discount_title"]; ?></span>
                                <?php endif; ?>
                                <img class="img-eaves" src="<?php echo Theme::asset()->usePath()->url('images/label/' . $tagIcon); ?>" alt="<?php echo $product["variants"][0]["active_special_discount"]["discount_title"]; ?>" />
                            </div>

                            <?php
                            $slug = (isset($product['slug']) && !empty($product['slug'])) ? $product['slug']  : url_title($product['title']);
                            ?>
                            <a href="<?php echo URL::toLang("products/" .  $slug . "-" . $product['pkey'] . ".html" ); ?>">
                                <div style="overflow: hidden;width: 100%;">
                                    <img style="width:100%;" src="<?php echo !empty($product["image_cover"]["thumbnails"]["large"])? $product["image_cover"]["thumbnails"]["large"] : ""; ?>" alt="<?php echo $product['title'];?>" />
                                </div>
                            </a>
                            <div class="sd-product-name">
                                <h5>
                                    <?php
                                        if( Lang::getLocale() == "en" && !empty($product["translate"]["title"]) ){
                                            echo $product["translate"]["title"];
                                        }elseif( ! empty($product["title"]) ){
                                            echo $product["title"];
                                        }
                                    ?>
                                </h5>
                                <?php if($isLineCampaign): ?>
                                    <?php if($product["variants"][0]["active_special_discount"]["flashsale_type"] == "tmvh"): ?>
                                        <span class="sd-product-logo"><img src="<?php echo Theme::asset()->usePath()->url('images/logo/line-truemove.png'); ?>" alt="iTruemart line truemove" /></span>
                                    <?php elseif($product["variants"][0]["active_special_discount"]["flashsale_type"] == "trueu") : ?>
                                        <span class="sd-product-logo"><img src="<?php echo Theme::asset()->usePath()->url('images/logo/line-trueyou.png'); ?>" alt="iTruemart line trueyou" /></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="sd-prop-info">
                                <div class="box-price">
                                    <div class="box-price-discount">
                                        <span class="box-title"><?php echo __("normal_price"); ?></span>
                                        <span class="price-discount">
                                            <?php echo isset($product["net_price_range"]["min"]) ? price_format($product["net_price_range"]["min"]) : "0"; ?>
                                        </span> .-
                                    </div>
                                    <div class="box-price-normal">
                                        <span class="box-title"><?php echo __("special_price"); ?></span>
                                        <span class="price-normal">
                                            <?php echo isset($product["price_range"]["min"]) ? price_format($product["price_range"]["min"]) : "0"; ?>
                                        </span> .-
                                    </div>
                                </div>
                                <div class="box-action">
                                    <?php
                                    $slug = (isset($product['slug']) && !empty($product['slug'])) ? $product['slug']  : url_title($product['title']);
                                    ?>
                                    <a href="<?php echo URL::toLang("products/" . $slug . "-" . $product['pkey'] . ".html" ); ?>" class="btn-order"><?php echo __("buy"); ?></a>
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
               data-orderby="<?php echo $params["orderBy"]?:"discount_started";  ?>"
               data-order="<?php echo $params["order"]?:"desc"; ?>"
               data-page="<?php echo $params["page"]?: '1'; ?>"
               href="<?php echo URL::toLang("ajax/super-deal/any-product"); ?>">
            </a>
        </div>
    </div>
</div>
