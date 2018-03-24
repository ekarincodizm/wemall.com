<div class="content-home sub">
    <div class="breadcrumbs">
        <div id="link_map">
            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                <a class="map" itemprop="url" href="http://www.itruemart.com/" title="ช้อปปิ้งออนไลน์">
                    <span itemprop="title"><?php echo __('ช้อปปิ้งออนไลน์'); ?></span>
                </a>
            </span>
            <?php echo Theme::breadcrumb()->render(); ?>
        </div>
    </div>			
    <div id="news" style="margin-left:150px;">
        <div id="banner-header">
            <img src="http://www.itruemart.com/assets/itruemart_new/global/images/news/banner-header-news.jpg">
        </div>
        <!-- Update -->
        <?php echo Theme::widget('newsUpdate')->render(); ?>

        <div id="main-content">
            <?php $lang = App::getLocale(); ?>	
            <?php if ( !empty($data) ): ?>
                <?php //alert($data, 'red');die;?>
                <div id="news-category">
                    <?php
                    echo Theme::widget('newsCategory', array('category_id' => !empty($data['term_id']) ? $data['term_id'] : ""))->render();
                    ?>
                    <div class="clearfix"></div>
                    <ul id="news-category-list">
                        <li class="news-category-item">
                            <span class="title">
                                <?php if ( !empty($data['language'][$lang]['title']) ): ?>
                                    <?php echo $data['language'][$lang]['title']; ?>
                                <?php endif; ?>
                            </span> 
                            <span class="date-modify"><?php echo date('F, d, Y', strtotime($data['create_date'])); ?></span>
                            <div class="news-desc">
                                <!-- Content News Here -->
                                <p style="text-align: center"><img src="<?php echo $data['news_images']['path_big']; ?>"/></p>
                                <p>
                                    <?php if ( !empty($data['language'][$lang]['short_description']) ): ?>
                                        <strong><?php echo $data['language'][$lang]['short_description']; ?></strong>
                                    <?php endif; ?>
                                </p>
                                <p>
                                    <?php if ( !empty($data['language'][$lang]['description']) ): ?>
                                        <?php echo $data['language'][$lang]['description']; ?>
                                    <?php endif; ?>
                                </p>
                                <!-- Content News Here -->
                            </div>
                            <div class="social-container">
                                <div class="sc-box head">
                                    SHARE TO YOUR FRIENDS:
                                </div>
                                <div class="sc-box">
                                    <a target="_blank" href="https://twitter.com/share?url=<?php echo newsLevelDUrl($data['language'][$lang]['title_slug'], $data['news_id']); ?>">
                                        <img src="<?php echo '/themes/itruemart/assets/images/news/icon-news-tw-on.jpg'; ?>" height="30" width="30" alt="Share on Twitter"/>
                                    </a>
                                </div>
                                <div class="sc-box">
                                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo newsLevelDUrl($data['language'][$lang]['title_slug'], $data['news_id']); ?>">
                                        <img src="<?php echo '/themes/itruemart/assets/images/news/icon-news-fb-on.jpg'; ?>" height="30" width="30" alt="Share on Facebook"/>
                                    </a>
                                </div>
                                <div class="sc-box">
                                    <a href="https://plus.google.com/share?url=<?php echo newsLevelDUrl($data['language'][$lang]['title_slug'], $data['news_id']); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                                        <img src="https://www.gstatic.com/images/icons/gplus-32.png" height="30" width="30" alt="Share on Google+"/>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            <?php else: ?>
                ไม่พบ
            <?php endif; ?>
            <?php echo Theme::widget('newsFbBox')->render(); ?>
        </div>
        <?php echo Theme::widget('newsSide')->render(); ?>
    </div>					
</div>
</div>