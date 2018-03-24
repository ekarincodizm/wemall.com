var Member = Member || {};

Member.profile = (function($) {
    
    var me = me || {};
    
    me.init = function()
    {
//        $('#shipping_address_list').on('change', function() {
//            
//            var address = {};
//            var addressOptions;
//            
//            var id = $(this).val();
//            
//            if (id == 0)
//            {
//                address.province_id = 1;
//                address.city_id = 1;
//            }
//            else
//            {
//                address = me.getAddress(id);
//            }
//            
//            addressOptions = me.getAddressData(address);
//            
//            me.renderAddress(address, addressOptions);
//            
//        });
        $('#shipping_address_list').on('change', function() {
            
            var val = $(this).val();
            
            if (val == 0) return;
            
            if (val == 0)
            {
                address.province_id = 1;
                address.city_id = 1;
            }
            else
            {
                address = me.getAddress(val);
            }
            
            var addressOptions = {
                province_id: address.province_id,
                city_id: address.city_id
            };
            
            me.renderAddress(address, addressOptions);
            
        });
        $('#shipping_address_list').change();
        
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
        
        $('#submit_addr').on('click', function() {
            
            if (me.validation())
            {
                $('#address-form').submit();
            }
            
        });
    
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
        if (address.email == '') $('#shipping_email').val($('#shipping_email').data('default'));
        if (typeof address.phone != 'undefined') $('#shipping_phone').val(address.phone);
        
        console.log(address);
        
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
                
            }
        });
        
    };
    
    me.getAddress = function(id)
    {
        var address = false;
        
        $.each(Member.addresses.data, function(k, v) {
            
            if (v.id == id)
            {
                address = Member.addresses.data[k];
            }
            
        });
        
        return address;
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
    
    me.showAlertDialog = function(title, msg) {
        
        if ( ! msg) return;
        
        $('.alert-title').text(__(title));
        $('.alert-message').text(__(msg));
        
        $('#alert-dialog').reveal({
            animation: 'none',
            dismissmodalclass: 'popup_ok'
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
    
    return me;
    
})(jQuery);

$(document).ready(function() {
    
    Member.profile.init();
	
	var select_val = '';
	var i = 0 ;
	$("#shipping_address_list option").each(function()
	{
		if(i == 1)
		{
			select_val = $(this).val();
		}
		i++;
	});
	
	if(select_val != '')
	{
		$("#shipping_address_list").val(select_val);
		$("#shipping_address_list").trigger('change');
	}
	
});

