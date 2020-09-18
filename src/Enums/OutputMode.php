<?php

namespace SquareetLabs\LaravelOpenVidu\Enums;

/**
 * Class OutputMode
 * @package SquareetLabs\LaravelOpenVidu\Enums
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


    /**
     * There is an extra recording output mode which is a variation of Composed recording.
     * The resulting recorded file will be exactly the same, but in this case the lifespan
     * of the recording module will be attached to the lifecycle of the session, not to the
     * lifecycle of the recording.
     */
    public const COMPOSED_QUICK_START = 'COMPOSED_QUICK_START';
}
