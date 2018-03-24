<?php
$ng_vendor_css = glob("store/app/*.vendor.css");
$ng_app_css = glob("store/app/*.app.css");
?>

<?php if (!empty($ng_vendor_css[0])): ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->originUrl($ng_vendor_css[0]); ?>"/>
<?php endif; ?>
<?php if (!empty($ng_app_css[0])): ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Theme::asset()->originUrl($ng_app_css[0]); ?>"/>
<?php endif; ?>
