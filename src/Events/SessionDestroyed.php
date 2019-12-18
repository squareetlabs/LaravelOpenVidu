<?php

namespace SquareetLabs\LaravelOpenVidu\Events;

use Illuminate\Queue\SerializesModels;

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
     * Create a new SessionCreated event instance.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->sessionId = array_key_exists('sessionId', $data) ? $data['sessionId'] : null;
        $this->timestamp = array_key_exists('timestamp', $data) ? $data['timestamp'] : null;
        $this->startTime = array_key_exists('startTime', $data) ? $data['startTime'] : null;
        $this->duration = array_key_exists('duration', $data) ? $data['duration'] : null;
        $this->reason = array_key_exists('reason', $data) ? $data['reason'] : null;
        $this->event = $data['event'];
    }
}