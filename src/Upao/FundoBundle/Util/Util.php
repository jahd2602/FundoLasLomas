<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daustinsac
 * Date: 5/11/13
 * Time: 23:46
 * To change this template use File | Settings | File Templates.
 */

namespace Upao\FundoBundle\Util;


class Util
{

    static function toAlpha($data)
    {
        $alphabet = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        $alpha_flip = array_flip($alphabet);
        if ($data <= 25) {
            return strtoupper($alphabet[$data]);
        } elseif ($data > 25) {
            $dividend = ($data + 1);
            $alpha = '';
            while ($dividend > 0) {
                $modulo = ($dividend - 1) % 26;
                $alpha = $alphabet[$modulo] . $alpha;
                $dividend = floor((($dividend - $modulo) / 26));
            }
            return strtoupper($alpha);
        }

    }

    static function toNumber($data)
    {
        $alphabet = array('a', 'b', 'c', 'd', 'e',
            'f', 'g', 'h', 'i', 'j',
            'k', 'l', 'm', 'n', 'o',
            'p', 'q', 'r', 's', 't',
            'u', 'v', 'w', 'x', 'y',
            'z'
        );
        $alpha_flip = array_flip($alphabet);
        $return_value = -1;
        $length = strlen($data);
        for ($i = 0; $i < $length; $i++) {
            $return_value += ($alpha_flip[$data[$i]] + 1) * pow(26, ($length - $i - 1));
        }
        return $return_value + 1;
    }

    static function truncate($paragraph, $limit = 100, $delimiter = ' ', $ellipsis = '...')
    {
        $parts = explode($delimiter, $paragraph);

        $preview = "";

        if ($ellipsis) {
            $limit = $limit - strlen($ellipsis);
        }

        foreach ($parts as $part) {
            $to_add = $part . $delimiter;
            if (strlen($preview . trim($to_add)) <= $limit) { // Can the part fit?
                $preview .= $to_add;
                continue;
            }
            if (!strlen($preview)) { // Is preview blank?
                $preview = substr($part, 0, $limit - 3) . '...'; // Forced ellipsis
                break;
            }
        }

        return trim($preview) . $ellipsis;

    }
}