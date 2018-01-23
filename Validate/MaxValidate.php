<?php

namespace App\Validate;

class MaxValidate implements ValidatorInterface
{
    public static function handle(array $item) :bool 
    {
        if (isset($item[1])){
            $max = intval($item[1]);
            if(is_int($item[0]) || is_float($item[0])){
                return $item[0] <= $max;
            }

            if(is_string($item[0])){
                return mb_strlen($item[0], "UTF-8") <= $max;
            }
        }
        
        return false;
    }
}