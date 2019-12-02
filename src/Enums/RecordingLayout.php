<?php

namespace SquareetLabs\LaravelOpenVidu\Enums;

use SquareetLabs\LaravelOpenVidu\SessionProperties;

/**
 * Class RecordingLayout
 * @package SquareetLabs\LaravelOpenVidu\Enums
 * {@see SessionProperties::$defaultRecordingLayout} and {@see RecordingProperties::$recordingLayout}
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

    /**
     * _(not available yet)_
     */
    public const PICTURE_IN_PICTURE = 'PICTURE_IN_PICTURE';

    /**
     * _(not available yet)_
     */
    public const VERTICAL_PRESENTATION = 'VERTICAL_PRESENTATION';

    /**
     * _(not available yet)_
     */
    public const HORIZONTAL_PRESENTATION = 'VERTICAL_PRESENTATION';
}
