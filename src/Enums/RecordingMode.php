<?php

namespace SquareetLabs\LaravelOpenVidu\Enums;

use SquareetLabs\LaravelOpenVidu\SessionProperties;

/**
 * Class RecordingMode
 * @package SquareetLabs\LaravelOpenVidu\Enums
 * {@see SessionProperties::$recordingMode}
 */
class RecordingMode
{
    /**
     * The session is recorded automatically as soon as the first client publishes a stream to the session.
     * It is automatically stopped after last user leaves the session (or until you call {@see OpenVidu::stopRecording}.
     */
    public const ALWAYS = 'ALWAYS';

    /**
     * The session is not recorded automatically. To record the session, you must call  {@see OpenVidu::startRecording} method.
     * To stop the recording, you must call  {@see OpenVidu::stopRecording}.
     */
    public const MANUAL = 'MANUAL';


}
