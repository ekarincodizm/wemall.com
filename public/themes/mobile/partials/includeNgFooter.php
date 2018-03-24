<?php
    $ng_app_js = glob("store/app/*.app.js");
    $ng_vendor_js = glob("store/app/*.vendor.js");
?>
<?php if (!empty($ng_vendor_js[0])): ?>
    <script type="text/javascript" src="<?php echo Theme::asset()->originUrl($ng_vendor_js[0]); ?>"></script>
<?php endif; ?>
<?php if(!empty($ng_app_js[0])): ?>
    <script type="text/javascript" src="<?php echo Theme::asset()->originUrl($ng_app_js[0]); ?>"></script>
<?php endif; ?>