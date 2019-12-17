<?php

namespace SquareetLabs\LaravelOpenVidu\Events;

use Illuminate\Queue\SerializesModels;
use stdClass;

/**
 * Class ParticipantJoined
 * @package SquareetLabs\LaravelOpenVidu\Events
 */
class ParticipantJoined implements WebhookEventInterface
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
     * @var string $event
     * Openvidu server webhook event
     */
    public $event;

    /**
     * Create a new ParticipantJoined event instance.
     * @param stdClass $data
     */
    public function __construct(stdClass $data)
    {
        $this->sessionId = property_exists($data, 'sessionId') ? $data->sessionId : null;
        $this->timestamp = property_exists($data, 'timestamp') ? $data->timestamp : null;
        $this->participantId = property_exists($data, 'participantId') ? $data->participantId : null;
        $this->platform = property_exists($data, 'platform') ? $data->platform : null;
        $this->event = $data->event;
    }
}