<?php

namespace SquareetLabs\LaravelOpenVidu\Builders;

use SquareetLabs\LaravelOpenVidu\Connection;

class ConnectionBuilder implements BuilderInterface
{
    /**
     * @param  array  $properties
     * @param  array  $publishers
     * @param  array  $subscribers
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