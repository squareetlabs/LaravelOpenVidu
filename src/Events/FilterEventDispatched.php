<?php

namespace SquareetLabs\LaravelOpenVidu\Events;


/**
 * Class FilterEventDispatched
 * @package SquareetLabs\LaravelOpenVidu\Events
 */
class FilterEventDispatched
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
     * @var string $streamId
     * Identifier of the stream for which the filter is applied
     * A string with the stream unique identifier
     */
    public $streamId;

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
        $this->event = $data['event'];
    }
}