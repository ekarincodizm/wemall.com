<div class="notice">
    <sup class="text--red">***</sup><span class="notice--text"><?php echo __("installment_note"); ?></span>
</div>
<div class="visible-xs">
    <h2 class="address-title"><?php echo __("Shipping address"); ?> :</h2>
</div>
<div class="form-horizontal delivery-container">
    <div class="form-group">
        <div class="col-sm-9">
            <div class="well form-control-static delivery-addr">
                <div class="row">
                    <p class="col-sm-12"><?php
                        if (!empty($checkout['customer_name'])) {
                            echo $checkout['customer_name'];
                        }
                        ?></p>
                    <p class="col-sm-6"> <?php
                        $address = '';
                        $address .= (!empty($checkout['customer_address'])) ? htmlentities($checkout['customer_address']) . " " : "";
                        if (!empty($checkout['customer_province']) && !empty($checkout['customer_district'])) {
                            $address .= ( $checkout['customer_province'] == 'กรุงเทพมหานคร') ? __("step2-special-subdistrict") : __("step2-subdictrict");
                        }
                        $address .= (!empty($checkout['customer_district'])) ? $checkout['customer_district'] . " " : "";
                        if (!empty($checkout['customer_province']) && !empty($checkout['customer_city'])) {
                            $address .= ($checkout['customer_province'] == 'กรุงเทพมหานคร') ? __("step2-special-district") : __("step2-district");
                        }
                        $address .= (!empty($checkout['customer_city'])) ? $checkout['customer_city'] . " " : '';
                        $address .= (!empty($checkout['customer_province'])) ? $checkout['customer_province'] . " " : "";
                        $address .= (!empty($checkout['customer_postcode'])) ? $checkout['customer_postcode'] . " " : "";
                        $address .= (!empty($checkout['customer_tel'])) ? "<br/>" . __("step2-phone") . ": " . $checkout['customer_tel'] : "";
                        echo $address;
                        ?></p>
                    <p class="col-sm-1"></p>
                    <p class="col-sm-5">
                        <?php
                        if (!empty($checkout['customer_tel'])) {
                            echo $checkout['customer_tel'];
                        }
                        ?>
                        <br />
<?php
if (!empty($checkout['customer_email'])) {
    echo $checkout['customer_email'];
}
?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>