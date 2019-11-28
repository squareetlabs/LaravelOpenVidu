<?php

namespace SquareetLabs\LaravelOpenVidu\Enums;

/**
 * Class OutputMode
 * @package SquareetLabs\LaravelOpenVidu
 */
class OutputMode
{
    /**
     * Record all streams in a grid layout in a single archive
     */
    public const COMPOSED = 'COMPOSED';

    /**
     * Record each stream individually
     */
    public const INDIVIDUAL = 'INDIVIDUAL';
}
