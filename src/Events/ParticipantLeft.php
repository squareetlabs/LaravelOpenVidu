<?php

namespace SquareetLabs\LaravelOpenVidu\Events;

use Illuminate\Queue\SerializesModels;
use stdClass;

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
     * Create a new ParticipantLeft event instance.
     * @param stdClass $data
     */
    public function __construct(stdClass $data)
    {
        $this->sessionId = property_exists($data, 'sessionId') ? $data->sessionId : null;
        $this->timestamp = property_exists($data, 'timestamp') ? $data->timestamp : null;
        $this->participantId = property_exists($data, 'participantId') ? $data->participantId : null;
        $this->platform = property_exists($data, 'platform') ? $data->platform : null;
        $this->startTime = property_exists($data, 'startTime') ? $data->startTime : null;
        $this->duration = property_exists($data, 'duration') ? $data->duration : null;
        $this->reason = property_exists($data, 'reason') ? $data->reason : null;
        $this->event = $data->event;
    }
}