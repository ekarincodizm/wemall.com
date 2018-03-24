<div class="hilightbanner">
    <div class="hilightbanner-container">
        <ul class="hilightbanner-wrapper" id="basic-modal">
            <?php if ( ! empty($banners['position_2']['group_list'])) : ?>
            
            <?php foreach ($banners['position_2']['group_list'] as $g_key => $g_value) : ?>
            <?php if ( ! empty($g_value['banner_list'])) : ?>
            <?php foreach ($g_value['banner_list'] as $b_key => $b_value) : ?>
            <li>         
                
                <?php if ($b_value['type'] == 1) : ?>
                    <a href="<?php echo $b_value['url_link']; ?>" title="<?php echo $b_value['name']; ?>"><img src="<?php echo $b_value['img_path']; ?>" usemap="#hilight_banner<?php echo $b_key; ?>" alt="<?php echo $b_value['name']; ?>" ></a>
                <?php elseif ($b_value['type'] == 2) : ?>      
                    <img src="<?php echo $b_value['img_path']; ?>" usemap="#hilight_banner<?php echo $b_key; ?>" alt="<?php echo $b_value['name']; ?>" >
                

                    <?php if ( ! empty($b_value['map_area'])) : ?>
                    <map name="hilight_banner<?php echo $b_key; ?>">
                        <?php foreach ($b_value['map_area'] as $m_key => $m_value) : ?>
                        <area shape="rect" coords="<?php echo $m_value['map_position']; ?>" href="<?php echo $m_value['url_link']; ?>" alt="">
                        <?php endforeach; ?>
                    </map>
                    <?php endif; ?>
               <?php  endif; ?> 
               
            </li>
            <?php endforeach; ?>
            <?php endif; ?>            
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?php #d($banners); ?>