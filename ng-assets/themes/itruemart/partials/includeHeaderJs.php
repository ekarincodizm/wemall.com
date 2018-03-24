<!--[if lt IE 9]>
<script src="<?php echo Theme::asset()->url('js/html5shiv.js'); ?>"></script>
<script src="<?php echo Theme::asset()->url('js/respond.min.js'); ?>"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/lib/jquery-1.11.0.min.js"); ?>" ></script>
<script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/lib/jquery-migrate-1.2.1.min.js"); ?>" ></script>
<script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url("js/lib/jquery-ui.min.js"); ?>" ></script>
<script type="text/javascript">
    var site_url_nolang = "<?php echo URL::to('/'); ?>/";
    var site_url = "<?php echo URL::toLang('/'); ?>/";
    var site_url_https = "<?php echo URL::toLang('/',array(),true); ?>/";
    var open_https = "<?php echo Config::get("https.useHttps")? 'true' : 'false'; ?>";
    var currentSession = "<?php echo md5(Session::getId()); ?>";
    var currentLocale = "<?php echo Lang::getLocale(); ?>";
</script>