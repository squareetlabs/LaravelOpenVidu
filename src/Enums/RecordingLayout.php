<?php

namespace SquareetLabs\LaravelOpenVidu\Enums;

/**
 * Class RecordingLayout
 * @package SquareetLabs\LaravelOpenVidu
 */
class RecordingLayout
{
    /**
     * All the videos are evenly distributed, taking up as much space as possible
     */
    public const BEST_FIT = 'BEST_FIT';

    /**
     * Use your own custom recording layout.
     * See Custom recording layouts to learn more
     * https://openvidu.io/docs/advanced-features/recording#custom-recording-layouts
     */
    public const CUSTOM = 'CUSTOM';
}
