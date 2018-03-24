<!-- Payment option -->
<div class="row">
    <div class="col-xs-12">
        <h2><?php echo __("step2-choose-shipping-address"); ?></h2>
    </div>
</div>
<div class="row address-option">
    <div class="col-xs-12">
        <?php echo (!empty($addressList)) ? $addressList : ""; ?>
        <!-- Add new Address -->
        <div class="row">
            <div class="col-xs-12 add-new-address">
                <a href="<?php echo URL::toLang("customers/create-shipping-address?continue=" . URL::toLang("checkout/step2?new=1")); ?>">
                    <div class="button">
                        <span class="glyphicon glyphicon-plus-sign"></span>
                        <?php echo __("step2-new-ship-addr"); ?>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<?php echo Theme::partial('minicart'); ?>

<div class="row button-buy">
    <div class="col-xs-12"><a href="javascript:void(0);">
            <div class="button">
                <span><?php echo __("step2-ship-this-addr"); ?></span>
            </div>
        </a></div>
</div>