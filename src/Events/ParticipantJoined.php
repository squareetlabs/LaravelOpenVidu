<?php

namespace SquareetLabs\LaravelOpenVidu\Events;

use Illuminate\Queue\SerializesModels;

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
     * Create a new SessionCreated event instance.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->sessionId = array_key_exists('sessionId', $data) ? $data['sessionId'] : null;
        $this->timestamp = array_key_exists('timestamp', $data) ? $data['timestamp'] : null;
        $this->participantId = array_key_exists('participantId', $data) ? $data['participantId'] : null;
        $this->platform = array_key_exists('platform', $data) ? $data['platform'] : null;
        $this->event = $data['event'];
    }
}