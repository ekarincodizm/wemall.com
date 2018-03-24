 <?php
    $txt = "footer__bg_main-link";
    $num1 = strpos($tmp,$txt);
    $head= "<head>";
    $head2= "</head>";
    
?>
<!DOCTYPE html>
<html>
<head lang="en">

 
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<meta charset="UTF-8">
	<title></title>
	<style>
		body {
			margin: 0;
			padding: 0;
		}
	</style>	
    <link rel="stylesheet" href="<?php echo URL::asset('assets/christmas/css/xmas.css')?>">
    <link rel="stylesheet" href="<?php echo URL::asset('assets/christmas/css/fonts.css')?>">	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://jqueryrotate.googlecode.com/svn/trunk/jQueryRotate.js" type="text/javascript"></script>
	<script src="<?php echo URL::asset('assets/christmas/js/jquery.easing.js')?>"></script>
	<script src="<?php echo URL::asset('assets/christmas/js/xmas.js')?>"></script>
    	<script>
		$ ( function () {
			$ ( '.xmas-link' ).xmas ();
		} );

	</script>

    <script>

    
$(document).ready(function(){
    
  $(".btn-subscribe-news").click(function(){
     
         var ss = $("#subscribe_news").val();
        if (isValidEmail(ss) == true) {
        }else{
             $("#msg_subscribe").show();
             $("#msg_subscribe").html("กรุณากรอกรูปแบบอีเมล์ให้ถูกต้อง");
             $("#msg_subscribe").css("color","red");
        return false;    
        }
        $.post("/ajax/subscribe/new",
        {
          email: ss

        },function(data,status){
                //console.log(data);      
                $("#msg_subscribe").show();
                $("#msg_subscribe").html('คุณได้ทำการลงทะเบียนเพื่อรับข่าวสารจาก iTrueMart เรียบร้อยแล้ว'+data.data);
                $("#msg_subscribe").css("color","#95c126");
            });
        });
    
    
});


        
function isValidEmail(str) {
var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
return (filter.test(str)); 
}
        
</script>

