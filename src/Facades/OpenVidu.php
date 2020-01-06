<?php

namespace SquareetLabs\LaravelOpenVidu\Facades;

use Illuminate\Support\Facades\Facade;
use SquareetLabs\LaravelOpenVidu\Recording;
use SquareetLabs\LaravelOpenVidu\RecordingProperties;
use SquareetLabs\LaravelOpenVidu\Session;
use SquareetLabs\LaravelOpenVidu\SessionProperties;

/**
 * Class LaravelOpenVidu
 * @package SquareetLabs\LaravelOpenVidu\Facades
 * @method Session createSession(?SessionProperties $properties = null)
 * @method Session getSession(string $sessionId)
 * @method bool deleteRecording(string $recordingId)
 * @method array getActiveSessions()
 * @method string getRecording(string $recordingId)
 * @method array getRecordings()
 * @method Recording startRecording(?RecordingProperties $properties = null)
 * @method Recording stopRecording(string $recordingId)
 */
class OpenVidu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'openVidu';
    }
}
