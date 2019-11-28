<?php

namespace SquareetLabs\LaravelOpenVidu\Builders;

use SquareetLabs\LaravelOpenVidu\TokenOptions;

/**
 * Class TokenOptionsFactory
 * @package SquareetLabs\LaravelOpenVidu\Builders
 */
class TokenOptionsBuilder
{
    /**
     * @param array $tokenOptions
     * @return TokenOptions|null
     */
    public static function build(array $tokenOptions)
    {
        if (is_array($tokenOptions)) {
            return new TokenOptions($tokenOptions['role'], $tokenOptions['data']);
        }
        return null;
    }
}
