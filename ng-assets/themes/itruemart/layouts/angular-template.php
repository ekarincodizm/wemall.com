<!DOCTYPE html>
<html lang='<?php echo __("lang_code"); ?>' xml:lang='<?php echo __("lang_code"); ?>' xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <base href="/">

        <title><?php echo Theme::get('title'); ?></title>
        <meta name="google-site-verification" content="yMAktZ2pT5xpZK2OLe9zhXrv2NDdS32wf0fMhjSjA4E" />
        <meta charset="UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <meta name="viewport">
        <meta name="description" content="<?php echo Theme::get('metadescription'); ?>"/>
        <meta name="keywords" content="<?php echo Theme::get('metakeywords'); ?>"/>
        <?php echo Theme::partial('meta'); ?>
        <?php echo Theme::partial('meta_og'); ?>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <?php if (Theme::get('canonical_url')) { ?>
            <link rel="canonical" href="<?php echo Theme::get('canonical_url') ?>"/>
        <?php } ?>

        <?php echo Theme::partial('includeHeaderCss');?>
        <?php echo Theme::partial('includeNgHeader'); ?>

        <link href="<?php echo Theme::asset()->usePath()->url('css/main.css?q=20141013'); ?>" rel="stylesheet">
        <link type="text/css" rel="stylesheet" media="all" href="<?php echo Theme::asset()->usePath()->url('../../itruemart/assets/css/truemoveh.css'); ?>">
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url("css/custom.css?q=20150121"); ?>" />

        <?php echo Theme::partial('includeHeaderJs'); ?>
        <?php echo Theme::asset()->scripts(); ?>
        <script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&render=explicit&hl=th" async defer></script>
    </head>
    <body class="pull_top" ng-app="itmApp">

        <!--[if lt IE 10]>
          <p class="browsehappy">เลือกดาวน์โหลดเบราว์เซอร์เวอร์ชั่นล่าสุด. กรุณา คลิ๊ก <a href="http://browsehappy.com/"><strong>อัพเกรดเบราว์เซอร์</strong></a> เพื่อการทำงานที่เต็มประสิทธิภาพจากทาง iTruemart.com</p>
          <script type="text/javascript">
          alert('ขออภัยค่ะ หน้านี้ไม่รองรับเบราว์เซอร์ที่ใช้อยู่ในขณะนี้ กรุณาใช้เบราว์เซอร์เวอร์ชั่นล่าสุดของ Chrome Safari Firefox หรือ Internet Explorer เวอร์ชั่น 10 ขึ้นไป ขอบคุณค่ะ');</script>
        <![endif]-->
    
        <?php echo Theme::partial('header'); ?>
        <?php echo Theme::partial('navbar'); ?>
        <?php echo Theme::partial("homeBanner"); ?>

        <!-- <div class="home__container"> -->
            <?php echo Theme::content(); ?>
        <!-- </div> -->
        <a href="#" class="productScrolltop">
            <img src="<?php echo Theme::asset()->usePath()->url('images/icn/top.png'); ?>" />
        </a>

        <?php echo Theme::partial('cartLightbox') ?>
        <?php echo Theme::widget("ajaxLoading", array())->render(); ?>
        <?php echo Theme::partial('footer'); ?>
        <?php echo Theme::partial("revealAlertDialog"); ?>
        <?php echo Theme::partial("includeFooterJs"); ?>

        <?php echo Theme::asset()->container('footer')->styles(); ?>

        <?php if (Theme::get('marketing_tag')): ?>
            <script type="text/javascript">
                <?php echo Theme::get('marketing_tag');?>
            </script>
        <?php endif; ?>

        <?php echo Theme::asset()->container('footer')->scripts(); ?>
        <?php echo Theme::asset()->container('embed')->scripts(); ?>
        <?php echo Theme::partial("includeNgFooter"); ?>
    </body>
</html>