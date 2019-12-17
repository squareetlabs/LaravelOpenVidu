<?php

namespace SquareetLabs\LaravelOpenVidu\Events;

use Illuminate\Queue\SerializesModels;
use stdClass;

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
     * @param stdClass $data
     */
    public function __construct(stdClass $data)
    {
        $this->sessionId = property_exists($data, 'sessionId') ? $data->sessionId : null;
        $this->timestamp = property_exists($data, 'timestamp') ? $data->timestamp : null;
        $this->event = $data->event;
    }
}