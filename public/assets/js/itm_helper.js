/**
 *  Generate URL.
 */
function UrlToLang(url){
    if(url != undefined){
        if(LANG != 'th'){
            url = LANG + "/" + url.replace(/^\//, '');
        }
        return location.protocol+'//'+location.hostname+"/"+url.replace(/^\//, '');
    }
    return "";
}

/**
 *  get payment channel pkey
 */
var getPaymentChannelPKey = function(channel){
    switch(channel) {
        case 'credit-card':
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
            //counter service
            //return '153213837979857';
        case 'cod':
            //cod
            return '155613837979771';
        case 'installment':
            return '156813837979402';
        default:
            return "";
    }
}


function saveStage(){
    // [S] set stage to cookie.
    var patStep1 = /checkout\/step1/gi;
    var patStep2 = /checkout\/step2/gi;
    var patStep3 = /checkout\/step3/gi;
    var patThankyou = /checkout\/thank-you/gi;

    if(patStep1.test(location.pathname)){
        document.cookie="stage=s1;path=/";
    }else if(patStep2.test(location.pathname)){
        document.cookie="stage=s2;path=/";
    }else if(patStep3.test(location.pathname)){
        document.cookie="stage=s3;path=/";
    }else if(patThankyou.test(location.pathname)){
        document.cookie="stage=; expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    }
    // [E] set stage to cookie.

    $(document).bind("clear-stage-cookie", function(){
        document.cookie="stage=; expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    });
}