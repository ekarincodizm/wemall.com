<div id="superdeal">
    <?php echo Theme::widget("superDealDaily", array())->render(); ?>
    <?php
    if(Input::get('frefresh') == '1')
    {
    ?>
    <script type="text/javascript">
            <?php
                //window.location = location + '?no-cache=1&frefresh=1';
                echo "window.location = '".URL::route('superdeal')."';";
            ?>

    </script>
    <?php
    }
    ?>
    <?php echo Theme::widget("superDealBanner", array())->render(); ?>

    <?php echo Theme::widget("productThumbnail", array())->render(); ?>
</div>