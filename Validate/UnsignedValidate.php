<?php

namespace App\Validate;

class UnsignedValidate implements ValidatorInterface
{
    public static function handle(array $item) : bool
    {
        return (bool) is_numeric($item[0]) && $item [0] > 0;
    }
}