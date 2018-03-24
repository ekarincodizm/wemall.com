<?php
if (!empty($content)) {
    echo htmlspecialchars_decode($content);
} else {
    echo '<div style="text-align:center; margin:200px 0; font: bold 27px Tahoma;">' . PHP_EOL;
    echo 'Sorry! Not found your content' . PHP_EOL;
    echo '</div>' . PHP_EOL;
}
?>