<?php

namespace App\Validate;

/**
 * Check for a similar password and confirm-password
 * Class ConfirmValidate
 * @package App\Validate
 */
class ConfirmValidate implements ValidatorInterface
{
    public static function handle(array $item) :bool
    {
        if (isset($item[1])){
            return strcmp( (string) $item[1], (string) $item[0]) === 0;
        }
        
        return false;
    }
}