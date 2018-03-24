<?php

if (!empty($content)) {

    if(!empty($campaign_css)){
        echo HTML::style($campaign_css);
    }

    echo htmlspecialchars_decode($content);

    if(!empty($campaign_js)){
        echo HTML::script($campaign_js);
    }

} else {
    echo '<div style="text-align:center; margin:200px 0; font: bold 27px Tahoma;">' . PHP_EOL;
    echo 'Sorry! Not found your content' . PHP_EOL;
    echo '</div>' . PHP_EOL;
}
