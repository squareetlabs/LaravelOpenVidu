<?php

namespace SquareetLabs\LaravelOpenVidu\Facades;

use Illuminate\Support\Facades\Facade;
use SquareetLabs\LaravelOpenVidu\Recording;
use SquareetLabs\LaravelOpenVidu\RecordingProperties;
use SquareetLabs\LaravelOpenVidu\Session;
use SquareetLabs\LaravelOpenVidu\SessionProperties;
use SquareetLabs\LaravelOpenVidu\SignalProperties;

/**
 * Class LaravelOpenVidu
 * @package SquareetLabs\LaravelOpenVidu\Facades
 * @method static Session createSession(?SessionProperties $properties = null)
 * @method static Session getSession(string $sessionId)
 * @method static bool existsSession(string $sessionId)
 * @method static bool deleteRecording(string $recordingId)
 * @method static array getActiveSessions()
 * @method static string getRecording(string $recordingId)
 * @method static array getRecordings()
 * @method static Recording startRecording(?RecordingProperties $properties = null)
 * @method static Recording stopRecording(string $recordingId)
 * @method static bool sendSignal(?SignalProperties $properties = null)
 */
class OpenVidu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'openVidu';
    }
}
