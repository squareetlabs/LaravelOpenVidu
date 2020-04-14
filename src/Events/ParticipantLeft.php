<?php

namespace SquareetLabs\LaravelOpenVidu\Events;


/**
 * Class ParticipantJoined
 * @package SquareetLabs\LaravelOpenVidu\Events
 */
class ParticipantLeft
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
     * @var string $clientData
     * Additional data added client side while connecting to Session
     */
    public $clientData;

    /**
     * @var string $serverData
     * Additional data added server side while generating Token
     */
    public $serverData;

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
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->sessionId = $data['sessionId'];
        $this->timestamp = $data['timestamp'];
        $this->participantId = $data['participantId'];
        $this->platform = $data['platform'];
        $this->clientData = $data['clientData'] ?? "";
        $this->serverData = $data['serverData'] ?? "";
        $this->startTime = $data['startTime'];
        $this->duration = $data['duration'];
        $this->reason = $data['reason'];
        $this->event = $data['event'];
    }
}

