$(document).ready(function () {
    $(document).on('click','.fb_share', function (event) {
        event.preventDefault();
        var t = document.title;
        var u = window.location.href;
        u = u.replace("://m", "://www");

        width = 626;
        height = 436;
        var centerWidth = (window.screen.width - width) / 2;
        var centerHeight = (window.screen.height - height) / 2;
        window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t), '_blank', 'toolbar=0, status=0, width=' + width + ', height=' + height + ', top=' + centerHeight + ', left=' + centerWidth + '');
    });
    $(document).on('click','.tw_share', function (event) {
        event.preventDefault();
        var t = $('.product-name h1').text();
        var u = window.location.href;
        u = u.replace("://m", "://www");

        var width = 626;
        var height = 436;
        var centerWidth = (window.screen.width - width) / 2;
        var centerHeight = (window.screen.height - height) / 2;
        var url = encodeURIComponent(u);
        var hashtags = '#iTrueMartPH';

        var twtText = t;
        var twtMaxLength = 140;

        if(twtText.length + hashtags.length + url.length > twtMaxLength)
        {
            var diff = (twtText.length + url.length + hashtags.length + 2) - twtMaxLength;
            // alert(diff);
            twtText = twtText.substring(0, twtText.length - diff - 3) + "..."; //remove text in tail part and add ...
        }

        window.open("https://twitter.com/intent/tweet?text=" + encodeURIComponent(twtText + " " + hashtags) + "&url=" + url, "", 'toolbar=0, status=0, width=' + width + ', height=' + height + ', top=' + centerHeight + ', left=' + centerWidth + '');
    });
    $(document).on('click','.gp_share', function (event) {
        event.preventDefault();
        t = document.title;
        var u = window.location.href;
        u = u.replace("://m", "://www");
        width = 626;
        height = 436;
        var centerWidth = (window.screen.width - width) / 2;
        var centerHeight = (window.screen.height - height) / 2;
        var url = encodeURIComponent(u);
        window.open("https://plus.google.com/share?hl=" + "&url=" + encodeURIComponent(u), "", "toolbar=0, status=0, width=900, height=500");
    });
    $('.ml_share').click(function (event) {
        event.preventDefault();
        t = document.title;
        u = jQuery(this).attr('href');
        var rel = $(this).attr('data-share');
        var begin_brace = rel.lastIndexOf('[');
        var end_brace = rel.lastIndexOf(']');
        rel_val = rel.substr(begin_brace + 1, rel.length - begin_brace - 2);
        array_rel = rel_val.split(",");
        params = new Array();
        for (var i = 0; i < array_rel.length; i++) {
            key_value = array_rel[i].split("=");
            key = key_value[0];
            value = key_value[1];
            switch ($.trim(key)) {
                case"width":
                    var width = value;
                    break;
                case"height":
                    var height = value;
                    break;
                case"thumbnail":
                    var thumbnail = value;
                    break;
                case"entry_id":
                    var entry_id = value;
                    break;
                default:
                    break;
            }
        }
        if (width == "" || width == null || width == undefined) {
            width = 506;
        }
        if (height == "" || height == null || height == undefined) {
            height = 396;
        }
        k = 'itruemart_' + entry_id;
        var centerWidth = (window.screen.width - width) / 2;
        var centerHeight = (window.screen.height - height) / 2;
        window.open("http://widget.mylife.truelife.com/?p=share&k=" + k + "&cate=2&subcate=0&url=" + encodeURIComponent(u) + "&thumbnail=" + thumbnail, '_blank', 'toolbar=0, status=0, width=' + width + ', height=' + height + ', top=' + centerHeight + ', left=' + centerWidth + '');
    });
    $('.pt_share').click(function (event) {
        event.preventDefault();
        t = document.title;
        u = jQuery(this).attr('href');
        var rel = $(this).attr('data-share');
        var begin_brace = rel.lastIndexOf('[');
        var end_brace = rel.lastIndexOf(']');
        rel_val = rel.substr(begin_brace + 1, rel.length - begin_brace - 2);
        array_rel = rel_val.split(",");
        params = new Array();
        for (var i = 0; i < array_rel.length; i++) {
            key_value = array_rel[i].split("=");
            key = key_value[0];
            value = key_value[1];
            switch ($.trim(key)) {
                case"width":
                    var width = value;
                    break;
                case"height":
                    var height = value;
                    break;
                case"thumbnail":
                    var thumbnail = value;
                    break;
                case"entry_id":
                    var entry_id = value;
                    break;
                default:
                    break;
            }
        }
        if (width == "" || width == null || width == undefined) {
            width = 506;
        }
        if (height == "" || height == null || height == undefined) {
            height = 396;
        }
        width = 626;
        height = 436;
        var centerWidth = (window.screen.width - width) / 2;
        var centerHeight = (window.screen.height - height) / 2;
        pinUrl = "http://pinterest.com/pin/create/button/?url=" + encodeURIComponent(window.location.href) + "&media=" + thumbnail + "&description=" + encodeURIComponent(t);
        window.open(pinUrl, '_blank', 'toolbar=0, status=0, width=' + width + ', height=' + height + ', top=' + centerHeight + ', left=' + centerWidth + '');
    });
});