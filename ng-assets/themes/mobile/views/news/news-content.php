<?php
$lang = App::getLocale();

?>

<div class="row">
    <div class="col-xs-12"><h1 style="color:#95c126;"><?php if ( !empty($data['language'][$lang]['title']) ): ?>
                <?php echo $data['language'][$lang]['title']; ?>
            <?php endif; ?></h1></div>
</div>
<!-- Content -->
<!-- ใช้ grid ของ bootstrap ในการวาง -->
<div class="row detail_content">
    <div class="col-xs-12">
        <?php
        if(isset($data['news_images']))
        {
        ?>
            <p style="text-align: center"><img src="<?php echo $data['news_images']['path_big']; ?>"/></p>
        <?php
        }
        ?>
        <?php if ( !empty($data['language'][$lang]['short_description']) ): ?>
            <strong><?php echo $data['language'][$lang]['short_description']; ?></strong>
        <?php endif; ?>
        
        <?php if ( !empty($data['language'][$lang]['description']) ): ?>
            <?php echo $data['language'][$lang]['description']; ?>
        <?php endif; ?>
    </div>
</div>

<div class="row back-to-detail">
    <div class="col-xs-12">
        <a href="/"><?php echo __('thankyou-goto-home'); ?></a>
    </div>
</div>