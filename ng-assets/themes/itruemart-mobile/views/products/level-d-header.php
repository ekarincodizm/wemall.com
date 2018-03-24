<div class="slide-up">
  <div style="padding:9px 0 0 10px; float:left;"> <img src="<?php echo Theme::asset()->usePath()->url('images/logo.png'); ?>" width="135" height="26" /></div>
  <div style="float:right; padding-top:3px;">
    <button class="product-buynow btn-blue-l-slide">สั่งซื้อ</button>
  </div>
</div>
<script>
    jQuery(document).ready(function($){
        var buy = $('.review').offset();
        $(window).scroll(function(){
            if ($(window).scrollTop() <= buy.top ){
                $('.slide-up').removeClass('show').addClass('hide');
            }else{
                $('.slide-up').removeClass('hide').addClass('show');
        }
        });
    });
</script>