<?php

/**
 * 	@author Preme W. <preme_won@truecorp.co.th>
 * 	@since   Jan 28, 2014
 * 	@version  1.0
 * 	@param  $array  pass by reference 
 *  @return  Reference 
 * 	@access  Public 
 */
if (!function_exists('shuffle_assoc'))
{

    function shuffle_assoc(&$array)
    {
        $keys = array_keys($array);

        shuffle($keys);

        foreach ($keys as $key)
        {
            //--- Reset key array ---//
            $new[] = $array[$key];
        }

        $array = $new;

        return true;
    }

}

if (!function_exists("array_combind_v2"))
{

    function array_combind_v2($arr1, $arr2, $separator = '-')
    {
        $resultArray = array();
        if (count($arr1) > 0 && count($arr2) == 0)
        {
            $resultArray == $arr1;
        } elseif (count($arr1) == 0 && count($arr2) > 0)
        {
            $resultArray = $arr2;
        } elseif (count($arr1) > 0 && count($arr2) > 0)
        {
            foreach ($arr1 as $arr1Key => $arr1Value)
            {
                foreach ($arr2 as $arr2Key => $arr2Value)
                {
                    $resultArray[] = $arr1Value . $separator . $arr2Value;
                }
            }
        }

        return $resultArray;
    }

}