<?php

namespace SquareetLabs\LaravelOpenVidu\Builders;

use SquareetLabs\LaravelOpenVidu\Enums\MediaMode;
use SquareetLabs\LaravelOpenVidu\Enums\OutputMode;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingLayout;
use SquareetLabs\LaravelOpenVidu\Enums\RecordingMode;
use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduInvalidArgumentException;
use SquareetLabs\LaravelOpenVidu\SessionProperties;
use SquareetLabs\LaravelOpenVidu\SignalProperties;

/**
 * Class SignalPropertiesBuilder
 * @package SquareetLabs\LaravelOpenVidu\Builders
 */
class SignalPropertiesBuilder implements BuilderInterface
{
    /**
     * @param  array  $properties
     * @return SignalProperties|null
     */
    public static function build(array $properties)
    {
        if (array_key_exists('session', $properties)) {
            return new SignalProperties(
                 $properties['session'],
                array_key_exists('data', $properties) ? $properties['data'] : null,
                array_key_exists('type', $properties) ? $properties['type'] : null,
                array_key_exists('to', $properties) ? $properties['to'] : null
            );
        }
        throw new OpenViduInvalidArgumentException('SignalPropertiesBuilder::build spects an array with session key');
    }

}
