<?php

namespace Faker;

use Faker\Plugin;

class Faker
{

    function __set($property, $value)
    {
        throw new Exception('Unknow property "' . $property . '"');
    }

    private static $address;

    public static function address($lang = NULL)
    {
        return self::$address ? self::$address : self::$address = new Plugin\Address($lang);
    }

    private static $company;

    public static function company($lang = NULL)
    {
        return self::$company ? self::$company : self::$company = new Plugin\Company($lang);
    }

    private static $internet;

    public static function internet($lang = NULL)
    {
        return self::$internet ? self::$internet : self::$internet = new Plugin\Internet($lang);
    }

    private static $lorem;

    public static function lorem()
    {
        return self::$lorem ? self::$lorem : self::$lorem = new Plugin\Lorem();
    }

    private static $name;

    public static function name($lang = NULL)
    {
        return self::$name ? self::$name : self::$name = new Plugin\Name($lang);
    }

    private static $phone;

    public static function phoneNumber($lang = NULL)
    {
        return self::$phone ? self::$phone : self::$phone = new Plugin\Phone($lang);
    }

    private static $identification;

    public static function identification($lang = NULL)
    {
        return self::$identification ? self::$identification : self::$identification = new Plugin\Identification($lang);
    }

    private static $date;

    public static function date()
    {
        return self::$date ? self::$date : self::$date = new Plugin\Date();
    }
}