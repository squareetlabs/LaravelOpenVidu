<?php

namespace SquareetLabs\LaravelOpenVidu\Events;

use Illuminate\Queue\SerializesModels;

/**
 * Class ParticipantJoined
 * @package SquareetLabs\LaravelOpenVidu\Events
 */
class ParticipantLeft implements WebhookEventInterface
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
     * @var string $participantId
     * Identifier of the participant
     * A string with the participant unique identifier
     */
    public $participantId;

    /**
     * @var string $platform
     * Complete description of the platform used by the participant to connect to the session
     * A string with the platform description
     */
    public $platform;

    /**
     * @var int $startTime
     * Time when the participant joined the session
     * UTC milliseconds
     */
    public $startTime;

    /**
     * @var int $duration
     * Total duration of the participant's connection to the session
     * Seconds
     */
    public $duration;

    /**
     * @var string $reason
     * How the participant left the session
     * ["disconnect","forceDisconnectByUser","forceDisconnectByServer","sessionClosedByServer","networkDisconnect","openviduServerStopped"]
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
        $this->participantId = array_key_exists('participantId', $data) ? $data['participantId'] : null;
        $this->platform = array_key_exists('platform', $data) ? $data['platform'] : null;
        $this->startTime = array_key_exists('startTime', $data) ? $data['startTime'] : null;
        $this->duration = array_key_exists('duration', $data) ? $data['duration'] : null;
        $this->reason = array_key_exists('reason', $data) ? $data['reason'] : null;
        $this->event = $data['event'];
    }
}