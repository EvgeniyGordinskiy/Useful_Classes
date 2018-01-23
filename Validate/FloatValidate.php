<?php

namespace App\Validate;

class FloatValidate implements ValidatorInterface
{
    public static function handle(array $item)
    {
        return is_float($item[0]);
    }
}