<?php

namespace SquareetLabs\LaravelOpenVidu\Events;


/**
 * Class SessionCreated
 * @package SquareetLabs\LaravelOpenVidu\Events
 */
class SessionCreated
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
        $this->event = $data['event'];
    }
}