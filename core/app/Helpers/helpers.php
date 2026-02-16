<?php

use Illuminate\Support\Facades\Cache;
use Morilog\Jalali\Jalalian;

function jalaliDate($date, $format = 'Y/m/d')
{
    return Jalalian::forge($date)->format($format);
}
function jalaliDateToMiladi($date = null, $format = "Y/m/d")
{
    return $date ? Jalalian::fromFormat($format,$date)->toCarbon() : null;
}
function miladiDateTojalali($date , $format = "Y/m/d")
{
    
    return Jalalian::forge($date)->format($format);
}
function jalaliDateDay($date, $format = '%A, %d %B %Y')
{
    return Jalalian::forge($date)->format($format);
}

function convertPersianToEnglish($number)
{
    $number = str_replace('۰', '0', $number);
    $number = str_replace('۱', '1', $number);
    $number = str_replace('۲', '2', $number);
    $number = str_replace('۳', '3', $number);
    $number = str_replace('۴', '4', $number);
    $number = str_replace('۵', '5', $number);
    $number = str_replace('۶', '6', $number);
    $number = str_replace('۷', '7', $number);
    $number = str_replace('۸', '8', $number);
    $number = str_replace('۹', '9', $number);

    return $number;
}


function convertArabicToEnglish($number)
{
    $number = str_replace('۰', '0', $number);
    $number = str_replace('۱', '1', $number);
    $number = str_replace('۲', '2', $number);
    $number = str_replace('۳', '3', $number);
    $number = str_replace('۴', '4', $number);
    $number = str_replace('۵', '5', $number);
    $number = str_replace('۶', '6', $number);
    $number = str_replace('۷', '7', $number);
    $number = str_replace('۸', '8', $number);
    $number = str_replace('۹', '9', $number);

    return $number;
}



function convertEnglishToPersian($number)
{
    $number = str_replace('0', '۰', $number);
    $number = str_replace('1', '۱', $number);
    $number = str_replace('2', '۲', $number);
    $number = str_replace('3', '۳', $number);
    $number = str_replace('4', '۴', $number);
    $number = str_replace('5', '۵', $number);
    $number = str_replace('6', '۶', $number);
    $number = str_replace('7', '۷', $number);
    $number = str_replace('8', '۸', $number);
    $number = str_replace('9', '۹', $number);

    return $number;
}



function priceFormat($price)
{
    $price = number_format($price, 0, '/', '،');
    $price = convertEnglishToPersian($price);
    return $price;
}
function numberFormat($number)
{
    $number = number_format($number, 0, '/', '');
    return $number;
}

function formatPhoneNumber($phone)
{
    // Remove any whitespace
    $phone = trim($phone);
    
    // Check if phone number doesn't start with 0 and add it
    if (!empty($phone) && substr($phone, 0, 1) !== '0') {
        $phone = '0' . $phone;
    }
    
    return $phone;
}

/**
 * Check if the given Jalali date is the start of a week (Saturday)
 * 
 * @param string $jalaliDate Date in Y/m/d format
 * @return bool
 */
function isWeekStartDate($jalaliDate)
{
    try {
        $normalizedDate = convertPersianToEnglish($jalaliDate);
        $jalalian = Jalalian::fromFormat('Y/m/d', $normalizedDate);

        // In Jalali calendar, Saturday is day 6 (week starts from Saturday)
        return $jalalian->getDayOfWeek() == 0;
    } catch (Exception $e) {
       
        return false;
    }
}
