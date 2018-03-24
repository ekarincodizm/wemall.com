/**
 * First time we need to check login from central.
 *
 * @return void
 */

var noSyncCentralize = false;

$(document).ready(function() {

    // var url = window.location.href;

    // if (url.indexOf('/auth/login') != -1)
    // {
    //     return;
    // }

    // if (url.indexOf('/auth/logout') != -1)
    // {
    //     return
    // }

    if (noSyncCentralize)
    {
        return;
    }

    // Sync authentication fronm central.

    $.getJSON('http://loginservice.alpha.truelife.com/checkCentralizeCookies.php?jsoncallback=?', function(response) {

        if (response.jsonReturn.uid != undefined)
        {
            // User logined

            // if ($.cookie('itmLogged') == currentSession && currentLoggedIn == true)
            //     return;

            // if ($.cookie('itmLogged') == currentSession)
            //     return;

            var ssoId = response.jsonReturn.uid;
            var accessToken = response.jsonReturn.access_token;

            // if cookie and ssoId is same so central == itruemart
            // if ($.cookie('itmLogged') == ssoId)
            //     return;

            // it not equal so update at itruemart
            // with this itruemart should have fresh sso id and access token
            $.ajax({
                async: false,
                type: 'POST',
                url: '/auth/ajax-sync',
                data: 'ssoId=' + ssoId + '&accessToken=' + accessToken,
                success: function(res) {
                    // if (res) {
                    //     $.cookie('itmLogged', ssoId, { expires: 365, path: '/' });
                    if (res.redirect) {
                        window.location.reload(true);
                    }

                }
            });
        }
        else
        {
            //Centralize tell us, User logout.

            // If user don't login, we don't have to call logout.
            // if ( ! $.cookie('itmLogged'))
            //     return;

            // On itruemart, user is logged in so we will logout as well.
            $.ajax({
                async: false,
                type: 'POST',
                url: '/auth/ajax-sync',
                data: null,
                success: function(res) {
                    // $.removeCookie('itmLogged');
                    if (res.redirect) {
                        window.location.reload(true);
                    }
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

    // data : require
    // data.remember_me
    // data.access_token
    // data.type
    // data.redirect

    NProgress.start();
    NProgress.set(0.5);

    $.getJSON("http://loginservice.alpha.truelife.com/centralizeAuthen.php?jsoncallback=?", data, function(res) {
        NProgress.done();
        window.location.href = data.redirect;
    })
    .fail(function() {
        // we called ajax and it doesn't success
        // redirect to homepage
        console.log("Login: Fail to call sso");
        window.location.href = "/";
    });


}

/**
 * Deauthorized from truelife.
 *
 * @param  json data
 * @return void
 */
var centralLogout = function(data) {

    // data : require
    // data.app_id
    // data.secret_key
    // data.type
    // data.redirect

    NProgress.start();
    NProgress.set(0.5);
    // $.getJSON("http://loginservice.alpha.truelife.com/centralizeDeAuthen.php?jsoncallback=?", data, function(res) {
    //     NProgress.done();

    //     // redirect to referer or auth/login
    //     window.location.href = data.redirect;
    // });

    $.getJSON("http://loginservice.alpha.truelife.com/checkCentralizeCookies.php?jsoncallback=?", function (response) {
        if (response.jsonReturn.uid != undefined) {
            var sso_id = response.jsonReturn.uid;
            var access_token = response.jsonReturn.access_token;
            $.getJSON("http://loginservice.alpha.truelife.com/centralizeDeAuthen.php?jsoncallback=?", {app_id: data.app_id, secret: data.secret_key, access_token: access_token, type: data.type }, function (profile_data) {
                // redirect to referer or auth/login
                window.location.href = data.redirect;
            });
        }
    })
    .fail(function() {
        // we called ajax and it doesn't success
        // redirect to homepage
        console.log("Logout: Fail to call sso");
        window.location.href = "/";
    });

}
