<?php

namespace App\Validate\Errors;

use App\Traits\HttpBoxTrait;

class ErrorsValidate
{
    use HttpBoxTrait;
    
    public static function message($item, string $name)
    {
        $name = lcfirst($name);
        if(is_array($item)){
          self::handleArray($item, $name);
        }

        if(is_string($item)){
            self::handleString($item, $name);
        }

    }

    private static function handleArray(array $item, string $name)
    {
        $nameMethod = key($item);
        $valueMethod = $item[$nameMethod];
        switch ($nameMethod) {
            case 'min':
                self::sendWithError("$name must be bigger than $valueMethod", [$name => "$name must be bigger than $valueMethod"]);
                break;
            case 'max':
                self::sendWithError("$name must be less than $valueMethod", [$name => "$name must be less than $valueMethod"]);
                break;
            case 'confirm':
                self::sendWithError("$name must be confirm", [$name => "$name must be confirm"]);
                break;
            default:
                self::sendWithError("$name error validating", [$name => "$name error validating"]);
                break;
        }
    }

    private static function handleString(string $item, string $name)
    {
        switch ($item) {
            case 'integer':
                self::sendWithError("$name must be an integer",  [$name => "$name must be an integer"]);
                break;
            case 'require':
                self::sendWithError("$name is required", [$name => "$name is required"]);
                break;
            case 'string':
                self::sendWithError("$name must be an integer",  [$name => "$name must be an integer"]);
                break;
            case 'email':
                self::sendWithError("Incorrect E-Mail", [$name => "Incorrect E-Mail"]);
                break;
            default:
                self::sendWithError("$name error validating",  [$name => "$name error validating"]);
                break;
        }
    }
}