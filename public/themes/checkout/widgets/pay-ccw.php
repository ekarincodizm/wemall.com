<div id="channel-ccw" class="tab-pane">
    <div>
        <p class="control-label-info left">&nbsp;</p>
        <div class=" form-max-info-2">
            <h1 class="clr-2"><?php echo __('step3-input-ccw-info'); ?></h1>
        </div>
    </div>
    <div>
        <p class="control-label-info left">&nbsp;</p>
        <div class=" form-max-info">
            <img src="<?php echo Theme::asset()->usePath()->url('images/visa_logo.png'); ?>" width="129" height="34" />
        </div>
    </div>
    <div class="clear"></div>
    <?php if (!empty($isLoggedin) && !empty($creditCardData)): ?>
        <div>
            <p class="control-label-info left"></p>
            <div class="form-max-info">
                <p>
                    <input name="is_new_ccw" class="control-form select-visa" data-target="credit-card-list" type="radio" value="N" id="select-credit-card" checked="checked" autocomplete="off" />
                    <label for="select-credit-card" class="control-select clr-3"><?php echo __('step3-select-credit-cards'); ?></label>
                </p>
            </div>
        </div>
        <div class="clear"></div>
        <div class="credit-card-list credit-card-content">
            <p class="control-label-info left">
                <label for="email" class="control-label-name"><?php echo __('step3-credit-card'); ?> : </label>
            </p>
            <div class=" form-max-info">
                <select name="creditno" class="select-new" id="creditno" autocomplete="off" >
                    <option value=""><?php echo __('select'); ?></option>
                    <?php foreach ($creditCardData as $key => $row): ?>
                        <option value="<?php echo $row['payment_token'] ?>" <?php if(!empty($row['default'])){ echo 'selected="selected"';};?> ><?php echo $row['card_number']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class=" clear"></div>
    <?php endif; ?>

    <?php if (!empty($isLoggedin) && !empty($creditCardData)): ?>
        <div>
            <p class="control-label-info left"></p>
            <div class=" form-max-info">
                <p>
                    <input name="is_new_ccw" type="radio" class="control-form select-visa" data-target="credit-card-info" value="Y" id="new-ccw" autocomplete="off" />
                    <label for="select-ccw" class="control-select clr-3"><?php echo __('step3-use-credit-card'); ?></label>
                </p>
            </div>
        </div>
        <div class=" clear"></div>
    <?php endif; ?>

    <div class="credit-card-info credit-card-content">
        <div>
            <p class="control-label-info left">
                <label for="ccw-info-name" class="control-label-name"><?php echo __('step3-name-surname'); ?> : </label>
            </p>
            <div class=" form-max-info">
                <input id="ccw-info-name" class="input-info" name="creditname" type="text" placeholder="<?php echo __('step3-name-surname-on-card'); ?>" autocomplete="off" />
            </div>
        </div>
        <div>
            <p class="control-label-info left">
                <label for="ccw-info-no" class="control-label-name"><?php echo __('step3-credit-number'); ?> : </label>
            </p>
            <div class=" form-max-info">
                <input id="ccw-info-no" class="input-info" name="creditnum" maxlength="16" type="text" placeholder="<?php echo __('step3-type-credit-number'); ?>" autocomplete="off" />
                <span class="icn-cc"><img src="<?php echo Theme::asset()->usePath()->url('images/cc_type.png'); ?>" /></span>
                <!--<div class="active-alert-text">* กรุณากรอกข้อมูลและตรวจสอบให้ถูกต้อง</div> -->
            </div>
        </div>
        <div>
            <p class="control-label-info left">
                <label for="ccw-info-exp" class="control-label-name"><?php echo __('step3-expire-date') ?> : </label>
            </p>
            <div class=" form-max-info">
                <select id="month" name="expiremonth" class="select-month-day" autocomplete="off" >
                    <option value=""><?php echo __('step3-month'); ?></option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
						<?php
                            if ($i <= 9)
                            {
                                $str_val = '0' . $i;
                            } else
                            {
                                $str_val = $i;
                            }
                        ?>
                        <option value="<?php echo $str_val; ?>">
                            <?php echo $str_val; ?>
                        </option>
                    <?php endfor; ?>
                </select> /
                <select id="year" name="expireyear" class="select-month-day" autocomplete="off" >
                    <option value=""><?php echo __('step3-year'); ?></option>
                    <?php $start_year = date('Y'); ?>
                    <?php $year = $start_year + 10; ?>
                    <?php for ($i = $start_year; $i <= $year; $i++): ?>
                        <option value="<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div>
            <p class="control-label-info left">
                <label for="email" class="control-form"><?php echo __('step3-ccv'); ?>: </label>
            </p>
            <div class="form-max-info ccw-pwd">
                <input class="input-info" maxlength="3" name="ccv" type="password" placeholder="<?php echo __('step3-type-ccv'); ?>" autocomplete="off" />
                <div class="left icon-success-ex">
                    <a href="#">
                        <img src="<?php echo Theme::asset()->usePath()->url('images/ex.png'); ?>" width="14" height="14" />
                    </a>
                    <div class="tooltip top">
                        <div class="tooltip-inner">
                            <img src="<?php echo Theme::asset()->usePath()->url("images/visa_ex.png"); ?>" />
                        </div>
                        <div class="tooltip-arrow"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div>
            <p class="control-label-info left"></p>
            <div class=" form-max-info box-invoice">
                <p>
                    <?php //if (!empty($isLoggedin)): save_ccw
						if (!empty($close_save_ccw)):
					?>
                        <input id="save_ccw" name="save_ccw" type="checkbox" value="Y" class="control-form" autocomplete="off" />
                        <span class="control-label-name clr-3" ><?php echo __('step3-save-card'); ?></span>
                    <?php endif; ?>
                    <span class="powered-by">Secured by
                        <a href="//www.cybersource.com/" target="_blank"><img src="<?php echo Theme::asset()->usePath()->url('images/cybersource.jpg'); ?>"/></a>
                    </span>
                </p>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="box-sub-divider clear"></div>
</div>
<div id="modal-save-credit" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="title bdr-btm-none">
                <div class="left">
                    <h1><?php echo __('credit-limit-header'); ?></h1>
                </div>
                <div class="clear"></div>
            </div>
            <div class="modal-credit-wrap">
                <div class="modal-credit-content">
                    <?php echo __('credit-limit-content'); ?>
                </div>
                <div>
                    <input type="button" value="<?php echo __('credit-manage-button'); ?>" name="manage_button" class="left form-bot" autocomplete="off" >
                    <input type="button" value="<?php echo __('credit-close-button'); ?>" data-dismiss="modal" name="close_button" class="left btn btn-default" autocomplete="off" >
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>