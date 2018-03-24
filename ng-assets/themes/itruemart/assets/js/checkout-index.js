var Checkout = Checkout || {};

Checkout.Index = (function($) {
    
    var me = me || {};
    
    me.change = false;
    
    me.old_shipping_fee = 0;
    
    me.init = function()
    {
        $('body').on('remove-item', function() {
            
            location.reload();
            
        });
        
        if (typeof Checkout.data == 'undefined') return;
        
        var address = {
            name: Checkout.data.customer_name,
            address: Checkout.data.customer_address,
            province_id: Checkout.data.customer_province_id,
            city_id: Checkout.data.customer_city_id,
            district_id: Checkout.data.customer_district_id,
            postcode: Checkout.data.customer_postcode,
            email: Checkout.data.customer_email,
            phone: Checkout.data.customer_tel
        };
        
        var addressOptions = {
            province_id: Checkout.data.customer_province_id,
            city_id: Checkout.data.customer_city_id
        };
        
        me.renderAddress(address, addressOptions);
        
        me.renderShippingMethod();
        
        me.saveShippingMethod();
        
        // requirement says this is not require
        // nope its all good
        $('#shipping_fullname, #shipping_address, #shipping_postcode, #shipping_phone, #shipping_email').on('change', function() {
            
            me.saveAddress();
            
        });
        
        $('#shipping_address_list').on('change', function() {
            
            var val = $(this).val();
            
            if (val == 0) return;
            
            var address = Customer.addresses[val];
            
            var addressOptions = {
                province_id: address.province_id,
                city_id: address.city_id
            };
            
            me.renderAddress(address, addressOptions);
            
            me.saveAddress();
            
        });
        
        $('#shipping_province_code').on('change', function() {
            
            var val = $(this).val();
            
            if (val == 0)
            {
                $('#shipping_city_code').html('<option value=0>------ กรุณาเลือกจังหวัด ------</option>').val(0);
                $('#shipping_district_code').html('<option value=0>------ กรุณาเลือกอำเภอ ------</option>').val(0);
                
                return;
            }
            
            me.loadingCity();
            me.loadingDistrict();
            
            var addressOptions = {
                province_id: val
            };
            
            var address = {
                province_id: val
            };
            
            me.renderAddress(address, addressOptions);
             
           $('#shipping_city_code').change();
            
        });
        
        $('#shipping_city_code').on('change', function() {
            
            var val = $(this).val();
            
            if (val == 0) return;
            
            var addressOptions = {
                city_id: val
            };
            
            var address = {
                city_id: val
            };
            
            me.loadingDistrict();
            
            me.renderAddress(address, addressOptions);
            
            $('#shipping_district_code').change();
            
        });
        
        $('#shipping_district_code').on('change', function() {
            
            me.saveAddress();
            
        });
        
        $('.qty').on('change', function() {
            
            me.change = true;
            
        });
        
        $('.select-shipping-method').on('change after-render-shipping-method', function() {
            
            me.change = true;
            
            var total_shipping_fee = parseInt($('#total_shipping_fee').html().replace(/$|₱ (\w+)/, '$1'));
            var new_shipping_fee = parseInt($(this).find('[value='+$(this).val()+']').data('fee'));
            
            var new_total_shipping_fee = total_shipping_fee - me.old_shipping_fee + new_shipping_fee;
            
            $('#total_shipping_fee').html(me.moneyFormat($('#total_shipping_fee').html().replace(/($|₱) \w+/, '$1 '+new_total_shipping_fee)));
            
            me.saveShippingMethod();
            
        });
        
        $('.select-shipping-method').on('click before-render-shipping-method', function() {
            
            me.old_shipping_fee = parseInt($(this).find('[value='+$(this).val()+']').data('fee'));
            
        });
        
        $('.btn-delete').on('click', function() {
            
            var id = $(this).data('inventory_id');
            
            me.removeItem(id);
            
        });
        
        $('.btn-shopping').on('click', function() {
            
            window.location.href = '/';
            
        });
        
        $('.btn-continue, .btn-next').on('click', function() {
            
            if (me.validation())
            {
                if (me.change)
                {
                    me.showAlertDialog('แจ้งเตือน', 'มีการเปลี่ยนแปลง จำนวน/รูปแบบการจัดส่งสินค้า กรุณากดปุ่มคำนวณใหม่ก่อนค่ะ');
                    
                    return;
                }
                
                me.addNewAddress();
                
                me.confirmCheckout();
                
                window.location.href = '/'+currentLocale+'/checkout/confirm';
            }
            
        });
        
        $('#frm_submit').on('submit', function()
        {
            me.addNewAddress();
            
           return true;
        });
        
        if (error)
        {
            me.showAlertDialog('พบข้อผิดพลาด', error);
        }
    };
    
    me.loadingCity = function()
    {
        $('#shipping_city_code').html('<option value=0>กำลังโหลด...</option>');
    };
    
    me.loadingDistrict = function()
    {
        $('#shipping_district_code').html('<option value=0>กำลังโหลด...</option>');
    };
    
    me.renderAddress = function(address, addressOptions)
    {
        var option = '<option value="{key}">{value}</option>';
        var html;
        
        if (typeof address.name != 'undefined') $('#shipping_fullname').val(address.name);
        if (typeof address.address != 'undefined') $('#shipping_address').val(address.address);
        if (typeof address.postcode != 'undefined') $('#shipping_postcode').val(address.postcode);
        if (typeof address.email != 'undefined') $('#shipping_email').val(address.email);
        if (typeof address.phone != 'undefined') $('#shipping_phone').val(address.phone);
        
        if (typeof address.province_id != 'undefined')
        {
            $('#shipping_province_code').val(address.province_id);
        }
        
        $.ajax({
            async: true,
            type : 'GET',
            url : '/ajax/customers/address',
            data : addressOptions,
            success: function(response) {
                
                html = '';
                if (typeof response.cities != 'undefined' && me.getLength(response.cities) > 0)
                {
                    var _;
                    $.each(response.cities, function(k, v) {
                        _ = option;
                        _ = _.replace('{key}', v['id']);
                        _ = _.replace('{value}', v['name']);

                        html += _;
                    });

                    $('#shipping_city_code').html(html).val(address.city_id);
                }

                html = '';
                if (typeof response.districts != 'undefined' && me.getLength(response.districts) > 0)
                {
                    var _;
                    $.each(response.districts, function(k, v) {
                        _ = option;
                        _ = _.replace('{key}', v['id']);
                        _ = _.replace('{value}', v['name']);

                        html += _;
                    });

                    $('#shipping_district_code').html(html).val(address.district_id);
                }
                
                me.saveAddress();
                
            }
        });
        
    };
    
    me.saveAddress = function()
    {
        var data = {
            customer_address_id: $('#shipping_address_list').val(),
            customer_name: $('#shipping_fullname').val(),
            customer_address: $('#shipping_address').val(),
            customer_province_id: $('#shipping_province_code').val(),
            customer_city_id: $('#shipping_city_code').val(),
            customer_district_id: $('#shipping_district_code').val(),
            customer_postcode: $('#shipping_postcode').val(),
            customer_email: $('#shipping_email').val(),
            customer_tel: $('#shipping_phone').val()
        };
        
        $.ajax({
            async: true,
            type : 'POST',
            url : '/ajax/checkout/set-customer-info',
            data : data,
            success: function(response) {
                
                Checkout.data = eval(response.data);
                
                me.renderShippingMethod();
                
                me.saveShippingMethod();
                
            }
        });
        
    };
    
    me.renderShippingMethod = function()
    {
        if ( ! Checkout.data.customer_province_id || ! Checkout.data.customer_city_id || ! Checkout.data.customer_district_id) return;
        
        $('.select-shipping-method').each(function() {
            
            $(this).trigger('before-render-shipping-method');
            
            var option = '<option value="{key}" data-fee="{fee}">{value}</option>';
            
            var key = $(this).data('shipment');
            var html;
            
            if (Checkout.data.shipments[key].available_shipping_methods.length == 0)
            {
                $(this).html('<option>ไม่สามารถจัดส่งสินค้าได้</option>').prop('disabled', true);
                return;
            }
            
            html = '';
            $.each(Checkout.data.shipments[key].available_shipping_methods, function(k, v) {
                _ = option;
                _ = _.replace('{key}', k);
                _ = _.replace('{value}', v.name+' ('+v.description+') ค่าธรรมเนียม '+v.fee+' บาท');
                _ = _.replace('{fee}', v.fee);
                
                html += _;
            });
            
            $(this).html(html).prop('disabled', false);

            if (Checkout.data.shipments[key].shipping_method)
            {
                $(this).val(Checkout.data.shipments[key].shipping_method);
            }
            
            $(this).trigger('after-render-shipping-method');
            
        });
        
    };
    
    me.saveShippingMethod = function()
    {
        var data = {};
        
        $('.select-shipping-method').each(function() {
            
            var id = $(this).data('shipment');
            
            var val = $(this).val();
            
            if ( ! val) return;
            
            data[id] = val;
            
        });
        
        $.ajax({
            async: true,
            type: 'POST',
            url: '/ajax/checkout/select-shipment-methods',
            data: {
                shipments: data
            },
            success: function(response) {
                
                me.change = false;

            }
        });
    };
    
    me.removeItem = function(id)
    {
        if ( ! confirm('Please confirm this action')) return;
        
        $('.inventory-'+id).fadeOut();
        
        $.ajax({
            async: true,
            type: 'POST',
            url: '/ajax/checkout/remove-item',
            data: {
                inventory_id: id
            },
            success: function(response) {

                location.reload();

            }
        });
    };
    
    me.validation = function()
    {
        var validation = false;
        
        if ($('#shipping_fullname').val() == '')
        {
            me.showAlertDialog('ไม่สามารถดำเนินการได้', 'กรุณากรอกชื่อ');
        }
        else if ($('#shipping_province_code').val() == '0')
        {
            me.showAlertDialog('ไม่สามารถดำเนินการได้', 'กรุณาเลือกจังหวัด');
        }
        else if ($('#shipping_city_code').val() == '0') 
        {
            me.showAlertDialog('ไม่สามารถดำเนินการได้', 'กรุณาเลือกเขต/อำเภอ');
        }
        else if ($('#shipping_district_code').val() == '0')
        {
            me.showAlertDialog('ไม่สามารถดำเนินการได้', 'กรุณาเลือกแขวง/ตำบล');
        }
        else if ($('#shipping_address').val() == '')
        {
            me.showAlertDialog('ไม่สามารถดำเนินการได้', 'กรุณากรอกที่อยู่');
        }
        else if ($('#shipping_postcode').val() == '')
        {
            me.showAlertDialog('ไม่สามารถดำเนินการได้', 'กรุณากรอกรหัสไปรษณีย์');
        }
        else if ( ! /^\d{5}$/.test($('#shipping_postcode').val()))
        {
            me.showAlertDialog('ไม่สามารถดำเนินการได้', 'รหัสไปรษณีย์ ไม่ถูกต้อง');
        }
        else if ($('#shipping_email').length != 0 && $('#shipping_email').val() == '')
        {
            me.showAlertDialog('ไม่สามารถดำเนินการได้', 'กรุณากรอกอีเมล์');
        }
        else if ($('#shipping_email').length != 0 && ! /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/.test($('#shipping_email').val()))
        {
            me.showAlertDialog('ไม่สามารถดำเนินการได้', 'Email ไม่ถูกต้อง');
        }
        else if ($('#shipping_email').val() != $('#shipping_email_confirmation').val())
        {
            me.showAlertDialog('ไม่สามารถดำเนินการได้', 'ยืนยัน Email ไม่ถูกต้อง');
        }
        else if ($('#shipping_phone').val() == '')
        {
            me.showAlertDialog('ไม่สามารถดำเนินการได้', 'กรุณากรอกเบอร์ติดต่อ');
        }
        else if (( ! /^(02)\d{7}$/.test($('#shipping_phone').val().replace(/[^0-9\.]+/g, '')) && ! /^\d{10}$/.test($('#shipping_phone').val().replace(/[^0-9\.]+/g, ''))) || ! /^\d(\d+-?)+\d+$/.test($('#shipping_phone').val()))
        {
            me.showAlertDialog('ไม่สามารถดำเนินการได้', 'เบอร์ติดต่อ ไม่ถูกต้อง');
        }
        else
        {
            validation = true;
        }
        
        return validation;
    };
    
    me.addNewAddress = function()
    {
        if (typeof $('.save_shipping:checked').val() == 'undefined' || $('.save_shipping:checked').val() == 0) return;
        
        var data = {
            id: $('#shipping_address_list').val(),
            name: $('#shipping_fullname').val(),
            email: $('#shipping_email').val(),
            address: $('#shipping_address').val(),
            postcode: $('#shipping_postcode').val(),
            phone: $('#shipping_phone').val(),
            province_id: $('#shipping_province_code').val(),
            city_id: $('#shipping_city_code').val(),
            district_id: $('#shipping_district_code').val()
        };
        
        $.ajax({
            async: false,
            type : 'POST',
            url : '/ajax/customers/address',
            data : data,
            success: function(response) {
                
            }
        });
    };
    
    me.confirmCheckout = function()
    {
       $.ajax({
            async: false,
            type : 'POST',
            url : '/ajax/checkout/confirm',
            data : null,
            success: function(response) {
                
            }
        }); 
    };
    
    me.getLength = function(obj)
    {
        var size = 0;
        var key;
        
        for (key in obj)
        {
            if (obj.hasOwnProperty(key)) size++;
        }
        
        return size;
    };
    
    me.showAlertDialog = function(title, msg) {
        
        if ( ! msg) return;
        
        $('.alert-title').text(__(title));
        $('.alert-message').html(__(msg));
        
        $('#cart-alert').reveal({
            animation: 'none',
            dismissmodalclass: 'popup_ok'
        });
    };
    
    me.moneyFormat = function(NumberStr)
    {
        NumberStr+= '';
        NumberData = NumberStr.split('.');
        Number1 = NumberData[0];
        Number2 = NumberData.length > 1 ? '.' + NumberData[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(Number1)) {
            Number1 = Number1.replace(rgx, '$1' + ',' + '$2');
        }
        return Number1 + Number2;
    };

    return me;

})(jQuery);
$(function() {

    Checkout.Index.init();

});