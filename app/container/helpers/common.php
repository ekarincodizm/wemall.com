<?php
/**
 * @author Preme W. <preme_won@truecorp.co.th>
 * @since   Jan 28, 2014
 * @version  1.0
 */
if (!function_exists('alert')) {
    function alert($str, $color = '#000000', $message = NULL, $debug = FALSE)
    {
        if (!empty($message)) {
            echo '<h1 style="color:' . $color . '">' . $message . '</h1>';
        }
        print "<pre><font color=\"" . $color . "\">";
        if ($debug == TRUE) {
            echo '<h3></h3>';
        }
        print_r($str);
        if ($debug == TRUE) {
            echo '<h3>=========== Debug Backtrace ==============</h3>';
            print_r(debug_backtrace());
        }
        print "</font></pre>";
    }
}

if (!function_exists('alertd')) {
    function alertd($str, $color = '#000000', $message = NULL, $debug = FALSE)
    {
        if (!empty($message)) {
            echo '<h1 style="color:' . $color . '">' . $message . '</h1>';
        }
        print "<pre><font color=\"" . $color . "\">";
        if ($debug == TRUE) {
            echo '<h3></h3>';
        }
        print_r($str);
        if ($debug == TRUE) {
            echo '<h3>=========== Debug Backtrace ==============</h3>';
            print_r(debug_backtrace());
        }
        print "</font></pre>";
        exit;
    }
}

/**
 * @todo convert len for utf8
 * @return length
 */
if (!function_exists('utf8_strlen')) {
    function utf8_strlen($s)
    {
        $c = strlen($s);
        $l = 0;
        for ($i = 0; $i < $c; ++$i) if ((ord($s[$i]) & 0xC0) != 0x80) ++$l;
        return $l;
    }
}

/**
 * Read seo config and set meta
 */
if (!function_exists('setSeoMeta')) {
    function setSeoMeta($name)
    {
        $escapeAttribute = function ($string) {
            return addcslashes($string, '"');
        };

        $title = Config::get("seo.{$name}.title");
        if ($title) {
            Theme::setTitle($title);
        }

        $description = Config::get("seo.{$name}.description");
        if ($description) {
            Theme::setMetadescription($escapeAttribute($description));
        }

        $keywords = Config::get("seo.{$name}.keywords");
        if ($keywords) {
            Theme::setMetakeywords($escapeAttribute($keywords));
        }
    }
}


/**
 * @todo strip word
 * @return string
 */
if (!function_exists('strip_words')) {
    function strip_words($word, $lchar = 140, $replace = "...")
    {
        $text = mb_substr(strip_tags(htmlspecialchars_decode($word)), 0, $lchar, 'UTF-8');
        if ((utf8_strlen($word)) > $lchar) {
            $text = $text . $replace;
        }
        return $text;
    }
}

/**
 * Create a Random String
 *
 * Useful for generating passwords or hashes.
 *
 * @access    public
 * @param    string    type of random string.  basic, alpha, alunum, numeric, nozero, unique, md5, encrypt and sha1
 * @param    integer    number of characters
 * @return    string
 */
if (!function_exists('random_string')) {
    function random_string($type = 'alnum', $len = 8)
    {
        switch ($type) {
            case 'basic'    :
                return mt_rand();
                break;
            case 'alnum'    :
            case 'numeric'    :
            case 'nozero'    :
            case 'alpha'    :

                switch ($type) {
                    case 'alpha'    :
                        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'alnum'    :
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'numeric'    :
                        $pool = '0123456789';
                        break;
                    case 'nozero'    :
                        $pool = '123456789';
                        break;
                }

                $str = '';
                for ($i = 0; $i < $len; $i++) {
                    $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
                }
                return $str;
                break;
            case 'unique'    :
            case 'md5'        :

                return md5(uniqid(mt_rand()));
                break;
        }
    }
}

function insightDate($datetime = NULL, $lang = 'th')
{
    # $datetime format is Y-m-d H:i:s
    if ($datetime != NULL) {
        if ($lang == 'th') {
            $my_date = explode(' ', $datetime);
            if (count($my_date) == 2) {
                $my_date_2 = explode('-', $my_date[0]);
                $d = $my_date_2[2];
                $month = array_month($lang);
                $m = $month[(int)$my_date_2[1]];
                $y = $my_date_2[0] + 543;

                return $d . " " . $m . " " . $y;
            } else {
                return NULL;
            }
        } else {
            list($date, $time) = explode(" ", $datetime);
            list($year, $month, $day) = explode("-", $date);
            list($hour, $minute, $second) = explode(":", $time);
            $timestamp = mktime((int)$hour, (int)$minute, (int)$second, (int)$month, (int)$day, (int)$year);

            #June 20, 2013
            return date("M d, Y", $timestamp);
        }
    } else {
        return NULL;
    }

}

