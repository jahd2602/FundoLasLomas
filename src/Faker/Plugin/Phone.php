<?php

namespace Faker\Plugin;
use Faker\Faker;

/**
 *
 */
class Phone
{

    public static $lang;

    public function __construct($lang = NULL)
    {
        if (!empty($lang)) {
            self::$lang = $lang;
        }
    }


    /**
     * Do nothing on being instanced
     *
     * @return void
     * @author Caius Durling
     */


    public function phoneNumber($seed=0)
    {
        return Utils::getInstance()->lexer('(0[4-7]{2}(-)[4-9]{3}[0-9]{3}|9[4-7]{2}[0-9]{3}[0-9]{3})',$seed);
    }

    public function phone($seed=0)
    {
        return Utils::getInstance()->lexer('0[4-7]{2}\-[4-9]{3}[0-9]{3}',$seed);
    }

    public function mobile($seed=0)
    {
        return Utils::getInstance()->lexer('9[4-7]{2}[0-9]{3}[0-9]{3}',$seed);
    }

    function __set($property, $value)
    {
        throw new Exception('Unknow property "' . $property . '"');
    }
}

?>