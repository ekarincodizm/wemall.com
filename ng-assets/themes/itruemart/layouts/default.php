<!DOCTYPE html>
<html lang='<?php echo __("lang_code"); ?>' xml:lang='<?php echo __("lang_code"); ?>' xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <title><?php echo Theme::get('title'); ?></title>
        <meta name="google-site-verification" content="yMAktZ2pT5xpZK2OLe9zhXrv2NDdS32wf0fMhjSjA4E" />
        <meta charset="UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <meta name="viewport">
        <meta name="description" content="<?php echo Theme::get('metadescription'); ?>"/>
        <meta name="keywords" content="<?php echo Theme::get('metakeywords'); ?>"/>
        <link href="<?php echo Theme::asset()->originUrl('assets/vendor/bootstrap/bootstrap.min.css'); ?>" rel="stylesheet">
        <?php //echo Theme::asset()->styles(); ?>
        <link href="<?php echo Theme::asset()->url('css/itruemart.css'); ?>" rel="stylesheet">
        <link href="<?php echo Theme::asset()->url('css/itruemart.custom.css'); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url("css/seo_web.css?q=20141013"); ?>" />
        <link rel="stylesheet" href="<?php echo Theme::asset()->url('css/print-style.css');?>" type="text/css" media="print" />

        <script src="<?php echo Theme::asset()->originUrl('assets/vendor/jquery/jquery-1.8.2.min.js'); ?>" type="text/javascript"></script>

        <!--<script type="text/javascript" src="<?php //echo Theme::asset()->usePath()->url("js/lib/jquery-1.11.0.min.js"); ?>" ></script>-->
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/lib/jquery-migrate-1.2.1.min.js"); ?>" ></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/lib/jquery-ui.min.js"); ?>" ></script>

        <script type="text/javascript">
            var site_url_nolang = "<?php echo URL::to('/'); ?>/";
            var site_url = "<?php echo URL::toLang('/'); ?>/";
            var site_url_https = "<?php echo URL::toLang('/',array(),true); ?>/";
            var open_https = "<?php echo Config::get("https.useHttps")? 'true' : 'false'; ?>";
            /* typeidea script */
            var dataLayer = [];
            /* //typeidea script */
        </script>

        <?php echo Theme::asset()->container("after_itruemart")->styles(); ?>
        <?php echo Theme::partial('meta'); ?>
        <?php echo Theme::partial('meta_og'); ?>

        <!--[if lt IE 9]>
        <script src="<?php echo Theme::asset()->url('js/html5shiv.js'); ?>"></script>
        <script src="<?php echo Theme::asset()->url('js/respond.min.js'); ?>"></script>
        <![endif]-->

        <!-- Resize 960px -->
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url("js/owl-carousel/owl.carousel.css"); ?>" />
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url("js/owl-carousel/owl.theme.css"); ?>" />
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url("css/stepper/jquery.fs.stepper.css"); ?>" />
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url("css/reveal.css"); ?>" />

        <?php echo Theme::asset()->styles(); ?>

        <link href="<?php echo Theme::asset()->url('css/resize.css'); ?>" rel="stylesheet">
        <link href="<?php echo Theme::asset()->usePath()->url('css/main.css?q=20141013'); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url("css/custom.css?q=20150121"); ?>" />

        <?php echo Theme::asset()->scripts(); ?>


        <?php if (Theme::get('canonical_url')) { ?>
            <link rel="canonical" href="<?php echo Theme::get('canonical_url') ?>"/>
        <?php } ?>

        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body class="pull_top">
        <?php # echo Theme::partial('topbar'); ?>
        <?php echo Theme::partial('header'); ?>
        <?php echo Theme::partial('navbar'); ?>
        <?php echo Theme::partial("homeBanner"); ?>

        <?php /* Content here */ ?>
        <div class="home__container">
            <?php echo Theme::content(); ?>
        </div>


        <!-- [S] Get partial cartLightbox from checkout theme -->
        <?php echo Theme::partial('cartLightbox') ?>
        <!-- [E] Get partial cartLightbox from checkout theme -->

        <!-- [S] ajax loading -->
        <?php echo Theme::widget("ajaxLoading", array())->render(); ?>
        <!-- [E] ajax loading -->

        <?php echo Theme::partial('footer'); ?>

        <?php echo Theme::partial("revealAlertDialog"); ?>

        <script type="text/javascript">
            var site_url = "<?php echo URL::to('/'); ?>/";
            var site_url_https = "<?php echo URL::to('/',array(),true); ?>/";
            var open_https = "<?php echo Config::get("https.useHttps")? 'true' : 'false'; ?>";
            var currentSession = "<?php echo md5(Session::getId()); ?>";
            var currentLocale = "<?php echo Lang::getLocale(); ?>";
        </script>


        <?php echo Theme::asset()->container('footer')->styles(); ?>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/jqueryui/jquery-ui-1.8.6.custom.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/jqueryui/jquery-ui.touch-punch.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/jquery-bxslider/jquery.bxslider.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/jquery-slimscroll/jquery.slimscroll.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/jquery-cookie/jquery.cookie.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/multizoom.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl("assets/vendor/underscore-min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/lib/jquery.countdown.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/lib/jquery.lazyload.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/bootstrap/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/js/jquery.formatMoney.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/js/price_helper.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->originUrl("assets/vendor/jquery.reveal.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/owl-carousel/owl.carousel.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/lib/jquery.fs.stepper.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/lib/jquery.sharrre.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/main.js"); ?>" ></script>


        <!-- Level b scripts : product_bestseller_slider -->
        <script type="text/javascript" src="<?php echo Theme::asset()->url('js/product_bestseller_slider.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->url('js/itruemart.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo Theme::asset()->url('js/subscribe.js'); ?>"></script>

        <a href="#" class="productScrolltop">
            <img src="<?php echo Theme::asset()->usePath()->url('images/icn/top.png'); ?>" />
        </a>

            <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/js/sso.js'); ?>"></script>

        <!-- marketing tag -->
        <?php if (Theme::get('marketing_tag')): ?>
            <script type="text/javascript">
                <?php echo Theme::get('marketing_tag');?>
            </script>
        <?php endif; ?>

        <!-- Criteo tag -->
        <?php if (Theme::get('criteo_tag')): ?>
            <?php echo Theme::get('criteo_tag');?>
        <?php endif; ?>

        <?php echo Theme::asset()->container('footer')->scripts(); ?>
        <?php echo Theme::asset()->container('embed')->scripts(); ?>

    </body>
</html>