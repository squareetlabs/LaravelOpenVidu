<?php
namespace SquareetLabs\LaravelOpenVidu\Builders;
use SquareetLabs\LaravelOpenVidu\Publisher;

class PublisherBuilder
{
    /**
     * @param array $properties
     * @return Publisher
     */
    public static function build(array $properties)
    {
        return new Publisher($publishedArray['streamId'] ?? null,
            $publishedArray['createdAt'] ?? null,
            $publishedArray['hasAudio'] ?? null,
            $publishedArray['hasVideo'] ?? null,
            $publishedArray['audioActive'] ?? null,
            $publishedArray['videoActive'] ?? null,
            $publishedArray['frameRate'] ?? null,
            $publishedArray['typeOfVideo'] ?? null,
            $publishedArray['videoDimensions'] ?? null
        );
    }
}