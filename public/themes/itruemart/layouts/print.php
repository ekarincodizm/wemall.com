<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!-- saved from url=(0083)http://www.weloveshopping.com/template/tem/bank_payment/billing.php?orderid=7756469 -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8;">
    <title>The coolest online shopping center; iTrue Mart</title>

    <!-- <link href="http://www.truemall.com/assets/front/css/payment/layout_print.css" rel="stylesheet" type="text/css" />
    <link href="http://www.truemall.com/assets/front/css/payment/layout_paymentpopup.css" rel="stylesheet" type="text/css" />
    <link href="http://www.truemall.com/assets/front/css/payment/text.css" rel="stylesheet" type="text/css" />
    -->
	
	<?php 
	$canonical_tag = "http";
	$alternate_tag = "http";
	if(isset($_SERVER['HTTPS'])){
		$canonical_tag .= "s";
		$alternate_tag .= "s";
	}
	$canonical_tag .= "://".str_replace("m.", "www.", $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
	$alternate_tag .= "://".str_replace("www.", "m.", $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
	$host_url = $_SERVER["HTTP_HOST"];
	if(preg_match('/m.itruemart/i',$host_url)){ ?>
		<link rel="canonical" href="<?php echo $canonical_tag; ?>">
	<?php }
	else{ ?>
		<link rel="alternate" media="only screen and (max-width: 640px)" href="<?php echo $alternate_tag; ?>">
	<?php } ?>
    <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('css/layout_print.css') ?>"></script>
    <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('css/layout_paymentpopup.css') ?>"></script>
    <script type="text/javascript" src="<?php echo Theme::asset()->usePath()->url('css/text.css') ?>"></script>
    <style type="text/css">
            <!--
            .style4 {font-size: 12px}
            .style5 {font-size: 12}
            .style6 {font-size: 14px}
            .style7 {
                font-family: Tahoma;
                font-weight: bold;
                font-size: 14px;
            }
            .style8 {color: #FF0000}
            --> </style>
    <script language="javascript">
            function myPrint(){
                imgprint.style.display='none';
                window.print();
                imgprint.style.display='block'; 
            }
        </script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">


        <?php /* Content here */ ?>
        <?php echo Theme::content(); ?>

</body>
        </html>