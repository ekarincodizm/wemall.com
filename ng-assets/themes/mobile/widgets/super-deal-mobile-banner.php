 
<?php if ( !empty($banner["group_list"][0]["banner_list"][0]) ): ?>
    <?php $bannerData = $banner["group_list"][0]["banner_list"][0]; ?>
    <div class="sd-banner">
        <a href="<?php echo (!empty($bannerData["url_link"]))? $bannerData["url_link"] : "#"; ?>" target="<?php echo ($bannerData["target"])? $bannerData["target"] : "_blank" ; ?>">
            <img alt="<?php echo ($bannerData["name"])? $bannerData["name"] : ""; ?>" src="<?php echo ($bannerData["img_path"])? $bannerData["img_path"] : "#"; ?>" style="height: auto; width: 100%;"/>
        </a>
    </div>
<?php endif; ?>