<?php

namespace SquareetLabs\LaravelOpenVidu\Builders;

use SquareetLabs\LaravelOpenVidu\Publisher;

class PublisherBuilder implements BuilderInterface
{
    /**
     * @param array $properties
     * @return Publisher
     */
    public static function build(array $properties)
    {
        return new Publisher($properties['streamId'],
            $properties['createdAt'],
            $properties['hasAudio'],
            $properties['hasVideo'],
            $properties['audioActive'],
            $properties['videoActive'],
            $properties['frameRate'],
            $properties['typeOfVideo'],
            $properties['videoDimensions']
        );
    }
}