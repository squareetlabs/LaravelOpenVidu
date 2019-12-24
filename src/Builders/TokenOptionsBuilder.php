<?php

namespace SquareetLabs\LaravelOpenVidu\Builders;

use SquareetLabs\LaravelOpenVidu\TokenOptions;

/**
 * Class TokenOptionsBuilder
 * @package SquareetLabs\LaravelOpenVidu\Builders
 */
class TokenOptionsBuilder implements BuilderInterface
{
    /**
     * @param mixed $tokenOptions
     * @return TokenOptions|null
     */
    public static function build(array $tokenOptions)
    {
        return new TokenOptions($tokenOptions['role'], $tokenOptions['data']);
    }
}