function array_month($language = NULL)
{
    if ($language == 'th') {
        $arr = array(1 => "มกราคม", 2 => "กุมภาพันธ์", 3 => "มีนาคม", 4 => "เมษายน", 5 => "พฤษภาคม", 6 => "มิถุนายน", 7 => "กรกฎาคม", 8 => "สิงหาคม", 9 => "กันยายน", 10 => "ตุลาคม", 11 => "พฤศจิกายน", 12 => "ธันวาคม");
    } else {
        $arr = array(1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June", 7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December");
    }
    return $arr;
}

function is_html($string)
{
    return preg_match("/<[^<]+>/", $string, $m) != 0;
}


if (!function_exists("url_no_protocal")) {
    function url_no_protocal($url = "", $params = array(), $url_lang = 'Y')
    {
        if ($url_lang == 'Y') {
            $tmp_url = URL::toLang($url, $params);
        } else {
            $tmp_url = URL::to($url, $params);
        }
        return preg_replace("/^(http:|https:)/i", "", $tmp_url);
    }
}

if (!function_exists("tracking_type")) {
    function tracking_type($number = "")
    {
        $number = (string)$number;
        if (empty($number)) {
            return "";
        }
        $number += "1";

        if (preg_match("/^(E|R)*(TH)$/i", $number)) {
            // Thai Post. EX. EKxxxxxxxxxTH(ขึ้นต้นด้วยตัว E , ตามมาด้วย ตัวอักษร 1 ตัว เช่น K หรือ J, ตามมาด้วยเลข 9 หลัก และตามด้วย TH) , RHxxxxxxxxxTH(ขึ้นต้นด้วยตัว R , ตามมาด้วย ตัวอักษร 1 ตัว เช่น H หรือ G, ตามมาด้วยเลข 9 หลัก และตามด้วย TH) 
            return "THP";
        } elseif (preg_match("/^[0-9]{6}$/i", $number)) {
            // Alpha Tracking. Note:Tracking ==> xxxxxx  (เป็นตัวเลข 6 หลัก)
            return "ALPHA";
        } elseif (preg_match("/^[0-9]{8}$/i", $number)) {
            //Genius Tracking ==> xxxxxxxx  (เป็นตัวเลข 8 หลัก)
            return "GENIUS";
        } elseif (preg_match("/^[0-9]{9}$/i", $number)) {
            // TNT. Tracking ==> xxxxxxxxx  (เป็นตัวเลข 9 หลัก) 
            return "TNT";
        } elseif (preg_match("/^[0-9]{12}$/i", $number)) {
            //CJ Korea Express. Tracking ==> xxxxxxxxxxxx  (เป็นตัวเลข 12 หลัก) เช่น  600001626671 
            return "CJK";
        } else {
            return "";
        }
    }
}

function getGitStatus()
{
    $dir = base_path();//dirname(__FILE__);

    $git_file = $dir . '/version.txt';
    $download_rate = 20.5;
    $file = fopen($git_file, "r");

    while (!feof($file)) {
        // send the current file part to the browser
        $git_version_file = fread($file, round($download_rate * 1024));
        // flush the content to the browser
        flush();
        // sleep one second
        sleep(1);
    }
    fclose($file);

    $git_array = explode("\n", $git_version_file);

    return json_encode(array("message" => "success", "data" => $git_array));
}

function getGitVersion()
{
    $result = getGitStatus();
    return array_get($result, 'commit', date("Y-W"));
}

function getGitStatusProduction()
{
    $branch = null;
    $commit = null;

    $headFile = app_path() . '/../.git/HEAD';

    if (!file_exists($headFile)) {
        return false;
    }

    $head = file_get_contents($headFile);

    preg_match("#refs/heads/(.+)$#", $head, $matches);

    if (!empty($matches[1])) {
        $branch = $matches[1];

        $headFile = app_path() . '/../.git/refs/heads/' . $matches[1];
        if (file_exists($headFile)) {
            $head = file_get_contents($headFile);
            preg_match("#([0-9a-f]+)#", $head, $matches);

            if (empty($matches[1]))
                return false;

            $commit = $matches[1];
        }
    } else {
        $fetchHeadFile = app_path() . '/../.git/HEAD';
        if (file_exists($fetchHeadFile)) {
            $commit = file_get_contents($fetchHeadFile);
            $branch = 'master';

        }

    }

    return compact('branch', 'commit');
}

if (!function_exists('cleanCustomerEmail')) {
    function cleanCustomerEmail($email)
    {
        if (!empty($email) && preg_match("/\@truelife.com$/", $email)) {
            return "";
        }
        return $email;
    }
}

if ( ! function_exists('generate_string'))
{
    function generate_string($length = 30, $start_at = 5)
    {
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789".time();
        $str = str_shuffle($str);
        $str = substr($str, $start_at, $length);
        return $str;
    }
}
