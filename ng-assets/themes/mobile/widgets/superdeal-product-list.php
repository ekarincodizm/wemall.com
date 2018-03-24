<!-- typeidea script -->
<?php $ec_banner = array();?>
<!-- typeidea script -->
  <?php foreach ($products as $key => $product): ?>
     <?php
          $flashsaleType = array_get($product, 'discount_icon');
          $campaignType = array_get($product, 'isLineCampaign');
          $end = strtotime(array_get($product, 'ended_at'));
          /* typeidea script */
          $position = $key+1;
          array_push($ec_banner, array( 'id' => $product['pkey'], 'name' => $product['title'], 'position' => 'everyday-wow-home-' . $position ));
          /* //typeidea script */
    ?>  

    <div class="col-xs-6 superdeal-<?php echo $key%2 == 0 ? 'left' : 'right'; ?>" id="home-superdeal".<?php echo $key+1;?> >
      <div class="superdeal-home-thumb">
        <?php if ($end < time()): ?>
          <div class="out-of-promotion"><span><?php echo __("out_of_promotion");?></span></div>
        <?php endif; ?>
        <?php if ($flashsaleType == 'tmvh'): ?>
          <div class="line-special"><img alt="line truemove H <?php echo $product['title'];?>" src="<?php echo URL::asset('themes/mobile/assets/img/line_truemove_h.png'); ?>"></div>
        <?php endif; ?>
        <?php if ($flashsaleType == 'trueu'): ?>
          <div class="line-special"><img alt="line True You <?php echo $product['title'];?>" src="<?php echo URL::asset('themes/mobile/assets/img/line_trueyou.png'); ?>"></div>
        <?php endif; ?>

        <?php
            $timeout = '';
            $timeout_tmp =  array_get($product, 'ended_at');
            if(!empty($timeout_tmp))
            {
                $timeout_str = str_replace('T', '',  $timeout_tmp);
                $timeout = date( 'Y/m/d H:i:s', strtotime($timeout_tmp) );
            }
        ?>
          <?php
          $slug = (isset($product['slug']) && !empty($product['slug'])) ? $product['slug']  : url_title($product['title']);
          ?>
        <!-- typeidea script -->
        <div class="col-xs-12"><div class="product-img"><a href="<?php echo URL::toLang("products/" . $slug . "-" . $product['pkey'] . ".html"); ?>" class="ec-promotion" data-ec-promotion="<?php echo $product['pkey']; ?>|<?php echo $product['title']; ?>|everyday-wow-home-<?php echo $key+1; ?>"><img title="<?php echo $product['title'];?>" alt="<?php echo $product['title'];?>" src="<?php echo $product['mobile_image']; ?>"></a></div></div>
        <!-- //typeidea script -->
        <div class="col-xs-12 time-remaining"><?php echo __("time_left_mobile"); ?> : <span style="color:#444" data-reload="0" data-countdown="<?php echo $timeout; ?>" ></span></div>
        <div class="col-xs-12 product-everyday-wow--name"><?php echo $product['title']?></div>
        <div class="col-xs-12 price-superdeal margin-top-20">
          <div class="row">
            <div class="col-xs-8">
              <?php if(!empty($product['special_price'])): ?>
              <p><?php echo $product['special_price']; ?>.-</p>
              <?php endif; ?>
                <span><?php echo $product['normal_price']; ?>.-</span>
            </div>
            <?php 
                if( $campaignType ):
            ?>
              <div class="col-xs-4"><span class="price-line"><?php echo $product['percent_discount']; ?></span><img alt="ราคา <?php echo $product['title'];?>" src="<?php echo URL::asset('themes/mobile/assets/img/dummy_sale_tag_02.png'); ?>"></div>
            <?php else: ?>
              <div class="col-xs-4"><span class="price-red"><?php echo $product['percent_discount']; ?></span><img alt="ราคา <?php echo $product['title'];?>" src="<?php echo URL::asset('themes/mobile/assets/img/dummy_sale_tag_01.png'); ?>"></div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
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