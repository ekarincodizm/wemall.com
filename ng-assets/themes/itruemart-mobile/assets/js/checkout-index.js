var Checkout = Checkout || {};

Checkout.Index = (function($) {
    
    var me = me || {};
    
    me.change = false;
    
    me.init = function()
    {
        $('body').on('remove-item', function() {
            
            location.reload();

        });
        
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
        
        var request = {
            province_id: Checkout.data.customer_province_id,
            city_id: Checkout.data.customer_city_id
        };
        
        var addressOptions = me.getAddressData(request);
        
        me.renderAddress(address, addressOptions);
        
        me.renderShippingMethod();
        
        //me.saveShippingMethod();
        
//        $('#shipping_fullname, #shipping_address, #shipping_postcode, #shipping_phone, #shipping_email').on('change', function() {
//            
//            me.saveAddress();
//            
//        });
        
        $('#shipping_address_list').on('change', function() {
            
            var val = $(this).val();
            
            if (val == 0) return;
            
            var address = Customer.addresses[val];
            
            var request = {
                province_id: address.province_id,
                city_id: address.city_id
            };
            
            var addressOptions = me.getAddressData(request);
            
            me.renderAddress(address, addressOptions);
            
            //me.saveAddress();
            
        });
        
        $('#shipping_province_code').on('change', function() {
            
            var val = $(this).val();
            
            if (val == 0) return;
            
            var request = {
                province_id: val
            };
            
            var address = {
                province_id: val
            };
            
            var addressOptions = me.getAddressData(request);
            
            me.renderAddress(address, addressOptions);
             
            $('#shipping_city_code').change();
            
        });
        
        $('#shipping_city_code').on('change', function() {
            
            var val = $(this).val();
            
            if (val == 0) return;
            
            var request = {
                city_id: val
            };
            
            var address = {
                city_id: val
            };
            
            var addressOptions = me.getAddressData(request);
            
            me.renderAddress(address, addressOptions);
            
            $('#shipping_district_code').change();
            
        });
        
//        $('#shipping_district_code').on('change', function() {
//            
//            me.saveAddress();
//            
//        });
        
        $('.qty').on('change', function() {
            
            me.change = true;
            
        });
        
        $('.select-shipping-method').on('change', function() {
            
            me.change = true;
            
            //me.saveShippingMethod();
            
        });
        
        $('.btn-delete').on('click', function() {
            
            var id = $(this).data('inventory_id');
            
            me.removeItem(id);
            
        });
        
        //        $('.btn-shopping').on('click', function() {
        //            
        //            window.location.href = '/';
        //            
        //        });
        
        $('.btn-continue, .btn-next').on('click', function() {
            $(".all_error").hide();
            
            if (me.validation())
            {
                if (me.change)
                {
                    //me.showAlertDialog('แจ้งเตือน', 'มีการเปลี่ยนแปลง จำนวน/รูปแบบการจัดส่งสินค้า กรุณากดปุ่มคำนวณใหม่ก่อนค่ะ');
                    alert("มีการเปลี่ยนแปลง จำนวนสินค้า กรุณากดปุ่มคำนวณใหม่ก่อนค่ะ");
                    return;
                }
                
                me.addNewAddress();
                me.saveAddress();
                
                window.location.href = siteUrl+'/'+currentLocale+'/checkout/confirm';
            }
            
        });
        
        $('#form-coupon').on('submit', function() {
            $(".all_error").hide();
            
            if ( ! me.validateCoupon())
            {
                return false;
            }
            
        });
        
        $('#form-coupon').on('submit', function() {
            $(".all_error").hide();
            
            if ( ! me.validateCoupon())
            {
                return false;
            }
            
        });
        
        $('.remove-coupon').on('click', function() {
            $(".all_error").hide();
            me.removeCoupon($(this));
            
        });
        
    };
    
    me.validateCoupon = function()
    {
        //var code = $('.checkout-coupon').val();
        var code = $("#vcode").val();

        if (code == '' || code == undefined)
        {
            //me.showAlertDialog('ไม่สามารถดำเนินการได้', 'กรุณากรอกคูปองให้ถูกต้อง');
            $("#coupon_error .error_msg").html("กรุณากรอกคูปองให้ถูกต้อง");
            $("#coupon_error").show();
            return false;
        }
        return true;
        
    };
    
    me.removeCoupon = function(elm)
    {
        var code = elm.data('code');
        
        elm.parent().fadeOut('slow', function() {
           $(this).remove();
        });
        
        $.ajax({
            async: true,
            type: 'POST',
            url: '/ajax/cart/remove-coupon',
            data: {
                code: code
            },
            success: function(response) {
                
                window.location.reload();
                
            }
        });
    };
    
    me.getAddressData = function(data) {
        
        var response;
        
        $.ajax({
            async: false,
            type : 'GET',
            url : '/ajax/customers/address',
            data : data,
            success: function(r) {
                response = r;
            }
        });
        
        return response;
        
    };
    
    me.renderAddress = function(address, addressOptions) {
        
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
        
        html = '';
        if (typeof addressOptions.cities != 'undefined' && me.getLength(addressOptions.cities) > 0)
        {
            var _;
            $.each(addressOptions.cities, function(k, v) {
                _ = option;
                _ = _.replace('{key}', k);
                _ = _.replace('{value}', v);
                
                html += _;
            });
            
            $('#shipping_city_code').html(html).val(address.city_id);
        }
        
        html = '';
        if (typeof addressOptions.districts != 'undefined' && me.getLength(addressOptions.districts) > 0)
        {
            var _;
            $.each(addressOptions.districts, function(k, v) {
                _ = option;
                _ = _.replace('{key}', k);
                _ = _.replace('{value}', v);
                
                html += _;
            });
            
            $('#shipping_district_code').html(html).val(address.district_id);
        }
        
    };
    
    me.saveAddress = function() {
        
        //        $('.saving').show();
        
        var data = {
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
            async: false, // true,
            type : 'POST',
            url : '/ajax/checkout/set-customer-info',
            data : data,
            success: function(response) {
                
                Checkout.data = eval(response.data);
                
                me.renderShippingMethod();
                
                me.saveShippingMethod();
                
            //                $('.saving').hide();
                
            }
        });
        
    };
    
    me.renderShippingMethod = function()
    {
        if ( ! Checkout.data.customer_province_id || ! Checkout.data.customer_city_id || ! Checkout.data.customer_district_id) return;
        
        $('.select-shipping-method').each(function() {
            
            var option = '<option value="{key}">{value}</option>';
            
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
                
                html += _;
            });
            
            $(this).html(html).prop('disabled', false);

            if (Checkout.data.shipments[key].shipping_method)
            {
                $(this).val(Checkout.data.shipments[key].shipping_method);
            }
            
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
            async: false, // true
            type: 'POST',
            url: '/ajax/checkout/select-shipment-methods',
            data: {
                shipments: data
            },
            success: function(response) {
                
            //                me.change = true;

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
            //me.showAlertDialog('ไม่สามารถดำเนินการได้', 'ชื่อ ไม่สามารถเว้นว่างได้');
            $("#address_error .error_msg").html("ชื่อ ไม่สามารถเว้นว่างได้");
            $("#address_error").show();
        }
        else if ($('#shipping_province_code').val() == '0' || $('#shipping_city_code').val() == '0' || $('#shipping_district_code').val() == '0')
        {
            //me.showAlertDialog('ไม่สามารถดำเนินการได้', 'ที่อยู่ ไม่สามารถเว้นว่างได้');
            $("#address_error .error_msg").html("ที่อยู่ ไม่สามารถเว้นว่างได้");
            $("#address_error").show();
        }
        else if ($('#shipping_address').val() == '')
        {
            //me.showAlertDialog('ไม่สามารถดำเนินการได้', 'ที่อยู่ ไม่สามารถเว้นว่างได้');
            $("#address_error .error_msg").html("ที่อยู่ ไม่สามารถเว้นว่างได้");
            $("#address_error").show();
        }
        else if ($('#shipping_postcode').val() == '')
        {
            //me.showAlertDialog('ไม่สามารถดำเนินการได้', 'รหัสไปรษณีย์ ไม่สามารถเว้นว่างได้');
            $("#address_error .error_msg").html("รหัสไปรษณีย์ ไม่สามารถเว้นว่างได้");
            $("#address_error").show();
        }
        else if ( ! /^\d{5}$/.test($('#shipping_postcode').val()))
        {
            //me.showAlertDialog('ไม่สามารถดำเนินการได้', 'รหัสไปรษณีย์ ไม่ถูกต้อง');
            $("#address_error .error_msg").html("รหัสไปรษณีย์ ไม่ถูกต้อง");
            $("#address_error").show();
        }
        else if ($('#shipping_email').length != 0 && $('#shipping_email').val() == '')
        {
            //me.showAlertDialog('ไม่สามารถดำเนินการได้', 'Email ไม่สามารถเว้นว่างได้');
            $("#address_error .error_msg").html("Email ไม่สามารถเว้นว่างได้");
            $("#address_error").show();
        }
        else if ($('#shipping_email').length != 0 && ! /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/.test($('#shipping_email').val()))
        {
            //me.showAlertDialog('ไม่สามารถดำเนินการได้', 'Email ไม่ถูกต้อง');
            $("#address_error .error_msg").html("Email ไม่ถูกต้อง");
            $("#address_error").show();
        }
        else if ($('#shipping_email').val() != $('#shipping_email_confirmation').val())
        {
            //me.showAlertDialog('ไม่สามารถดำเนินการได้', 'ยืนยัน Email ไม่ถูกต้อง');
            $("#address_error .error_msg").html("ยืนยัน Email ไม่ถูกต้อง");
            $("#address_error").show();
        }
        else if ($('#shipping_phone').val() == '')
        {
            //me.showAlertDialog('ไม่สามารถดำเนินการได้', 'เบอร์ติดต่อ ไม่สามารถเว้นว่างได้');
            $("#address_error .error_msg").html("เบอร์ติดต่อ ไม่สามารถเว้นว่างได้");
            $("#address_error").show();
        }
        else if (( ! /^(02)\d{7}$/.test($('#shipping_phone').val().replace(/[^0-9\.]+/g, '')) && ! /^\d{10}$/.test($('#shipping_phone').val().replace(/[^0-9\.]+/g, ''))) || ! /^\d(\d+-?)+\d+$/.test($('#shipping_phone').val()))
        {
            //me.showAlertDialog('ไม่สามารถดำเนินการได้', 'เบอร์ติดต่อ ไม่ถูกต้อง');
            $("#address_error .error_msg").html("เบอร์ติดต่อ ไม่ถูกต้อง");
            $("#address_error").show();
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
        $('.alert-message').text(__(msg));
        
        $('#cart-alert').reveal({
            animation: 'none',
            dismissmodalclass: 'popup_ok'
        });
    };

    return me;

})(jQuery);
$(function() {
    Checkout.Index.init();
});