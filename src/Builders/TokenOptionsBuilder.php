<?php

namespace SquareetLabs\LaravelOpenVidu\Builders;

use SquareetLabs\LaravelOpenVidu\TokenOptions;

/**
 * Class TokenOptionsBuilder
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
        throw new OpenViduInvalidArgumentException('TokenOptionsBuilder::build spects an array and '.gettype($properties).' is given');
    }
}
