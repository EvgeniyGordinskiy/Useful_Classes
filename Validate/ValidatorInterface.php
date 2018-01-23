<?php

namespace App\Validate;

interface ValidatorInterface
{
    /**
     * Run validation
     * @return mixed
     */
    public static function handle(array $item);

}