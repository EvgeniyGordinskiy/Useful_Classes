<?php

namespace App\Validate;

class EmailValidate implements ValidatorInterface
{
    public static function handle(array $item) :bool
    {
        
        return (bool) filter_var($item[0], FILTER_VALIDATE_EMAIL);
    }
}