<?php

namespace SquareetLabs\LaravelOpenVidu\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class LaravelOpenVidu
 * @package SquareetLabs\LaravelOpenVidu\Facades
 */
class OpenVidu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'openVidu';
    }
}
