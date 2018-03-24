$(function(){

    $(document).on("click", '.install_bank' , function( event ){

        $('#install').hide();

        //show installment period options
        var bankAbbr = $('input[name=radiog_lite]:checked').data("abbreviation");
        $(".installment-current-bank-name").html(__("bank-installment-" + bankAbbr));
        $("#installment-period-container").show();
        month_options();

        var radioBank = $(this).find('input:radio').attr('id'),
            ddlPayPerMonth = $('#pay_per_month');

        $(document).data('radioBank', radioBank);

        if(ddlPayPerMonth.val().length)
        {
            var can_pay = chkValidInstall();
            if(can_pay == true)
            {
                showBtnSubmit();
                saveCartInstallment();
            }
            else
            {
                disabledButton();
            }
        }

        $('.bank-list__container').attr('data-period', $('#pay_per_month').val());
        $('.bank-list__container').attr('data-bank', $('input[name=radiog_lite]:checked').val() );
    });

    /*
     * bank
     * */

    $('#pay_per_month').change(function(){
     


        /***
         * conflict month
         */
        var can_pay = chkValidInstall();
        if(can_pay == true)
        {
            hideErrorMsg();
            showBtnSubmit();
            saveCartInstallment();
        }
        else
        {
            disabledButton();
        }
        $('.bank-list__container').attr('data-period', $('#pay_per_month').val());
        $('.bank-list__container').attr('data-bank', $('input[name=radiog_lite]:checked').val() );
    });



});

function month_options(event, checkoutv2)
{
    
    $('#pay_per_month').removeAttr('style');
    $('#instalment .icon-success-2').remove();
    $('#instalment .active-alert-text').remove();

    var installmentItems = manageItemPayment.Main.installItems;
    var default_periods = $('.bank-list__container').attr('data-period');
    var default_bank = $('.bank-list__container').attr('data-bank');
    $('#pay_per_month').val('');

    if(installmentItems && $('input[name=radiog_lite]:checked').val() != undefined)
    {
        if ( typeof(manageItemPayment.Main.installBankInfo)=='undefined' ) {
            return;
        }

        var bank_select = $('input[name=radiog_lite]:checked').val();
        var bank_data = manageItemPayment.Main.installBankInfo[bank_select];
        var html_select = '<option value="" >'+__('inst-pay-per-month')+'</option>';
        $.each(bank_data.periods, function( pindex, pval ) {
            var period = parseInt(pindex);
            var pay = pval.formatMoney();
            var selected_opt = '';

            // pval
            if (pindex == default_periods) {
                selected_opt = 'selected';
            }

            html_select += '<option value="'+pindex+'" '+selected_opt+' >'
                + __('step3-installment-pay') + ' ' + pindex + ' '
                + __('step3-installment-month') + ', ' + __('step3-installment-for') + ' ' + pay + ' '
                + __('step3-installment-baht') + ' </option>';
        });

        $('#pay_per_month').html(html_select);
    }
    return;
}

