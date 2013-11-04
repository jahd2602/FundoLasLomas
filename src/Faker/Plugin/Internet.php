<?php

namespace Faker\Plugin;
use Faker\Faker;

/**
 * Internet Class
 */
class Internet
{
    public static $lang;

    public function __construct($lang = NULL)
    {
        if (!empty($lang)) {
            self::$_domainSuffix = I18n::get('internet_domainSuffix', $lang);
            self::$_free = I18n::get('internet_domainSuffix', $lang);
            self::$lang = $lang;
        }
    }

    /**
     * Do nothing on being instanced
     *
     * @return void
     * @author Caius Durling
     */

    private static $_domainSuffix = array('org', 'com', 'us', 'net', 'info', 'live', 'name');

    private static $_free = array('gmail.com', 'facebook.com', 'yahoo.com', 'yahoo.es', 'live.com', 'hotmail.com', 'hotmail.es');

    private static $_name_formats = array(array('firstName'), array('firstName', 'surname'));

    public function domainSuffix()
    {
        return Utils::getInstance()->random(self::$_domainSuffix);
    }

    public function domainWord()
    {
        $result = explode(' ', Faker::company()->name());
        $result = $result[0];
        $result = strtolower($result);
        $result = preg_replace("/\W/", '', $result);
        return $result;
    }

    public function domainName()
    {
        $result[] = $this->domainWord();
        $result[] = $this->domainSuffix();
        return join($result, '.');
    }

    public function userName($name = null)
    {
        if ($name) {
            return $this->sanitiseName($name);
        }

        // get first_name, surname
        $n = Faker::name(self::$lang);
        $a = Utils::getInstance()->random(self::$_name_formats);

        foreach ($a as $method) {
            $na[] = $n->$method();
        }

        // run sanitiseName()
        $na = join(' ', $na);
        $result = $this->sanitiseName($na);
        return $result;
    }

    public function email($name = null)
    {
        return join(array($this->userName($name), $this->domainName()), "@");
    }

    public function freeEmail($name = null)
    {
        return join(array($this->userName($name), Utils::getInstance()->random(self::$_free)), "@");
    }

    public function unAcent($text)
    {
        $test = NULL;

        if (is_null($test)) {
            // Obtenemos la tabla de "traduccion"
            $html = get_html_translation_table(HTML_ENTITIES);

            foreach ($html as $char => $ord) {
                if (ord($char) >= 192)
                    $test[$char] = $ord[1];
            }
        } // Hacemos los cambios de acentos...
        $text = strtr($text, $test);
        return $text;
    }


    protected function sanitiseName($name)
    {
        $name = $this->unAcent($name);
        $name = strtolower($name);
        $n = explode(' ', $name);
        $n = preg_replace("/\W/", "", $n);
        $d = array('.', '_');
        // Randomise the array order
        shuffle($n);
        return join($n, Utils::getInstance()->random($d));
    }

    function __set($property, $value)
    {
        throw new Exception('Unknow property "' . $property . '"');
    }

}

?>