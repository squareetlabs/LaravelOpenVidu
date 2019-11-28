<?php

namespace SquareetLabs\LaravelOpenVidu\Enums;

/**
 * Class RecordingMode
 * @package SquareetLabs\LaravelOpenVidu
 */
class RecordingMode
{
    /**
     * The session is recorded automatically as soon as the first client publishes a stream to the session.
     * It is automatically stopped after last user leaves the session (or until you call LaravelOpenVidu.stopRecording).
     */
    public const ALWAYS = 'ALWAYS';

    /**
     * The session is not recorded automatically. To record the session, you must call LaravelOpenVidu.startRecording method.
     * To stop the recording, you must call LaravelOpenVidu.stopRecording.
     */
    public const MANUAL = 'MANUAL';


}
