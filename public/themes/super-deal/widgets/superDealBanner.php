<?php if ( !empty($banner["group_list"][0]["banner_list"][0]) ): ?>
    <?php $bannerData = $banner["group_list"][0]["banner_list"][0]; ?>
    <div class="sd-banner">
        <a href="<?php echo (!empty($bannerData["url_link"]))? $bannerData["url_link"] : "#"; ?>" target="<?php echo ($bannerData["target"])? $bannerData["target"] : "_blank" ; ?>">
            <img src="<?php echo ($bannerData["img_path"])? $bannerData["img_path"] : "#"; ?>" <?php if(!empty($bannerData["width"])){ echo "width='".$bannerData["width"]."'"; } ?> <?php if(!empty($bannerData["height"])){ echo "height='".$bannerData["height"]."'"; } ?> />
        </a>
    </div>
<?php endif; ?>