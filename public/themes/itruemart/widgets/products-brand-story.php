<div class="brand-story">

    <div class="brand_banner_pic">
        <?php if (!empty($metas['banner'])) { ?>
            <img src="<?php echo $metas['banner'] ?>" alt="">
        <?php } elseif (!empty($metas['banner-logo'])) { ?>
            <img src="<?php echo $metas['banner-logo'] ?>" alt="">
        <?php } else { ?>
            <img src="http://cdn.itruemart.com/files/edm/14/02/25/xxx/ComingSoon-brand-banner.jpg" width="627" height="290" alt="">
        <?php } ?>
    </div>


    <?php /*
    <div class="brand_banner_pic">
        <?php if (!empty($metas['banner'])) : ?>
            <img src="<?php echo $metas['banner']; ?>" alt="">
        <?php else: ?>
            <img src="http://cdn.itruemart.com/files/brand/1048/1048_627x290_1374723094.jpg" width="627" height="290" alt="A Bird">
        <?php endif; ?>
    </div>
    */ ?>

    <div style="width:343px;height:290px;float:left;">
        <div class="levelB_container_03">
            <div style=" float: left; margin: 6px 0px 0px 7px; ">
            <?php if (!empty($metas['video'])) { ?>
                <iframe width="329" height="173" src="<?php echo ($metas['video']) ? $metas['video'] : "//www.youtube-nocookie.com/embed/fbbDP65k7NA"; ?>" frameborder="0"></iframe>
            <?php } ?>
            </div>
        </div>
        <div class="levelB_container_04">
            <div class="brandstory">
                <div class="brandstory_head"><?php echo __("brands-story-title"); ?></div>
                <div class="brandstory_line">
                    <div class="brandstory_content">
                        <div class="brandstory_options">
                            <ul>
                                <li>
                                    <?php if (!empty($description)) { echo $description; }  ?>
                                    <?php /* if (!empty($metas['history'])) { echo $metas['history']; } */ ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>