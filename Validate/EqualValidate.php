<?php

namespace App\Validate;

class EqualValidate implements ValidatorInterface
{
    public static function handle(array $item) :bool
    {
        if (isset($item[1])){
            $equal = intval($item[1]);
            if(is_int($item[0]) || is_float($item[0])){
                return $item[0] === $equal;
            }

            if(is_string($item[0])){
                return mb_strlen($item[0], "UTF-8") === $equal;
            }
        }

        return false;
    }
}