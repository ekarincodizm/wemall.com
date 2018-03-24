<?php

$file_url ='//cdn.dev.itruemart.com/pcms/banners/102/136.jpg';

$file_list = explode('/',$file_url);

$file_name = $file_list[(count($file_list) -1)];

echo $file_name.'</br>';

if (!copy($file_url, './uploads/branners/'.$file_name)) {
    echo "failed to copy $file_name...\n";
}

?>