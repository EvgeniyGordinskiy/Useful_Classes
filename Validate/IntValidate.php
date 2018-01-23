<?php

namespace App\Validate;

class IntValidate implements ValidatorInterface
{
    public static function handle(array $item)
    {
        return is_int($item[0]);
    }
}