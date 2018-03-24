$(document).ready(function(){

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
});