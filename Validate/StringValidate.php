<?php

namespace App\Validate;

class StringValidate implements ValidatorInterface
{
    public static function handle(array $item) :bool 
    {
            return is_string($item[0]);
    }
}