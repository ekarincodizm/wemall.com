<div class="row">
    <div class="col-xs-12 address-shipping-section">
        <h2><?php echo __("Shipping address"); ?></h2>
        <p style="font-weight:400;"><?php echo isset($checkout['customer_name']) ? $checkout['customer_name']." " : ""; ?></p>
        <p>
            <?php echo isset($checkout['customer_address']) ? htmlentities($checkout['customer_address'])." " : ""; ?>
            <?php echo isset($checkout['customer_district']) ? $checkout['customer_district']." " : ""; ?>
            <?php echo isset($checkout['customer_city']) ? $checkout['customer_city']." " : ""; ?>
            <?php echo isset($checkout['customer_province']) ? $checkout['customer_province']." " : ""; ?>
            <?php echo isset($checkout['customer_postcode']) ? $checkout['customer_postcode'] : ""; ?>
        </p>

        <p><?php echo __("step2-phone");?> <?php echo isset($checkout['customer_tel']) ? $checkout['customer_tel'] : ""; ?></p>

        <p><?php echo isset($checkout['customer_email']) ? $checkout['customer_email'] : ""; ?></p>

        <div class="checkbox">
            <label>
                <input id="address-tax" type="checkbox" name="add_invoice" value="Y"
                    <?php
                    $displayStyle = "block";
                    if($cart['data']['bill_same_shipping'] == 'Y')
                    {
                        $displayStyle = "none";
                        echo 'checked';
                    }
                    ?> /> <?php echo __('step3-other-billing-address'); ?>
            </label>
        </div>
        <div class="row address-tax-field" style="display:<?php echo $displayStyle; ?>;">
            <div class="col-xs-12">
                <label class="control-label"><?php echo __('step3-billing-name-surname'); ?></label>
                <input type="text" class="form-control" id="bill_name" name="bill_name" placeholder="<?php echo __('step3-type-billing-name-surname'); ?>">
            </div>
            <div class="col-xs-12">
                <label class="control-label"><?php echo __('step3-province'); ?></label>
                <select class="form-control" name="bill_province_id" id="bill_province_id">
                    <!--[S] Province Option -->
                    <option disabled="disabled" value="" selected="selected" hidden="hidden"><?php echo __("step2-select-province"); ?></option>
                    <?php if(!empty($provincesList)): ?>
                        <?php foreach($provincesList as $key => $province): ?>
                            <option value="<?php echo $province['id']; ?>" <?php echo (!empty($address['customer_province_id']) && $province['id'] == $address['customer_province_id']) ? 'selected="selected"' : ""; ?>><?php echo $province['name']; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <!--[E] Province Option -->
                </select>
            </div>
            <div class="col-xs-12" >
                <label class="control-label" id="city-name">
                    <?php if( !empty($address['bill_province_id']) && $address['bill_province_id'] == 1 ): ?>
                        <?php echo __('step3-special-district'); ?> :
                    <?php else: ?>
                        <?php echo __('step3-district'); ?> :
                    <?php endif; ?>
                </label>
                <select class="form-control" name="bill_city_id" id="bill_city_id">
                    <option disabled="disabled" value="" selected="selected" hidden="hidden"><?php echo __("step2-select-city"); ?></option>
                    <?php if ( ! empty($city)) : ?>
                        <?php foreach ($city as $key => $value) : ?>
                            <option value="<?php echo $value['id']; ?>" <?php echo (!empty($address['bill_city_id']) && $value['id'] == $address['bill_city_id']) ? 'selected="selected"' : ""; ?>><?php echo $value['name']; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-xs-12">
                <label class="control-label" id="district-name">
                    <?php if( !empty($address['bill_province_id']) && $address['bill_province_id'] == 1 ): ?>
                        <?php echo __('step3-special-sub-district'); ?> :
                    <?php else: ?>
                        <?php echo __('step3-sub-district'); ?> :
                    <?php endif; ?>
                </label>
                <select class="form-control" name="bill_district_id" id="bill_district_id">
                    <option disabled="disabled" value="" selected="selected" hidden="hidden"><?php echo __("step2-select-district"); ?></option>
                    <?php if ( ! empty($district)) : ?>
                        <?php foreach ($district as $key => $value) : ?>
                            <option value="<?php echo $value['id']; ?>" <?php echo (!empty($address['bill_district_id']) && $value['id'] == $address['bill_district_id']) ? 'selected="selected"' : ""; ?>><?php echo $value['name']; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-xs-12">
                <label class="control-label"><?php echo __('step3-post-code'); ?></label>
                <select class="form-control" name="bill_postcode" id="bill_postcode">
                    <option disabled="disabled" value="" selected="selected" hidden="hidden"><?php echo __("step2-select-zipcode"); ?></option>
                    <?php  if ( ! empty($zip_code)) : ?>
                        <?php foreach ($zip_code as $k => $v) : ?>
                            <option value="<?php echo $v['zipcode']; ?>" <?php echo (!empty($address['bill_postcode']) && $v['zipcode'] == $address['bill_postcode']) ? 'selected="selected"' : ""; ?>><?php echo $v['zipcode']; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-xs-12">
                <label class="control-label"><?php echo __('step3-address'); ?></label>
                <textarea rows="4" name="bill_address" id="bill_address" class="form-control" placeholder="<?php echo __('step3-vill-no'); ?>" autocomplete="off"></textarea>
            </div>
        </div>
    </div>
</div>