<?php

namespace App\Helpers;

class DecimalToWordsHelper
{
    public static function convertDecimalToWords($number, $currency)
    {
        $intValue = intval($number);
        $hundred = null;
        $digitLength = strlen(strval($intValue));
        $string = [];
        $words = config('constants.amount-to-words');
        $digits = ['', 'hundred', 'thousand', 'lakh', 'crore'];
        $index = 0;
        while ($index < $digitLength) {
            $divider = ($index == 2) ? 10 : 100;
            $number = floor($intValue % $divider);
            $intValue = floor($intValue / $divider);
            $index += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($string)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                $string[] = ($number < 21) ? $words[$number] .
                    ' ' . $digits[$counter] . $plural . ' ' . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . ' ' . $words[$number % 10] . ' '
                    . $digits[$counter] . $plural . ' ' . $hundred;
            } else {
                $string[] = null;
            }
        }
        $string = array_reverse($string);
        $integerVal = implode('', $string);

        return $integerVal . $currency;
    }
}
