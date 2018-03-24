<div>
	<div>
		<p class="control-label-info left">&nbsp;</p>
		<div class=" form-max-info-2">
			<h1 class="clr-2"><?php echo __('step3-billing-address'); ?></h1>
		</div>
	</div>
	<div>
		<p class="control-label-info left"></p>
		<div class=" form-max-info">
			<input type="checkbox" name="add_invoice" id="add-invoice" class="inv-addr" value="Y" autocomplete="off" 
				<?php
					if($cart['data']['bill_same_shipping'] == 'Y')
					{
						echo 'checked';
					}
				?>
			/>
			<label for="add-invoice" class="control-select clr-3"><?php echo __('step3-other-billing-address'); ?></label>
		</div>
	</div>
	<div class="invoice-info">
		<!--<div>
			<p class="control-label-info left">&nbsp;</p>
			<div class="form-max-info invoice-process">
				<p>
				</p><h1 class="clr-2">ที่อยู่ในการออกใบเสร็จ/ใบกำกับภาษี</h1>
				<p></p>
			</div>
		</div>-->
		<div>
			<p class="control-label-info left">
				<label for="inv-name" class="control-label-name"><?php echo __('step3-billing-name-surname'); ?> : </label>
			</p>
			<div class=" form-max-info">
				<input class="input-info" name="bill_name" id="bill_name" id="inv-name" type="text" placeholder="<?php echo __('step3-type-billing-name-surname'); ?>" value="<?php echo !empty($cart['data']['bill_name'])? $cart['data']['bill_name']:''; ?>" autocomplete="off" />
			</div>
		</div>
		<!--
		<div>
			<p class="control-label-info left">
				<label for="inv-telephone" class="control-label-name"><?php echo __('step3-mobile-phone'); ?> : </label>
			</p>
			<div class=" form-max-info">
				<input class="input-info" name="billing_tel" maxlength="15" id="inv-telephone" type="text" placeholder="<?php echo __('step3-phone'); ?>" />
			</div>
		</div>
		-->
		<div>
			<p class="control-label-info left">
				<label for="province" class="control-label-name"><?php echo __('step3-province'); ?> : </label>
			</p>
			<div class=" form-max-info">
				<select id="bill_province_id" name="bill_province_id" class="select-new" autocomplete="off">
					<!--[S] Province Option -->
					<option value=""><?php echo __("step2-empty-option"); ?></option>
					<?php if(!empty($provincesList)): ?>
						<?php foreach($provincesList as $key => $province): ?>
							<option value="<?php echo $province['id']; ?>" <?php echo ($province['id'] == $address['customer_province_id']) ? 'selected="selected"' : ""; ?>><?php echo $province['name']; ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
					<!--[E] Province Option -->
				</select>
			</div>
		</div>
		<div>
			<p class="control-label-info left">
				<label for="email" class="control-label-name"><?php echo __('step3-district'); ?> : </label>
			</p>
			<div class=" form-max-info">
				<select id="bill_city_id" name="bill_city_id" class="select-new" autocomplete="off">
					<!--[S] District Option -->
					<?php if ( ! empty($city)) : ?>
					<?php foreach ($city as $key => $value) : ?>
					<option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $address['customer_city_id']) ? 'selected="selected"' : ""; ?>><?php echo $value['name']; ?></option>
					<?php endforeach; ?>
					<?php else : ?>
					<option value=""><?php echo __("step2-empty-option"); ?></option>
					<?php endif;  ?>
					<!--[E] District Option -->
				</select>
			</div>
		</div>
		<div>
			<p class="control-label-info left">
				<label for="email" class="control-label-name"><?php echo __('step3-sub-district'); ?> : </label>
			</p>
			<div class=" form-max-info">
				<select id="bill_district_id" name="bill_district_id" class="select-new" autocomplete="off">
					<!--[S] Sub District Option -->
					<?php if ( ! empty($district)) : ?>
					<?php foreach ($district as $key => $value) : ?>
						<option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $address['customer_district_id']) ? 'selected="selected"' : ""; ?>><?php echo $value['name']; ?></option>
					<?php endforeach; ?>
					<?php else : ?>
						<option value=""><?php echo __("step2-empty-option"); ?></option>
					<?php endif; ?>
					<!--[E] Sub District Option -->
				</select>
			</div>
		</div>
		<div>
			<p class="control-label-info left">
				<label for="email" class="control-label-name"><?php echo __('step3-post-code'); ?> : </label>
			</p>
			<div class=" form-max-info">
				<select id="bill_postcode" name="bill_postcode" class="select-new"  onchange="" autocomplete="off">
					<!--[S] Post Code Option -->
					<?php  if ( ! empty($zip_code)) : ?>
						<?php foreach ($zip_code as $k => $v) : ?>
							<option value="<?php echo $v['zipcode']; ?>" <?php echo ($v['zipcode'] == $address['customer_postcode']) ? 'selected="selected"' : ""; ?>><?php echo $v['zipcode']; ?></option>
						<?php endforeach; ?>
					<?php else : ?>
						<option value=""><?php echo __("step2-empty-option"); ?></option>
					<?php endif;  ?>
					<!--[E] Post Code Option -->
				</select>
			</div>
		</div>
		<div>
			<p class="control-label-info left">
				<label for="email" class="control-label-name"><?php echo __('step3-address'); ?> : </label>
			</p>
			<div class=" form-max-info">
				<textarea id="bill_address" maxlength="150" name="bill_address" class="input-box control-inv-addr" placeholder="<?php echo __('step3-vill-no'); ?>" autocomplete="off" ><?php echo !empty($cart['data']['bill_address'])? $cart['data']['bill_address']:''; ?></textarea>
                <div style="color: #000000;font-size: 10px;padding: 5px 5px 0;">*Max. 150 characters</div>
			</div>
		</div>
	</div>
</div>