/**
 * First time we need to check login from central.
 *
 * @return void
 */
$(document).ready(function() {

    // Sync authentication fronm central.
    $.getJSON("https://loginservice.truelife.com/checkCentralizeCookies.php?jsoncallback=?" ,function(response) {

        if (response.jsonReturn.uid != undefined) {
            if($.cookie('itmLogged'))
                return;

            var ssoId = response.jsonReturn.uid;
            var accessToken = response.jsonReturn.access_token;

            $.ajax({
                type: 'POST',
                url: '/auth/ajax-sync',
                data: 'ssoId=' + ssoId + '&accessToken=' + accessToken,
                success: function(res) {
                    if (res) {
                        $.cookie('itmLogged', true);
                    }

                }
            });
        }
        else {
            if(!$.cookie('itmLogged'))
                return;

            $.removeCookie('itmLogged');
            $.ajax({
                type: 'POST',
                url: '/auth/ajax-sync',
                data: null,
                success: function(res) {
                    // Do nothing.
                }
            });
        }
    });
});

/**
 * Authorized.
 *
 * @param  json data
 * @return void
 */
var centralLogin = function(data) {

    //console.log(data);

    $.getJSON("https://loginservice.truelife.com/centralizeAuthen.php?jsoncallback=?", data, function(res) {
        //
    });

    setTimeout(function() {
        window.location.href = data.redirect
    }, 1000);
}

/**
 * Deauthorized from truelife.
 *
 * @param  json data
 * @return void
 */
var centralLogout = function(data) {

    //console.log(data);

    $.getJSON("https://loginservice.truelife.com/centralizeDeAuthen.php?jsoncallback=?", data, function(res) {
        //
    });

    setTimeout(function() {
        window.location.href = data.redirect
    }, 1000);
}
