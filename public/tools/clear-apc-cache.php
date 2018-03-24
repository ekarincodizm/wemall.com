<?php

if (! function_exists('apc_clear_cache'))
{
    echo "Call to undefined function apc_clear_cache()";
    exit();
}

if (apc_clear_cache('opcode') == false || apc_clear_cache('user') == false) {
    echo "Unable to clear apc cache.";
}

echo "Clear apc cache successfully.";