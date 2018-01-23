<?php

namespace App\Validate;

class TimeValidate implements ValidatorInterface
{
    public static function handle(array $item)
    {
        $format = '%H:%M:%S';
        $result = strptime($item[0], $format);
        
        return $result['tm_min'] || $result['tm_hour'];
    }
}