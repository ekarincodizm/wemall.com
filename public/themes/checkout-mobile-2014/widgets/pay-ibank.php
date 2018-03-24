<div class="payment-channel">
    <input type="radio" name="payment_channel" value="ibank" id="ibank"/>
    <label for="ibank">
        <img src="<?php echo Theme::asset()->usePath()->url("img/ico-ibanking.png"); ?>" class="ico_payment_channel"/>
        <span class="payment-name"><small>ONLINE BANKING</small></span>
    </label>

    <div class="divider-menu" id="box-ibank">
        <?php if( !isset($checkout['available_payment_methods']['158913837979603']) ): ?>
        <div id="ibank-payment-error" class="clear-error-msg" style="display: none"></div>
        <?php endif ?>
        <div class="add-remark" id="ibank-payment-block">
            <h3>Available Channels</h3>
            <div>
                <div class=" form-max-info-2">
                    <table style="width:100%">
                        <tr style="height: 40%">
                            <td style="width:60%"><ul><li>BDO Internet Banking (Fund Transfer)</li></ul></td>
                            <td><ul><li>BDO Corp Internet Banking</li></ul></td>
                        </tr>
                        <tr style="height: 40%">
                            <td style="width:60%"><ul><li>BPI ExpressOnline/Mobile (Fund Transfer)</li></ul></td>
                            <td><ul><li>UCPB Connect</li></ul></td>
                        </tr>
                        <tr style="height: 40%">
                            <td style="width:60%"><ul><li>BPI ExpressOnline (Bills Payment - new)</li></ul></td>
                            <td><ul><li>Chinabank Online</li></ul></td>
                        </tr>
                        <tr style="height: 40%">
                            <td style="width:60%"><ul><li>Metrobankdirect</li></ul></td>
                            <td><ul><li>RCBC AccessOne</li></ul></td>
                        </tr>
                        <tr style="height: 40%">
                            <td style="width:60%"><ul><li>Unionbank of the Philippines EON</li></ul></td>
                            <td><ul><li>Unionbank of the Philippines</li></ul></td>
                        </tr>

                        <tr style="height: 40%;width:100%;" >
                            <td colspan="2">
                        <span class="powered-by">Secured by
                            <a href="//www.dragonpay.ph/" target="_blank"><img src="<?php echo Theme::asset()->usePath()->url('img/dragonpay-logo.png'); ?>"/></a>
                        </span>
                            </td>
                            <td>

                            </td>

                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>