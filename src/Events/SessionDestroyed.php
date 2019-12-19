<?php

namespace SquareetLabs\LaravelOpenVidu\Events;


/**
 * Class SessionDestroyed
 * @package SquareetLabs\LaravelOpenVidu\Events
 */
class SessionDestroyed
{
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
     * Create a new SessionCreated event instance.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->sessionId = $data['sessionId'];
        $this->timestamp = $data['timestamp'];
        $this->startTime = $data['startTime'];
        $this->duration = $data['duration'];
        $this->reason = $data['reason'];
        $this->event = $data['event'];
    }
}