<div class="home__inner_wrapper">
    <div class="hilight_banner owl-carousel">
        <?php if( ! empty($highlightBanner[0]["group_list"][0]["banner_list"]) ): ?>
            <?php foreach($highlightBanner[0]["group_list"][0]["banner_list"] as $idx => $banner): ?>
                    <?php if ($banner['type'] == 1) : ?>
                        <div class="hilight_banner__item">
                            <a href="<?php echo $banner['url_link']; ?>"  title="<?php echo $banner['name']; ?>">
                                <img src="<?php echo $banner['img_path']; ?>" alt="<?php echo $banner['name']; ?>" />
                            </a>
                        </div>
                    <?php elseif($banner['type'] == 2): ?>
                        <div class="hilight_banner__item">
                            <img src="<?php echo $banner['img_path']; ?>" usemap="#hilight_banner<?php echo $idx; ?>" alt="<?php echo $banner['name']; ?>" >
                        </div>
                        <?php if ( ! empty($banner['map_area']) ) : ?>
                            <map name="hilight_banner<?php echo $idx; ?>">
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