<?php

namespace SquareetLabs\LaravelOpenVidu\Builders;

use SquareetLabs\LaravelOpenVidu\Exceptions\OpenViduStreamTypeInvalidException;
use SquareetLabs\LaravelOpenVidu\IPCameraOptions;
use SquareetLabs\LaravelOpenVidu\StreamInterface;

/**
 * Class PublishStreamBuilder
 * @package SquareetLabs\LaravelOpenVidu\Builders
 */
class PublishStreamBuilder implements BuilderInterface
{
    /**
     * @param  array  $properties
     * @return StreamInterface
     * @throws OpenViduStreamTypeInvalidException
     */
    public static function build(array $properties)
    {
        switch ($properties['type']) {
            case 'IPCAM':
                return new IPCameraOptions($properties['rtspUri'],
                    $properties['type'],
                    $properties['adaptativeBitrate'],
                    $properties['onlyPlayWithSubscribers'],
                    $properties['data']
                );
            default:
                throw new OpenViduStreamTypeInvalidException();
        }
    }
}