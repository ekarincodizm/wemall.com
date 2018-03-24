(function($) {

    $.fn.clearError = function(v){
		if (v != undefined)
		{
			//v.resetForm();		
		}
		this.css('border-color', '#e2e2e2');
		this.siblings('.icon-success').remove(); 
		this.siblings('.active-alert-text').remove();

	}

	$.fn.resetForm = function(){
		this.find('input, select, textarea').css('border-color', '#E2E2E2'); 
		this.find('.icon-success').remove();
		this.find('.active-alert-text').remove(); 
	}



    $.fn.resetSelect = function(text) {
        return this.emptySelect().each(function(){
            if (this.tagName == "SELECT")
            {
                var selectElement = this; 
                var option = new Option(text, ''); 
                selectElement.add(option);
                /*
                if ($.browser.msie)
                {
                    selectElement.add(option);
                }
                else 
                {
                    selectElement.add(option, null); 
                }
                */
            }
        }); 
    }
    $.fn.showLoading = function(text) {
        return this.emptySelect().each(function(){
            if (this.tagName == "SELECT")
            {
                var selectElement = this; 
                var option = new Option(text, ''); 

                /*
                if ($.browser.msie)
                {
                    selectElement.add(option);
                }
                else 
                {
                    selectElement.add(option, null); 
                }
                */
                selectElement.add(option);
                
            }
        }); 
    }
    $.fn.disabled = function() {
        this.attr('disabled', 'disabled'); 
        this.addClass('disabled_elem'); 
    }
    $.fn.enabled = function() {
        this.attr('disabled', false); 
        this.removeClass('disabled_elem'); 
    }

    $.fn.emptySelect = function() {
        return this.each(function(){
            if (this.tagName=='SELECT') this.options.length = 0;
        });
    }
    $.fn.loadSelect = function(optionsDataArray, lblFirst, currentValue) {
        //console.log(JSON.stringify(optionsDataArray));

        return this.emptySelect().each(function(){
            //console.log("this.tagName = " + this.tagName);
            
            if (this.tagName=='SELECT') {
                var selectElement = this;
                if (lblFirst != "" && lblFirst != undefined)
                {
                    //selectElement.add(new Option(lblFirst, ""));
                    var option = new Option(lblFirst, ""); 
                    /*
                    if ($.browser.msie)
                        selectElement.add(option); 
                    else 
                        selectElement.add(option, null); 
                    */
                    
                    selectElement.add(option);
                }       
                if (optionsDataArray != null && optionsDataArray != undefined)
                {
                    $.each(optionsDataArray,function(index,optionsData){        
                        if (optionsData.opt_value == currentValue)
                        {
                            var option = new Option(optionsData.opt_text, optionsData.opt_value);
                            option.selected = true; 
                        }
                        else
                        {
                            var option = new Option(optionsData.opt_text, optionsData.opt_value);
                        }
                        /*
                        if ($.browser.msie) {
                            selectElement.add(option);
                        }
                        else {
                            selectElement.add(option,null);
                        }
                        */
                        
                        selectElement.add(option);
                    });                 
                }           
            }
            
        });
    }
    
})(jQuery);


/**
 *  get payment channel pkey
 */
var getPaymentChannelPKey = function(channel){
    switch(channel) {
        case 'visa':
            return '155413837979192';
        case 'atm':
            return '156513837979495';
        case 'ibank':
            return '158913837979603';
        case 'bank':
            //bank counter
            return '152313837979681';
        case 'cservice':
            //counter service
            return '153211444223894';
        case 'hservice':
            //cod
            return '155613837979771';
        case 'install':
            return '156813837979402';
        default:
            return "";
    }
}

/**
 *  Generate URL.
 */
function UrlToLang(url){
    if(url != undefined){
        if(LANG != 'th'){
            url = "/" + LANG + url;
        }
        return url;
    }
    return "";
}

/**
 *  check site by domain.
 */
function isMobile(){
    var mPattern = /^m\./i;
    var hostname = location.hostname;
    if(mPattern.test(hostname)){
        return true;
    }else{
        return false;
    }
}