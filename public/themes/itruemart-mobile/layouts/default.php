<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <title><?php echo Theme::get('title'); ?></title>

        <meta name="keywords" content="<?php echo Theme::get('keywords'); ?>">
        <meta name="description" content="<?php echo Theme::get('description'); ?>">
        <?php if (Request::segment(1) != "campaign" || (Request::segment(1) == 'campaign') && Request::segment(2) == 'line') : ?>
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url('css/main.css'); ?>">
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url('css/addon.css'); ?>">
        <?php endif; ?>
        <link rel="stylesheet" href="<?php echo Theme::asset()->usePath()->url('css/dev_custom.css'); ?>">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>

        <?php echo Theme::asset()->styles(); ?>
        <?php echo Theme::asset()->scripts(); ?>
          <script type="text/javascript">
            var site_url = "<?php echo URL::to('/'); ?>/";
            var secure_site_url = "<?php echo URL::to('/', array(), true); ?>/";
            var use_secure = '<?php echo Config::get("https.useHttps");?>';
            var currentSession = "<?php echo md5(Session::getId()); ?>";
            var currentLocale = "<?php echo Lang::getLocale(); ?>";
        </script>
    </head>
    <body>
        <div id="wrapper" style="max-width:480px;">
            <?php echo Theme::partial('header'); ?>

            <?php if (Request::segment(1) != "campaign") : ?>
            <div class="container">
            <?php endif; ?>
                <?php echo Theme::content(); ?>
            <?php if (Request::segment(1) != "campaign") : ?>
            </div>
            <?php endif; ?>

            <?php echo Theme::place("subfooter", ""); ?>
            <?php echo Theme::partial('footer'); ?>

            <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/jquery-cookie/jquery.cookie.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/reveal.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/notice.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/script.js'); ?>"></script>

            <?php echo Theme::asset()->container('footer')->scripts(); ?>
            <script type="text/javascript" src="<?php echo Theme::asset()->originUrl('assets/vendor/jquery-bxslider/jquery.bxslider.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('js/app.js'); ?>"></script>
        </div>
        <div class="clear"></div>

		<?php if (Request::segment(2) != 'thank-you'){?>
		<!-- Google Tag Manager -->

                        <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PNLTZQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            		<script>
            			var g_url = document.URL;
            			if (g_url.indexOf( "http://www.itruemart.com" ) > -1 || g_url.indexOf( "http://m.itruemart.com" ) > -1)
            			{
                            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start":
                                new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],
                                j=d.createElement(s),dl=l!="dataLayer"?"&l="+l:"";j.async=true;j.src=
                                "//www.googletagmanager.com/gtm.js?id="+i+dl;f.parentNode.insertBefore(j,f);
                            })(window,document,"script","dataLayer","GTM-PNLTZQ");
            			}
            		</script>
		<!-- End Google Tag Manager --><!-- End Save for Web Slices -->
		<?php } ?>

        <script src="//support.itruemart.com/application/js/bootstrap.min.js"></script>

    </body>
</html>

