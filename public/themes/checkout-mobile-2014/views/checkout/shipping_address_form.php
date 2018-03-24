<div class="row">
    <div class="col-xs-12">
        <?php  if (!empty($shipping_address_id)): ?>
        <h4><a href="<?php echo URL::toLang('checkout/step2'); ?>"><?php _e('Back'); ?></a></h4>
        <h2><?php _e("step2-edit-shipping-address"); ?></h2>
        <?php else: ?>
        <h2><?php _e("step2-new-shipping-address"); ?></h2>
        <?php endif; ?>
    </div>
</div>

<form id="shipping-address-form" method="post"
      data-submit-url="<?php echo URL::route(!empty($shipping_address_id) ? 'ajax.post.customer.edit-ship-addr' : 'ajax.customers.save-ship-addr'); ?>"
      data-redirect="<?php echo URL::toLang($continue); ?>">
    <?php if(!empty($shipping_address_id)): ?>
        <input type="hidden" name="address_id" value="<?php echo $shipping_address_id; ?>"/>
    <?php endif; ?>

    <div class="row address-field">
        <div class="col-xs-12">
            <label class="control-label"><?php echo __("step2-firstname-lastname"); ?></label>
            <input id="name" maxlength="40" name="name" type="text" class="form-control"
                   placeholder="<?php echo __("step2-firstname-lastname-placeholder"); ?>" value="<?php echo array_get($address, 'name'); ?>" />
        </div>
        <div class="col-xs-12">
            <label class="control-label"><?php echo __("step2-phone-number"); ?></label>
            <input id="telephone" maxlength="11" name="phone" type="text" class="form-control" placeholder="<?php echo __("step2-phone-number-placeholder"); ?>" value="<?php echo array_get($address, 'phone', $phone); ?>" />
        </div>
        <div class="col-xs-12">
            <label class="control-label"><?php echo __("email"); ?></label>
            <input id="email" name="email" type="text" class="form-control" placeholder="<?php echo __("Enter your email address"); ?>" value="<?php echo array_get($address, 'email', $email); ?>" >
        </div>
        <div class="col-xs-12">
            <label class="control-label"><?php echo __("step2-province"); ?></label>
            <select class="form-control" id="province-control" name="province_id" data-value="<?php echo array_get($address, 'province_id', false); ?>">
                <option value=""><?php echo __("step2-select-province"); ?></option>
                <?php if(!empty($provincesList)): ?>
                    <?php foreach($provincesList as $key => $province): ?>
                        <option value="<?php echo $province['id']; ?>" <?php echo $province['id'] == array_get($address, 'province_id') ? 'selected="selected"' : ""; ?>>
                            <?php echo $province['name']; ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-xs-12">
            <label class="control-label" id="city-label">
                <?php if (array_get($address, 'province') == "กรุงเทพมหานคร") : ?>
                    <?php echo __("step2-special-district"); ?>
                <?php else : ?>
                    <?php echo __("step2-district"); ?>
                <?php endif; ?>
            </label>
            <select class="form-control" id="city-control" name="city_id" data-value="<?php echo array_get($address, 'city_id', false); ?>">
                <option disabled="disabled">
                    <?php echo array_get($address, 'province') == "กรุงเทพมหานคร" ? __("step2-select-city-special") : __("step2-select-city"); ?>
                </option>
                <?php if ( ! empty($city)) : ?>
                    <?php foreach ($city as $key => $value) : ?>
                        <option value="<?php echo $value['id']; ?>" <?php echo $value['id'] == array_get($address, 'city_id') ? 'selected="selected"' : ''; ?>><?php echo $value['name']; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-xs-12">
            <label class="control-label" id="district-label">
                <?php if (array_get($address, 'province') == "กรุงเทพมหานคร") : ?>
                    <?php echo __("step2-special-subdistrict"); ?>
                <?php else : ?>
                    <?php echo __("step2-subdistrict"); ?>
                <?php endif; ?>
            </label>
            <select class="form-control" id="district-control" name="district_id" data-value="<?php echo array_get($address, 'district_id', false); ?>">
                <option disabled="disabled">
                    <?php echo array_get($address, 'province' == "กรุงเทพมหานคร") ? __("step2-select-district-special") : __("step2-select-district"); ?>
                </option>
                <?php if ( ! empty($district)) : ?>
                    <?php foreach ($district as $key => $value) : ?>
                        <option value="<?php echo $value['id']; ?>" <?php echo $value['id'] == array_get($address, 'district_id') ? 'selected="selected"' : ""; ?>><?php echo $value['name']; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-xs-12">
            <label class="control-label"><?php echo __("step2-zipcode"); ?></label>
<!--            <select class="form-control" id="zip-code-control" name="postcode" data-value="--><?php //echo array_get($address, 'postcode', false); ?><!--">-->
<!--                <option disabled="disabled">--><?php //echo __("step2-select-zipcode"); ?><!--</option>-->
<!--                --><?php //if ( ! empty($zip_code)) : ?>
<!--                    --><?php //foreach ($zip_code as $key => $value) : ?>
<!--                        <option value="--><?php //echo $value['zipcode']; ?><!--" --><?php //echo $value['zipcode'] == array_get($address, 'postcode') ? 'selected="selected"' : ""; ?><!--><?php //echo $value['zipcode']; ?><!--</option>-->
<!--                    --><?php //endforeach; ?>
<!--                --><?php //endif; ?>
<!--            </select>-->
            <input id="zip-code-control" class="form-control" name="postcode" type="text" maxlength="4" placeholder="<?php echo __("step2-select-zipcode"); ?>" value="<?php echo array_get($address, 'postcode'); ?>" />
        </div>
        <div class="col-xs-12">
            <label class="control-label"><?php echo __("step2-address-box"); ?></label>
            <textarea id="address" maxlength="150" name="address" rows="4" class="form-control" placeholder="<?php echo __("step2-address-box-placeholder"); ?>"><?php echo array_get($address, 'address'); ?></textarea>
            <div style="color: #000000;font-size: 10px;padding: 5px 5px 0;">*Max. 150 characters</div>
        </div>
    </div>

    <div class="row button-buy">
        <div class="col-xs-12">
            <a href="#">
                <div class="button"><span><?php echo __("Continue"); ?></span></div>
            </a>
        </div>
    </div>
</form>