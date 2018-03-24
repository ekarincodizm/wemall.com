<?php
    if (!isset($banners))
    {
        $banners = array();
    }
    /* typeidea script */
    $ec_banner = array();
    /* //typeidea script */
?>
<div class="home__middle_banner">
<?php if (! empty($banners) && is_array($banners)):?>
    <ul class="accordion_banner">

        <?php if (array_key_exists('acc_banner1', $banners)) {
            $key = 'acc_banner1'; 
            /* typeidea script */
            $arr = explode("#", $banners[$key]['url_link']); $ec_banner_promo = end($arr);
            array_push($ec_banner, array( 'id' => $ec_banner_promo, 'name' => $ec_banner_promo,'position' => 'home_accordion_banner_1'));
            /* //typeidea script */
            ?>
            <li class="ac_banner_1">
                <!-- typeidea script -->
                <a class="ec-promotion" href="<?php echo $banners[$key]['url_link'];?>" data-ec-promotion="<?php echo $ec_banner_promo; ?>|<?php echo $ec_banner_promo; ?>|home_accordion_banner_1">
                <!-- //typeidea script -->
                    <img src="<?php echo $banners[$key]['img_path'].'?q='.md5($banners[$key]['url_link']); ?>" />
                </a>
            </li>
        <?php } ?>

        <?php if (array_key_exists('acc_banner2', $banners)) {
            $key = 'acc_banner2';
            /* typeidea script */
            $arr = explode("#", $banners[$key]['url_link']); $ec_banner_promo = end($arr); 
            array_push($ec_banner, array( 'id' => $ec_banner_promo, 'name' => $ec_banner_promo,'position' => 'home_accordion_banner_2'));
            /* //typeidea script */
            ?>
            <li class="ac_banner_2">
                <!-- typeidea script -->
                <a  class="ec-promotion" href="<?php echo $banners[$key]['url_link']; ?>" data-ec-promotion="<?php echo $ec_banner_promo; ?>|<?php echo $ec_banner_promo; ?>|home_accordion_banner_2">
                <!-- //typeidea script -->
                    <img src="<?php echo $banners[$key]['img_path'].'?q='.md5($banners[$key]['url_link']); ?>" />
                </a>
            </li>
        <?php } ?>

        <?php if (array_key_exists('acc_banner3', $banners)) {
            $key = 'acc_banner3';
            /* typeidea script */
            $arr = explode("#", $banners[$key]['url_link']); $ec_banner_promo = end($arr); 
            array_push($ec_banner, array( 'id' => $ec_banner_promo, 'name' => $ec_banner_promo,'position' => 'home_accordion_banner_3'));
            /* //typeidea script */
            ?>
            <li class="ac_banner_3 open">
                <!-- typeidea script -->
                <a  class="ec-promotion" href="<?php echo $banners[$key]['url_link']; ?>" data-ec-promotion="<?php echo $ec_banner_promo; ?>|<?php echo $ec_banner_promo; ?>|home_accordion_banner_3">
                <!-- //typeidea script -->
                    <img src="<?php echo $banners[$key]['img_path'].'?q='.md5($banners[$key]['url_link']); ?>" />
                </a>
            </li>
        <?php } ?>

    </ul>
<?php endif; ?>
</div>
<!-- typeidea script -->
<script type="text/javascript">
    var ec_banner = <?php echo jsonUnescapedUnicode(json_encode($ec_banner)); ?>;
    dataLayer.push({
      'event': 'promoView',
      'ecommerce': {
        'currencyCode': 'PHP',
        'promoView': {
          "promotions": ec_banner
        }
      }
    });
    dataLayer.push({
      'event': '',
      'ecommerce': {
        'currencyCode': 'PHP',
        'promoView': {
          "promotions": []
        }
      }
    });
</script>
<!-- //typeidea script -->