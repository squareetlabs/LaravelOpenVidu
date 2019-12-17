<?php

namespace SquareetLabs\LaravelOpenVidu\Events;

use Illuminate\Queue\SerializesModels;
use stdClass;

/**
 * Class SessionDestroyed
 * @package SquareetLabs\LaravelOpenVidu\Events
 */
class SessionDestroyed implements WebhookEventInterface
{
    use SerializesModels;
    /**
     * @var string $sessionId
     * Session for which the event was triggered
     * A string with the session unique identifier
     */
    public $sessionId;

    /**
     * @var int $timestamp
     * Time when the event was triggered
     * UTC milliseconds
     */
    public $timestamp;


    /**
     * @var int $startTime
     * Time when the session started
     * UTC milliseconds
     */
    public $startTime;

    /**
     * @var int $duration
     * Total duration of the session
     * Seconds
     */
    public $duration;

    /**
     * @var string $reason
     * Why the session was destroyed
     * ["lastParticipantLeft","sessionClosedByServer","openviduServerStopped"]
     */
    public $reason;

    /**
     * @var string $event
     * Openvidu server webhook event
     */
    public $event;

    /**
     * Create a new SessionDestroyed event instance.
     * @param stdClass $data
     */
    public function __construct(stdClass $data)
    {
        $this->sessionId = property_exists($data, 'sessionId') ? $data->sessionId : null;
        $this->timestamp = property_exists($data, 'timestamp') ? $data->timestamp : null;
        $this->startTime = property_exists($data, 'startTime') ? $data->startTime : null;
        $this->duration = property_exists($data, 'duration') ? $data->duration : null;
        $this->reason = property_exists($data, 'reason') ? $data->reason : null;
        $this->event = $data->event;
    }

}