<div class="home__inner_wrapper">
    <div class="hilight_banner owl-carousel">
        <?php if( ! empty($highlightBanner[0]["group_list"][0]["banner_list"]) ): ?>
            <?php foreach($highlightBanner[0]["group_list"][0]["banner_list"] as $idx => $banner): ?>
                    <?php if ($banner['type'] == 1) : ?>
                        <div class="hilight_banner__item">
                            <!-- typeidea script -->
                            <a class="ec-promotion" href="<?php echo $banner['url_link']; ?>"  title="<?php echo $banner['name']; ?>" target="<?php echo $banner['target']; ?>" data-ec-promotion="<?php echo $banner['id']; ?>|<?php echo $banner['name']; ?>|hilight <?php echo $idx+1; ?>" >
                            <!-- //typeidea script -->
                                <img src="<?php echo $banner['img_path'].'?q='.md5($banner['url_link']); ?>" alt="<?php echo $banner['name']; ?>" />
                            </a>
                        </div>
                    <?php elseif($banner['type'] == 2): ?>
                        <div class="hilight_banner__item">
                            <img src="<?php echo $banner['img_path']; ?>" usemap="#hilight_banner<?php echo $idx+1; ?>" alt="<?php echo $banner['name']; ?>" >
                        </div>
                        <?php if ( ! empty($banner['map_area']) ) : ?>
                            <map name="hilight_banner<?php echo $idx+1; ?>">
                                <?php foreach ($banner['map_area'] as $m_key => $m_value) : ?>
                                <area shape="rect" coords="<?php echo $m_value['map_position']; ?>" href="<?php echo $m_value['url_link']; ?>" alt="">
                                <?php endforeach; ?>
                            </map>
                       <?php  endif; ?>
                    <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- typeidea script -->
<script type="text/javascript">
    <?php 
    if( ! empty($highlightBanner[0]["group_list"][0]["banner_list"]) ):
    $ec_banner = array();
    foreach($highlightBanner[0]["group_list"][0]["banner_list"] as $idx => $banner):
        $position = $idx+1;
        array_push($ec_banner, array( 'id' => $banner['id'], 'name' => $banner['name'],'position' => 'hilight ' . $position));
    endforeach; ?>
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
    <?php endif; ?>
</script>
<!-- //typeidea script -->