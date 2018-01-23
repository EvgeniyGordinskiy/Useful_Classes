<?php

namespace App\Validate;

class DatetimeValidate implements ValidatorInterface
{
    public static function handle(array $item)
    {
        $format = '%Y-%m-%d %H:%M';
        $result = strptime($item[0], $format);
       
        return $result['tm_mday'] && $result['tm_mon'] && $result['tm_year'] && $result['tm_yday'] ;
    }
}