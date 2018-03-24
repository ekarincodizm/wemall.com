<?php

function jsonUnescapedUnicode($str)
{
    $unescaped = preg_replace_callback('/\\\u(\w{4})/', function ($matches) {
        return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
    }, $str);
    return $unescaped;
}


