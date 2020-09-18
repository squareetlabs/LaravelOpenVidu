<?php

namespace SquareetLabs\LaravelOpenVidu\Builders;

use SquareetLabs\LaravelOpenVidu\Publisher;

/**
 * Class PublisherBuilder
 * @package SquareetLabs\LaravelOpenVidu\Builders
 */
class PublisherBuilder implements BuilderInterface
{
    /**
     * @param  array  $properties
     * @return Publisher
     */
    public static function build(array $properties)
    {
        return new Publisher($properties['streamId'],
            $properties['createdAt'],
            $properties['mediaOptions']['hasAudio'],
            $properties['mediaOptions']['hasVideo'],
            $properties['mediaOptions']['audioActive'],
            $properties['mediaOptions']['videoActive'],
            $properties['mediaOptions']['frameRate'],
            $properties['mediaOptions']['typeOfVideo'],
            $properties['mediaOptions']['videoDimensions']
        );
    }
}