</head>
<body>
	<div class="xmas-container">
		<div class="xmas-controller">
			<img src="<?php echo URL::asset('assets/christmas/img/christmas-landing-bg.jpg')?>" alt="x'mas"/>
			<span class="xmas-link link-pos-1">
				<a href="#"><img src="<?php echo URL::asset('assets/christmas/img/link/no1.png')?>" alt="" /></a>
			</span>
			<span class="xmas-link link-pos-2">
				<a href="#"><img src="<?php echo URL::asset('assets/christmas/img/link/no2.png')?>" alt="" /></a>
			</span>
			<span class="xmas-link link-pos-3">
				<a href="#"><img src="<?php echo URL::asset('assets/christmas/img/link/no3.png')?>" alt="" /></a>
			</span>
			<span class="xmas-link link-pos-4">
				<a href="#"><img src="<?php echo URL::asset('assets/christmas/img/link/no4.png')?>" alt="" /></a>
			</span>
			<span class="xmas-link link-pos-5">
				<a href="#"><img src="<?php echo URL::asset('assets/christmas/img/link/no5.png')?>" alt="" /></a>
			</span>
			<span class="xmas-link link-pos-6">
				<a href="#"><img src="<?php echo URL::asset('assets/christmas/img/link/no6.png')?>" alt="" /></a>
			</span>
			<span class="xmas-link link-pos-7">
				<a href="#"><img src="<?php echo URL::asset('assets/christmas/img/link/no7.png')?>" alt="" /></a>
			</span>
			<span class="xmas-link link-pos-8">
				<a href="#"><img src="<?php echo URL::asset('assets/christmas/img/link/no8.png')?>" alt="" /></a>
			</span>
			<span class="xmas-link link-pos-9">
				<a href="#"><img src="<?php echo URL::asset('assets/christmas/img/link/no9.png')?>" alt="" /></a>
			</span>
			<span class="xmas-link link-pos-10">
				<a href="#"><img src="<?php echo URL::asset('assets/christmas/img/link/no10.png')?>" alt="" /></a>
			</span>
		</div>
		<div class="xmas-content">
			<p>
				iTrueMart มอบความสุขส่งท้ายปีเก่ารับปีใหม่<br/>
				ด้วยของรางวัลพิเศษแด่ลูกค้า ทั้งคูปองเงินสดและ<br/>
				ส่วนลดแบรนด์ชั้นนำจากต้นคริสมาส์ตนำโชคให้คุณได้ช้อปเพลิน</p>

			<p>
				<span>ลุ้นรับเลย วันนี้ - 15 มกราคม 2558*</span>
				<a href="http://support.itruemart.com/246198-เงอนไขการใชรหสสวนลด-Lucky-Xmas">
					<img src="<?php echo URL::asset('assets/christmas/img/christmas-notice.png')?>" alt=""/>
				</a>
			</p>
		</div>
        <div class="products-container">
			<p class="products-title-name">
				<span class="title-left">CHRISTMAS SPECIAL PRICE</span>
				<span class="title-right">ใส่โค้ดลดเพิ่มอีก!!</span>
			</p>
			<ul class="products-list">
				<li class="item">
					<a href="http://www.itruemart.com/products/iphone-6-ieassau--2807965589907.html">
						<img class="tag-discount" src="<?php echo URL::asset('assets/christmas/img/products/discount-48p.png')?>" alt=""/>
						<img src="<?php echo URL::asset('assets/christmas/img/products/product_1.jpg')?>" alt=""/>
						<span class="bg-price">
							<span class="price price-discount">490.-</span>
							<span class="price price-special">250.-</span>
						</span>
					</a>
					<span class="bg-text-codePromotion bg-1">ใส่โค้ดลดเพิ่มอีก 50.-</span>
				</li>
				<li class="item">
					<a href="http://www.itruemart.com/products/samsung-galaxy-note-4--2369954865487.html">
						<img class="tag-discount" src="<?php echo URL::asset('assets/christmas/img/products/discount-7p.png')?>" alt=""/>
						<img src="<?php echo URL::asset('assets/christmas/img/products/product_2.jpg')?>" alt=""/>
						<span class="bg-price">
							<span class="price price-discount">25,000.-</span>
							<span class="price price-special">23,990.-</span>
						</span>
					</a>
					<span class="bg-text-codePromotion bg-2">ใส่โค้ดลดเพิ่มอีก 2,000.-</span>
				</li>
				<li class="item">
					<a href="http://www.itruemart.com/products/smalltalk-bluetooth-mipow-model-vox-tube-501-2568742184812.html">
						<img class="tag-discount" src="<?php echo URL::asset('assets/christmas/img/products/discount-60p.png')?>" alt=""/>
						<img src="<?php echo URL::asset('assets/christmas/img/products/product_3.jpg')?>" alt=""/>
						<span class="bg-price">
							<span class="price price-discount">2,490.-</span>
							<span class="price price-special">990.-</span>
						</span>
					</a>
					<span class="bg-text-codePromotion bg-2">ใส่โค้ดลดเพิ่มอีก 100.-</span>
				</li>
				<li class="item">
					<a href="http://www.itruemart.com/products/polk-audio-surroundbar-bluetooth-5000-2747404513219.html">
						<img class="tag-discount" src="<?php echo URL::asset('assets/christmas/img/products/discount-47p.png')?>" alt=""/>
						<img src="<?php echo URL::asset('assets/christmas/img/products/product_4.jpg')?>" alt=""/>
						<span class="bg-price">
							<span class="price price-discount">18,990.-</span>
							<span class="price price-special">9,990.-</span>
						</span>
					</a>
					<span class="bg-text-codePromotion bg-1">ใส่โค้ดลดเพิ่มอีก 200.-</span>
				</li>
				<li class="item"><a href="http://www.itruemart.com/products/smart-watch-pebble-310-2733108777126.html">
					<img class="tag-discount" src="<?php echo URL::asset('assets/christmas/img/products/discount-28p.png')?>" alt=""/>
					<img src="<?php echo URL::asset('assets/christmas/img/products/product_5.jpg')?>" alt=""/>
					<span class="bg-price">
						<span class="price price-discount">5,990.-</span>
						<span class="price price-special">4,290.-</span>
					</span>
				</a>
					<span class="bg-text-codePromotion bg-2">ใส่โค้ดลดเพิ่มอีก 1,000.-</span>
				</li>
				<li class="item"><a href="http://www.itruemart.com/products/casio-exilim-tr50-2694026353256.html">
					<img src="<?php echo URL::asset('assets/christmas/img/products/product_6.jpg')?>" alt=""/>
					<span class="bg-price">
						<span class="price price-special">34,990.-</span>
					</span>
				</a>
					<span class="bg-text-codePromotion bg-2">ใส่โค้ดลดเพิ่มอีก 3,000.-</span>
				</li>
				<li class="item">
					<a href="http://www.itruemart.com/products/canon-eos-1200d-lens-kit-18-55-is-stm-itruemart-2777777635189.html">
						<img class="tag-discount" src="<?php echo URL::asset('assets/christmas/img/products/discount-15p.png')?>" alt=""/>
						<img src="<?php echo URL::asset('assets/christmas/img/products/product_7.jpg')?>" alt=""/>
						<span class="bg-price">
							<span class="price price-discount">18,900.-</span>
							<span class="price price-special">15,990.-</span>
						</span>
					</a>
					<span class="bg-text-codePromotion bg-1">ใส่โค้ดลดเพิ่มอีก 2,000.-</span>
				</li>
				<li class="item">
					<a href="http://www.itruemart.com/products/ipad-mini-3-wificellular-2343802091605.html">
                        <img src="<?php echo URL::asset('assets/christmas/img/products/product_8.jpg')?>" alt=""/>
						<span class="bg-price">
							<span class="price">เริ่มต้น</span>
							<span class="price price-special">17,900 - 24,900.-</span>
						</span>
					</a>
					<span class="bg-text-codePromotion bg-2">ใส่โค้ดลดเพิ่มอีก 600.-</span>
				</li>
				<li class="item"><a href="http://www.itruemart.com/products/kaidobot-k6l-2406515887127.html">
					<img class="tag-discount" src="<?php echo URL::asset('assets/christmas/img/products/discount-49p.png')?>" alt=""/>
					<img src="<?php echo URL::asset('assets/christmas/img/products/product_9.jpg')?>" alt=""/>
					<span class="bg-price">
						<span class="price price-discount">5,900.-</span>
						<span class="price price-special">2,999.-</span>
					</span>
				</a>
					<span class="bg-text-codePromotion bg-2">ใส่โค้ดลดเพิ่มอีก 100.-</span>
				</li>
				<li class="item">
					<a href="http://www.itruemart.com/products/horizon-fitness-elliptical-e901-2489017192544.html">
						<img class="tag-discount" src="<?php echo URL::asset('assets/christmas/img/products/discount-27p.png')?>" alt=""/>
						<img src="<?php echo URL::asset('assets/christmas/img/products/product_10.jpg')?>" alt=""/>
						<span class="bg-price">
							<span class="price price-discount">12,900.-</span>
							<span class="price price-special">9,400.-</span>
						</span>
					</a>
					<span class="bg-text-codePromotion bg-1">ใส่โค้ดลดเพิ่มอีก 1,200.-</span>
				</li>
				<li class="item"><a href="http://www.itruemart.com/products/apple-tv-2532179925572.html">
					<img src="<?php echo URL::asset('assets/christmas/img/products/product_11.jpg')?>" alt=""/>
					<span class="bg-price">
						<span class="price price-special">3,800.-</span>
					</span>
				</a>
					<span class="bg-text-codePromotion bg-2">ใส่โค้ดลดเพิ่มอีก 330.-</span>
				</li>
				<li class="item"><a href="http://www.itruemart.com/products/lg-dtv-42-42lb551t-2426637282198.html">
					<img class="tag-discount" src="<?php echo URL::asset('assets/christmas/img/products/discount-40p.png')?>" alt=""/>
					<img src="<?php echo URL::asset('assets/christmas/img/products/product_12.jpg')?>" alt=""/>
					<span class="bg-price">
						<span class="price price-discount">19,990.-</span>
						<span class="price price-special">11,898.-</span>
					</span>
				</a>
					<span class="bg-text-codePromotion bg-2">ใส่โค้ดลดเพิ่มอีก 100.-</span>
				</li>
			</ul>
			<div class="more-products">
				<a href="http://www.itruemart.com"><img src="<?php echo URL::asset('assets/christmas/img/products/btn-more-products.jpg')?>" alt=""/></a>
			</div>
		</div>
        
	</div>
  
