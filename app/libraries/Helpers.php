<?php
class Helpers {
    public static function array_month_cc(){
        // Use for credit card page
        $arr = array(
                1 => '01',
                2 => '02',
                3 => '03',
                4 => '04',
                5 => '05',
                6 => '06',
                7 => '07',
                8 => '08',
                9 => '09',
                10 => '10',
                11 => '11',
                12 => '12'
        );
        return $arr;
    }
    public static function genMoreTenYears(){
        $gm_now = time();
        $currentGMTYear = intVal(date('Y', $gm_now));
        $arrOutput = array(
                $currentGMTYear
        );
        for($ii = 1;$ii <= 10;$ii++){
            $currentGMTYear += 1;
            $arrOutput[] = $currentGMTYear;
        }
        return $arrOutput;
    }
    public static function insightDate($datetime = NULL, $lang = 'th'){
        // $datetime format is Y-m-d H:i:s
        if($datetime != NULL){
            if($lang == 'th'){
				$my_date = explode(' ', $datetime);
                if(count($my_date) == 2){
					$my_date_2 = explode('-', $my_date[0]);
					$d = $my_date_2[2];
					$month = self::array_month($lang);
					$m = $month[(int)$my_date_2[1]];
					$y = $my_date_2[0] + 543;
					
					return $d." ".$m." ".$y;
                }else{
					return NULL;
				}
            }else{
				list($date, $time) = explode(" ", $datetime); 
				list($year, $month, $day) = explode("-", $date);
				list($hour, $minute, $second) = explode(":", $time);
				$timestamp = mktime((int)$hour, (int)$minute, (int)$second, (int)$month, (int)$day, (int)$year); 

                // une 20, 2013
				return date("M d, Y", $timestamp);
			}
        }else{
			return NULL;
		}

	}
	
	public static function array_month($language=NULL) 
	{
		if($language == 'th') {
            $arr = array(
                    1 => "มกราคม",
                    2 => "กุมภาพันธ์",
                    3 => "มีนาคม",
                    4 => "เมษายน",
                    5 => "พฤษภาคม",
                    6 => "มิถุนายน",
                    7 => "กรกฎาคม",
                    8 => "สิงหาคม",
                    9 => "กันยายน",
                    10 => "ตุลาคม",
                    11 => "พฤศจิกายน",
                    12 => "ธันวาคม"
            );
		} else {
            $arr = array(
                    1 => "January",
                    2 => "February",
                    3 => "March",
                    4 => "April",
                    5 => "May",
                    6 => "June",
                    7 => "July",
                    8 => "August",
                    9 => "September",
                    10 => "October",
                    11 => "November",
                    12 => "December"
            );
		}
		return $arr;
	}
    public static function random_string($type = 'alnum', $len = 8){
        switch($type){
            case 'basic':
                return mt_rand();
				break;
			case 'alnum'	:
			case 'numeric'	:
			case 'nozero'	:
			case 'alpha'	:

                switch($type){
                    case 'alpha':
                        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
							break;
                    case 'alnum':
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
							break;
                    case 'numeric':
                        $pool = '0123456789';
							break;
                    case 'nozero':
                        $pool = '123456789';
							break;
					}

					$str = '';
                for($i = 0;$i < $len;$i++){
						$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
					}
					return $str;
				break;
			case 'unique'	:
			case 'md5'		:

						return md5(uniqid(mt_rand()));
				break;
		}
	}
}