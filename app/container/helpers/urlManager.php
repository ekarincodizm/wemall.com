<?php

function levelDUrl($productSlug = NULL, $productPkey = NULL) 
{
	if (is_null($productSlug) OR empty($productSlug))
	{
		$productSlug = "item";
	}
	if (is_null($productPkey) OR !isset($productPkey))
	{
		return NULL; 
	}

	$level_d_url = Config::get('url_manager.level_d_url');

	$search = array(
		'{PRODUCT_SLUG}', '{PRODUCT_PKEY}'
	);
	$replace = array(
		$productSlug, $productPkey
	);

	$url =  URL::toLang(str_replace($search, $replace, $level_d_url));
    $url = preg_replace("/--/","-" , $url);
    return $url;
}
function newsLevelBUrl($cate_slug = NULL, $cate_id = NULL)
{
	if (is_null($cate_slug) OR empty($cate_slug))
	{
		return NULL; 
	}
	if (is_null($cate_id) OR !isset($cate_id))
	{
		return NULL; 
	}
	#$CI =& get_instance();
	#$CI->load->config('url_config');
	#sd($cate_slug);
	$level_b_url = Config::get('url_manager.news_level_b_url');

	$search = array(
						'{CATEGORY_SLUG}', '{CATEGORY_ID}'
					);
	if (is_array($cate_slug))
	{
		foreach ($cate_slug as $key => $value) 
		{
			$new_cate[] = urlTitle($value);
		}
		$cate_path = implode("_", $new_cate); 
	}
	else
	{
		$cate_path = urlTitle($cate_slug); 
	}
	$replace= array(
						$cate_path, $cate_id
					);

	return URL::toLang(str_replace($search, $replace, $level_b_url));
	
}

function newsLevelDUrl($news_slug = NULL, $newsID = NULL) 
{	
	if (is_null($news_slug) OR empty($news_slug))
	{
		return NULL;
	}
	if (is_null($newsID) OR empty($newsID))
	{
		return NULL;
	}
	
	#Config::get('app.timezone');
	#$CI->load->config('url_config');
	$level_d_url = Config::get('url_manager.news_level_d_url');

	$search = array(
						'{NEWS_SLUG}', '{NEWS_ID}'
					);

	$replace= array(
						urlTitle($news_slug), $newsID
					);
	
	return URL::toLang(str_replace($search, $replace, $level_d_url));
}

function urlTitle($str, $separator = 'dash')
{
	if ($separator == 'dash')
	{
		$search		= '_';
		$replace	= '-';
	}
	else
	{
		$search		= '-';
		$replace	= '_';
	}

	$str = strtolower($str); 
	
	$trans = array(
					$search								=> $replace,
					"\""							=> '',
					'\\\\'							=> '',
					'\s+'							=> $replace,
					'\/'							=> $replace,
					" "								=> $replace,
					"\."								=> '',
					"\#"							=> '',
					"\("								=> '',
					"\)"								=> '',
					"\?"								=> '',
					"\:"								=> '',
					"\;"								=> '',
					"\'"								=> '',
					","									=> '',
					"\&"									=> '',
					"\%"								=> '',
					"@"								=> '',
					"\*"								=> '',
					"\+"								=> '',
					$replace."+"						=> $replace,
					$replace."$"						=> '',
					"^".$replace						=> ''
				   );

	foreach ($trans as $key => $val)
	{
		$str = preg_replace("/".$key."/", $val, $str);
	}
	$str = strtolower($str); 

	return trim(stripslashes($str));
}

if ( ! function_exists('url_title'))
{
    function url_title($str, $separator = 'dash', $lowercase = FALSE)
    {
        if ($separator == 'dash')
        {
            $search		= '_';
            $replace	= '-';
        }
        else
        {
            $search		= '-';
            $replace	= '_';
        }

        $trans = array(
            '&\#\d+?;'				=> '',
            '&\S+?;'				=> '',
            '\s+'					=> $replace,
            '[^a-z0-9\-\._]'		=> '',
            $replace.'+'			=> $replace,
            $replace.'$'			=> $replace,
            '^'.$replace			=> $replace,
            '\.+$'					=> ''
        );

        $str = strip_tags($str);

        foreach ($trans as $key => $val)
        {
            $str = preg_replace("#".$key."#i", $val, $str);
        }

        if ($lowercase === TRUE)
        {
            $str = strtolower($str);
        }

        $str = strtolower($str);
        if(substr($str,0,1) == '-')
        {
            $str = substr($str,1,(strlen($str)-1));
        }
        return trim(stripslashes($str));
    }
}

