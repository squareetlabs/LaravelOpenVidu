<?php

namespace SquareetLabs\LaravelOpenVidu\Enums;


/**
 * Class MediaMode
 * @package SquareetLabs\LaravelOpenVidu\Enums
 */
class MediaMode
{
    /**
     * <i>(not available yet)</i> The session will attempt to transmit streams
     * directly between clients
     */
    public const RELAYED = 'RELAYED';

    /**
     * The session will transmit streams using LaravelOpenVidu Media Node
     */
    public const ROUTED = 'ROUTED';
}
