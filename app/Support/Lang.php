<?php

namespace App\Support;

use App\Support\Facades\Config;
use Carbon\Carbon;

class Lang
{
    public static function moneyFormat($var)
    {
        return Config::get('currency_code').' '.number_format($var, 0, Config::get('dec_point'), Config::get('thousands_sep'));
    }

    public static function phoneFormat($phone)
    {
        if (Validator::UnsignedNumber($phone) && ! empty(Config::get('country_code_phone'))) {
            return preg_replace('/^0/', Config::get('country_code_phone'), $phone);
        } else {
            return $phone;
        }
    }

    public static function dateFormat($date)
    {
        return date(Config::get('date_format'), strtotime($date));
    }

    public static function dateTimeFormat(?Carbon $date)
    {
        return $date?->format(Config::get('date_format').' H:i') ?? '-';
    }

    public static function dateAndTimeFormat($date, $time)
    {
        return date(Config::get('date_format').' H:i', strtotime("$date $time"));
    }

    public static function ucWords($text)
    {
        return ucwords(str_replace('_', ' ', $text));
    }

    public static function randomUpLowCase($text)
    {
        $jml = strlen($text);
        $result = '';
        for ($i = 0; $i < $jml; $i++) {
            if (rand(0, 99) % 2) {
                $result .= strtolower(substr($text, $i, 1));
            } else {
                $result .= substr($text, $i, 1);
            }
        }

        return $result;
    }
}
