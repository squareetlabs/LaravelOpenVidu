<?php

namespace SquareetLabs\LaravelOpenVidu\Enums;

use SquareetLabs\LaravelOpenVidu\Recording;

/**
 * Class RecordingStatus
 * @package SquareetLabs\LaravelOpenVidu\Enums
 * {@see Recording::$status}
 */
class RecordingStatus
{
    /**
     * The recording is starting (cannot be stopped). Some recording may not go
     * through this status and directly reach "started" status
     */
    public const STARTING = 'starting';

    /**
     * The recording has started and is going on
     */
    public const STARTED = 'STARTED';

    /**
     * The recording has stopped and is being processed. At some point it will reach
     * "ready" status
     */
    public const STOPPED = 'stopped';

    /**
     * The recording has finished OK and is available for download through OpenVidu
     * Server recordings endpoint:
     * https://YOUR_OPENVIDUSERVER_IP/recordings/{RECORDING_ID}/{RECORDING_NAME}.{EXTENSION}
     */
    public const READY = 'ready';

    /**
     * The recording has failed. This status may be reached from "starting",
     * "started" and "stopped" status
     */
    public const FAILED = 'failed';
}
