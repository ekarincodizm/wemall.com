<div class="home__middle_banner">
    <ul class="accordion_banner">

        <?php if (array_key_exists('acc_banner1', $banners)) {
            $key = 'acc_banner1'; ?>
            <li class="ac_banner_1">
                <a href="<?php echo $banners[$key]['url_link'];?>">
                    <img src="<?php echo $banners[$key]['img_path']; ?>" />
                </a>
            </li>
        <?php } ?>

        <?php if (array_key_exists('acc_banner2', $banners)) {
            $key = 'acc_banner2'; ?>
            <li class="ac_banner_2">
                <a href="<?php echo $banners[$key]['url_link']; ?>">
                    <img src="<?php echo $banners[$key]['img_path']; ?>" />
                </a>
            </li>
        <?php } ?>

        <?php if (array_key_exists('acc_banner3', $banners)) {
            $key = 'acc_banner3'; ?>
            <li class="ac_banner_3 open">
                <a href="<?php echo $banners[$key]['url_link']; ?>">
                    <img src="<?php echo $banners[$key]['img_path']; ?>" />
                </a>
            </li>
        <?php } ?>

    </ul>
</div>