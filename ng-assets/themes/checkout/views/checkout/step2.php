<?php if(!empty($addressList)): ?>
    <?php echo $addressList; ?>
<?php endif; ?>

<!-- Fill Address -->


<?php 
if ( 
    ! empty($address['customer_name']) OR 
    ! empty($address['customer_tel']) OR
    ! empty($address['customer_province_id']) OR
    ! empty($address['customer_city_id']) OR 
    ! empty($address['customer_district_id']) OR 
    ! empty($address['customer_address']) OR 
    ! empty($address['customer_postcode'])
) : ?>
<script type="text/javascript">
    $(document).ready(function(){        
        $('#add-address-frm').find('input, select, textarea').each(function(){
            elemId = $(this).attr('id');
            if (elemId == "name" ||
                elemId == "telephone" ||
                elemId == "province-control" ||
                elemId == "district-control" ||
                elemId == "sub-district-control" ||
                elemId == "zip-code-control" ||
                elemId == "address"
                )
            {
                $(this).valid();
            }
        });    
    });
</script>
<?php endif; ?>
<div id="fill-address-form" <?php echo (!empty($addressList))? "class='iamuser'" : ""; ?> >
    <div class="title <?php echo (!empty($addressList))? "box-divider" : ""; ?>">
        <h1 id="title-shipping-address"><?php echo __("step2-enter-shipping-address"); ?></h1>
    </div>
    <form id="add-address-frm" method="post" action="<?php echo URL::toLang('checkout/step2'); ?>" data-save-url="<?php echo URL::toLang('ajax/customers/save-ship-addr'); ?>">
        <input type="hidden" name="hidden_address_id" 
                id="hidden_address_id"             
                >
        <div class="in-form">
            <div>
                <p class="control-label left">
                    <label for="name" class="form-label-control" class="form-label-control"><?php echo __("step2-firstname-lastname"); ?> : </label>
                </p>
                <div class="form-max">
                    <input class="input-box" maxlength="40" id="name" name="name" type="text" placeholder="<?php echo __("step2-firstname-lastname-placeholder"); ?>"  value="<?php echo $address['customer_name']; ?>"/>
                </div>
            </div>
            <div>
                <p class="control-label left">
                    <label for="phone_number" class="form-label-control"><?php echo __("step2-phone-number"); ?> : </label>
                </p>
                <div class=" form-max ">
                    <input id="telephone" class="input-box" maxlength="10" name="phone_number" type="text" placeholder="<?php echo __("step2-phone-number-placeholder"); ?>"  value="<?php echo $address['customer_tel']; ?>" />
                </div>
            </div>
            <div class="form-divider-control">
                <p class="control-label left">
                    <label for="email" class="form-label-control"><?php echo __("email"); ?> : </label>
                </p>
                <div class=" form-max ">
                    <?php
                        $customer_email = "";
                        if(isset($address['customer_email']) && !preg_match("/\@truelife.com$/", $address['customer_email'])){
                            $customer_email = $address['customer_email'];
                        }
                    ?>
                    <input id="email" class="input-box" name="email" type="text" placeholder="<?php echo __("Enter your email address"); ?>"  value="<?php echo $customer_email; ?>" />
                </div>
            </div>
            <div>
                <p class="control-label left">
                    <label for="province-control" id="province" class="form-label-control"><?php echo __("step2-province"); ?> : </label>
                </p>
                <div class=" form-max">
                    <select name="province" id="province-control" class="select-new" data-url="<?php echo URL::toLang('ajax/customers/addr'); ?>">
                        <option value=""><?php echo __("step2-select-province"); ?></option>
                        <?php if(!empty($provincesList)): ?>
                            <?php foreach($provincesList as $key => $province): ?>
                                <option value="<?php echo $province['id']; ?>" <?php echo ($province['id'] == $address['customer_province_id']) ? 'selected="selected"' : ""; ?>><?php echo $province['name']; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="clear"></div>
            <div>
                <p class="control-label left">
                    <label for="district" class="form-label-control">
                            <span id="district-name">
                                <?php if ( ! empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") : ?>
                                <?php echo __("step2-special-district"); ?>
                                <?php else : ?>
                                <?php echo __("step2-district"); ?>
                                <?php endif; ?>
                            </span> : 
                    </label>
                </p>
                <div class=" form-max">
                    <select name="district" id="district-control" class="select-new" data-url="<?php echo URL::toLang('ajax/customers/addr'); ?>">                        
                        <?php if ( ! empty($city) && !empty($address['customer_province_id']) ) : ?>
                        <option value=""><?php echo ( ! empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") ? __("step2-select-city-special") : __("step2-select-city"); ?></option>
                        <?php foreach ($city as $key => $value) : ?>
                        <option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $address['customer_city_id']) ? 'selected="selected"' : ''; ?>><?php echo $value['name']; ?></option>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <option value=""><?php echo ( ! empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") ? __("step2-select-city-special") : __("step2-select-city"); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="clear"></div>
            <div>
                <p class="control-label left">
                    <label for="subdistrict" class="form-label-control">
                        <span id="sub-district-name"> 
                            <?php if ( ! empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") : ?>
                            <?php echo __("step2-special-subdistrict"); ?>
                            <?php else : ?>
                            <?php echo __("step2-subdistrict"); ?>
                            <?php endif; ?>
                        </span> : 
                    </label>
                </p>
                <div class=" form-max">
                    <select name="subdistrict" id="sub-district-control" class="select-new" data-url="<?php echo URL::toLang('ajax/customers/addr'); ?>">                        
                        <?php if ( ! empty($district) && !empty($address['customer_city_id'])) : ?>
                        <option value=""><?php echo ( ! empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") ? __("step2-select-district-special") : __("step2-select-district"); ?></option>
                        <?php foreach ($district as $key => $value) : ?>
                            <option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $address['customer_district_id']) ? 'selected="selected"' : ""; ?>><?php echo $value['name']; ?></option>
                        <?php endforeach; ?>
                        <?php else : ?>
                            <option value=""><?php echo ( ! empty($address['customer_province']) && $address['customer_province'] == "กรุงเทพมหานคร") ? __("step2-select-district-special") : __("step2-select-district"); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="clear"></div>
            <div>
                <p class="control-label left">
                    <label for="zip_code" class="form-label-control"><?php echo __("step2-zipcode"); ?> : </label>
                </p>
                <div class=" form-max">
                    <select name="zip_code" id="zip-code-control" class="select-new" >
                        <?php if ( ! empty($zip_code) && !empty($address['customer_district_id']) ) : ?>
                            <option value=""><?php echo __("step2-select-zipcode"); ?></option>
                            <?php foreach ($zip_code as $key => $value) : ?>
                            <option value="<?php echo $value['zipcode']; ?>" <?php echo ($value['zipcode'] == $address['customer_postcode']) ? 'selected="selected"' : ""; ?>><?php echo $value['zipcode']; ?></option>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <option value=""><?php echo __("step2-select-zipcode"); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="clear"></div>
            <div>
                <p class="control-label left">
                    <label for="address" class="form-label-control"><?php echo __("step2-address-box"); ?> : </label>
                </p>
                <div class=" form-max">
                    <textarea name="address" maxlength="150" id="address" class="input-box form-address" placeholder="<?php echo __("step2-address-box-placeholder"); ?>"><?php echo $address['customer_address']; ?></textarea>
                    <div style="color: #000000;font-size: 10px;padding: 5px 5px 0;">*Max. 150 characters</div>
                </div>
            </div>
            <div>
                <div class=" form-max">
                    <input class="form-bot" name="btnSave" id="btnSave" type="submit" value="<?php echo __("step2-nextstep-btn"); ?>" />
                </div>
            </div>
        </div>
    </form>
</div>
<!-- /Fill Address -->


