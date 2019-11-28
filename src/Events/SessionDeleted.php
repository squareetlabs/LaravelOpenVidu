<?php

namespace SquareetLabs\LaravelOpenVidu\Events;

/**
 * Class SessionDeleted
 * @package SquareetLabs\LaravelOpenVidu\Events
 */
class SessionDeleted
{

    public $sessionId;

    /**
     * Create a new event instance.
     *
     * @param string $sessionId
     */
    public function __construct(string $sessionId)
    {
        $this->sessionId = $sessionId;
    }
}
