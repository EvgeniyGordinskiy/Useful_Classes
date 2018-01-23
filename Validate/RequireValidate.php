<?php

namespace App\Validate;

class RequireValidate implements ValidatorInterface
{
    public static function handle(array $item) :bool
    {

        return mb_strlen( (string) $item[0], "UTF-8") > 0;
    }
}