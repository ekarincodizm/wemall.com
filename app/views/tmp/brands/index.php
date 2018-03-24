<div class="content-home sub">
    <div class="breadcrumbs">
        <div id="link_map">
            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                <a class="map" itemprop="url" href="http://<?php echo Request::server ("SERVER_NAME"); ?>/" title="<?php echo __('Shopping On-line'); ?>">
                    <span itemprop="title"><?php echo __('Shopping On-line'); ?></span>
                </a>
            </span>
            <?php echo Theme::breadcrumb()->render(); ?>
        </div>
    </div>
    <div id="wrapper_content">
        <div id="shop-by-brand">

            <!-- Brand Menu List -->
            <?php if (!empty($collections)) { ?>
                <div id="menu">
                    <div class="header">SHOP ALL BRANDS</div>

                    <?php echo Theme::widget('shopbybrandCategoryMenu', array('collections' => $collections, 'currentPkey' => $currentPkey))->render(); ?>

                </div>
            <?php } ?>

            <!-- Brand List -->
            <div id="brand-list">
                <div id="banner-top">
                    <img src="http://<?php echo Request::server ("SERVER_NAME"); ?>/assets/itruemart_new/global/images/banner-temp.jpg">
                </div>

                <?php if (!empty($brands)) { ?>
                    <ul id="bl-container">
                        <?php if (!empty($brands['others'])) { ?>
                        <li>
                            <h2>#</h2>
                            <ul class="bl-box">
                                <?php foreach ($brands['others'] as $brand) { ?>
                                <li>
                                    <a href="<?php echo route('brands.products', $brand['pkey']) ?>" title="<?php echo $brand['name'] ?>"><?php echo $brand['name'] ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php foreach ($brands as $key => $subArr) { ?>
                            <?php if ($key == 'others') continue; ?>
                            <li>
                                <h2><?php echo strtoupper($key) ?></h2>
                                <ul class="bl-box">
                                    <?php foreach ($subArr as $brand) { ?>
                                    <li>
                                        <a href="<?php echo route('brands.products', $brand['pkey']) ?>" title="<?php echo $brand['name'] ?>"><?php echo $brand['name'] ?></a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>

                <div class="clearfix">
                </div>
            </div>

        </div>
    </div>
</div>