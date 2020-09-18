<?php

namespace SquareetLabs\LaravelOpenVidu\Builders;

use SquareetLabs\LaravelOpenVidu\Connection;

/**
 * Class ConnectionBuilder
 * @package SquareetLabs\LaravelOpenVidu\Builders
 */
class ConnectionBuilder implements BuilderInterface
{
    /**
     * @param  array  $properties
     * @param  array|null  $publishers
     * @param  array|null  $subscribers
     * @return Connection
     */
    public static function build(array $properties, ?array $publishers = [], ?array $subscribers = [])
    {
        return new Connection($properties['connectionId'],
            $properties['createdAt'],
            $properties['role'],
            $properties['token'],
            $properties['location'],
            $properties['platform'],
            $properties['serverData'],
            $properties['clientData'],
            $publishers,
            $subscribers
        );
    }
}