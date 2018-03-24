<div class="breadcrumb__bg" style="margin-top: 0px;">
<div class="breadcrumb__inner_wrapper">
    <!-- <ul class="breadcrumb__link">

        <li>
            <a href="#">
                Home
            </a>
        </li>
        <li>
            <a href="#">
                สมาร์ทโฟน และอุปกรณ์
            </a>
        </li>
        <li>
            <a href="#">
                สมาร์ทโฟน
            </a>
        </li>

    </ul> -->
    <!-- get breadcrumbs paths -->
    <div class="breadcrumb">
        <div id="link_map">
            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                <a class="map" itemprop="url" href="http://www.itruemart.com/" title="Home">
                    <!-- <span itemprop="title"><?php //echo __('Shopping On-line'); ?></span> -->
                    <span itemprop="title"><?php echo __('home'); ?></span>
                </a>
            </span>
            <?php echo Theme::breadcrumb()->render(); ?>
        </div>
    </div>

    <div class="campaign_banner">
        <!-- get link of banner from pcms -->
        <a href=<?php echo $banners['url_link']; ?> >
            <!-- get banner from pcms -->
            <!-- <img src="images/banner/campaign-banner.jpg"> -->
            <img src=<?php echo $banners['img_path']; ?> alt="">
        </a>
    </div>
</div>
</div>