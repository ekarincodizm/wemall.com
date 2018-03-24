<div class="breadcrumb__bg" style="margin-top: 0px; <?php if($showBanner == true):?><?php echo isset($banners['description']) ? 'background-color: '.$banners['description'] : ''; ?><?php endif;?>">
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
    <ul class="breadcrumb__link">
            <li><a href="<?php echo URL::tolang('/');?>"><?php echo __('home')." "; ?></a></li>
            <?php echo Theme::breadcrumb()->render(); ?>
    </ul>
	<?php if($showBanner == true):?>
        <div class="campaign_banner">
        <!-- get link of banner from pcms -->
        <a href=<?php echo $banners['url_link']; ?> >
            <!-- get banner from pcms -->
            <!-- <img src="images/banner/campaign-banner.jpg"> -->
            <img src="<?php echo $banners['img_path']; ?>" alt="">
        </a>
    </div>
    <script type="text/javascript">
        $('.home__container').css({
            width: '100%',
            paddingLeft: '0px',
            paddingRight: '0px'
        })
    </script>
    <?php endif;?>
</div>
</div>
