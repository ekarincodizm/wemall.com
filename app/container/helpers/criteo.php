<?php

/**
 * 	@param  $email
 *  @return  lower caes > trim > convert to UTF-8 > md5
 *  @return  hashed email
 * 	@access  Public
 */
if (!function_exists('hashed_email')) {
    function hashed_email($email = "")
    {
        if (empty($email)) {
            //$email = "guest@domain.com";
            return "";
        }

        $email = trim(strtolower($email));
        $email = iconv(mb_detect_encoding($email, mb_detect_order(), true), "UTF-8", $email);

        return md5($email);
    }
}

if (!function_exists('criteoGetContentType')) {
    function criteoGetContentType()
    {
        return preg_match("/^(m|m2|m-(a|b|b1|b2))\.|-m\./i", Request::server('HTTP_HOST')) ? 'm' : 'd';
    }
}

if (!function_exists('criteoGetHashEmail')) {
    function criteoGetHashEmail()
    {
        $user = ACL::getUser();
        return hashed_email($user['email']);
    }
}

if (!function_exists('criteoTagHome')) {
    function criteoTagHome()
    {
        $criteo_script = "<div id=\"criteo-script\"></div><script>
$('#criteo-script')
    .append(
    '<script src=\"//static.criteo.net/js/ld/ld.js\" async=\"true\"><\/script>' +
    '<script>$(document).on(\"criteo-load\", function(event, response){ ' +
    'window.criteo_q = window.criteo_q || []; window.criteo_q.push(' +
    '{ event: \"setAccount\", account: 26653 }, ' +
    '{ event: \"setHashedEmail\", email: [ response.criteo_hash ] }, ' +
    '{ event: \"setSiteType\", type: \"".criteoGetContentType()."\"}, ' +
    '{ event: \"viewHome\"}' +
    '); });<\/script>');
</script>";
        return $criteo_script;
    }
}

if (!function_exists('criteoTagHomeMobile')) {
    function criteoTagHomeMobile() {
        $criteo_script = criteoTagHome();
        $criteo_script.="<script>$('#criteo-script').append('<script>$(function() { $.ajax({ async: true, url : \"/users/ajax-get-user\", success: function(r) { $(document).trigger(\"criteo-load\", [ r ]); } }); });<\/script>');</script>";
        return $criteo_script;
    }
}

if (!function_exists('criteoTagLevelD')) {
    function criteoTagLevelD($pkey)
    {
        $criteo_script = "<div id=\"criteo-script\"></div><script>
$('#criteo-script')
    .append(
    '<script src=\"//static.criteo.net/js/ld/ld.js\" async=\"true\"><\/script>' +
    '<script>$(document).on(\"criteo-load\", function(event, response){ ' +
    'window.criteo_q = window.criteo_q || []; window.criteo_q.push(' +
    '{ event: \"setAccount\", account: 26653 }, ' +
    '{ event: \"setHashedEmail\", email: [ response.criteo_hash ] }, ' +
    '{ event: \"setSiteType\", type: \"".criteoGetContentType()."\"}, ' +
    '{ event: \"viewItem\", item: \"".$pkey."\"}' +
    '); });<\/script>');
</script>";
        return $criteo_script;
    }
}

if (!function_exists('criteoTagLevelDMobile')) {
    function criteoTagLevelDMobile($pkey) {
        $criteo_script = criteoTagLevelD($pkey);
        $criteo_script.="<script>$('#criteo-script').append('<script>$(function() { $.ajax({ async: true, url : \"/users/ajax-get-user\", success: function(r) { $(document).trigger(\"criteo-load\", [ r ]); } }); });<\/script>');</script>";
        return $criteo_script;
    }
}

if (!function_exists('criteoTagLevelC')) {
    function criteoTagLevelC($product_list, $keyword, $platform = 'web')
    {
        $inject_box = $platform=='web' ? '#criteo-script' : '#criteo-script-mobile';
        $criteo_script = '';

        if ($platform=='mobile') {
            $criteo_script.= "<script>$('#criteo-script-mobile, #criteo-script').html('');$('#criteo-tags-div').remove();</script>";
        }

        $criteo_script.= "<div id=\"criteo-script\"></div><script>
$('" . $inject_box . "')
    .append(
    '<script src=\"//static.criteo.net/js/ld/ld.js\" async=\"true\"><\/script>' +
    '<script>$(document).on(\"criteo-load\", function(event, response){ ' +
    'var productlist = " . json_encode($product_list) . ";' +
    'window.criteo_q = window.criteo_q || []; window.criteo_q.push(' +
    '{ event: \"setAccount\", account: 26653 }, ' +
    '{ event: \"setHashedEmail\", email: [ response.criteo_hash ] }, ' +
    '{ event: \"setSiteType\", type: \"".criteoGetContentType()."\"}, ' +
    '{ event: \"viewList\", item: productlist, keywords: \"" . $keyword . "\"}' +
    '); });<\/script>');
</script>";

        return $criteo_script;
    }
}

if (!function_exists('criteoTagLevelCMobile')) {
    function criteoTagLevelCMobile($product_list, $keyword, $platform = 'mobile') {
        $criteo_script = criteoTagLevelC($product_list, $keyword, $platform);
        $criteo_script.="<script>$('#criteo-script').append('<script>$(function() { $.ajax({ async: true, url : \"/users/ajax-get-user\", success: function(r) { $(document).trigger(\"criteo-load\", [ r ]); } }); });<\/script>');</script>";
        return $criteo_script;
    }
}
