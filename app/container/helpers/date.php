<?php
if ( ! function_exists('newsDate'))
{
	function newsDate($datetime = NULL)
	{
		list($date, $time) = explode(" ", $datetime);
		list($year, $month, $day) = explode("-", $date);
		list($hour, $minute, $second) = explode(":", $time);
		$timestamp = mktime((int)$hour, (int)$minute, (int)$second, (int)$month, (int)$day, (int)$year);

		#Dec 17, 2012, 06.28 pm

		return date("M d, Y, H.i a", $timestamp);

	}
}


if(!function_exists("deliveryDate")){
    function deliveryDate($datetime, $ln = "th"){
        $fDate = new DateTime($datetime);
        $fDate->modify("+4 days");
        $fastestDate = $fDate->format("Y-m-d H:i:s");
        $fastestDate = formatDate($fastestDate, "d M y", $ln);

        $sDate = new DateTime($datetime);
        $sDate->modify("+10 days");
        $slowestDate = $sDate->format("Y-m-d H:i:s");
        $slowestDate = formatDate($slowestDate, "d M y", $ln);

        return $fastestDate . " - " . $slowestDate;
    }
}

if(!function_exists("formatDate")){
    function formatDate($_date, $_format = 'Y-m-d H:i:s', $_lang = 'en') {

        $th_format = array(
            // Day
            'd' => array('type' => 'day', 'value' => array()),
            'D' => array('type' => 'day', 'value' => array('อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.')),
            'j' => array('type' => 'day', 'value' => array()),
            'l' => array('type' => 'day', 'value' => array('อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์')), //'lower case [L]'
            'N' => array('type' => 'day', 'value' => array()),
            'S' => array('type' => 'day', 'value' => array()),
            'w' => array('type' => 'day', 'value' => array()),
            'z' => array('type' => 'day', 'value' => array()),
            // Month
            'F' => array('type' => 'month', 'value' => array('', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม')),
            'm' => array('type' => 'month', 'value' => array()),
            'M' => array('type' => 'month', 'value' => array('', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.')),
            'n' => array('type' => 'month', 'value' => array()),
            't' => array('type' => 'month', 'value' => array()),
            // Year
            'L' => array('type' => 'year', 'value' => array()),
            'o' => array('type' => 'year', 'value' => array()),
            'Y' => array('type' => 'year', 'value' => array()),
            'y' => array('type' => 'year', 'value' => array()),
            // Time
            'a' => array('type' => 'time', 'value' => array()),
            'A' => array('type' => 'time', 'value' => array()),
            'B' => array('type' => 'time', 'value' => array()),
            'g' => array('type' => 'time', 'value' => array()),
            'G' => array('type' => 'time', 'value' => array()),
            'h' => array('type' => 'time', 'value' => array()),
            'H' => array('type' => 'time', 'value' => array()),
            'i' => array('type' => 'time', 'value' => array()),
            's' => array('type' => 'time', 'value' => array()),
            'u' => array('type' => 'time', 'value' => array()),
        );
        $pattern_format = array('th' => $th_format);

        if ($_date != '') {
            $return = '';
            $date = explode(' ', $_date);
            if (count($date) > 1) {
                $tmp_date = explode('-', $date[0]);
                if ($tmp_date[0] != '0000') {
                    $exDate['day'] = $tmp_date[2];
                    $exDate['month'] = $tmp_date[1];
                    $exDate['year'] = $tmp_date[0];
                    if (isset($date[1])) {
                        $tmp_time = explode(':', $date[1]);
                        $exDate['hour'] = $tmp_time[0];
                        $exDate['minute'] = $tmp_time[1];
                        $exDate['second'] = $tmp_time[2];
                    } else {
                        $hour = 0;
                        $minute = 0;
                        $second = 0;
                    }

                    if ($_lang == 'en') {
                        $return = date($_format, mktime($exDate['hour'], $exDate['minute'], $exDate['second'], $exDate['month'], $exDate['day'], $exDate['year']));
                        return $return;
                    } else {
                        $str_format = preg_split('//', $_format, -1, PREG_SPLIT_NO_EMPTY);
                        foreach ($str_format as $chr) {
                            if (isset($pattern_format[$_lang][$chr])) {
                                if (count($pattern_format[$_lang][$chr]['value']) > 0) {
                                    $type = $pattern_format[$_lang][$chr]['type'];
                                    if ($type == 'day') {
                                        $index_day = date('w', strtotime($_date));
                                    } else {
                                        $index_day = intval($exDate[$type]);
                                    }
                                    $return .= $pattern_format[$_lang][$chr]['value'][$index_day];
                                } else {
                                    $type = $pattern_format[$_lang][$chr]['type'];
                                    if ($type == 'year') {
                                        if($chr == 'y'){
                                            $year = strval($exDate[$type] + 543);
                                            $return .= substr($year, -2);
                                        }else{
                                            $return .= $exDate[$type] + 543;
                                        }
                                    } else {
                                        $tmp_date = date("Y-m-d H:i:s", mktime(intval($exDate['hour']), intval($exDate['minute']), intval($exDate['second']), intval($exDate['month']), intval($exDate['day']), intval($exDate['year'])));
                                        $return .= date($chr, strtotime($tmp_date));
                                    }
                                }
                            } else {
                                $return .= $chr;
                            }
                        }

                        //$return = '[]';
                        return $return;
                    }
                }
            }
        }

        return false;
    }
}

if ( ! function_exists('getTimeRemaining'))
{
    function getTimeRemaining($datetime = NULL, $expiredValue = false)
    {
        if (strtotime($datetime) < time())
        {
            return $expiredValue;
        }
        $now = new \Carbon\Carbon();
        $future_date = new \Carbon\Carbon($datetime);

        // $interval = $future_date->diff($now);

        $diff = max($future_date->getTimestamp() - $now->getTimestamp(), 0);

        if ($diff == 0)
        {
            return '--:--:--';
        }

        $hours = floor($diff / 3600);

        $minutes = floor(($diff - ($hours*3600)) / 60);

        $seconds = $diff - ($hours*3600) - ($minutes*60);

        return sprintf('%02d', $hours).":".sprintf('%02d', $minutes).":".sprintf('%02d', $seconds);
    }
}

function next_work_day($next_day, $from_date = false, $format = 'Y-m-d H:i:s') {
    if ($next_day<=0) {
        return $from_date;
    }

    $WORK_DAY = 5;
    $WEEK_DAY = 7;
    $ONE_DAY = 60 * 60 * 24;

    $from_date = !$from_date ? time() : strtotime($from_date);
    $from_day_index = date("N", $from_date);

    $within_week = $from_day_index + $next_day <= $WORK_DAY;
    if ($within_week) {
        return date( $format, $from_date + ($next_day * $ONE_DAY) );
    }

    $new_next_date = $next_day - ($WORK_DAY - $from_day_index);
    $mod_day = 1 + $WEEK_DAY - $from_day_index;

    $from_date = date( $format, $from_date + ($mod_day * $ONE_DAY) );
    return next_work_day($new_next_date -1, $from_date);
}

function deliveryPeriod($order_date)
{
    $deliver_date = '';

    if(empty($order_date) && date_format($order_date, 'Y-m-d H:i:s'))
    {
        return $deliver_date;
    }

    $first_date = next_work_day(4, $order_date);
    $end_date = next_work_day(10, $order_date);
    $first_date_txt = formatDate($first_date, "d M y", Lang::getLocale());
    $end_date_txt = formatDate($end_date, "d M y", Lang::getLocale());
    $deliver_date = $first_date_txt.' - '.$end_date_txt;

    return $deliver_date;
}