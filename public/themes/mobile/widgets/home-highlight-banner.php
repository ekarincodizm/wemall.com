
<?php $count = 0; ?>
<?php if ( ! empty($banners['position_2']['group_list'])) : ?>
    <?php foreach ($banners['position_2']['group_list'] as $g_key => $g_value) : ?>
        <?php if ( ! empty($g_value['banner_list'])) : ?>
            <?php foreach ($g_value['banner_list'] as $b_key => $b_value) : ?>
                <?php $count++; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php for ($i=0; $i < $count; $i++): ?>
            <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i; ?>"<?php echo $i == 0 ? ' class="active"' : ''; ?>></li>
        <?php endfor; ?>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">

    <?php if ( ! empty($banners['position_2']['group_list'])) : ?>
    <?php foreach ($banners['position_2']['group_list'] as $g_key => $g_value) : ?>
    <?php if ( ! empty($g_value['banner_list'])) : ?>
    <?php foreach ($g_value['banner_list'] as $b_key => $b_value) : ?>

    <div class="item<?php echo $g_key == 0 && $b_key == 0 ? ' active' : ''; ?>">
        <?php if ($b_value['type'] == 1) : ?>
            <!-- URL Link -->
            <!-- typeidea script -->
            <a target="<?php echo $b_value['target'] ; ?>" href="<?php echo $b_value['url_link']; ?>" title="<?php echo $b_value['name']; ?>" class="ec-promotion" data-ec-promotion="<?php echo $b_value['id']; ?>|<?php echo $b_value['name']; ?>|hilight <?php echo $b_key+1; ?>"><img src="<?php echo $b_value['img_path'].'?q='.md5($b_value['url_link']); ?>"></a>
            <!-- //typeidea script -->
        <?php elseif ( ! empty($b_value['map_area'])) :?>
            <!-- Maparea -->
            <img src="<?php echo $b_value['img_path']; ?>" usemap="#hilight_banner<?php echo $b_key;?>" alt="<?php echo htmlspecialchars($b_value['name']); ?>" >
            <map name="hilight_banner<?php echo $b_key;?>">
                <?php foreach ($b_value['map_area'] as $m_key => $m_value) : ?>
                    <area shape="rect" coords="<?php echo $m_value['map_position']; ?>" href="<?php echo $m_value['url_link']; ?>" alt="<?php echo $m_value['tag_alt']; ?>">
                <?php endforeach; ?>
            </map>
        <?php else: ?>
            <img src="<?php echo $b_value['img_path']; ?>">
        <?php endif; ?>

        <?php /*
        <?php if ($b_value['type'] == 1) : ?>
            <a href="<?php echo $b_value['url_link']; ?>" title="<?php echo $b_value['name']; ?>"><img src="<?php echo $b_value['img_path']; ?>" usemap="#hilight_banner<?php echo $b_key; ?>" alt="<?php echo $b_value['name']; ?>" ></a>
        <?php elseif ($b_value['type'] == 2) : ?>
            <img src="<?php echo $b_value['img_path']; ?>" usemap="#hilight_banner<?php echo $b_key; ?>" alt="<?php echo $b_value['name']; ?>" >


            <?php if ( ! empty($b_value['map_area'])) : ?>
            <map name="hilight_banner<?php echo $b_key; ?>">
                <?php foreach ($b_value['map_area'] as $m_key => $m_value) : ?>
                <area shape="rect" coords="<?php echo $m_value['map_position']; ?>" href="<?php echo $m_value['url_link']; ?>" alt="">
                <?php endforeach; ?>
            </map>
            <?php endif; ?>
        <?php  endif; ?>
        */ ?>

    </div>

    <?php endforeach; ?>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>

  <!--
    <div class="item active">
      <img src="<?php echo URL::asset('themes/mobile/assets/img/test_slide_01.jpg'); ?>" >
    </div>
    <div class="item">
      <img src="<?php echo URL::asset('themes/mobile/assets/img/test_slide_02.jpg'); ?>" >
    </div>
    <div class="item">
      <img src="<?php echo URL::asset('themes/mobile/assets/img/test_slide_03.jpg'); ?>" >
    </div>

    -->
    </div>
    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
<!-- typeidea script -->
<script type="text/javascript">
<?php $ec_banner = array(); ?>
<?php if( ! empty($g_value['banner_list']) ): ?>
    <?php 
    foreach($g_value['banner_list'] as $idx => $banner):
        $position = $idx+1;
        array_push($ec_banner, array( 'id' => $banner['id'], 'name' => $banner['name'],'position' => 'hilight ' . $position));
    endforeach; ?>
<?php endif; ?>
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
</script>
<!-- //typeidea script -->

