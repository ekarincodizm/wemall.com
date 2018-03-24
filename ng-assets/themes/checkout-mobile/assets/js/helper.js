(function($) {
    
	$.fn.clearError = function(){
		this.css('border-color', '#e2e2e2');
		this.siblings('.active-alert-text').remove();
	}

	$.fn.resetForm = function(){
		this.find('input, select, textarea').css('border-color', '#E2E2E2'); 
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