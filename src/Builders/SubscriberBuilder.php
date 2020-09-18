<?php

namespace SquareetLabs\LaravelOpenVidu\Builders;

use SquareetLabs\LaravelOpenVidu\Subscriber;

/**
 * Class SubscriberBuilder
 * @package SquareetLabs\LaravelOpenVidu\Builders
 */
class SubscriberBuilder implements BuilderInterface
{
    /**
     * @param  array  $properties
     * @return Subscriber
     */
    public static function build(array $properties)
    {
        return new Subscriber($properties['streamId'],
            $properties['publisherStreamId'],
            $properties['createdAt']);
    }
}