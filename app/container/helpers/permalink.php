<?php

function get_permalink($firstUriSegment, $data = array())
{
    $uri = $firstUriSegment;

    if(!isset($data['slug']) || empty($data['slug']))
    {
        if(isset($data['title']))
        {
            $data['slug'] = url_title($data['title']);
        }else{
            if(isset($data['name']))
            {
                $data['slug'] = url_title($data['name']);
            }
        }
    }

    if ( !empty($data['pkey']) )
    {
        if ( !empty($data['slug']) )
        {
            $uri .= "/{$data['slug']}-{$data['pkey']}.html";
        }
        else
        {
            $uri .= "/{$data['pkey']}.html";
        }
    }


    // return URL::to($uri);
    return URL::toLang($uri);
}

// check url
function isURL($pattern, $isCLI = false)
{
    $path = Request::path();
    return (
            (bool) preg_match('#^'.$pattern.'$#', $path)
            && App::runningInConsole() == $isCLI
            && Input::get('route') != "default"
            );
}