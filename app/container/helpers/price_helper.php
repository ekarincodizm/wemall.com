<?php
if ( ! function_exists('showPrice'))
{
	function showPrice($begin = NULL, $to = NULL, $format = "ß %s", $suffix = " .-")
	{
		if (is_null($begin) OR empty($begin))
		{
			return NULL;
		}
		if (is_null($to) OR empty($to))
		{
			return NULL;
		}

		if ($begin == $to)
		{
			return sprintf($format, number_format($begin)).$suffix;
		}
		else
		{
			return sprintf($format, number_format($begin))." - ".sprintf($format, number_format($to)).$suffix;
		}
	}
}

if ( ! function_exists('priceFormat'))
{
	function priceFormat($price = NULL)
	{
		if (is_null($price) OR empty($price))
		{
			return NULL;
		}

		return "ß ".number_format($price).' .-';
	}
}

/**
 * @author  Preme W. <preme_won@truecorp.co.th>
 * @since   July 5, 2014
 * @description  Price format for iTruemart new level A all site
 *
 */
if ( ! function_exists('priceMobile'))
{
    function priceMobile($startPrice = NULL, $toPrice = NULL)
    {
        if (is_null($startPrice) OR empty($startPrice))
        {
            return NULL;
        }

        if ( ! empty($toPrice))
        {
            return number_format($startPrice)." .-";
        }
        return number_format($startPrice)." .-";
    }
}


/**
 * เวลาเรียกใช้ให้เรียก ThaiBahtConversion(1234020.25); ประมาณนี้
 * @param numberic $amount_number
 * @return string
 */
if ( ! function_exists('thaiBahtConversion'))
{
	function thaiBahtConversion($amount_number)
	{
	    $amount_number = number_format($amount_number, 2, ".","");
	    //echo "<br/>amount = " . $amount_number . "<br/>";
	    $pt = strpos($amount_number , ".");
	    $number = $fraction = "";
	    if ($pt === false)
	        $number = $amount_number;
	    else
	    {
	        $number = substr($amount_number, 0, $pt);
	        $fraction = substr($amount_number, $pt + 1);
	    }

	    //list($number, $fraction) = explode(".", $number);
	    $ret = "";
	    $baht = readNumber ($number);
	    if ($baht != "")
	        $ret .= $baht . "บาท";

	    $satang = readNumber($fraction);
	    if ($satang != "")
	        $ret .=  $satang . "สตางค์";
	    else
	        $ret .= "ถ้วน";
	    //return iconv("UTF-8", "TIS-620", $ret);
	    return $ret;
	}
}

function readNumber($number)
{
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number = $number + 0;
    $ret = "";
    if ($number == 0) return $ret;
    if ($number > 1000000)
    {
        $ret .= readNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }

    $divider = 100000;
    $pos = 0;
    while($number > 0)
    {
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" :
            ((($divider == 10) && ($d == 1)) ? "" :
            ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}
