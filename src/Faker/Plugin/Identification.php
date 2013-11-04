<?php

namespace Faker\Plugin;
use Faker\Faker;

/**
 *
 */
class Identification
{

    public static $lang;

    public function __construct($lang = NULL)
    {
        if (!empty($lang)) {
            self::$lang = $lang;
        }
    }


    public function ruc($i=0)
    {
        return Utils::getInstance()->lexer('1[0-9]{4}[0-9]{1}[0-9]{5}',$i);
    }

    public function dni($i=0)
    {
        return Utils::getInstance()->lexer('[1-4]{1}[0-9]{2}[0-9]{2}[0-9]{3}',$i);
    }

    function __set($property, $value)
    {
        throw new Exception('Unknow property "' . $property . '"');
    }
}

?>