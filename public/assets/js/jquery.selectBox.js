(function($, window){
    $.fn.emptySelect = function() {
        return this.each(function(){
            if (this.tagName=='SELECT') this.options.length = 0;
        });
    }

    $.fn.resetSelect = function(text) {
        return this.emptySelect().each(function(){
            if (this.tagName == "SELECT")
            {
                var selectElement = this;
                var option = new Option(text, '');
                option.setAttribute("disabled","disabled");
                selectElement.add(option);
            }
        });
    }

    $.fn.loadSelect = function(optionsDataArray, lblFirst, currentValue) {
        return this.emptySelect().each(function(){
            if (this.tagName=='SELECT') {
                var selectElement = this;
                if (lblFirst != "" && lblFirst != undefined)
                {
                    var option = new Option(lblFirst, "");
                    option.setAttribute("selected","selected");
                    //option.setAttribute("disabled","disabled");
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
                        selectElement.add(option);
                    });
                }
            }

        });
    }
})(jQuery, window);