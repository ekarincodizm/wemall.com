<!-- Start NewDesign -->
<div class="container-sharing">
    <span>SHARING</span>
  

    <!--a onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" 
        href="http://widget.mylife.truelife.com/?p=share&k=itruemart_24262&cate=2&subcate=0&url=<?php echo get_permalink('products', $product) ?>&thumbnail=<?php echo  array_get($product, 'image_cover.thumbnails.square'); ?>" class="inline ml_share" rel="nofollow"  data-share="[thumbnail=<?php echo  array_get($product, 'image_cover.thumbnails.square'); ?>,entry_id=22250]"  >
        <img src="<?php echo Theme::asset()->url('images/icon-share-1.jpg') ?>" class="block" alt="MyLife" />
    </a-->

<!--     <a onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="http://widget.mylife.truelife.com/?p=popuplogin&action=loginandshare&k=itruemart_22250&cate=2&subcate=0&page=0&url=<?php echo URL::route('products.detail', $product['pkey']) ?>" class="inline ml_share" rel="nofollow"  data-share="[thumbnail=http://cdn.itruemart.com/files/product/1254/22250/5BIdaAtunp7LQC80VXjV1cJvwNPs3gTK2eE6WhvbDGMkU4mZSrOilzqoHxFfR9_thumb.jpg,entry_id=22250]"  >
        <img src="http://www.itruemart.com/assets/itruemart_new/global/images/icon-share-1.jpg" class="block" alt="MyLife" />
    </a> -->

    <a onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink('products', $product) ?>" target="_blank" class="inline fb_share" rel="nofollow">
        <img src="<?php echo Theme::asset()->url('images/icon-share-2.jpg') ?>" class="block" alt="Facebook" />
    </a>

    <a onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="//twitter.com/share?via=iTruemart&url=<?php echo get_permalink('products', $product) ?>&text=<?php echo $product['title'];?>" class="inline tw_share" rel="nofollow">
        <img src="<?php echo Theme::asset()->url('images/icon-share-4.jpg') ?>" class="block" alt="twitter" />
    </a>
    
    <a onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="//www.pinterest.com/pin/create/button/?url=<?php echo get_permalink('products', $product) ?>&media=<?php echo  array_get($product, 'image_cover.thumbnails.square'); ?>&description=<?php echo $product['title'];?>" class="inline pt_share" rel="nofollow"  data-share="[thumbnail=<?php echo  array_get($product, 'image_cover.thumbnails.square'); ?>]"  >
        <img src="<?php echo Theme::asset()->url('images/icon-share-5.jpg') ?>" class="block" alt="pinterrest" />
    </a>

    <a href="https://plus.google.com/share?url=<?php echo get_permalink('products', $product) ?>" 
    onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="inline" rel="nofollow">
        <img src="<?php echo Theme::asset()->url('images/icon-share-6.jpg') ?>" class="block" alt="google"/>
    </a>

</div>
<!-- End NewDesign -->