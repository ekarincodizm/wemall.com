<div class="box-right">
    <div class="title">
        <div class="left">
            <h1 class="title-order"><?php echo __("Shipping address"); ?></h1>
        </div>
        <div class="right edit-box"><a href="<?php echo URL::toLang("checkout/step2", array(), Config::get("https.useHttps")); ?>" ><?php echo __("miniaddress-edit"); ?></a></div>
        <div class="clear"></div>
    </div>
    <div class="on-cart bdr-none">
        <p class="control-label-total">
        <p class="delivery-customer-info">
        <h2><?php if(!empty($checkout['customer_name'])){ echo $checkout['customer_name']; } ?></h2>
        </p>
        <p class="delivery-addr-info">
            <?php 
                $address = '';
                $address .= (!empty($checkout['customer_address']))? htmlentities($checkout['customer_address']). " " : "";

                if(!empty($checkout['customer_province']) && !empty($checkout['customer_district'])){
                   $address .= ($checkout['customer_province'] == 'กรุงเทพมหานคร')? __("step2-special-subdistrict") . " " :  __("step2-subdistrict") . " ";
                }
                $address .= (!empty($checkout['customer_district']))? $checkout['customer_district'] . " " : "";

                if(!empty($checkout['customer_province']) && !empty($checkout['customer_city'])){
                    $address .= ($checkout['customer_province'] == 'กรุงเทพมหานคร')? __("step2-special-district") . " " : __("step2-district") . " ";
                }
                $address .= (!empty($checkout['customer_city']))? $checkout['customer_city'] . " " : '';
                $address .= (!empty($checkout['customer_province']) && $checkout['customer_province'] != 'กรุงเทพมหานคร' && $checkout['customer_province'] != 'BANGKOK')? __("step2-province") . " " : "";
                $address .= (!empty($checkout['customer_province']))? $checkout['customer_province'] . " " : "";
                $address .= (!empty($checkout['customer_postcode']))? $checkout['customer_postcode'] . " " : "";
                $address .= (!empty($checkout['customer_tel']))? "<br/>" . __("step2-phone") . ": " . $checkout['customer_tel'] : "";
                echo $address;
            ?>
        </p>
        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>