function bank_options(event, checkoutv2){
    if(load_bank_first == true)
    {
        load_bank_first = false;
        return;
    }

    var count_key = Object.keys(manageItemPayment.Main.installBankInfo).length;
    var bank_html = '';
    if(count_key > 0)
    {
        $.each(manageItemPayment.Main.installBankInfo, function( inst_index, inst_val ) {

            if(inst_val.abbreviation == 'kbank')
            {
                var rdo_id = 'rdo_kbank';
                var img_src = 'k_bank.png';

            }
            else if(inst_val.abbreviation == 'bay')
            {
                var rdo_id = 'rdo_krungsri';
                var img_src = 'krungsri_bank.png';
            }
            else if(inst_val.abbreviation == 'centralcard')
            {
                var rdo_id = 'rdo_central';
                var img_src = 'central.png';
            }
            else if(inst_val.abbreviation == 'firstchoice')
            {
                var rdo_id = 'rdo_firstchoice';
                var img_src = 'firstchoice.png';
            }
            else if(inst_val.abbreviation == 'tescolotus')
            {
                var rdo_id = 'rdo_tesco';
                var img_src = 'tesco.png';
            }
            else if(inst_val.abbreviation == 'ktc')
            {
                var rdo_id = 'rdo_ktc';
                var img_src = 'ktc_bank_new.png';
            }
            else if(inst_val.abbreviation == 'bbl')
            {
                var rdo_id = 'rdo_bbl';
                var img_src = 'bbl_bank_new.png';
            }
            var trans_key = 'bank-'+inst_val.abbreviation;
            var bank_name = __(trans_key);
            var bank_id = inst_val.id;
            var bank_abb = inst_val.abbreviation;
            var default_bank_id = $('.bank-list__container').attr('data-bank');

            var checked_opt = '';
            if(bank_id == default_bank_id)
            {
                checked_opt = 'checked';
            }

            bank_html += '<div class="bank-list"> \n\
                    <input type="radio" name="radiog_lite" id="'+rdo_id+'"  class="css-checkbox install_bank" value="'+bank_id+'" autocomplete="off" data-abbreviation="'+bank_abb+'" '+checked_opt+' >\n\
                    <label for="'+rdo_id+'" class="css-label radGroup1 radGroup1 clr"><img class="bank--icn" src="/themes/checkout/assets/images/icn/'+img_src+'"/>\n\
                    <span class="bank--name">'+bank_name+'</span>\n\
                </label></div>';

        });

    }

    $('.bank-list__container').html(bank_html);

    return;
}

function chkValidInstall(event, checkoutv2)
{

        var month = $("#pay_per_month").val();
        var bank_name = $(".inst-bank-list input[name=radiog_lite]:checked").data("abbreviation");

        var can_pay = false;

        if(month.length > 0 && bank_name.length > 0 && month != undefined && bank_name != undefined && month != '' && bank_name != '' )
        {
            var total_variants = Object.keys(manageItemPayment.Main.items).length;
            var total_install_valid = manageItemPayment.Main.installItems[bank_name][month].length;


            if( (total_variants !== total_install_valid) && (total_variants > 1) ){
                step3ErrorManager.installError();
            }
            else if(total_variants !== total_install_valid && total_variants == 1){
                step3ErrorManager.installError();
            }
            else{
                can_pay = true;
            }

        }

        return can_pay;

}

function showBtnSubmit(can_pay)
{
    if ($('.install').attr('rel') == "available")
    {
        $('#install').hide();
    }
    $('#step3-submit').enabled();
    $('#step3-submit').removeClass('btn-disabled').removeAttr('disabled');

}

function hideErrorMsg()
{
    $('#instalment .icon-success-2').remove();
    $('#instalment .active-alert-text').remove();
}

function disabledButton(){
    $('#step3-submit').addClass("btn-disabled").attr('disabled', 'disabled');
    $('#pay_per_month').removeAttr('style');
}

function saveCartInstallment()
{
    $.post(
        $('#pay_per_month').attr('data-url'),
        {
            installment: $('#pay_per_month').val(),
            bank_id: $('input[name=radiog_lite]:checked').val()
        },
        function (data){

        },
        'html'

    );
}

function chkLoadVaild()
{

    var tab_active = check_payment();
    if(tab_active == 'install')
    {
        var can_pay = chkValidInstall();
        if(can_pay == true)
        {
            hideErrorMsg();
            showBtnSubmit();
            saveCartInstallment();
        }
        else
        {
            disabledButton();
        }

        $('.bank-list__container').attr('data-period', $('#pay_per_month').val());
        $('.bank-list__container').attr('data-bank', $('input[name=radiog_lite]:checked').val() );

    }
}

var load_bank_first = true;
var load_option_first = true;

$(document).ready(function(){

    if(check_payment() == 'install'){
        $('#step3-submit').addClass('btn-disabled').attr('disabled', 'disabled');
    }
    $(document).bind("get-cart-v2", month_options);
    $(document).bind("get-cart-v2", bank_options);
    $(document).bind("get-cart-v2", chkLoadVaild);
});