<link href="<?php echo url(); ?>/assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo url(); ?>/themes/itruemart/assets/css/itruemart.css" rel="stylesheet">
<link href="<?php echo url(); ?>/themes/itruemart/assets/css/itruemart.custom.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo url(); ?>/themes/itruemart/assets/css/seo_web.css?q=20141013" />
<link rel="stylesheet" href="<?php echo url(); ?>/themes/itruemart/assets/css/print-style.css" type="text/css" media="print" />



<!-- Resize 960px -->
<link rel="stylesheet" href="<?php echo url(); ?>/themes/itruemart/assets/js/owl-carousel/owl.carousel.css" />
<link rel="stylesheet" href="<?php echo url(); ?>/themes/itruemart/assets/js/owl-carousel/owl.theme.css" />
<link rel="stylesheet" href="<?php echo url(); ?>/themes/itruemart/assets/css/stepper/jquery.fs.stepper.css" />
<link rel="stylesheet" href="<?php echo url(); ?>/themes/itruemart/assets/css/reveal.css" />

<link media="all" type="text/css" rel="stylesheet" href="<?php echo url(); ?>/themes/itruemart/assets/css/nprogress.css">

<link href="<?php echo url(); ?>/themes/itruemart/assets/css/resize.css" rel="stylesheet">
<link href="<?php echo url(); ?>/themes/itruemart/assets/css/main.css?q=20141013" rel="stylesheet">
<link rel="stylesheet" href="<?php echo url(); ?>/themes/itruemart/assets/css/custom.css?q=20141013" />



<?php   
      
    echo   substr($tmp,$num1-12);

?>

