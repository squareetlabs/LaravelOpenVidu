<?php

namespace SquareetLabs\LaravelOpenVidu\Events;

use Illuminate\Queue\SerializesModels;

/**
 * Class SessionCreated
 * @package SquareetLabs\LaravelOpenVidu\Events
 */
class SessionCreated implements WebhookEventInterface
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
        $this->event = $data['event'];
    }
}